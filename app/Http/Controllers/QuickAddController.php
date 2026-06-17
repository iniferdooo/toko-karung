<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Category;
use App\Models\Debt;
use Illuminate\Http\Request;

class QuickAddController extends Controller
{
    public function index()
    {
        $customers = Customer::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();
        $debts = Debt::with('customer')->where('status', 'unpaid')->latest()->get();

        return view('quick_add', compact('customers', 'categories', 'debts'));
    }
}
