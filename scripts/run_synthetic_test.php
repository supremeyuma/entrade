<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

// Bootstrap the kernel so Eloquent and app services are available
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Jobs\GenerateSimulatedTradesJob;
use App\Models\Trader;

// Find first eligible user (exclude admin/trader roles)
$user = User::whereDoesntHave('roles', function ($q) {
    $q->whereIn('name', ['admin', 'trader']);
})->first();

if (! $user) {
    echo "No eligible user found.\n";
    exit(1);
}

echo "Using user id: {$user->id} ({$user->email})\n";

$tradingPairs = ['BTC/USDT', 'ETH/USDT'];
$netProfit = 500.00; // currency total
$winRate = 60.0; // percent
$tradeCount = 10;
$startDate = '2026-02-01';
$endDate = '2026-02-15';

$systemTrader = Trader::first();
if (! $systemTrader) {
    echo "No Trader records exist in DB. Create a trader before running this test.\n";
    exit(1);
}

echo "Using trader id: {$systemTrader->id} ({$systemTrader->name})\n";

$job = new GenerateSimulatedTradesJob($tradingPairs, $netProfit, $winRate, $tradeCount, $user->id, $startDate, $endDate);

$job->handle();

echo "Synthetic trade generation complete.\n";
