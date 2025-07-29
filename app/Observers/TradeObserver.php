<?php

namespace App\Observers;

use App\Models\Trade;
use App\Services\TradeHistoryService;

class TradeObserver
{
    public function created(Trade $trade)
    {
        TradeHistoryService::generateHistoriesForTrade($trade);
    }
}
