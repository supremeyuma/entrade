<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Trade;
use App\Models\UserTraderSubscription;
use App\Models\TradeOutcome;
use App\Models\User;
use App\Models\TradeHistory;

class Trader extends Model
{
    use HasFactory;

    public function subscriptions()
    {
        return $this->hasMany(UserTraderSubscription::class);
    }

    public function tradeOutcomes()
    {
        return $this->hasMany(TradeOutcome::class);
    }

    public function latestOutcome()
    {
        return $this->hasOne(TradeOutcome::class)->latestOfMany();
    }

    public function tradeHistories()
    {
        return $this->hasMany(TradeHistory::class);
    }

    public function trades()
    {
        return $this->hasMany(Trade::class);
    }

    public function tradeLogs()
    {
        return $this->hasMany(TradeLog::class);
    }


}
