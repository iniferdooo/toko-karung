<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Toko Karung G') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            body {
                font-family: 'Plus Jakarta Sans', sans-serif;
            }
        </style>
    </head>
    <body class="antialiased bg-slate-50/50 text-slate-800">
        <div class="min-h-screen flex flex-col md:flex-row">
            
            <!-- Navigation Sidebar (includes mobile topbar) -->
            @include('layouts.navigation')

            <!-- Page Content Area -->
            <div class="flex-1 flex flex-col min-w-0">
                <!-- Page Top Header -->
                @isset($header)
                    <header class="bg-white/80 backdrop-blur-md border-b border-slate-100 sticky top-0 z-30">
                        <div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8 flex items-center justify-between">
                            <div class="flex-1 min-w-0">
                                {{ $header }}
                            </div>
                            <!-- User Quick Info -->
                            <div class="hidden sm:flex items-center space-x-3">
                                <span class="text-xs font-semibold px-2.5 py-1 bg-slate-100 text-slate-700 rounded-full">
                                    Admin
                                </span>
                                <span class="text-sm font-semibold text-slate-700">
                                    {{ Auth::user()->name }}
                                </span>
                            </div>
                        </div>
                    </header>
                @endisset

                <!-- Main Section -->
                <main class="flex-1 p-4 sm:p-6 lg:p-8 max-w-7xl w-full mx-auto">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>

