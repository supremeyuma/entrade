<?php

namespace App\Services;

use App\Models\OhlcvData; // <-- IMPORT YOUR OHLCVDATA MODEL
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache; // Still useful for API call caching if needed
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Throwable; // Use Throwable for broader exception catching
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class MarketDataService
{
    protected $baseUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('services.polygon.base_url');
        $this->apiKey = config('services.polygon.api_key');
    }

    /**
     * Fetches OHLCV data, prioritizing local database and falling back to API.
     *
     * @param string $symbol
     * @param string $marketType
     * @param string $interval
     * @param string $startDate (Y-m-d)
     * @param string $endDate (Y-m-d)
     * @return array|null Returns an array with 'results' key, or null on failure.
     */
    public function getOhlcvData(string $symbol, string $marketType, string $interval, string $startDate, string $endDate): ?array
    {
        $carbonStartDate = Carbon::parse($startDate)->startOfDay();
        $carbonEndDate = Carbon::parse($endDate)->endOfDay();
        $polygonSymbol = $this->formatPolygonSymbol($symbol, $marketType); // Keep this for API calls and consistent logging

        // --- 1. Attempt to fetch from local database first ---
        try {
            $localData = OhlcvData::where('symbol', $symbol)
                                ->where('market_type', $marketType)
                                ->where('interval', $interval)
                                ->whereBetween('timestamp', [$carbonStartDate, $carbonEndDate])
                                ->orderBy('timestamp', 'asc')
                                ->get();

            // Check if local data covers the full requested range
            $localMinDate = $localData->min('timestamp');
            $localMaxDate = $localData->max('timestamp');

            // If local data exists and spans the full requested range, use it
            if ($localData->isNotEmpty() &&
                ($localMinDate && Carbon::parse($localMinDate)->startOfDay()->equalTo($carbonStartDate)) &&
                ($localMaxDate && Carbon::parse($localMaxDate)->endOfDay()->equalTo($carbonEndDate))) {

                \Log::info("Fetched OHLCV data for {$symbol} ({$interval}) from LOCAL DATABASE for {$startDate} to {$endDate}.");
                return ['results' => $this->formatLocalDataForConsumer($localData)];
            }

            // If local data is incomplete or missing, proceed to API fallback
            \Log::info("Local data for {$symbol} ({$interval}) is incomplete or missing. Falling back to API.");

        } catch (Throwable $e) {
            // Log and continue to API if there's an issue with DB query
            \Log::error("Error fetching local OHLCV data for {$symbol} ({$interval}): " . $e->getMessage());
        }

        // --- 2. Fallback to Polygon.io API ---
        try {
            list($multiplier, $timespan) = $this->parseInterval($interval);

            // No need for Cache::remember here, as data will be persisted to DB
            $url = "{$this->baseUrl}/v2/aggs/ticker/{$polygonSymbol}/range/{$multiplier}/{$timespan}/{$startDate}/{$endDate}";

            $params = [
                'adjusted' => 'true',
                'sort' => 'asc',
                'limit' => 50000, // Max limit for Polygon.io
                'apiKey' => $this->apiKey,
            ];

            $response = Http::timeout(60)->get($url, $params);
            $data = $response->json();

            if ($response->failed() || !isset($data['results'])) {
                $errorMessage = $data['error'] ?? $data['message'] ?? 'Unknown Polygon.io API error.';
                \Log::error("Polygon.io API Error for {$polygonSymbol} ({$interval}, {$startDate} to {$endDate}): " . $errorMessage . " Full Response: " . json_encode($data));
                return null;
            }

            if (empty($data['results'])) {
                \Log::warning("No OHLCV data found from Polygon.io for {$polygonSymbol} ({$interval}) between {$startDate} and {$endDate}.");
                return ['results' => []]; // Return empty results array
            }

            // --- 3. Save newly fetched API data to database ---
            $dataToUpsert = [];
            foreach ($data['results'] as $candle) {
                $dataToUpsert[] = [
                    'symbol'      => $symbol,
                    'market_type' => $marketType,
                    'interval'    => $interval,
                    'timestamp'   => Carbon::createFromTimestampMs($candle['t'])->toDateTimeString(),
                    'open'        => $candle['o'],
                    'high'        => $candle['h'],
                    'low'         => $candle['l'],
                    'close'       => $candle['c'],
                    'volume'      => $candle['v'] ?? 0, // Volume might be missing for some API responses
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ];
            }

            // Use upsert to insert new or update existing records
            $columnsToUpdate = ['open', 'high', 'low', 'close', 'volume', 'updated_at'];
            $uniqueBy = ['symbol', 'market_type', 'interval', 'timestamp']; // Matches your unique index

            
            $symbolSlug = str_replace(['/', ':'], '_', $symbol);
            $filename = "ohlcv/{$marketType}_{$symbolSlug}_{$interval}.json";

            Storage::put($filename, json_encode($dataToUpsert, JSON_PRETTY_PRINT));
            Log::info("Saved OHLCV data for {$symbol} to file: {$filename}");

            \Log::info("Successfully fetched and saved " . count($data['results']) . " OHLCV records from Polygon.io for {$polygonSymbol} ({$interval}).");

            return $data; // Return the data fetched from API

        } catch (Throwable $e) {
            \Log::error("Failed to fetch or save OHLCV data from Polygon.io for {$symbol} ({$interval}): " . $e->getMessage() . " on line " . $e->getLine() . " in " . $e->getFile());
            return null;
        }
    }

    /**
     * Parses interval string into Polygon.io multiplier and timespan.
     * Assumes '1d', '1min', '5min', etc.
     */
    protected function parseInterval(string $interval): array
    {
        if (Str::endsWith($interval, 'min')) {
            $multiplier = (int) Str::before($interval, 'min');
            return [$multiplier, 'minute'];
        } elseif (Str::endsWith($interval, 'h')) {
            $multiplier = (int) Str::before($interval, 'h');
            return [$multiplier, 'hour'];
        } elseif (Str::endsWith($interval, 'd')) {
            $multiplier = (int) Str::before($interval, 'd');
            return [$multiplier, 'day'];
        } elseif (Str::endsWith($interval, 'w')) {
            $multiplier = (int) Str::before($interval, 'w');
            return [$multiplier, 'week'];
        } elseif (Str::endsWith($interval, 'mo')) {
            $multiplier = (int) Str::before($interval, 'mo');
            return [$multiplier, 'month'];
        } elseif (Str::endsWith($interval, 'y')) {
            $multiplier = (int) Str::before($interval, 'y');
            return [$multiplier, 'year'];
        }
        throw new InvalidArgumentException("Invalid interval format: {$interval}");
    }

    /**
     * Formats symbol for Polygon.io API.
     */
    public function formatPolygonSymbol(string $symbol, string $marketType): string
    {
        switch ($marketType) {
            case 'crypto':
                $parts = explode('/', $symbol);
                if (count($parts) === 2) {
                    $base = strtoupper($parts[0]);
                    // Always use USD for Polygon crypto API (Polygon doesn't support USDT)
                    return 'X:' . $base . 'USD';
                }
                break;
            case 'forex':
                $parts = explode('/', $symbol);
                if (count($parts) === 2) {
                    return 'C:' . strtoupper($parts[0]) . strtoupper($parts[1]);
                }
                break;
            case 'stocks':
                return strtoupper($symbol);
                break;
        }
        throw new InvalidArgumentException("Unknown market type or invalid symbol format for: {$symbol} ({$marketType})");
    }

    /**
     * Formats data from local database to match Polygon.io's 'results' array structure.
     * This ensures consumers (like GenerateHistoricalTradesJob) don't need to know the source.
     */
    protected function formatLocalDataForConsumer($localDataCollection): array
    {
        return $localDataCollection->map(function ($item) {
            return [
                'o' => (float) $item->open,
                'h' => (float) $item->high,
                'l' => (float) $item->low,
                'c' => (float) $item->close,
                'v' => (float) $item->volume,
                't' => Carbon::parse($item->timestamp)->getTimestampMs(), // Convert to milliseconds
            ];
        })->toArray();
    }
}