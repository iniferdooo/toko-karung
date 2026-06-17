<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-900 antialiased bg-slate-950 relative overflow-x-hidden">
        <!-- Background decorative blobs -->
        <div class="absolute top-0 left-0 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-indigo-600/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-0 right-0 translate-x-1/2 translate-y-1/2 w-96 h-96 bg-emerald-600/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative z-10">
            <!-- Back to Welcome Page -->
            <div class="mb-4">
                <a href="/" class="flex items-center gap-2 group text-slate-400 hover:text-white transition">
                    <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span class="text-xs font-semibold uppercase tracking-wider">Kembali ke Beranda</span>
                </a>
            </div>

            <!-- Logo -->
            <div class="mb-2">
                <a href="/" class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-indigo-600 rounded-xl flex items-center justify-center font-extrabold text-lg text-white shadow-lg shadow-indigo-600/35">K</div>
                    <div>
                        <div class="font-extrabold text-base text-white tracking-wider">Toko Karung G</div>
                        <div class="text-[9px] font-bold text-indigo-400 uppercase tracking-widest -mt-0.5">Sistem Kasir & Piutang</div>
                    </div>
                </a>
            </div>

            <!-- Content Card -->
            <div class="w-full sm:max-w-md mt-6 px-8 py-8 bg-white border border-slate-100 shadow-2xl rounded-2xl overflow-hidden relative">
                <!-- Top accent line -->
                <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-indigo-500 to-emerald-500"></div>
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
