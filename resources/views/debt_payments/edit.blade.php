<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight">
            {{ __('Edit Catatan Pembayaran') }}
        </h2>
        <p class="text-sm text-slate-500 mt-1">Ubah data riwayat pembayaran cicilan hutang pelanggan.</p>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto">
            @if ($errors->any())
                <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-2xl">
                    <ul class="list-disc pl-5 text-xs space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 md:p-8">
                <form method="POST" action="{{ route('debt-payments.update', $debtPayment) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2" for="debt_id">Pilih Hutang Pelanggan <span class="text-rose-500">*</span></label>
                            <select id="debt_id" name="debt_id" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition text-sm" required>
                                <option value="">-- Pilih Hutang --</option>
                                @foreach ($debts as $debt)
                                    <option value="{{ $debt->id }}" {{ old('debt_id', $debtPayment->debt_id) == $debt->id ? 'selected' : '' }}>
                                        {{ $debt->customer->name ?? 'Tanpa Pelanggan' }} — Rp {{ number_format($debt->remaining_amount, 0, ',', '.') }} sisa (Tgl: {{ $debt->debt_date }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2" for="amount_paid">Jumlah Pembayaran (Rp) <span class="text-rose-500">*</span></label>
                                <input id="amount_paid" name="amount_paid" type="number" step="0.01" value="{{ old('amount_paid', $debtPayment->amount_paid) }}" placeholder="0" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition text-sm" required>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2" for="payment_date">Tanggal Pembayaran <span class="text-rose-500">*</span></label>
                                <input id="payment_date" name="payment_date" type="date" value="{{ old('payment_date', $debtPayment->payment_date) }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition text-sm" required>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2" for="notes">Catatan Pembayaran</label>
                            <textarea id="notes" name="notes" rows="3" placeholder="Contoh: Pembayaran cicilan cash / transfer bank" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition text-sm">{{ old('notes', $debtPayment->notes) }}</textarea>
                        </div>

                        <div class="flex items-center justify-end pt-4 border-t border-slate-50 space-x-3">
                            <a href="{{ route('debt-payments.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-xl text-sm transition">Batal</a>
                            <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-sm shadow-md shadow-indigo-500/20 transition">Simpan Perubahan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
