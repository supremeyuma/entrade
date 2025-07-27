<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Jobs\DownloadDailyOhlcvDataJob; // <-- ADD THIS LINE

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Schedule the job to download daily OHLCV data every week
        // It will run every Sunday at 02:00 AM based on your server's timezone
        $schedule->job(new DownloadDailyOhlcvDataJob())->weekly()->sundays()->at('02:00');

        // Example of other scheduling options:
        // $schedule->job(new DownloadDailyOhlcvDataJob())->dailyAt('03:00'); // Runs daily at 3 AM
        // $schedule->job(new DownloadDailyOhlcvDataJob())->hourly(); // Runs every hour
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}