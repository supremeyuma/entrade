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
        'pair',
        'trade_type',
        'entry_price',
        'exit_price',
        'lot_size',
        'stop_loss',
        'take_profit',
        'profit_loss',
        'status',
        'executed_at',
        'opened_at',
        'closed_at',
    ];


    public function trader()
    {
        return $this->belongsTo(Trader::class);
    }
}
