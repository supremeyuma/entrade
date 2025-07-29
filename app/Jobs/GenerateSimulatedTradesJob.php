<?php

namespace App\Jobs;

use App\Models\Trade;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Str;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use APP\Services\TradeHistoryService;

class GenerateSimulatedTradesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $symbol;
    protected $marketType;
    protected $interval;
    protected $targetRoi;
    protected $targetWinRate;
    protected $tradeCount;
    protected $traderUserId;
    protected $startDate;
    protected $endDate;

    public function __construct($symbol, $marketType, $interval, $targetRoi, $targetWinRate, $tradeCount, $traderUserId, $startDate, $endDate)
    {
        $this->symbol = $symbol;
        $this->marketType = $marketType;
        $this->interval = $interval;
        $this->targetRoi = $targetRoi;
        $this->targetWinRate = $targetWinRate;
        $this->tradeCount = $tradeCount;
        $this->traderUserId = $traderUserId;
        $this->startDate = Carbon::parse($startDate);
        $this->endDate = Carbon::parse($endDate);
    }

    public function handle(): void
    {
        Log::info("Starting simulated trade generation for {$this->symbol} between {$this->startDate} and {$this->endDate}");

        $fileName = str_replace(['/', ':'], '_', "{$this->marketType}_{$this->symbol}_{$this->interval}.json");
        $filePath = storage_path("app/ohlcv/{$fileName}");

        if (!File::exists($filePath)) {
            Log::error("OHLCV file not found at: {$filePath}");
            return;
        }

        $ohlcv = collect(json_decode(File::get($filePath), true))
            ->filter(function ($candle) {
                $timestamp = Carbon::parse($candle['timestamp']);
                return $timestamp->between($this->startDate, $this->endDate);
            })
            ->values();

        if ($ohlcv->isEmpty()) {
            Log::error("No OHLCV data available in date range: {$this->startDate} to {$this->endDate}");
            return;
        }

        $trades = [];
        $batchId = Str::uuid(); // 🔑 Create a unique batch ID
        $winsNeeded = round($this->tradeCount * ($this->targetWinRate / 100));
        $lossesNeeded = $this->tradeCount - $winsNeeded;

        // Target ROI range ±4%
        $totalTargetRoi = $this->targetRoi;
        $roiVariance = $totalTargetRoi * 0.04;

        $actualTotalRoi = $this->randomBetween($totalTargetRoi - $roiVariance, $totalTargetRoi + $roiVariance);

        // Sum of ROIs across wins
        $roiPerWinAvg = $actualTotalRoi / max(1, $winsNeeded);
        $roiPerLossAvg = -($roiPerWinAvg / 3); // loss trades lose half of an average win

        // Generate trade outcomes
        $tradeTypes = array_merge(
            array_fill(0, $winsNeeded, 'win'),
            array_fill(0, $lossesNeeded, 'loss')
        );
        shuffle($tradeTypes);

        foreach ($tradeTypes as $type) {
            $candle = $ohlcv->random();
            $baseDate = Carbon::parse($candle['timestamp']);

            $entryDate = $baseDate->copy()->addMinutes(rand(0, 720));
            $exitDate = (clone $entryDate)->addDays(rand(1, 5))->addMinutes(rand(0, 720));

            if (!$entryDate->between($this->startDate, $this->endDate)) {
                continue; // Skip trades outside range
            }

            $entryPrice = $this->randomBetween($candle['low'], $candle['high']);

            // Randomize ROI per trade with small variance (±25% of average ROI)
            $roiVarianceFactor = 0.25;
            $roi = $type === 'win'
                ? $this->randomBetween($roiPerWinAvg * (1 - $roiVarianceFactor), $roiPerWinAvg * (1 + $roiVarianceFactor))
                : $this->randomBetween($roiPerLossAvg * (1 - $roiVarianceFactor), $roiPerLossAvg * (1 + $roiVarianceFactor));

            $exitPrice = $entryPrice * (1 + ($roi / 100));

            $trades[] = [
                'batch_id' => $batchId, // 🆕 Set the batch_id
                'trader_id' => $this->traderUserId,
                'symbol' => $this->symbol,
                'market' => $this->marketType,
                'type' => 'buy',
                'entry_price' => round($entryPrice, 4),
                'exit_price' => round($exitPrice, 4),
                'entry_timestamp' => $entryDate->toDateTimeString(),
                'exit_timestamp' => $exitDate->toDateTimeString(),
                'roi' => round($roi, 2),
                'status' => 'closed',
                'created_at' => now(),
                'updated_at' => now(),
            ];
            
        }
        
        Log::info("Inserted " . count($trades) . " trades with simulated ROI totaling ~{$actualTotalRoi}% for {$this->symbol}");

        foreach ($trades as $tradeData) {
            $trade = Trade::create($tradeData);
            // The observer will also run, but this is explicit
            //TradeHistoryService::generateHistoriesForTrade($trade);
        }
    }

    private function randomBetween($min, $max)
    {
        return $min + mt_rand() / mt_getrandmax() * ($max - $min);
    }
}
