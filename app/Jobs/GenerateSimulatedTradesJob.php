<?php

namespace App\Jobs;

use App\Models\Trade;
use App\Models\Trader;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Str;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use App\Services\TradeHistoryService;
use App\Jobs\DownloadDailyOhlcvDataJob;

class GenerateSimulatedTradesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $tradingPairs;
    protected $netProfit;
    protected $targetWinRate;
    protected $tradeCount;
    protected $userId;
    protected $startDate;
    protected $endDate;

    public function __construct(array $tradingPairs = [], float $netProfit = 0.0, float $targetWinRate = 50.0, int $tradeCount = 10, int $userId = null, $startDate = null, $endDate = null)
    {
        $this->tradingPairs = $tradingPairs;
        $this->netProfit = $netProfit;
        $this->targetWinRate = $targetWinRate;
        $this->tradeCount = $tradeCount;
        $this->userId = $userId;
        $this->startDate = $startDate ? Carbon::parse($startDate) : Carbon::now()->subDays(30);
        $this->endDate = $endDate ? Carbon::parse($endDate) : Carbon::now();
    }

    public function handle(): void
    {
        Log::info("Starting synthetic trade generation for user {$this->userId} between {$this->startDate} and {$this->endDate}");

        $pairs = $this->tradingPairs ?: ['BTC/USDT'];

        // Determine which trader to assign these trades to
        $trader = $this->getAssignedTrader();

        if (! $trader) {
            Log::error('No trader record found to associate synthetic trades with. Aborting.');
            return;
        }

        $batchId = Str::uuid();

        $winsNeeded = (int) round($this->tradeCount * ($this->targetWinRate / 100));
        $lossesNeeded = $this->tradeCount - $winsNeeded;

        // Build trade outcome array and shuffle
        $tradeTypes = array_merge(array_fill(0, $winsNeeded, 'win'), array_fill(0, $lossesNeeded, 'loss'));
        shuffle($tradeTypes);

        // Build per-pair consistent directions
        $pairDirections = [];
        foreach ($pairs as $p) {
            $pairDirections[$p] = (rand(0, 1) === 1) ? 'buy' : 'sell';
        }

        // Distribute netProfit accurately across trades
        // Generate random weights for proportional distribution
        $winWeights = $winsNeeded > 0 ? array_map(fn() => mt_rand(1, 100) / 100, range(1, $winsNeeded)) : [];
        $lossWeights = $lossesNeeded > 0 ? array_map(fn() => mt_rand(1, 100) / 100, range(1, $lossesNeeded)) : [];
        $sumW = array_sum($winWeights) ?: 1;
        $sumL = array_sum($lossWeights) ?: 1;

        // Calculate profit distribution
        // Strategy: losses are typically smaller than wins (loss divisor of 3.0)
        $lossDiv = 3.0;
        
        // Determine scale factors based on net profit and trade counts
        $profit_for_wins = $this->netProfit;
        $profit_for_losses = 0;
        
        if ($this->tradeCount > 0 && $this->netProfit < 0 && $lossesNeeded > 0) {
            // If we need to generate losses, distribute negative profit to them
            $profit_for_wins = 0;
            $profit_for_losses = $this->netProfit;
        } elseif ($this->tradeCount > 0 && $this->netProfit > 0 && $winsNeeded > 0 && $lossesNeeded > 0) {
            // Split positive profit: most to wins, some to offset losses
            $profit_for_wins = $this->netProfit;
            $profit_for_losses = 0; // Losses just offset wins
        }

        // Build per-trade profit amounts
        $profits = [];
        $winIndex = 0;
        $lossIndex = 0;

        foreach ($tradeTypes as $type) {
            if ($type === 'win') {
                $weight = $winWeights[$winIndex++] ?? 1;
                // Distribute win profit proportionally
                $amount = ($sumW > 0) ? ($profit_for_wins * ($weight / $sumW)) : 0;
                $profits[] = round($amount, 2);
            } else {
                $weight = $lossWeights[$lossIndex++] ?? 1;
                // Distribute loss profit proportionally (negative or smaller positive)
                if ($profit_for_losses < 0) {
                    // Negative net profit: make these true losses
                    $amount = ($sumL > 0) ? ($profit_for_losses * ($weight / $sumL)) : 0;
                } else {
                    // Positive net profit: make these small losses
                    $amount = ($sumL > 0) ? (-($weight / $sumL) * ($profit_for_wins / $lossDiv)) : 0;
                }
                $profits[] = round($amount, 2);
            }
        }

        // Adjust the last profit to ensure exact total equals netProfit
        if (count($profits) > 0) {
            $totalProfit = array_sum($profits);
            $difference = $this->netProfit - $totalProfit;
            $lastIdx = count($profits) - 1;
            $profits[$lastIdx] = round($profits[$lastIdx] + $difference, 2);
        }

        $tradesCreated = 0;

        // Base invested amount per trade (currency). Using a fixed amount simplifies ROI calculation.
        $baseInvested = 100.00;

        foreach ($tradeTypes as $idx => $type) {
            if ($tradesCreated >= $this->tradeCount) break;

            $pair = $pairs[array_rand($pairs)];
            $direction = $pairDirections[$pair] ?? ((rand(0,1)===1)?'buy':'sell');

            // pick random timestamps within range
            $entryTimestamp = Carbon::parse($this->startDate)->addSeconds(rand(0, $this->endDate->diffInSeconds($this->startDate)));
            $exitTimestamp = (clone $entryTimestamp)->addMinutes(rand(10, 60*24*5));
            if (!$entryTimestamp->between($this->startDate, $this->endDate)) {
                continue;
            }

            $profitAmount = $profits[$idx] ?? 0.0; // currency amount (positive for wins, negative for losses)

            // compute ROI percentage relative to baseInvested
            $roiPercent = $baseInvested > 0 ? ($profitAmount / $baseInvested) * 100 : 0;

            // synthesize entry/exit prices
            $entryPrice = round(mt_rand(1000, 100000) / 100, 4); // 10.00 - 1000.00
            $exitPrice = round($entryPrice * (1 + ($roiPercent / 100)), 4);

            $tradeData = [
                'batch_id' => $batchId,
                'trader_id' => $trader->id,
                'symbol' => $pair,
                'market' => 'synthetic',
                'type' => $direction,
                'entry_price' => $entryPrice,
                'exit_price' => $exitPrice,
                'entry_timestamp' => $entryTimestamp->toDateTimeString(),
                'exit_timestamp' => $exitTimestamp->toDateTimeString(),
                'roi' => round($roiPercent, 2),
                'status' => 'closed',
                'source' => 'admin-synthetic',
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $trade = Trade::create($tradeData);

            // Update user balance with profit/loss and create trade history
            $user = \App\Models\User::find($this->userId);
            if ($user) {
                $balance = $user->balance;
                if (!$balance) {
                    $balance = new \App\Models\Balance([
                        'user_id' => $user->id,
                        'main_balance' => 0,
                        'trade_balance' => 0,
                    ]);
                }

                // Store old balance before update
                $oldTradeBalance = $balance->trade_balance;

                // Add profit/loss to balance
                $balance->trade_balance += $profitAmount;
                $balance->save();

                // Determine amount invested for trade history
                // Priority: explicit allocation > trade_balance > main_balance > old balance
                $subscription = $user->traderSubscriptions()
                    ->where('trader_id', $trader->id)
                    ->first();

                if ($subscription && $subscription->allocated_amount > 0) {
                    // User has an explicit allocation
                    $amountInvested = $subscription->allocated_amount;
                    $amountReturned = round($subscription->allocated_amount + $profitAmount, 2);
                } elseif ($oldTradeBalance > 0) {
                    // Use existing trade balance (before profit was added)
                    $amountInvested = $oldTradeBalance;
                    $amountReturned = round($balance->trade_balance, 2);
                } elseif ($balance->main_balance > 0) {
                    // Use main balance if trade balance is empty
                    $amountInvested = $balance->main_balance;
                    $amountReturned = round($balance->main_balance + $profitAmount, 2);
                } else {
                    // Fallback: no balance available, use old trade balance (likely 0)
                    $amountInvested = $oldTradeBalance;
                    $amountReturned = round($balance->trade_balance, 2);
                }

                // Save trade history record for the user
                \App\Models\TradeHistory::create([
                    'user_id' => $user->id,
                    'trader_id' => $trader->id,
                    'trade_id' => $trade->id,
                    'amount_invested' => $amountInvested,
                    'roi' => round($roiPercent, 2),
                    'amount_returned' => $amountReturned,
                    'new_trade_balance' => round($balance->trade_balance, 2),
                ]);
            }

            $tradesCreated++;
        }

        Log::info("Created {$tradesCreated} synthetic trades for user {$this->userId} (batch {$batchId}).");
    }

    /**
     * Get the trader to assign these synthetic trades to.
     * Logic:
     * 1. If user is subscribed to a trader with status 'active', use that trader
     * 2. Otherwise, assign to the first trader in the database
     * 3. If no trader exists, return null
     */
    private function getAssignedTrader(): ?Trader
    {
        $user = \App\Models\User::find($this->userId);
        if (!$user) {
            return null;
        }

        // Check if user has an active subscription to a trader
        $subscription = $user->traderSubscriptions()
            ->where('status', 'active')
            ->first();

        if ($subscription) {
            return $subscription->trader;
        }

        // If no active subscription, check for 'pending_approval' subscriptions
        $pendingSubscription = $user->traderSubscriptions()
            ->where('status', 'pending_approval')
            ->first();

        if ($pendingSubscription) {
            return $pendingSubscription->trader;
        }

        // Fallback: Assign to first trader in database
        $firstTrader = Trader::first();
        
        // If a first trader exists and user is not subscribed, auto-subscribe them
        if ($firstTrader) {
            // Check if subscription already exists (inactive)
            $existingSubscription = $user->traderSubscriptions()
                ->where('trader_id', $firstTrader->id)
                ->first();

            if (!$existingSubscription) {
                // Create an automatic subscription to the first trader
                $user->traderSubscriptions()->create([
                    'trader_id' => $firstTrader->id,
                    'allocated_amount' => 0, // No specific allocation needed
                    'status' => 'active',
                ]);
            } elseif ($existingSubscription->status === 'inactive') {
                // Reactivate the existing subscription
                $existingSubscription->status = 'active';
                $existingSubscription->save();
            }
        }

        return $firstTrader;
    }
}
