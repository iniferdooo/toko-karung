<?php

namespace App\Observers;

use App\Models\Product;
use App\Services\ActivityLogService;

class ProductObserver {
    public function created(Product $product) { ActivityLogService::log($product, 'created', 'Inventory'); }
    public function updated(Product $product) { ActivityLogService::log($product, 'updated', 'Inventory'); }
    public function deleted(Product $product) { ActivityLogService::log($product, 'deleted', 'Inventory'); }
}