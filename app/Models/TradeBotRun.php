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

    public function getStatsAttribute()
    {
        $trades = $this->trades;

        $count = $trades->count();
        $winRate = $count > 0 ? round($trades->where('roi', '>', 0)->count() / $count * 100, 2) : 0;
        $avgRoi = $count > 0 ? round($trades->avg('roi'), 2) : 0;
        $maxLoss = $count > 0 ? round($trades->min('roi'), 2) : 0;
        $from = $count > 0 ? $trades->min('opened_at') : null;
        $to = $count > 0 ? $trades->max('closed_at') : null;

        return [
            'total_trades' => $count,
            'win_rate' => $winRate,
            'avg_roi' => $avgRoi,
            'max_loss' => $maxLoss,
            'from' => $from,
            'to' => $to,
        ];
    }



}
