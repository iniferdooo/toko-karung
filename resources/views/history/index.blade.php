<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-2xl text-slate-800 leading-tight">
                {{ __('Riwayat & Log Aktivitas') }}
            </h2>
            <p class="text-sm text-slate-500 mt-1">Pantau seluruh catatan transaksi penjualan, penyesuaian stok produk, dan mutasi hutang.</p>
        </div>
    </x-slot>

    <div class="py-6">
        {{-- Tab Navigation --}}
        <div class="flex items-center space-x-2 bg-white p-1.5 rounded-2xl border border-slate-100 shadow-sm mb-6 max-w-lg">
            <a href="{{ route('history.index') }}?tab=penjualan" 
               class="flex-1 text-center py-2.5 text-xs sm:text-sm font-bold rounded-xl transition duration-150 {{ $tab === 'penjualan' ? 'bg-indigo-600 text-white shadow-md shadow-indigo-500/25' : 'text-slate-600 hover:bg-slate-50' }}">
                Riwayat Penjualan
            </a>
            <a href="{{ route('history.index') }}?tab=stok" 
               class="flex-1 text-center py-2.5 text-xs sm:text-sm font-bold rounded-xl transition duration-150 {{ $tab === 'stok' ? 'bg-indigo-600 text-white shadow-md shadow-indigo-500/25' : 'text-slate-600 hover:bg-slate-50' }}">
                Perubahan Stok
            </a>
            <a href="{{ route('history.index') }}?tab=hutang" 
               class="flex-1 text-center py-2.5 text-xs sm:text-sm font-bold rounded-xl transition duration-150 {{ $tab === 'hutang' ? 'bg-indigo-600 text-white shadow-md shadow-indigo-500/25' : 'text-slate-600 hover:bg-slate-50' }}">
                Perubahan Hutang
            </a>
        </div>

        {{-- Main Content Table --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            
            {{-- ═══════════════════════════════════════════
                 TAB 1: RIWAYAT PENJUALAN
                 ═══════════════════════════════════════════ --}}
            @if ($tab === 'penjualan')
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 text-left">
                        <thead class="bg-slate-50/50">
                            <tr>
                                <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Tanggal</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">No Invoice</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Pelanggan</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Barang Belanjaan</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest text-right">Diskon</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest text-right">Total Bayar</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest text-center w-32">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($sales as $sale)
                                <tr class="hover:bg-slate-50/30 transition">
                                    <td class="px-6 py-4 text-sm text-slate-600 whitespace-nowrap font-medium">
                                        {{ $sale->created_at->timezone('Asia/Jakarta')->format('d M Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-mono font-bold text-indigo-600 whitespace-nowrap">
                                        #{{ str_pad($sale->id, 5, '0', STR_PAD_LEFT) }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-slate-800 font-semibold whitespace-nowrap">
                                        {{ $sale->customer->name ?? 'Pelanggan Umum' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-slate-600">
                                        <div class="flex flex-wrap gap-1 max-w-md">
                                            @foreach ($sale->items as $item)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-xs font-bold bg-slate-100 text-slate-700 border border-slate-200/50">
                                                    {{ $item->quantity }}x {{ $item->product->name ?? 'Produk Dihapus' }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-slate-500 text-right whitespace-nowrap">
                                        @if ($sale->discount > 0)
                                            <span class="text-rose-500 font-semibold">-Rp {{ number_format($sale->discount, 0, ',', '.') }}</span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm font-black text-slate-900 text-right whitespace-nowrap">
                                        Rp {{ number_format($sale->total_amount, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-center whitespace-nowrap">
                                        <a href="{{ route('sales.print', $sale) }}" target="_blank"
                                           class="inline-flex items-center px-3 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-bold text-xs rounded-lg transition">
                                            <svg class="h-3.5 w-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                            </svg>
                                            Cetak Struk
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center text-slate-400">
                                        Belum ada data transaksi penjualan POS.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($sales && $sales->hasPages())
                    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/30">
                        {!! $sales->links() !!}
                    </div>
                @endif

            {{-- ═══════════════════════════════════════════
                 TAB 2: PERUBAHAN STOK
                 ═══════════════════════════════════════════ --}}
            @elseif ($tab === 'stok')
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 text-left">
                        <thead class="bg-slate-50/50">
                            <tr>
                                <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Tanggal</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Produk</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest text-center">Tipe</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest text-center">Jumlah</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Keterangan</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Oleh</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($stockMovements as $movement)
                                <tr class="hover:bg-slate-50/30 transition">
                                    <td class="px-6 py-4 text-sm text-slate-600 whitespace-nowrap font-medium">
                                        {{ $movement->created_at->timezone('Asia/Jakarta')->format('d M Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-slate-800 font-semibold whitespace-nowrap">
                                        {{ $movement->product->name ?? 'Produk Dihapus' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-center whitespace-nowrap font-bold">
                                        @if ($movement->type === 'in')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                                Masuk
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-100">
                                                Keluar
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm text-center whitespace-nowrap font-black">
                                        <span class="{{ $movement->type === 'in' ? 'text-emerald-600' : 'text-rose-500' }}">
                                            {{ $movement->type === 'in' ? '+' : '-' }}{{ $movement->quantity }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-slate-600 font-medium">
                                        {{ $movement->reason ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-slate-500 whitespace-nowrap font-semibold">
                                        {{ $movement->user->name ?? 'Sistem' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                                        Belum ada log mutasi stok produk.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($stockMovements && $stockMovements->hasPages())
                    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/30">
                        {!! $stockMovements->links() !!}
                    </div>
                @endif

            {{-- ═══════════════════════════════════════════
                 TAB 3: PERUBAHAN HUTANG
                 ═══════════════════════════════════════════ --}}
            @elseif ($tab === 'hutang')
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 text-left">
                        <thead class="bg-slate-50/50">
                            <tr>
                                <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Tanggal</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Pelanggan</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest text-center">Kategori Perubahan</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest text-right">Jumlah</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($debtChanges as $change)
                                <tr class="hover:bg-slate-50/30 transition">
                                    <td class="px-6 py-4 text-sm text-slate-600 whitespace-nowrap font-medium">
                                        {{ \Carbon\Carbon::parse($change->action_date)->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-slate-800 font-semibold whitespace-nowrap">
                                        {{ $change->customer_name }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-center whitespace-nowrap font-bold">
                                        @if ($change->change_type === 'debt')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-100">
                                                Hutang Baru
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                                Pembayaran
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm text-right whitespace-nowrap font-black">
                                        <span class="{{ $change->change_type === 'debt' ? 'text-rose-500' : 'text-emerald-600' }}">
                                            {{ $change->change_type === 'debt' ? '+' : '-' }}Rp {{ number_format($change->amount, 0, ',', '.') }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-slate-600 font-medium">
                                        {{ $change->notes ?? '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                        Belum ada catatan penambahan atau pembayaran hutang.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($debtChanges && $debtChanges->hasPages())
                    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/30">
                        {!! $debtChanges->links() !!}
                    </div>
                @endif
            @endif

        </div>
    </div>
</x-app-layout>
