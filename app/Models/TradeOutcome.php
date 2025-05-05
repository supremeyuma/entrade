<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TradeOutcome extends Model
{
    use HasFactory;

    protected $fillable = [
        'trader_id',
        'percentage_change',
        'description',
    ];

    public function trader()
    {
        return $this->belongsTo(Trader::class);
    }
}
