<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OhlcvData extends Model
{
    use HasFactory;

    protected $table = 'ohlcv_data'; // Make sure this matches your table name

    protected $fillable = [
        'symbol',
        'market_type',
        'interval',
        'timestamp',
        'open',
        'high',
        'low',
        'close',
        'volume',
        // Add any other columns your table has
    ];

    protected $casts = [
        'timestamp' => 'datetime',
        'open' => 'float',
        'high' => 'float',
        'low' => 'float',
        'close' => 'float',
        'volume' => 'float',
    ];
}