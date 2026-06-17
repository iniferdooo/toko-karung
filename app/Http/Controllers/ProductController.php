<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'sku' => 'required|unique:products,sku',
            'name' => 'required|string|max:255',
            'unit' => 'required|string|max:50',
            'stock' => 'required|integer',
            'purchase_price' => 'required|numeric',
            'selling_price' => 'required|numeric',
        ]);
        $product = Product::create($validated);

        // Record initial stock if greater than 0
        if ($product->stock > 0) {
            \App\Models\StockMovement::create([
                'product_id' => $product->id,
                'user_id' => \Illuminate\Support\Facades\Auth::id() ?? 1,
                'type' => 'in',
                'quantity' => $product->stock,
                'reason' => 'Stok Awal (Produk Baru)',
            ]);
        }

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'sku' => 'required|unique:products,sku,' . $product->id,
            'name' => 'required|string|max:255',
            'unit' => 'required|string|max:50',
            'stock' => 'required|integer',
            'purchase_price' => 'required|numeric',
            'selling_price' => 'required|numeric',
        ]);
        $oldStock = $product->stock;
        $product->update($validated);
        $newStock = $product->fresh()->stock;

        // Log StockMovement if stock changed
        if ($oldStock != $newStock) {
            $diff = $newStock - $oldStock;
            \App\Models\StockMovement::create([
                'product_id' => $product->id,
                'user_id' => \Illuminate\Support\Facades\Auth::id() ?? 1,
                'type' => $diff > 0 ? 'in' : 'out',
                'quantity' => abs($diff),
                'reason' => 'Edit Produk (Stok diubah dari ' . $oldStock . ' ke ' . $newStock . ')',
            ]);
        }

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
?>
