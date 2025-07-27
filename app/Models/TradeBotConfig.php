<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TradeBotConfig extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_date',
        'end_date',
        'roi',
        'markets',
        'trading_pairs',
        'assign_to',
        'auto_run',
        'timeframe',
        'risk_per_trade',
        'desired_win_rate',
        'max_trades',
        'status',
        'job_log', // Make sure 'job_log' is also fillable if you append to it
        'export_csv', // Ensure this is fillable
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'markets' => 'array',        // Cast 'markets' to array
        'trading_pairs' => 'array',  // Cast 'trading_pairs' to array
        'auto_run' => 'boolean',
        'job_log' => 'array',        // Cast 'job_log' to array if it stores JSON logs
    ];

    /**
     * Appends a message to the job log and saves the config.
     * This method is assumed to exist based on your job usage.
     * Make sure 'job_log' is fillable and cast to 'array'.
     */
    public function appendLog(string $message): void
    {
        $currentLog = $this->job_log ?? []; // Ensure it's an array, even if null initially
        $currentLog[] = '[' . now()->toDateTimeString() . '] ' . $message;
        $this->job_log = $currentLog;
        $this->save();
    }
}