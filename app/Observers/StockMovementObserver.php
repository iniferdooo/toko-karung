<?php
namespace App\Observers;
use App\Models\StockMovement;
use App\Services\ActivityLogService;

class StockMovementObserver {
    public function created(StockMovement $sm) { ActivityLogService::log($sm, 'created', 'Stock Movement'); }
}