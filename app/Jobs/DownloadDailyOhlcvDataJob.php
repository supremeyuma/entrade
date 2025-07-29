<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Services\MarketDataService;
use Carbon\Carbon;

class DownloadDailyOhlcvDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    protected $symbol;
    protected $marketType;
    protected $interval;

    public function __construct(string $symbol = 'BTC/USDT', string $marketType = 'crypto', string $interval = '1d')
    {
        $this->symbol = $symbol;
        $this->marketType = $marketType;
        $this->interval = $interval;
    }

    public function handle(MarketDataService $marketDataService)
    {
        Log::info("⏳ Starting OHLCV download for {$this->symbol}");

        $symbolSlug = str_replace(['/', ':'], '_', $this->symbol);
        $filename = "ohlcv/{$this->marketType}_{$symbolSlug}_{$this->interval}.json";

        $existingData = [];

        if (Storage::exists($filename)) {
            $existingData = json_decode(Storage::get($filename), true);

            if (!empty($existingData)) {
                $lastTimestamp = Carbon::parse(end($existingData)['timestamp'])->startOfDay();
                $cutoff = now()->subDays(2)->startOfDay();

                if ($lastTimestamp->greaterThanOrEqualTo($cutoff)) {
                    Log::info("✅ OHLCV data already up to date for {$this->symbol}");
                    return;
                }

                $sinceDate = $lastTimestamp->addDay()->toDateString();
            } else {
                $sinceDate = now()->subYear()->toDateString();
            }
        } else {
            $sinceDate = now()->subYear()->toDateString();
        }

        $endDate = now()->subDays(2)->toDateString();  // ⬅️ this fixes the Polygon restriction

        $ohlcvResponse = $marketDataService->getOhlcvData(
            $this->symbol,
            $this->marketType,
            $this->interval,
            $sinceDate,
            $endDate
        );

        if (!$ohlcvResponse || empty($ohlcvResponse['results'])) {
            Log::warning("No new OHLCV data fetched for {$this->symbol}");
            return;
        }

        $newData = array_map(function ($candle) {
            return [
                'timestamp' => Carbon::createFromTimestampMs($candle['t'])->toDateTimeString(),
                'open' => $candle['o'],
                'high' => $candle['h'],
                'low' => $candle['l'],
                'close' => $candle['c'],
                'volume' => $candle['v'],
            ];
        }, $ohlcvResponse['results']);

        $merged = array_merge($existingData, $newData);

        $merged = collect($merged)
            ->unique('timestamp')
            ->sortBy('timestamp')
            ->values()
            ->toArray();

        Storage::put($filename, json_encode($merged, JSON_PRETTY_PRINT));

        Log::info("✅ OHLCV data updated for {$this->symbol}: " . count($newData) . " new entries.");
    }
}
