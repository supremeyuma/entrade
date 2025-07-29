<?php

// app/Services/TradeHistoryService.php

namespace App\Services;

use App\Models\Balance;
use App\Models\Trade;
use App\Models\TradeHistory;
use App\Models\UserTraderSubscription;

class TradeHistoryService
{
    public static function generateHistoriesForTrade(Trade $trade): void
    {
        $subscriptions = UserTraderSubscription::where('trader_id', $trade->trader_id)
            ->where('status', 'active')
            ->get();

        foreach ($subscriptions as $subscription) {
            $user = $subscription->user;
            $amountInvested = $subscription->allocated_amount;
            $roi = $trade->roi; // % e.g. 50
            $amountReturned = $amountInvested * (1 + ($roi / 100));
            $net = $amountReturned - $amountInvested;

            // Update trade_balance
            $balance = $user->balance;
            if (!$balance) {
                $balance = new Balance([
                    'user_id' => $user->id,
                    'main_balance' => 0,
                    'trade_balance' => 0,
                ]);
            }

            $balance->trade_balance += $net;
            $balance->save();

            // Save history
            TradeHistory::create([
                'user_id' => $user->id,
                'trader_id' => $trade->trader_id,
                'trade_id' => $trade->id,
                'amount_invested' => $amountInvested,
                'roi' => $roi,
                'amount_returned' => $amountReturned,
                'new_trade_balance' => $balance->trade_balance,
            ]);
        }
    }
}
