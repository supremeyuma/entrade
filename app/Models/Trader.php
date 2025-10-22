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

    protected $fillable = [
        'name',
        'bio',
        'profile_photo',
        'performance_metrics',

    ];

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

    public function getRoi12mAttribute()
    {
        return round($this->trades()->where('created_at', '>=', now()->subYear())->avg('roi'), 2);
    }

    public function getSubscriberCountAttribute()
    {
        return $this->subscriptions()->count();
    }

    public function getAvatarUrlAttribute()
    {
        return $this->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($this->name);
    }


}
