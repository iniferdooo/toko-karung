<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Debt;
use App\Models\DebtPayment;
use App\Models\Sale;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCustomers = Customer::count();
        $totalProducts = Product::count();
        $totalDebt = Debt::where('status', 'unpaid')->sum('remaining_amount');
        $totalPayments = DebtPayment::sum('amount_paid');

        $recentDebts = Debt::with('customer')->latest()->take(5)->get();
        $recentPayments = DebtPayment::with('debt.customer')->latest()->take(5)->get();
        
        // Products with stock less than 10 or custom threshold
        $lowStockProducts = Product::where('stock', '<=', 10)->get();

        // Sales revenue and profit metrics
        $salesRevenue = Sale::sum('total_amount');
        $salesProfit = Sale::sum('total_profit');

        return view('dashboard', compact(
            'totalCustomers',
            'totalProducts',
            'totalDebt',
            'totalPayments',
            'recentDebts',
            'recentPayments',
            'lowStockProducts',
            'salesRevenue',
            'salesProfit'
        ));
    }
}
