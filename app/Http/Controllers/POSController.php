<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class POSController extends Controller
{
    /**
     * Show the POS (cashier) page.
     */
    public function index()
    {
        // Load products with their category for filtering
        $productsData = Product::with('category')->orderBy('name')->get()->map(function($p){
            return [
                'id' => $p->id,
                'name' => $p->name,
                'sku' => $p->sku,
                'selling_price' => floatval($p->selling_price),
                'stock' => intval($p->stock),
                'unit' => $p->unit,
                'category_id' => $p->category_id,
                'category_name' => $p->category->name ?? 'Tanpa Kategori'
            ];
        });

        // Load customers with sales count to identify frequent buyers
        $customersData = Customer::withCount('sales')->orderBy('name')->get()->map(function($c){
            return [
                'id' => $c->id,
                'name' => $c->name,
                'sales_count' => intval($c->sales_count ?? 0)
            ];
        });

        // Load categories for filtering
        $categories = \App\Models\Category::orderBy('name')->get();

        // Check if there is a newly saved transaction to print
        $printSale = null;
        if (session('print_sale_id')) {
            $printSale = Sale::with(['customer', 'items.product'])->find(session('print_sale_id'));
        }

        return view('pos.index', compact('productsData', 'customersData', 'categories', 'printSale'));
    }

    /**
     * Store a new sale transaction.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'discount' => 'nullable|numeric|min:0',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $saleId = DB::transaction(function () use ($validated) {
            $totalAmount = 0;
            $totalProfit = 0;
            $discount = isset($validated['discount']) ? floatval($validated['discount']) : 0;

            // Create the sale header first
            $sale = Sale::create([
                'customer_id' => $validated['customer_id'] ?? null,
                'total_amount' => 0,
                'discount' => $discount,
                'total_profit' => 0,
            ]);

            foreach ($validated['items'] as $item) {
                $product = Product::findOrFail($item['product_id']);
                $quantity = $item['quantity'];

                // Ensure enough stock
                if ($product->stock < $quantity) {
                    abort(422, "Stok tidak cukup untuk produk {$product->name}");
                }

                // Update stock
                $product->decrement('stock', $quantity);

                // Record stock movement
                \App\Models\StockMovement::create([
                    'product_id' => $product->id,
                    'user_id' => \Illuminate\Support\Facades\Auth::id() ?? 1,
                    'type' => 'out',
                    'quantity' => $quantity,
                    'reason' => "Penjualan POS (Transaksi #{$sale->id})",
                ]);

                $unitPrice = $product->selling_price;
                $unitCost = $product->purchase_price;
                $subtotal = $unitPrice * $quantity;
                $profit = ($unitPrice - $unitCost) * $quantity;

                // Record sale item
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'unit_cost' => $unitCost,
                    'subtotal' => $subtotal,
                    'profit' => $profit,
                ]);

                $totalAmount += $subtotal;
                $totalProfit += $profit;
            }

            // Deduct discount from total amount and profit
            $finalAmount = max(0, $totalAmount - $discount);
            $finalProfit = $totalProfit - $discount;

            // Update totals on the sale record
            $sale->update([
                'total_amount' => $finalAmount,
                'total_profit' => $finalProfit,
            ]);

            return $sale->id;
        });

        return Redirect::route('pos.index')
            ->with('success', 'Transaksi berhasil dicatat.')
            ->with('print_sale_id', $saleId);
    }

    /**
     * Print receipt for a past sale transaction.
     */
    public function printReceipt(Sale $sale)
    {
        $sale->load(['customer', 'items.product']);
        return view('pos.print', compact('sale'));
    }
}
?>
