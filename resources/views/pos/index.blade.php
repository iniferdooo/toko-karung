{{-- resources/views/pos/index.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kasir POS — Toko Karung G</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }

        /* Hide number input spin buttons */
        input[type=number]::-webkit-outer-spin-button,
        input[type=number]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        input[type=number] {
            -moz-appearance: textfield;
        }

        /* POS full screen layout */
        html, body { height: 100%; overflow: hidden; background: #f8fafc; }

        /* Scrollbars */
        .scroll-y::-webkit-scrollbar { width: 5px; }
        .scroll-y::-webkit-scrollbar-track { background: transparent; }
        .scroll-y::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .scroll-y::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        /* Product tile animation */
        .product-card { transition: all .15s ease; }
        .product-card:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,.08); }
        .product-card:active { transform: scale(.97); }
        .product-card.in-cart { background: #f0fdf4; border-color: #86efac; }

        /* Print */
        @media print {
            body * { visibility: hidden !important; }
            #struk-print, #struk-print * { visibility: visible !important; }
            #struk-print {
                position: fixed !important; inset: 0;
                width: 72mm; margin: 0 auto;
                padding: 10px; font-size: 10pt;
                font-family: 'Courier New', monospace;
                background: white; color: black;
                box-shadow: none; border: none;
            }
        }
    </style>
</head>
<body>
<div x-data="posApp()" class="flex flex-col" style="height:100vh;">

    {{-- ═══════════════════════════════════════════
         TOP BAR
    ═══════════════════════════════════════════ --}}
    <div class="flex-none bg-white border-b border-slate-200 shadow-sm z-30">
        <div class="flex items-center h-14 px-4 gap-3">

            {{-- Brand --}}
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2 flex-none mr-2">
                <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center text-white font-black text-sm shadow">K</div>
                <span class="font-bold text-slate-800 hidden sm:block">Toko Karung G</span>
            </a>

            {{-- Product Search --}}
            <div class="flex-1 relative max-w-md">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input x-model="search" type="text"
                    placeholder="Cari nama produk atau SKU..."
                    class="w-full pl-9 pr-4 py-2 text-sm bg-slate-100 rounded-xl border border-transparent focus:bg-white focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 transition outline-none">
            </div>

            {{-- Cart badge --}}
            <div class="flex-none flex items-center gap-2 ml-auto">
                <div class="relative">
                    <svg class="h-6 w-6 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span x-show="cartCount > 0"
                        x-text="cartCount"
                        class="absolute -top-1.5 -right-1.5 min-w-[18px] h-[18px] bg-emerald-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center px-1">
                    </span>
                </div>
                <span class="text-sm text-slate-500 font-medium">
                    {{ Auth::user()->name }}
                </span>
                <a href="{{ route('dashboard') }}"
                   class="p-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 transition" title="Dashboard">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                </a>
            </div>
        </div>

        {{-- Category pills below topbar --}}
        <div class="flex items-center gap-2 px-4 pb-3 overflow-x-auto">
            <button @click="activeCat = ''"
                :class="activeCat === '' ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-slate-600 border-slate-200 hover:border-indigo-300'"
                class="px-3 py-1 rounded-full text-xs font-bold border whitespace-nowrap transition flex-none">
                Semua
            </button>
            <template x-for="cat in categories" :key="cat.id">
                <button @click="activeCat = cat.id"
                    :class="activeCat == cat.id ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-slate-600 border-slate-200 hover:border-indigo-300'"
                    class="px-3 py-1 rounded-full text-xs font-bold border whitespace-nowrap transition flex-none"
                    x-text="cat.name">
                </button>
            </template>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════
         MAIN CONTENT
    ═══════════════════════════════════════════ --}}
    <div class="flex flex-1 overflow-hidden">

        {{-- ─── LEFT: Product Grid ─── --}}
        <div class="flex-1 overflow-y-auto scroll-y p-4">

            {{-- Empty state --}}
            <div x-show="filteredProducts.length === 0" class="flex flex-col items-center justify-center h-64 text-slate-400">
                <svg class="h-12 w-12 mb-3 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
                <p class="text-sm font-semibold">Produk tidak ditemukan</p>
                <p class="text-xs mt-1">Coba ubah kata kunci pencarian</p>
            </div>

            {{-- Product Grid --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-4 xl:grid-cols-5 gap-3">
                <template x-for="p in filteredProducts" :key="p.id">
                    <div @click="p.stock > 0 && addItem(p)"
                         :class="{
                             'in-cart': cartQty(p.id) > 0,
                             'opacity-50 cursor-not-allowed': p.stock <= 0,
                             'cursor-pointer': p.stock > 0
                         }"
                         class="product-card bg-white rounded-2xl border border-slate-200 overflow-hidden select-none">

                        {{-- Image area --}}
                        <div class="relative">
                            <div class="aspect-square bg-slate-50 flex items-center justify-center overflow-hidden">
                                <img src="{{ asset('img/product_placeholder.png') }}"
                                     class="w-full h-full object-cover opacity-70"
                                     alt="">
                            </div>

                            {{-- Cart qty badge --}}
                            <div x-show="cartQty(p.id) > 0"
                                 class="absolute top-2 right-2 w-6 h-6 bg-emerald-500 text-white text-xs font-black rounded-full flex items-center justify-center shadow-lg"
                                 x-text="cartQty(p.id)">
                            </div>

                            {{-- Out of stock overlay --}}
                            <div x-show="p.stock <= 0"
                                 class="absolute inset-0 bg-white/70 flex items-center justify-center">
                                <span class="text-[10px] font-bold bg-rose-500 text-white px-2 py-0.5 rounded-full">Habis</span>
                            </div>

                            {{-- Low stock badge --}}
                            <div x-show="p.stock > 0 && p.stock <= 10"
                                 class="absolute top-2 left-2 text-[9px] font-bold bg-amber-400 text-white px-1.5 py-0.5 rounded-full shadow">
                                Sisa <span x-text="p.stock"></span>
                            </div>
                        </div>

                        {{-- Info --}}
                        <div class="px-2.5 py-2">
                            <p class="text-xs font-bold text-slate-800 leading-snug truncate" x-text="p.name"></p>
                            <p class="text-[10px] text-indigo-500 font-semibold mt-0.5" x-text="p.sku"></p>
                            <p class="text-sm font-bold text-slate-900 mt-1" x-text="rp(p.selling_price)"></p>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        {{-- ─── RIGHT: Order Panel ─── --}}
        <div class="flex-none w-72 xl:w-80 border-l border-slate-200 bg-white flex flex-col">

            {{-- Order list --}}
            <div class="flex-1 overflow-y-auto scroll-y divide-y divide-slate-100">

                {{-- Empty order --}}
                <div x-show="items.length === 0" class="flex flex-col items-center justify-center h-full text-slate-300 py-10">
                    <svg class="h-10 w-10 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    <p class="text-xs font-medium">Pilih produk di sebelah kiri</p>
                </div>

                <template x-for="(it, idx) in items" :key="it.product_id">
                    <div class="flex flex-col px-4 py-3 hover:bg-slate-50 transition border-b border-slate-100 gap-1.5">
                        <div class="flex items-start gap-2">
                            {{-- Qty control --}}
                            <div class="flex-none flex items-center gap-1 mt-0.5">
                                <button @click="decQty(idx)"
                                    class="w-5 h-5 rounded bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-xs flex items-center justify-center transition">
                                    −
                                </button>
                                <input type="number" 
                                       x-model.number="it.qty" 
                                       @change="if(it.qty > it.stock) { alert('Stok ' + it.name + ' hanya ' + it.stock + ' ' + it.unit); it.qty = it.stock; } else if(it.qty < 1 || !it.qty) { it.qty = 1; }"
                                       class="text-xs font-bold text-slate-800 w-10 text-center bg-slate-50 border border-slate-200 rounded focus:border-indigo-400 focus:ring-1 focus:ring-indigo-100 focus:outline-none py-0.5">
                                <button @click="incQty(idx)"
                                    class="w-5 h-5 rounded bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-xs flex items-center justify-center transition">
                                    +
                                </button>
                            </div>

                            {{-- Name + SKU --}}
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-bold text-slate-800 leading-snug" x-text="it.name"></p>
                                <p class="text-[10px] text-indigo-400 font-semibold mt-0.5" x-text="it.sku"></p>
                            </div>

                            {{-- Price + delete --}}
                            <div class="flex-none flex flex-col items-end gap-1">
                                <span class="text-xs font-bold text-slate-800" x-text="rp(it.price * it.qty)"></span>
                                <button @click="items.splice(idx, 1)"
                                    class="text-slate-300 hover:text-rose-500 transition">
                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        
                        {{-- Quick Increments Row --}}
                        <div class="flex items-center gap-1.5 pl-[72px]">
                            <span class="text-[9px] text-slate-400 font-medium mr-0.5">Quick:</span>
                            <button @click="changeQty(idx, 50)" class="px-1.5 py-0.5 text-[9px] font-bold bg-slate-100 hover:bg-indigo-50 hover:text-indigo-600 rounded text-slate-600 transition border border-slate-200/60 hover:border-indigo-200">+50</button>
                            <button @click="changeQty(idx, 100)" class="px-1.5 py-0.5 text-[9px] font-bold bg-slate-100 hover:bg-indigo-50 hover:text-indigo-600 rounded text-slate-600 transition border border-slate-200/60 hover:border-indigo-200">+100</button>
                            <button @click="changeQty(idx, 1000)" class="px-1.5 py-0.5 text-[9px] font-bold bg-slate-100 hover:bg-indigo-50 hover:text-indigo-600 rounded text-slate-600 transition border border-slate-200/60 hover:border-indigo-200">+1k</button>
                            <span class="text-slate-200 text-[9px]">|</span>
                            <button @click="changeQty(idx, -50)" class="px-1.5 py-0.5 text-[9px] font-bold bg-slate-100 hover:bg-rose-50 hover:text-rose-600 rounded text-slate-600 transition border border-slate-200/60 hover:border-rose-200">-50</button>
                            <button @click="changeQty(idx, -100)" class="px-1.5 py-0.5 text-[9px] font-bold bg-slate-100 hover:bg-rose-50 hover:text-rose-600 rounded text-slate-600 transition border border-slate-200/60 hover:border-rose-200">-100</button>
                            <button @click="changeQty(idx, -1000)" class="px-1.5 py-0.5 text-[9px] font-bold bg-slate-100 hover:bg-rose-50 hover:text-rose-600 rounded text-slate-600 transition border border-slate-200/60 hover:border-rose-200">-1k</button>
                        </div>
                    </div>
                </template>
            </div>

            {{-- ─── Bottom: Discount + Total ─── --}}
            <div class="flex-none border-t border-slate-200">

                {{-- Discount row --}}
                <div class="px-4 py-3 border-b border-slate-100 space-y-2">
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-xs font-semibold text-slate-500">Diskon</span>
                        <div class="flex gap-2">
                            {{-- Pct input --}}
                            <div class="relative w-20">
                                <input type="number" x-model.number="discPct" min="0" max="100" placeholder="0"
                                    class="w-full text-xs border border-slate-200 rounded-lg pl-2 pr-5 py-1.5 focus:border-indigo-400 focus:ring-1 focus:ring-indigo-100 outline-none transition">
                                <span class="absolute right-2 top-1/2 -translate-y-1/2 text-[10px] text-slate-400 font-bold">%</span>
                            </div>
                            {{-- Rp input --}}
                            <div class="relative flex-1">
                                <input type="number" x-model.number="discRp" min="0" placeholder="0"
                                    class="w-full text-xs border border-slate-200 rounded-lg pl-6 pr-2 py-1.5 focus:border-indigo-400 focus:ring-1 focus:ring-indigo-100 outline-none transition">
                                <span class="absolute left-2 top-1/2 -translate-y-1/2 text-[10px] text-slate-400 font-bold">Rp</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Summary rows --}}
                <div class="px-4 py-3 space-y-1.5">
                    <div class="flex justify-between text-xs text-slate-500">
                        <span>Sub Total</span>
                        <span class="font-semibold text-slate-700" x-text="rp(subtotal)"></span>
                    </div>
                    <div x-show="totalDiscount > 0" class="flex justify-between text-xs text-rose-500 font-semibold">
                        <span>Diskon</span>
                        <span x-text="'−' + rp(totalDiscount)"></span>
                    </div>
                </div>

                {{-- Action buttons + Grand total --}}
                <div class="flex items-stretch gap-2 px-3 pb-4">
                    {{-- Clear cart --}}
                    <button @click="items = []"
                        :disabled="items.length === 0"
                        :class="items.length === 0 ? 'opacity-40 cursor-not-allowed' : 'hover:bg-rose-50 hover:border-rose-300 hover:text-rose-500'"
                        class="w-10 h-12 border border-slate-200 rounded-xl flex items-center justify-center text-slate-400 transition flex-none">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>

                    {{-- Checkout / Grand Total button --}}
                    <button @click="items.length > 0 && openCheckout()"
                        :disabled="items.length === 0"
                        :class="items.length === 0 ? 'bg-slate-200 text-slate-400 cursor-not-allowed' : 'bg-emerald-500 hover:bg-emerald-400 active:scale-[.98] shadow-lg shadow-emerald-500/30'"
                        class="flex-1 h-12 rounded-xl font-black text-white text-base transition-all flex items-center justify-between px-4">
                        <span class="text-sm font-bold">Bayar</span>
                        <span x-text="rp(grandTotal)"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════
         CHECKOUT CONFIRMATION MODAL
    ═══════════════════════════════════════════ --}}
    <div x-show="showConfirm"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm">

        <div @click.away="showConfirm = false"
             class="bg-white rounded-3xl shadow-2xl max-w-sm w-full"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100">

            <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-bold text-slate-800">Konfirmasi Pembayaran</h3>
                <button @click="showConfirm = false" class="text-slate-400 hover:text-slate-700 transition">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <div class="px-6 py-4 space-y-2.5">
                <div class="bg-slate-50 rounded-2xl p-4 space-y-2 max-h-40 overflow-y-auto">
                    <template x-for="it in items" :key="it.product_id">
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-700 font-medium" x-text="it.qty + 'x ' + it.name"></span>
                            <span class="font-bold text-slate-900" x-text="rp(it.price * it.qty)"></span>
                        </div>
                    </template>
                </div>

                <div class="space-y-1 text-sm">
                    <div class="flex justify-between text-slate-500">
                        <span>Subtotal</span><span x-text="rp(subtotal)"></span>
                    </div>
                    <div x-show="totalDiscount > 0" class="flex justify-between font-semibold text-rose-500">
                        <span>Diskon</span><span x-text="'−' + rp(totalDiscount)"></span>
                    </div>
                    <div class="flex justify-between font-black text-lg text-slate-900 pt-2 border-t border-dashed border-slate-200 mt-2">
                        <span>Total</span>
                        <span class="text-emerald-600" x-text="rp(grandTotal)"></span>
                    </div>
                </div>
            </div>

            <div class="px-6 pb-6 flex gap-3">
                <button @click="showConfirm = false"
                    class="flex-1 py-3 border border-slate-200 rounded-2xl text-sm font-semibold text-slate-600 hover:bg-slate-50 transition">
                    Kembali
                </button>
                <button @click="submitSale()"
                    class="flex-1 py-3 bg-emerald-500 hover:bg-emerald-400 text-white rounded-2xl text-sm font-black shadow-lg shadow-emerald-500/25 transition flex items-center justify-center gap-2">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    Simpan & Cetak
                </button>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════
         RECEIPT MODAL (shown after successful sale)
    ═══════════════════════════════════════════ --}}
    @if($printSale)
    <div x-data="{ open: true }" x-show="open"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
         x-transition>

        <div class="bg-white rounded-3xl shadow-2xl max-w-xs w-full overflow-hidden"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100">

            <div class="bg-emerald-500 px-5 py-4 flex items-center justify-between">
                <div class="flex items-center gap-2 text-white">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="font-bold text-sm">Transaksi Berhasil!</span>
                </div>
                <button @click="open = false" class="text-white/80 hover:text-white transition">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Receipt scroll area --}}
            <div class="p-4 bg-slate-100 max-h-[55vh] overflow-y-auto flex justify-center">
                <div id="struk-print"
                     class="bg-white w-full max-w-[260px] px-4 py-5 shadow-sm text-black"
                     style="font-family:'Courier New',monospace; font-size:11px; line-height:1.6;">

                    <div class="text-center mb-3">
                        <div class="font-bold text-sm tracking-widest uppercase">TOKO KARUNG G</div>
                        <div style="font-size:9px; color:#666;">Grosir & Eceran Karung</div>
                        <div style="font-size:9px; color:#666;">Telp: 0812-3456-7890</div>
                    </div>

                    <div style="border-top:1px dashed #999; margin: 8px 0;"></div>

                    <div style="font-size:9px;">
                        <div style="display:flex; justify-content:space-between;">
                            <span>No:</span><span style="font-weight:bold;">#{{ str_pad($printSale->id, 5, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <div style="display:flex; justify-content:space-between;">
                            <span>Tgl:</span><span>{{ $printSale->created_at->timezone('Asia/Jakarta')->format('d/m/Y H:i') }}</span>
                        </div>
                        <div style="display:flex; justify-content:space-between;">
                            <span>Kasir:</span><span>{{ Auth::user()->name }}</span>
                        </div>
                    </div>

                    <div style="border-top:1px dashed #999; margin: 8px 0;"></div>

                    @php $rawSub = 0; @endphp
                    @foreach($printSale->items as $item)
                        @php $line = $item->unit_price * $item->quantity; $rawSub += $line; @endphp
                        <div style="font-size:9px; margin-bottom:6px;">
                            <div style="font-weight:bold; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ $item->product->name }}</div>
                            <div style="display:flex; justify-content:space-between; color:#555;">
                                <span>{{ number_format($item->unit_price,0,',','.') }} x{{ $item->quantity }}</span>
                                <span style="font-weight:bold; color:#000;">{{ number_format($line,0,',','.') }}</span>
                            </div>
                        </div>
                    @endforeach

                    <div style="border-top:1px dashed #999; margin: 8px 0;"></div>

                    <div style="font-size:9px;">
                        <div style="display:flex; justify-content:space-between;">
                            <span>Subtotal:</span><span>{{ number_format($rawSub,0,',','.') }}</span>
                        </div>
                        @if($printSale->discount > 0)
                        <div style="display:flex; justify-content:space-between; font-weight:bold; color:#dc2626;">
                            <span>Diskon:</span><span>-{{ number_format($printSale->discount,0,',','.') }}</span>
                        </div>
                        @endif
                        <div style="display:flex; justify-content:space-between; font-weight:bold; font-size:12px; border-top:1px dotted #ccc; padding-top:4px; margin-top:4px;">
                            <span>TOTAL:</span><span>Rp{{ number_format($printSale->total_amount,0,',','.') }}</span>
                        </div>
                    </div>

                    <div style="border-top:1px dashed #999; margin: 8px 0;"></div>
                    <div style="text-align:center; font-size:9px; color:#555;">
                        <div style="font-weight:bold; color:#000; margin-bottom:2px;">*** TERIMA KASIH ***</div>
                        <div>Barang tidak dapat dikembalikan</div>
                    </div>
                </div>
            </div>

            <div class="flex gap-3 p-4 border-t border-slate-100">
                <button @click="open = false"
                    class="flex-1 py-2.5 border border-slate-200 rounded-2xl text-sm font-semibold text-slate-600 hover:bg-slate-50 transition">
                    Tutup
                </button>
                <button @click="window.print()"
                    class="flex-1 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-2xl text-sm font-bold shadow transition flex items-center justify-center gap-1.5">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    Cetak Struk
                </button>
            </div>
        </div>
    </div>
    @endif

    {{-- Hidden submit form --}}
    <form id="sale-form" method="POST" action="{{ route('pos.store') }}" class="hidden">
        @csrf
        <div id="form-fields"></div>
    </form>

</div>

<script>
function posApp() {
    return {
        search: '',
        activeCat: '',
        discPct: 0,
        discRp: 0,
        items: [],
        showConfirm: false,

        products:   @json($productsData),
        categories: @json($categories),

        get filteredProducts() {
            const q = this.search.toLowerCase().trim();
            return this.products.filter(p => {
                const matchCat = this.activeCat === '' || p.category_id == this.activeCat;
                const matchQ   = !q || p.name.toLowerCase().includes(q) || p.sku.toLowerCase().includes(q);
                return matchCat && matchQ;
            });
        },

        cartQty(pid) {
            const it = this.items.find(i => i.product_id === pid);
            return it ? it.qty : 0;
        },

        get cartCount() {
            return this.items.reduce((s, i) => s + i.qty, 0);
        },

        addItem(p) {
            const ex = this.items.find(i => i.product_id === p.id);
            if (ex) {
                if (ex.qty < p.stock) ex.qty++;
                else alert('Stok ' + p.name + ' hanya ' + p.stock + ' ' + p.unit);
            } else {
                this.items.push({
                    product_id: p.id,
                    name:  p.name,
                    sku:   p.sku,
                    price: p.selling_price,
                    qty:   1,
                    stock: p.stock,
                    unit:  p.unit
                });
            }
        },

        incQty(idx) {
            const it = this.items[idx];
            if (it.qty < it.stock) it.qty++;
            else alert('Stok ' + it.name + ' hanya ' + it.stock + ' ' + it.unit);
        },

        decQty(idx) {
            if (this.items[idx].qty > 1) this.items[idx].qty--;
            else this.items.splice(idx, 1);
        },

        changeQty(idx, amount) {
            const it = this.items[idx];
            let newQty = it.qty + amount;
            if (newQty > it.stock) {
                alert('Stok ' + it.name + ' hanya ' + it.stock + ' ' + it.unit + '. Mengatur ke stok maksimum.');
                newQty = it.stock;
            }
            if (newQty < 1) {
                newQty = 1;
            }
            it.qty = newQty;
        },

        get subtotal() { return this.items.reduce((s, i) => s + i.price * i.qty, 0); },
        get discFromPct() { return Math.round(this.subtotal * (this.discPct || 0) / 100); },
        get totalDiscount() { return Math.min(this.subtotal, this.discFromPct + (this.discRp || 0)); },
        get grandTotal() { return Math.max(0, this.subtotal - this.totalDiscount); },

        rp(v) { return 'Rp ' + Math.round(v).toLocaleString('id-ID'); },

        openCheckout() { this.showConfirm = true; },

        submitSale() {
            if (!this.items.length) return;
            const fields = document.getElementById('form-fields');
            fields.innerHTML = '';
            this.items.forEach((it, i) => {
                fields.innerHTML +=
                    `<input type="hidden" name="items[${i}][product_id]" value="${it.product_id}">` +
                    `<input type="hidden" name="items[${i}][quantity]"   value="${it.qty}">`;
            });
            fields.innerHTML += `<input type="hidden" name="discount" value="${this.totalDiscount}">`;
            document.getElementById('sale-form').submit();
        }
    };
}
</script>
</body>
</html>
