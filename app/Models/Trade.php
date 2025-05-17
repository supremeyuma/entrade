<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trade extends Model
{
    use HasFactory;

    protected $fillable = [
        'trader_id',
        'asset',
        'trade_type', // buy/sell or long/short etc.
        'entry_price',
        'exit_price',
        'profit_loss',
        'status', // pending, closed, etc.
        'executed_at',
    ];

    public function trader()
    {
        return $this->belongsTo(Trader::class);
    }
}
