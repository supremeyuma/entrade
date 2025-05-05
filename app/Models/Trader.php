<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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


}
