<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight">
                    {{ __('Daftar Produk / Inventaris') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1">Pantau stok barang, harga beli, harga jual, dan kategori produk.</p>
            </div>
            <a href="{{ route('quick-add.index') }}?tab=produk" class="inline-flex items-center px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm rounded-xl shadow-md shadow-indigo-500/20 transition duration-150">
                <svg class="h-4.5 w-4.5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Tambah Produk
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        @if (session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl flex items-center space-x-3">
                <svg class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="font-semibold text-sm">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100 text-left">
                    <thead class="bg-slate-50/50">
                        <tr>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Barang</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Kategori</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Harga Beli</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Harga Jual</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest text-center">Stok</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest text-center w-36">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($products as $product)
                            <tr class="hover:bg-slate-50/30 transition">
                                <td class="px-6 py-4 text-sm font-semibold text-slate-800">
                                    <div>
                                        <p class="font-bold text-slate-800 text-sm">{{ $product->name }}</p>
                                        <p class="text-[10px] text-slate-400 font-mono mt-0.5">SKU: {{ $product->sku }}</p>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600 font-semibold">
                                    {{ $product->category->name ?? 'Tanpa Kategori' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600">
                                    Rp {{ number_format($product->purchase_price, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-800 font-bold">
                                    Rp {{ number_format($product->selling_price, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-sm text-center whitespace-nowrap">
                                    @if ($product->stock == 0)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-100">
                                            Habis
                                        </span>
                                    @elseif ($product->stock <= 10)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-100">
                                            {{ $product->stock }} {{ $product->unit }} (Tipis)
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                            {{ $product->stock }} {{ $product->unit }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-center font-medium whitespace-nowrap">
                                    <div class="flex items-center justify-center space-x-3">
                                        <!-- Edit Link -->
                                        <a href="{{ route('products.edit', $product) }}" class="inline-flex items-center px-3 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-bold text-xs rounded-lg transition">
                                            <svg class="h-3.5 w-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Edit
                                        </a>
                                        <!-- Delete Form -->
                                        <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus produk ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 font-bold text-xs rounded-lg transition">
                                                <svg class="h-3.5 w-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center space-y-3">
                                        <div class="w-12 h-12 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center">
                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4M0-10L4 7m8 4v10M4 7v10l8 4" />
                                            </svg>
                                        </div>
                                        <p class="text-sm text-slate-500 font-semibold">Gudang kosong. Belum ada produk tercatat.</p>
                                        <a href="{{ route('quick-add.index') }}?tab=produk" class="text-xs font-bold text-indigo-600 hover:text-indigo-800">Tambah Sekarang →</a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
