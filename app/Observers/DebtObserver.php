<?php
namespace App\Observers;
use App\Models\Debt;
use App\Services\ActivityLogService;

class DebtObserver {
    public function created(Debt $d) { ActivityLogService::log($d, 'created', 'Debt'); }
    public function updated(Debt $d) { ActivityLogService::log($d, 'updated', 'Debt'); }
}