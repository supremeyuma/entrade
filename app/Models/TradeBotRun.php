<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TradeBotRun extends Model
{
    use HasFactory;

    protected $fillable = [
        'trade_bot_config_id',
        'status', // running, completed, failed
        'started_at',
        'completed_at',
        'trades_generated',
        'average_roi',
        'note', // optional error messages
    ];

    public function config()
    {
        return $this->belongsTo(TradeBotConfig::class, 'trade_bot_config_id');
    }


}
