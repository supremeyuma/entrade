<?php

namespace App\Services\TradeBot;

use App\Services\MarketDataService;
use Carbon\Carbon;

class BacktestSimulator
{
    protected static $marketDataService; // Use static for simplicity if called statically

    public function __construct(MarketDataService $marketDataService)
    {
        static::$marketDataService = $marketDataService;
    }

    public static function run(array $params): array
    {
        // If not already injected (e.g., if called statically without prior injection)
        if (!isset(static::$marketDataService)) {
            static::$marketDataService = app(MarketDataService::class);
        }

        $startDate       = Carbon::parse($params['start_date']);
        $endDate         = Carbon::parse($params['end_date']);
        $timeframe       = $params['timeframe'] ?? '1d';
        $riskPerTrade    = $params['risk_per_trade'] ?? 1; // Percentage
        $desiredWinRate  = $params['desired_win_rate'] ?? 60;
        $maxTrades       = $params['max_trades'] ?? 100;
        $targetRoi       = $params['target_roi'] ?? 0;
        $marketType      = $params['market_type'] ?? 'forex';
        $symbols         = $params['symbols'] ?? []; // Now an array of specific symbols

        $equity = 100; // Starting equity
        $roiCurve = [['timestamp' => $startDate->timestamp, 'equity' => $equity]];
        $totalProfitPercentage = 0;
        $totalTrades = 0;
        $winCount = 0;

        $intervalOhlcv = self::mapTimeframeToOhlcvInterval($timeframe);

        $allOhlcvData = [];
        foreach ($symbols as $symbol) {
            $ohlcv = static::$marketDataService->getOhlcvData($symbol, $intervalOhlcv, 'full');
            if ($ohlcv) {
                $filteredOhlcv = array_filter($ohlcv, function($candle) use ($startDate, $endDate) {
                    return $candle['timestamp']->between($startDate->startOfDay(), $endDate->endOfDay());
                });
                if (!empty($filteredOhlcv)) {
                    $allOhlcvData[$symbol] = array_values($filteredOhlcv);
                } else {
                    \Log::info("No OHLCV data for {$symbol} within date range for preview.");
                }
            }
        }

        if (empty($allOhlcvData)) {
            return [
                'summary' => 'No market data available for simulation preview.',
                'roi_curve' => [['timestamp' => $startDate->timestamp, 'equity' => 100]],
                'stats' => ['total_trades' => 0, 'win_rate' => 0, 'total_roi' => 0],
                'trades' => [],
            ];
        }

        $simulatedTrades = []; // Store a sample of trades for preview

        // Simplified simulation loop for preview
        for ($i = 0; $i < $maxTrades; $i++) {
            // Stop if target ROI is hit (optional for preview, but good for efficiency)
            if ($totalProfitPercentage >= $targetRoi && $totalTrades >= ($maxTrades / 2)) break;

            $randomSymbol = array_rand($allOhlcvData);
            $symbolOhlcv = $allOhlcvData[$randomSymbol];

            if (empty($symbolOhlcv)) continue;
            $candle = $symbolOhlcv[array_rand($symbolOhlcv)]; // Pick a random candle from available data

            $isWin = (mt_rand(0, 100) < $desiredWinRate);
            $profitMultiplier = $isWin
                ? (mt_rand(120, 200) / 100)
                : -(mt_rand(80, 100) / 100);

            $profitPercentage = ($riskPerTrade / 100) * $profitMultiplier * 100;

            $equity *= (1 + ($profitPercentage / 100)); // Apply profit to equity
            $totalProfitPercentage += $profitPercentage;
            $totalTrades++;
            if ($isWin) $winCount++;

            $roiCurve[] = [
                'timestamp' => $candle['timestamp']->timestamp, // Use candle timestamp for curve point
                'equity' => round($equity, 2),
            ];

            // Add a sample trade for visualization in the preview
            $simulatedTrades[] = [
                'symbol' => $randomSymbol,
                'opened_at' => $candle['timestamp']->toDateTimeString(),
                'profit_percentage' => round($profitPercentage, 2),
                'is_win' => $isWin,
                'equity_after_trade' => round($equity, 2)
            ];
        }

        $winRate = $totalTrades > 0 ? round(($winCount / $totalTrades) * 100, 2) : 0;

        return [
            'summary' => "Simulated {$totalTrades} trades, achieved " . round($totalProfitPercentage, 2) . "% ROI with {$winRate}% win rate.",
            'roi_curve' => $roiCurve,
            'stats' => [
                'total_trades' => $totalTrades,
                'win_rate' => $winRate,
                'total_roi' => round($totalProfitPercentage, 2),
                'final_equity' => round($equity, 2),
            ],
            'trades' => $simulatedTrades, // Sample of trades
        ];
    }

    /**
     * Map job timeframe to MarketDataService interval.
     */
    private static function mapTimeframeToOhlcvInterval(string $timeframe): string
    {
        return match ($timeframe) {
            '1h' => '60min',
            '4h' => 'daily', // Alpha Vantage doesn't have 4h, daily is a reasonable fallback
            '1d' => 'daily',
            default => 'daily',
        };
    }
}