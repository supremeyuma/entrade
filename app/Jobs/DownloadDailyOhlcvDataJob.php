<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use App\Models\OhlcvData;
use App\Services\MarketDataService;
use Throwable; // Import Throwable for more generic error catching

class DownloadDailyOhlcvDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @param MarketDataService $marketDataService
     * @return void
     */
    public function handle(MarketDataService $marketDataService): void
    {
        Log::info('Starting DownloadDailyOhlcvDataJob...');

        // Define the symbols and market types you want to fetch
        // You can expand this list or make it configurable later
        $targets = [
            ['symbol' => 'BTC/USDT', 'market_type' => 'crypto'],
            ['symbol' => 'ETH/USDT', 'market_type' => 'crypto'],
            // Add more symbols/market types as needed, e.g., for stocks:
            // ['symbol' => 'AAPL', 'market_type' => 'stocks'],
        ];

        $interval = '1d'; // We are specifically fetching daily data

        foreach ($targets as $target) {
            $symbol = $target['symbol'];
            $marketType = $target['market_type'];

            try {
                // 1. Determine the last date we have data for this symbol
                $latestOhlcv = OhlcvData::where('symbol', $symbol)
                                        ->where('market_type', $marketType)
                                        ->where('interval', $interval)
                                        ->orderBy('timestamp', 'desc')
                                        ->first();

                $startDate = Carbon::now()->subYears(2)->startOfDay(); // Default: Start 2 years ago
                if ($latestOhlcv) {
                    // Start fetching from the day after the last recorded date
                    $startDate = Carbon::parse($latestOhlcv->timestamp)->addDay()->startOfDay();
                }

                // Always fetch up to yesterday's end of day for complete daily candles on free tier
                $endDate = Carbon::now()->subDay()->endOfDay();

                // If startDate is somehow in the future or after endDate, skip
                if ($startDate->isAfter($endDate)) {
                    Log::info("No new data to fetch for {$symbol}/{$marketType} ({$interval}). Already up to date or start date is after end date.");
                    continue;
                }

                Log::info("Fetching new OHLCV data for {$symbol}/{$marketType} ({$interval}) from {$startDate->toDateString()} to {$endDate->toDateString()} from API...");

                // 2. Fetch data from Polygon.io using your MarketDataService
                // (This will temporarily use the direct API call before we modify MarketDataService in the next step)
                $apiData = $marketDataService->getOhlcvData(
                    $symbol,
                    $marketType,
                    $interval,
                    $startDate->toDateString(),
                    $endDate->toDateString()
                );

                if (empty($apiData['results'])) {
                    Log::warning("No new OHLCV data returned from API for {$symbol}/{$marketType} ({$interval}) between {$startDate->toDateString()} and {$endDate->toDateString()}.");
                    continue;
                }

                // 3. Prepare data for upsert
                $dataToUpsert = [];
                foreach ($apiData['results'] as $candle) {
                    $dataToUpsert[] = [
                        'symbol'      => $symbol,
                        'market_type' => $marketType,
                        'interval'    => $interval,
                        'timestamp'   => Carbon::createFromTimestampMs($candle['t'])->toDateTimeString(),
                        'open'        => $candle['o'],
                        'high'        => $candle['h'],
                        'low'         => $candle['l'],
                        'close'       => $candle['c'],
                        'volume'      => $candle['v'],
                        'created_at'  => now(),
                        'updated_at'  => now(),
                    ];
                }

                // 4. Use upsert to insert or update the data in the database
                $columnsToUpdate = ['open', 'high', 'low', 'close', 'volume', 'updated_at'];
                $uniqueBy = ['symbol', 'market_type', 'interval', 'timestamp']; // Matches your unique index

                OhlcvData::upsert($dataToUpsert, $uniqueBy, $columnsToUpdate);

                Log::info("Successfully upserted " . count($dataToUpsert) . " daily OHLCV records for {$symbol}/{$marketType}.");

            } catch (Throwable $e) {
                Log::error("Failed to download or upsert data for {$symbol}/{$marketType} ({$interval}): " . $e->getMessage() . " on line " . $e->getLine() . " in " . $e->getFile());
            }
        }

        Log::info('DownloadDailyOhlcvDataJob completed.');
    }
}