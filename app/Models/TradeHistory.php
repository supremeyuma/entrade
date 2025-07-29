<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TradeHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'trade_id', 'user_id', 'trader_id', 'amount_invested', 
        'roi', 'amount_returned','new_trade_balance',
    ];

    public function trade()
    {
        return $this->belongsTo(Trade::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function trader()
    {
        return $this->belongsTo(User::class, 'trader_id');
    }
}
