<?php
namespace App\Observers;
use App\Models\Customer;
use App\Services\ActivityLogService;

class CustomerObserver {
    public function created(Customer $c) { ActivityLogService::log($c, 'created', 'Customer'); }
    public function updated(Customer $c) { ActivityLogService::log($c, 'updated', 'Customer'); }
}