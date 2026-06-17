<?php
namespace App\Observers;
use App\Models\DebtPayment;
use App\Services\ActivityLogService;

class DebtPaymentObserver {
    public function created(DebtPayment $dp) { ActivityLogService::log($dp, 'created', 'Debt Payment'); }
}