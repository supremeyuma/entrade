<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trade extends Model
{
    use HasFactory;

    protected $fillable = [
        'trader_id',
        'pair',
        'batch_id',
        'type',
        'entry_price',
        'exit_price',
        'lot_size',
        'stop_loss',
        'take_profit',
        'profit',
        'status',
        'executed_at',
        'opened_at',
        'closed_at',
        'source',
        'meta',
    ];
    protected $dates = ['trade_date']; // If not already there


    public function trader()
    {
        return $this->belongsTo(Trader::class);
    }
}
