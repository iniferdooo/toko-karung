<?php

namespace App\Http\Controllers;

use App\Models\Debt;
use App\Models\Customer;
use Illuminate\Http\Request;

class DebtController extends Controller
{
    public function index()
    {
        $debts = Debt::with('customer')->latest()->get();
        return view('debts.index', compact('debts'));
    }

    public function create()
    {
        $customers = Customer::orderBy('name')->get();
        return view('debts.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id'      => 'required|exists:customers,id',
            'total_amount'     => 'required|numeric|min:0',
            'remaining_amount' => 'required|numeric|min:0',
            'status'           => 'required|in:unpaid,paid',
            'debt_date'        => 'required|date',
            'due_date'         => 'nullable|date',
            'notes'            => 'nullable|string',
        ]);
        Debt::create($validated);
        return redirect()->route('debts.index')->with('success', 'Data hutang berhasil ditambahkan.');
    }

    public function show(Debt $debt)
    {
        $debt->load('customer', 'payments');
        return view('debts.show', compact('debt'));
    }

    public function edit(Debt $debt)
    {
        $customers = Customer::orderBy('name')->get();
        return view('debts.edit', compact('debt', 'customers'));
    }

    public function update(Request $request, Debt $debt)
    {
        $validated = $request->validate([
            'customer_id'      => 'required|exists:customers,id',
            'total_amount'     => 'required|numeric|min:0',
            'remaining_amount' => 'required|numeric|min:0',
            'status'           => 'required|in:unpaid,paid',
            'debt_date'        => 'required|date',
            'due_date'         => 'nullable|date',
            'notes'            => 'nullable|string',
        ]);
        $debt->update($validated);
        return redirect()->route('debts.index')->with('success', 'Data hutang berhasil diperbarui.');
    }

    public function destroy(Debt $debt)
    {
        $debt->delete();
        return redirect()->route('debts.index')->with('success', 'Data hutang berhasil dihapus.');
    }
}
