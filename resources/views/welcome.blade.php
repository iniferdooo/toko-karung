<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Toko Karung G') }} — Sistem Kasir & Piutang</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

        <!-- Scripts & Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-slate-950 text-slate-100 min-h-screen relative overflow-x-hidden">
        <!-- Background decorative blobs -->
        <div class="absolute top-0 left-0 -translate-x-1/3 -translate-y-1/3 w-[500px] h-[500px] bg-indigo-600/10 rounded-full blur-[120px] pointer-events-none"></div>
        <div class="absolute top-1/2 right-0 translate-x-1/3 -translate-y-1/2 w-[500px] h-[500px] bg-emerald-600/10 rounded-full blur-[120px] pointer-events-none"></div>

        <!-- HEADER / NAVIGATION -->
        <header class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 relative z-10">
            <div class="flex items-center justify-between">
                <!-- Brand Logo -->
                <a href="/" class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center font-extrabold text-base text-white shadow-lg shadow-indigo-600/35">K</div>
                    <div>
                        <div class="font-extrabold text-sm text-white tracking-wider">Toko Karung G</div>
                        <div class="text-[8px] font-bold text-indigo-400 uppercase tracking-widest -mt-0.5">Sistem Kasir & Piutang</div>
                    </div>
                </a>

                <!-- Navigation Links -->
                <nav class="flex items-center gap-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="inline-flex items-center justify-center px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-xs shadow-md shadow-indigo-500/20 hover:shadow-indigo-500/35 transition duration-150">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-xs font-bold text-slate-400 hover:text-white transition duration-150">
                                {{ __('Masuk') }}
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-xs shadow-md shadow-indigo-500/20 hover:shadow-indigo-500/35 transition duration-150">
                                    {{ __('Daftar Baru') }}
                                </a>
                            @endif
                        @endauth
                    @endif
                </nav>
            </div>
        </header>

        <!-- HERO SECTION -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-12 pb-20 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                <!-- Left Content -->
                <div class="lg:col-span-7 space-y-6">
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 rounded-full text-xs font-semibold">
                        <span class="w-1.5 h-1.5 rounded-full bg-indigo-400 animate-pulse"></span>
                        Versi Baru 2.0 — Menggunakan SQLite
                    </div>
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-white leading-tight">
                        Solusi Pintar Kelola Usaha <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-400 via-indigo-500 to-emerald-400">Karung Goni</span>
                    </h1>
                    <p class="text-sm sm:text-base text-slate-400 leading-relaxed max-w-xl">
                        Aplikasi manajemen penjualan (Kasir/POS) dan pelacakan hutang piutang pelanggan terlengkap. Dibuat khusus untuk efisiensi transaksi, manajemen persediaan, dan pencatatan cicilan secara transparan.
                    </p>
                    <div class="flex flex-wrap gap-4 pt-2">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="inline-flex items-center justify-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-sm shadow-md shadow-indigo-500/20 hover:shadow-indigo-500/35 transition duration-150">
                                Masuk ke Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-sm shadow-md shadow-indigo-500/20 hover:shadow-indigo-500/35 transition duration-150">
                                Mulai Sekarang
                            </a>
                            <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-5 py-3 bg-slate-900 hover:bg-slate-800 text-slate-300 font-semibold rounded-xl text-sm border border-slate-800 transition duration-150">
                                Daftar Akun Baru
                            </a>
                        @endauth
                    </div>
                </div>

                <!-- Right Visual Mockup -->
                <div class="lg:col-span-5 relative">
                    <!-- Dashboard Mockup Card -->
                    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 shadow-2xl space-y-6 relative overflow-hidden">
                        <!-- Top Accent Line -->
                        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-indigo-500 to-emerald-500"></div>

                        <!-- Card Header Mockup -->
                        <div class="flex items-center justify-between pb-4 border-b border-slate-800">
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 rounded-full bg-rose-500/80"></span>
                                <span class="w-3 h-3 rounded-full bg-amber-500/80"></span>
                                <span class="w-3 h-3 rounded-full bg-emerald-500/80"></span>
                            </div>
                            <span class="text-[10px] font-mono text-slate-500">toko-karung-g.com/dashboard</span>
                        </div>

                        <!-- Metric Row Mockup -->
                        <div class="grid grid-cols-2 gap-4">
                            <!-- Metrik 1 -->
                            <div class="bg-slate-950 p-4 border border-slate-800/50 rounded-xl">
                                <span class="text-[9px] font-bold text-slate-500 uppercase tracking-wider block">Total Pelanggan</span>
                                <span class="text-xl font-extrabold text-white block mt-1">42</span>
                                <span class="text-[9px] text-indigo-400 font-bold block mt-1">▲ 12% Bulan ini</span>
                            </div>
                            <!-- Metrik 2 -->
                            <div class="bg-slate-950 p-4 border border-slate-800/50 rounded-xl">
                                <span class="text-[9px] font-bold text-slate-500 uppercase tracking-wider block">Piutang Aktif</span>
                                <span class="text-xl font-extrabold text-amber-500 block mt-1">Rp 4.750.000</span>
                                <span class="text-[9px] text-slate-500 block mt-1">Belum ditagih/lunas</span>
                            </div>
                        </div>

                        <!-- Table Mockup -->
                        <div class="bg-slate-950 border border-slate-800/50 rounded-xl overflow-hidden">
                            <div class="bg-slate-900/50 px-4 py-2 border-b border-slate-800 flex justify-between items-center">
                                <span class="text-[10px] font-bold text-slate-400">Transaksi Terbaru</span>
                                <span class="text-[9px] font-bold text-indigo-400">Lihat Semua →</span>
                            </div>
                            <div class="p-3 space-y-2">
                                <div class="flex items-center justify-between text-xs py-1 border-b border-slate-900">
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-full bg-indigo-950 text-indigo-400 flex items-center justify-center font-bold text-[10px]">B</div>
                                        <div>
                                            <p class="font-bold text-white text-[11px]">Budi Santoso</p>
                                        </div>
                                    </div>
                                    <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-amber-500/10 text-amber-400 border border-amber-500/20">Belum Lunas</span>
                                </div>
                                <div class="flex items-center justify-between text-xs py-1">
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-full bg-emerald-950 text-emerald-400 flex items-center justify-center font-bold text-[10px]">S</div>
                                        <div>
                                            <p class="font-bold text-white text-[11px]">Siti Rahayu</p>
                                        </div>
                                    </div>
                                    <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Lunas</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- FEATURES SECTION -->
        <section class="border-t border-slate-900 bg-slate-950/50 py-20 relative z-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Section Header -->
                <div class="text-center max-w-3xl mx-auto space-y-4 mb-16">
                    <h2 class="text-xs font-bold text-indigo-400 uppercase tracking-widest">Mengapa Toko Karung G?</h2>
                    <p class="text-3xl sm:text-4xl font-extrabold text-white">Fitur Lengkap Untuk Produktivitas Usaha</p>
                    <p class="text-sm text-slate-400 leading-relaxed">
                        Dirancang untuk menyelesaikan masalah pencatatan manual. Semua modul terintegrasi untuk mempercepat alur transaksi Anda.
                    </p>
                </div>

                <!-- Features Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Fitur 1 -->
                    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 hover:-translate-y-1.5 transition-all duration-300 group">
                        <div class="w-12 h-12 rounded-xl bg-indigo-500/10 text-indigo-400 flex items-center justify-center mb-6 group-hover:bg-indigo-600 group-hover:text-white transition duration-300">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-white mb-2">Kasir & Point of Sale (POS)</h3>
                        <p class="text-xs text-slate-400 leading-relaxed">
                            Input penjualan karung goni secara instan. Kalkulasi subtotal, diskon, modal dasar (HPP), hingga perolehan keuntungan secara otomatis untuk setiap nota transaksi.
                        </p>
                    </div>

                    <!-- Fitur 2 -->
                    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 hover:-translate-y-1.5 transition-all duration-300 group">
                        <div class="w-12 h-12 rounded-xl bg-amber-500/10 text-amber-400 flex items-center justify-center mb-6 group-hover:bg-amber-600 group-hover:text-white transition duration-300">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-white mb-2">Pelacakan Hutang Piutang</h3>
                        <p class="text-xs text-slate-400 leading-relaxed">
                            Pantau total piutang yang belum terbayar oleh pelanggan. Dilengkapi deteksi otomatis keterlambatan tanggal jatuh tempo dan pencatatan cicilan bertahap yang rapi.
                        </p>
                    </div>

                    <!-- Fitur 3 -->
                    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 hover:-translate-y-1.5 transition-all duration-300 group">
                        <div class="w-12 h-12 rounded-xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center mb-6 group-hover:bg-emerald-600 group-hover:text-white transition duration-300">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-white mb-2">Log Persediaan & Mutasi Stok</h3>
                        <p class="text-xs text-slate-400 leading-relaxed">
                            Mengawasi perputaran stok barang. Setiap barang keluar dari kasir atau restok masuk terekam dengan jelas dalam log mutasi stok karung goni Anda.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- FOOTER -->
        <footer class="border-t border-slate-900 py-10 relative z-10 text-center text-slate-500 text-xs">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-3">
                <p>&copy; 2026 Toko Karung G. Hak Cipta Dilindungi.</p>
                <div class="flex items-center justify-center gap-4 text-slate-600">
                    <span>Laravel v{{ app()->version() }}</span>
                    <span>&middot;</span>
                    <span>TailwindCSS v3.x + Vite</span>
                    <span>&middot;</span>
                    <span>SQLite Database</span>
                </div>
            </div>
        </footer>
    </body>
</html>
