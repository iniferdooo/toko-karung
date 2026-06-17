<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'penjualan');

        $sales = null;
        $stockMovements = null;
        $debtChanges = null;

        if ($tab === 'penjualan') {
            $sales = Sale::with(['customer', 'items.product'])
                ->orderBy('created_at', 'desc')
                ->paginate(15)
                ->withQueryString();
        } elseif ($tab === 'stok') {
            $stockMovements = StockMovement::with(['product', 'user'])
                ->orderBy('created_at', 'desc')
                ->paginate(15)
                ->withQueryString();
        } elseif ($tab === 'hutang') {
            $debtsQuery = DB::table('debts')
                ->join('customers', 'debts.customer_id', '=', 'customers.id')
                ->select(
                    DB::raw("'debt' as change_type"),
                    'debts.id',
                    'customers.name as customer_name',
                    'debts.total_amount as amount',
                    'debts.notes',
                    'debts.debt_date as action_date',
                    'debts.created_at'
                );

            $paymentsQuery = DB::table('debt_payments')
                ->join('debts', 'debt_payments.debt_id', '=', 'debts.id')
                ->join('customers', 'debts.customer_id', '=', 'customers.id')
                ->select(
                    DB::raw("'payment' as change_type"),
                    'debt_payments.id',
                    'customers.name as customer_name',
                    'debt_payments.amount_paid as amount',
                    'debt_payments.notes',
                    'debt_payments.payment_date as action_date',
                    'debt_payments.created_at'
                );

            // Union debt creation and payments chronologically
            $debtChanges = $debtsQuery->unionAll($paymentsQuery)
                ->orderBy('action_date', 'desc')
                ->orderBy('created_at', 'desc')
                ->paginate(15)
                ->withQueryString();
        }

        return view('history.index', compact('tab', 'sales', 'stockMovements', 'debtChanges'));
    }
}
