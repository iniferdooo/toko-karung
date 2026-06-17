<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight">
            {{ __('Tambah Hutang Baru') }}
        </h2>
        <p class="text-sm text-slate-500 mt-1">Buat catatan hutang baru untuk transaksi kredit pelanggan.</p>
    </x-slot>

    <div class="py-6" x-data="{ total: '', sisa: '' }">
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
                <form method="POST" action="{{ route('debts.store') }}">
                    @csrf
                    <div class="space-y-6">
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2" for="customer_id">Nama Pelanggan <span class="text-rose-500">*</span></label>
                                <select id="customer_id" name="customer_id" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition text-sm" required>
                                    <option value="">-- Pilih Pelanggan --</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                            {{ $customer->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2" for="status">Status Pembayaran <span class="text-rose-500">*</span></label>
                                <select id="status" name="status" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition text-sm" required>
                                    <option value="unpaid" {{ old('status') == 'unpaid' ? 'selected' : '' }}>Belum Lunas</option>
                                    <option value="paid" {{ old('status') == 'paid' ? 'selected' : '' }}>Lunas</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2" for="total_amount">Total Nilai Hutang (Rp) <span class="text-rose-500">*</span></label>
                                <input id="total_amount" name="total_amount" type="number" step="0.01" value="{{ old('total_amount') }}" x-model="total" @input="sisa = total" placeholder="0" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition text-sm" required>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2" for="remaining_amount">Sisa Hutang (Rp) <span class="text-rose-500">*</span></label>
                                <input id="remaining_amount" name="remaining_amount" type="number" step="0.01" value="{{ old('remaining_amount') }}" x-model="sisa" placeholder="0" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition text-sm" required>
                                <span class="text-[10px] text-slate-400 mt-1.5 block">Diisi otomatis sesuai total nilai hutang.</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2" for="debt_date">Tanggal Hutang <span class="text-rose-500">*</span></label>
                                <input id="debt_date" name="debt_date" type="date" value="{{ old('debt_date', date('Y-m-d')) }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition text-sm" required>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2" for="due_date">Tanggal Jatuh Tempo</label>
                                <input id="due_date" name="due_date" type="date" value="{{ old('due_date') }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition text-sm">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2" for="notes">Catatan Transaksi</label>
                            <textarea id="notes" name="notes" rows="3" placeholder="Contoh: Pembelian karung goni bekas 100 lembar" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition text-sm">{{ old('notes') }}</textarea>
                        </div>

                        <div class="flex items-center justify-end pt-4 border-t border-slate-50 space-x-3">
                            <a href="{{ route('debts.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-xl text-sm transition">Batal</a>
                            <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-sm shadow-md shadow-indigo-500/20 transition">Simpan Hutang</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
