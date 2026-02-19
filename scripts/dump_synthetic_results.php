<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Trade;
use App\Models\TradeHistory;
use Illuminate\Support\Facades\DB;

// Dump latest synthetic trades
$trades = Trade::where('source', 'admin-synthetic')->latest()->limit(10)->get();
$histories = TradeHistory::latest()->limit(10)->get();

echo "=== Trades (source=admin-synthetic) ===\n";
foreach ($trades as $t) {
    echo json_encode([
        'id' => $t->id,
        'symbol' => $t->symbol,
        'type' => $t->type ?? $t->trade_type ?? null,
        'entry' => $t->entry_timestamp ?? $t->entry_at ?? null,
        'exit' => $t->exit_timestamp ?? $t->exit_at ?? null,
        'roi' => $t->roi,
        'entry_price' => $t->entry_price,
        'exit_price' => $t->exit_price,
        'created_at' => $t->created_at,
    ], JSON_PRETTY_PRINT), "\n";
}

echo "\n=== Trade Histories (latest) ===\n";
foreach ($histories as $h) {
    $trade = $h->trade;
    echo json_encode([
        'history_id' => $h->id,
        'user_id' => $h->user_id,
        'trader_id' => $h->trader_id,
        'trade_id' => $h->trade_id,
        'pair' => $trade->symbol ?? null,
        'side' => $trade->type ?? $trade->trade_type ?? null,
        'entry' => $trade->entry_timestamp ?? null,
        'exit' => $trade->exit_timestamp ?? null,
        'roi' => $h->roi,
        'profit_loss' => $h->amount_returned - $h->amount_invested,
    ], JSON_PRETTY_PRINT), "\n";
}
