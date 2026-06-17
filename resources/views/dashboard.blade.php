<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
        <p class="text-sm text-slate-500 mt-1">Selamat datang kembali! Berikut ringkasan performa dan transaksi toko Anda hari ini.</p>
    </x-slot>

    <div class="space-y-6">
        <!-- 4 Metric Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            
            <!-- Metric Card 1: Pelanggan -->
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between hover:translate-y-[-2px] transition-all duration-300">
                <div class="space-y-2">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total Pelanggan</span>
                    <h3 class="text-2xl font-extrabold text-slate-800">{{ $totalCustomers }}</h3>
                    <p class="text-xs text-slate-400">Terdaftar aktif</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600 shadow-inner">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>

            <!-- Metric Card 2: Produk -->
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between hover:translate-y-[-2px] transition-all duration-300">
                <div class="space-y-2">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Stok Barang</span>
                    <h3 class="text-2xl font-extrabold text-slate-800">{{ $totalProducts }}</h3>
                    <p class="text-xs text-slate-400">Variasi produk terdata</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600 shadow-inner">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
            </div>

            <!-- Metric Card 3: Sisa Piutang Aktif -->
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between hover:translate-y-[-2px] transition-all duration-300">
                <div class="space-y-2">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Sisa Piutang Aktif</span>
                    <h3 class="text-2xl font-extrabold text-amber-600">Rp {{ number_format($totalDebt, 0, ',', '.') }}</h3>
                    <p class="text-xs text-slate-400">Belum ditagih/lunas</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600 shadow-inner">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M12 16v-1" />
                    </svg>
                </div>
            </div>

            <!-- Metric Card 5: Pendapatan Penjualan -->
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between hover:translate-y-[-2px] transition-all duration-300">
                <div class="space-y-2">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Pendapatan Penjualan</span>
                    <h3 class="text-2xl font-extrabold text-emerald-600">Rp {{ number_format($salesRevenue, 0, ',', '.') }}</h3>
                    <p class="text-xs text-slate-400">Total penjualan</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600 shadow-inner">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h18v18H3V3z"/></svg>
                </div>
            </div>

            <!-- Metric Card 6: Laba Penjualan -->
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between hover:translate-y-[-2px] transition-all duration-300">
                <div class="space-y-2">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Laba Penjualan</span>
                    <h3 class="text-2xl font-extrabold text-rose-600">Rp {{ number_format($salesProfit, 0, ',', '.') }}</h3>
                    <p class="text-xs text-slate-400">Total profit</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-rose-50 flex items-center justify-center text-rose-600 shadow-inner">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v8"/></svg>
                </div>
            </div>

            <!-- Metric Card 4: Total Pembayaran -->
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between hover:translate-y-[-2px] transition-all duration-300">
                <div class="space-y-2">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total Bayar Masuk</span>
                    <h3 class="text-2xl font-extrabold text-violet-600">Rp {{ number_format($totalPayments, 0, ',', '.') }}</h3>
                    <p class="text-xs text-slate-400">Total cicilan/lunas</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-violet-50 flex items-center justify-center text-violet-600 shadow-inner">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
            </div>

        </div>

        <!-- Quick Access Section -->
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm space-y-4">
            <h3 class="font-bold text-md text-slate-700">Akses Cepat Tambah Data</h3>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <a href="{{ route('quick-add.index') }}?tab=pelanggan" class="group p-4 bg-slate-50 hover:bg-indigo-600 hover:text-white rounded-2xl border border-slate-100 flex flex-col items-center justify-center text-center transition-all duration-200">
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 group-hover:bg-indigo-500 group-hover:text-white flex items-center justify-center mb-2 transition">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="text-xs font-bold">+ Pelanggan</span>
                </a>

                <a href="{{ route('quick-add.index') }}?tab=kategori" class="group p-4 bg-slate-50 hover:bg-indigo-600 hover:text-white rounded-2xl border border-slate-100 flex flex-col items-center justify-center text-center transition-all duration-200">
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 group-hover:bg-indigo-500 group-hover:text-white flex items-center justify-center mb-2 transition">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <span class="text-xs font-bold">+ Kategori</span>
                </a>

                <a href="{{ route('quick-add.index') }}?tab=produk" class="group p-4 bg-slate-50 hover:bg-indigo-600 hover:text-white rounded-2xl border border-slate-100 flex flex-col items-center justify-center text-center transition-all duration-200">
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 group-hover:bg-indigo-500 group-hover:text-white flex items-center justify-center mb-2 transition">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <span class="text-xs font-bold">+ Produk</span>
                </a>

                <a href="{{ route('quick-add.index') }}?tab=hutang" class="group p-4 bg-slate-50 hover:bg-indigo-600 hover:text-white rounded-2xl border border-slate-100 flex flex-col items-center justify-center text-center transition-all duration-200">
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 group-hover:bg-indigo-500 group-hover:text-white flex items-center justify-center mb-2 transition">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <span class="text-xs font-bold">+ Hutang</span>
                </a>
            </div>
        </div>

        <!-- Main Dashboard Split Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Left Side: Recent Debts & Payments (2/3 width) -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Section: Recent Debts -->
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                    <div class="p-5 border-b border-slate-50 flex items-center justify-between">
                        <h3 class="font-bold text-sm text-slate-700">Daftar Hutang Terbaru</h3>
                        <a href="{{ route('debts.index') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 transition">Lihat Semua →</a>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-100 text-left">
                            <thead class="bg-slate-50/50">
                                <tr>
                                    <th class="px-5 py-3 text-xs font-bold text-slate-400 uppercase tracking-widest">Pelanggan</th>
                                    <th class="px-5 py-3 text-xs font-bold text-slate-400 uppercase tracking-widest">Total Hutang</th>
                                    <th class="px-5 py-3 text-xs font-bold text-slate-400 uppercase tracking-widest">Sisa Hutang</th>
                                    <th class="px-5 py-3 text-xs font-bold text-slate-400 uppercase tracking-widest">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse ($recentDebts as $debt)
                                    <tr class="hover:bg-slate-50/30 transition">
                                        <td class="px-5 py-4 whitespace-nowrap text-sm font-semibold text-slate-700">{{ $debt->customer->name ?? 'Pelanggan Terhapus' }}</td>
                                        <td class="px-5 py-4 whitespace-nowrap text-sm text-slate-600">Rp {{ number_format($debt->total_amount, 0, ',', '.') }}</td>
                                        <td class="px-5 py-4 whitespace-nowrap text-sm text-slate-600 font-bold">Rp {{ number_format($debt->remaining_amount, 0, ',', '.') }}</td>
                                        <td class="px-5 py-4 whitespace-nowrap">
                                            @if ($debt->status === 'paid')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span>
                                                    Lunas
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-100">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-1.5"></span>
                                                    Belum Lunas
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-5 py-8 text-center text-xs text-slate-400 font-medium">Belum ada transaksi hutang tercatat.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Section: Recent Payments -->
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                    <div class="p-5 border-b border-slate-50 flex items-center justify-between">
                        <h3 class="font-bold text-sm text-slate-700">Riwayat Cicilan & Pembayaran</h3>
                        <a href="{{ route('debt-payments.index') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 transition">Lihat Semua →</a>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-100 text-left">
                            <thead class="bg-slate-50/50">
                                <tr>
                                    <th class="px-5 py-3 text-xs font-bold text-slate-400 uppercase tracking-widest">Pelanggan</th>
                                    <th class="px-5 py-3 text-xs font-bold text-slate-400 uppercase tracking-widest">Jumlah Dibayar</th>
                                    <th class="px-5 py-3 text-xs font-bold text-slate-400 uppercase tracking-widest">Tanggal</th>
                                    <th class="px-5 py-3 text-xs font-bold text-slate-400 uppercase tracking-widest">Catatan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse ($recentPayments as $payment)
                                    <tr class="hover:bg-slate-50/30 transition">
                                        <td class="px-5 py-4 whitespace-nowrap text-sm font-semibold text-slate-700">{{ $payment->debt->customer->name ?? 'Pelanggan Terhapus' }}</td>
                                        <td class="px-5 py-4 whitespace-nowrap text-sm font-bold text-emerald-600">Rp {{ number_format($payment->amount_paid, 0, ',', '.') }}</td>
                                        <td class="px-5 py-4 whitespace-nowrap text-sm text-slate-500">{{ $payment->payment_date }}</td>
                                        <td class="px-5 py-4 text-sm text-slate-500 truncate max-w-[200px]">{{ $payment->notes ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-5 py-8 text-center text-xs text-slate-400 font-medium">Belum ada pembayaran cicilan tercatat.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <!-- Right Side: Low Stock & Summary Statistics (1/3 width) -->
            <div class="space-y-6">
                
                <!-- Section: Low Stock Warning -->
                <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm space-y-4">
                    <div class="flex items-center justify-between">
                        <h3 class="font-bold text-sm text-slate-700">Peringatan Stok Tipis</h3>
                        <span class="text-[10px] font-bold bg-amber-50 text-amber-700 px-2 py-0.5 rounded-full">Min. 10 pcs</span>
                    </div>

                    <div class="space-y-3 max-h-[300px] overflow-y-auto pr-1">
                        @forelse ($lowStockProducts as $prod)
                            <div class="flex items-center justify-between p-3 bg-rose-50/30 hover:bg-rose-50/60 border border-rose-100 rounded-xl transition">
                                <div>
                                    <h4 class="text-sm font-bold text-slate-800">{{ $prod->name }}</h4>
                                    <p class="text-[10px] text-slate-400 mt-0.5">SKU: {{ $prod->sku }}</p>
                                </div>
                                <div class="text-right">
                                    <span class="text-xs font-extrabold text-rose-700 bg-rose-100 px-2.5 py-1 rounded-lg">
                                        {{ $prod->stock }} {{ $prod->unit }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="flex flex-col items-center justify-center py-8 text-center space-y-2">
                                <div class="w-10 h-10 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center shadow-inner">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <p class="text-xs text-slate-500 font-semibold">Semua stok produk aman!</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Section: Quick Quick Ratios / Statistics -->
                <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm space-y-4">
                    <h3 class="font-bold text-sm text-slate-700 font-sans">Proporsi Pembayaran</h3>
                    
                    @php
                        $grandTotalDebt = \App\Models\Debt::sum('total_amount');
                        $paidRatio = $grandTotalDebt > 0 ? ($totalPayments / $grandTotalDebt) * 100 : 0;
                        $unpaidRatio = 100 - $paidRatio;
                    @endphp

                    <div class="space-y-4">
                        <div class="space-y-1.5">
                            <div class="flex justify-between text-xs font-bold text-slate-500">
                                <span>Terbayar/Lunas ({{ number_format($paidRatio, 1) }}%)</span>
                                <span>Sisa Hutang ({{ number_format($unpaidRatio, 1) }}%)</span>
                            </div>
                            <div class="w-full bg-slate-100 h-3.5 rounded-full overflow-hidden flex">
                                <div class="bg-indigo-600 h-full shadow-inner" style="width: {{ $paidRatio }}%"></div>
                                <div class="bg-amber-400 h-full shadow-inner animate-pulse" style="width: {{ $unpaidRatio }}%"></div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 pt-2 text-center">
                            <div class="p-3 bg-slate-50 rounded-xl">
                                <span class="text-[10px] font-bold text-slate-400 block uppercase">Total Piutang</span>
                                <span class="text-sm font-extrabold text-slate-700">Rp {{ number_format($grandTotalDebt, 0, ',', '.') }}</span>
                            </div>
                            <div class="p-3 bg-slate-50 rounded-xl">
                                <span class="text-[10px] font-bold text-slate-400 block uppercase">Total Pelunasan</span>
                                <span class="text-sm font-extrabold text-indigo-600">Rp {{ number_format($totalPayments, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
