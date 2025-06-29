<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TradeHistory extends Model
{
    protected $fillable = [
        'user_id',
        'trader_id',
        'trade_outcome_id',
        'input',
        'roi',
        'output',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function trader(): BelongsTo
    {
        return $this->belongsTo(Trader::class);
    }

    public function tradeOutcome(): BelongsTo
    {
        return $this->belongsTo(TradeOutcome::class);
    }
}
