<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

// Import semua Model yang ingin diawasi
use App\Models\Product;
use App\Models\StockMovement;
use App\Models\Customer;
use App\Models\Debt;
use App\Models\DebtPayment;

// Import semua Observers penyusunnya
use App\Observers\ProductObserver;
use App\Observers\StockMovementObserver;
use App\Observers\CustomerObserver;
use App\Observers\DebtObserver;
use App\Observers\DebtPaymentObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (app()->environment('production') || env('APP_ENV') === 'production') {
            URL::forceScheme('https');
        }

        // Daftarkan model ke masing-masing observer di sini
        Product::observe(ProductObserver::class);
        StockMovement::observe(StockMovementObserver::class);
        Customer::observe(CustomerObserver::class);
        Debt::observe(DebtObserver::class);
        DebtPayment::observe(DebtPaymentObserver::class);
    }
}