<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TradeBotConfig extends Model
{
    use HasFactory;

    // app/Models/TradeBotConfig.php

    protected $fillable = [
        'start_date', 'end_date', 'roi', 'markets', 'trading_pairs', 'assign_to', 'auto_run',
    ];

    protected $casts = [
        'markets' => 'array',
        'trading_pairs' => 'array',
        'auto_run' => 'boolean',
    ];

}
