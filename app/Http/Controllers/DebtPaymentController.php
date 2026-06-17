<?php

namespace App\Http\Controllers;

use App\Models\DebtPayment;
use App\Models\Debt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DebtPaymentController extends Controller
{
    public function index()
    {
        $payments = DebtPayment::with('debt.customer')->get();
        return view('debt_payments.index', compact('payments'));
    }

    public function create()
    {
        $debts = Debt::with('customer')->where('status', 'unpaid')->get();
        return view('debt_payments.create', compact('debts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'debt_id'      => 'required|exists:debts,id',
            'amount_paid'  => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'notes'        => 'nullable|string',
        ]);

        $validated['user_id'] = Auth::id();

        DebtPayment::create($validated);

        // Update sisa hutang
        $debt = Debt::findOrFail($validated['debt_id']);
        $debt->remaining_amount = max(0, $debt->remaining_amount - $validated['amount_paid']);
        if ($debt->remaining_amount <= 0) {
            $debt->status = 'paid';
        }
        $debt->save();

        return redirect()->route('debt-payments.index')->with('success', 'Pembayaran berhasil disimpan.');
    }

    public function edit(DebtPayment $debtPayment)
    {
        $debts = Debt::with('customer')->get();
        return view('debt_payments.edit', compact('debtPayment', 'debts'));
    }

    public function update(Request $request, DebtPayment $debtPayment)
    {
        $validated = $request->validate([
            'debt_id'      => 'required|exists:debts,id',
            'amount_paid'  => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'notes'        => 'nullable|string',
        ]);

        $debtPayment->update($validated);

        return redirect()->route('debt-payments.index')->with('success', 'Pembayaran berhasil diperbarui.');
    }

    public function destroy(DebtPayment $debtPayment)
    {
        $debtPayment->delete();
        return redirect()->route('debt-payments.index')->with('success', 'Pembayaran berhasil dihapus.');
    }
}
