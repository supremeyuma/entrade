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
        'timeframe',
        'risk_per_trade',
        'desired_win_rate',
        'max_trades',
    ];

    protected $casts = [
        'markets' => 'array',
        'trading_pairs' => 'array',
        'auto_run' => 'boolean',
    ];

    public function appendLog($line)
    {
        $this->job_log = trim($this->job_log . "\n" . now()->toDateTimeString() . ' | ' . $line);
        $this->save();
    }


}
