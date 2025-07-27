<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Exception; // Import Exception as well
use App\Models\OhlcvData; // Import your model

class MarketDataService
{
    protected $apiKey;
    protected $baseUrl; // Changed to use base_url from config

    public function __construct()
    {
        $this->apiKey = config('services.polygon.key');
        $this->baseUrl = config('services.polygon.base_url');

        if (empty($this->apiKey)) {
            throw new Exception("Polygon.io API Key not configured. Please set POLYGON_API_KEY in your .env file.");
        }
    }

    /**
     * Transforms a given interval (e.g., '60min', '1d') into Polygon.io's multiplier and timespan.
     *
     * @param string $interval
     * @return array ['multiplier', 'timespan']
     * @throws InvalidArgumentException
     */
    protected function parseInterval(string $interval): array
    {
        if (Str::endsWith($interval, 'min')) {
            $multiplier = (int) Str::before($interval, 'min');
            $timespan = 'minute';
        } elseif (Str::endsWith($interval, 'h')) {
            $multiplier = (int) Str::before($interval, 'h');
            $timespan = 'hour';
        } elseif ($interval === '1d') {
            $multiplier = 1;
            $timespan = 'day';
        } elseif ($interval === '1w') { // Assuming you might add weekly later
            $multiplier = 1;
            $timespan = 'week';
        } elseif ($interval === '1mo') { // Assuming you might add monthly later
            $multiplier = 1;
            $timespan = 'month';
        } else {
            throw new InvalidArgumentException("Unsupported interval format: {$interval}. Supported: Xmin, Xh, 1d, 1w, 1mo.");
        }

        return [$multiplier, $timespan];
    }

    /**
     * Formats the symbol for Polygon.io.
     * BTC/USDT -> X:BTCUSD (Crypto)
     * EUR/USD -> C:EURUSD (Forex)
     * IBM -> IBM (Stocks)
     *
     * @param string $symbol
     * @param string $marketType // Pass the determined market type (crypto, forex, stocks)
     * @return string
     */
    protected function formatPolygonSymbol(string $symbol, string $marketType): string
    {
        switch ($marketType) {
            case 'crypto':
                // Assumes format like BTC/USDT. Polygon often uses X:BTCUSD.
                $parts = explode('/', $symbol);
                if (count($parts) === 2) {
                    return 'X:' . strtoupper($parts[0]) . strtoupper($parts[1]);
                }
                break;
            case 'forex':
                // Assumes format like EUR/USD. Polygon often uses C:EURUSD.
                $parts = explode('/', $symbol);
                if (count($parts) === 2) {
                    return 'C:' . strtoupper($parts[0]) . strtoupper($parts[1]);
                }
                break;
            case 'stocks':
                // Stocks are usually just the ticker.
                return strtoupper($symbol);
                break;
            default:
                throw new InvalidArgumentException("Unknown market type for symbol formatting: {$marketType}");
        }
        return strtoupper($symbol); // Fallback for unmatched formats, or throw error
    }

    /**
     * Fetch OHLCV (Open, High, Low, Close, Volume) data for a given symbol.
     * Caches data to avoid hitting API rate limits unnecessarily.
     *
     * @param string $symbol The trading pair (e.g., 'BTC/USDT', 'EUR/USD', 'AAPL').
     * @param string $marketType The market type ('crypto', 'forex', 'stocks') to help format the symbol.
     * @param string $interval e.g., '1min', '5min', '15min', '30min', '60min', '1d'
     * @param string $startDate 'YYYY-MM-DD'
     * @param string $endDate 'YYYY-MM-DD'
     * @return array|null
     */
    public function getOhlcvData(string $symbol, string $marketType, string $interval, string $startDate, string $endDate): ?array
    {
        // Polygon's free tier is limited to 2 years of daily data and 2 days of intraday data.
        // Adjust outputsize or request more specific date ranges if needed for paid tiers.
        // For historical data over long periods, you might need to make multiple calls
        // or ensure your plan supports it.

        // --- ADD THIS CONDITIONAL LOGIC ---
        if (env('USE_MOCK_MARKET_DATA', false)) {
            return $this->getMockOhlcvData($symbol, $marketType, $interval, $startDate, $endDate);
        }
        // --- END ADDITION ---
        
        try {
            list($multiplier, $timespan) = $this->parseInterval($interval);
            $polygonSymbol = $this->formatPolygonSymbol($symbol, $marketType);

            // Cache key includes all parameters that define the data
            $cacheKey = "polygon_ohlcv_{$polygonSymbol}_{$multiplier}_{$timespan}_{$startDate}_{$endDate}";

            // Cache for 6 hours
            return Cache::remember($cacheKey, now()->addHours(6), function () use ($polygonSymbol, $multiplier, $timespan, $startDate, $endDate, $interval) {
                $url = "{$this->baseUrl}/v2/aggs/ticker/{$polygonSymbol}/range/{$multiplier}/{$timespan}/{$startDate}/{$endDate}";

                $params = [
                    'adjusted' => 'true', // Recommended for adjusted data
                    'sort' => 'asc',      // Oldest to newest
                    'limit' => 50000,     // Max limit per call (free tier might have smaller limit, check docs)
                    'apiKey' => $this->apiKey,
                ];

                $response = Http::timeout(60)->get($url, $params); // Increased timeout

                $data = $response->json();

                if ($response->failed() || !isset($data['results'])) {
                    $errorMessage = $data['error'] ?? $data['message'] ?? 'Unknown Polygon.io API error.';
                    \Log::error("Polygon.io API Error for {$polygonSymbol} ({$interval}, {$startDate} to {$endDate}): " . $errorMessage . " Full Response: " . json_encode($data));
                    return null;
                }

                if (empty($data['results'])) {
                    \Log::warning("No OHLCV data found from Polygon.io for {$polygonSymbol} ({$interval}) between {$startDate} and {$endDate}.");
                    return null;
                }

                $ohlcvData = [];
                foreach ($data['results'] as $bar) {
                    $ohlcvData[] = [
                        'timestamp' => Carbon::createFromTimestampMs($bar['t']), // Polygon returns timestamp in milliseconds
                        'open'      => (float) $bar['o'],
                        'high'      => (float) $bar['h'],
                        'low'       => (float) $bar['l'],
                        'close'     => (float) $bar['c'],
                        'volume'    => (int) $bar['v'],
                        'vwap'      => (float) ($bar['vw'] ?? 0), // Volume Weighted Average Price (optional)
                        'num_trades' => (int) ($bar['n'] ?? 0), // Number of trades (optional)
                    ];
                }

                // Polygon's 'sort=asc' already gives us oldest to newest, so no need for usort here.
                return $ohlcvData;
            });
        } catch (Exception $e) {
            \Log::error("Failed to fetch OHLCV data from Polygon.io for {$symbol} ({$interval}): " . $e->getMessage() . " on line " . $e->getLine() . " in " . $e->getFile());
            return null;
        }
    }

    
}