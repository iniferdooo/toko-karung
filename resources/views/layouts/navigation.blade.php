<nav x-data="{ open: false }" class="bg-slate-950 text-slate-200 border-r border-slate-900 flex-none w-full md:w-64 min-h-screen-off md:min-h-screen flex flex-col justify-between sticky top-0 z-40">
    <!-- Desktop/Mobile Logo and Navigation Wrapper -->
    <div class="flex flex-col flex-1">
        <!-- Brand Header (Desktop logo & Mobile toggle bar) -->
        <div class="flex items-center justify-between h-16 px-6 bg-slate-950 border-b border-slate-900">
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
                <!-- Icon/Logo -->
                <div class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center font-bold text-white shadow-lg shadow-indigo-500/30">
                    K
                </div>
                <span class="font-bold text-lg tracking-wider text-white">Toko Karung G</span>
            </a>
            
            <!-- Mobile Menu Toggle Button -->
            <button @click="open = ! open" class="md:hidden p-2 rounded-md text-slate-400 hover:text-white hover:bg-slate-900 focus:outline-none focus:bg-slate-900 focus:text-white transition duration-150 ease-in-out">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Sidebar Links (Hidden on mobile unless toggled open) -->
        <div :class="{'block': open, 'hidden': ! open}" class="flex-1 px-4 py-6 space-y-1 md:block overflow-y-auto">
            
            <!-- Nav Item: Dashboard -->
            <a href="{{ route('dashboard') }}" 
               class="group flex items-center px-4 py-3 text-sm font-semibold rounded-xl transition duration-150 ease-in-out {{ request()->routeIs('dashboard') ? 'bg-indigo-600 text-white' : 'text-slate-400 hover:bg-slate-900 hover:text-slate-100' }}">
                <svg class="mr-3 h-5 w-5 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-slate-400 group-hover:text-slate-200' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Dashboard
            </a>

            <!-- Nav Item: Tambah Data (Unified Add Center) -->
            <a href="{{ route('quick-add.index') }}" 
               class="group flex items-center px-4 py-3 text-sm font-semibold rounded-xl transition duration-150 ease-in-out {{ request()->routeIs('quick-add.*') ? 'bg-indigo-600 text-white' : 'text-slate-400 hover:bg-slate-900 hover:text-slate-100' }}">
                <svg class="mr-3 h-5 w-5 {{ request()->routeIs('quick-add.*') ? 'text-white' : 'text-slate-400 group-hover:text-slate-200' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Tambah Data
            </a>

            <div class="pt-4 pb-2">
                <p class="px-4 text-xs font-bold uppercase tracking-widest text-slate-600">Manajemen Toko</p>
            </div>

            <!-- Nav Item: Pelanggan -->
            <a href="{{ route('customers.index') }}" 
               class="group flex items-center px-4 py-3 text-sm font-semibold rounded-xl transition duration-150 ease-in-out {{ request()->routeIs('customers.*') ? 'bg-indigo-600 text-white' : 'text-slate-400 hover:bg-slate-900 hover:text-slate-100' }}">
                <svg class="mr-3 h-5 w-5 {{ request()->routeIs('customers.*') ? 'text-white' : 'text-slate-400 group-hover:text-slate-200' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                Pelanggan
            </a>

            <!-- Nav Item: Produk -->
            <a href="{{ route('products.index') }}" 
               class="group flex items-center px-4 py-3 text-sm font-semibold rounded-xl transition duration-150 ease-in-out {{ request()->routeIs('products.*') ? 'bg-indigo-600 text-white' : 'text-slate-400 hover:bg-slate-900 hover:text-slate-100' }}">
                <svg class="mr-3 h-5 w-5 {{ request()->routeIs('products.*') ? 'text-white' : 'text-slate-400 group-hover:text-slate-200' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
                Produk
            </a>

            <!-- Nav Item: Hutang -->
            <a href="{{ route('debts.index') }}" 
               class="group flex items-center px-4 py-3 text-sm font-semibold rounded-xl transition duration-150 ease-in-out {{ request()->routeIs('debts.*') ? 'bg-indigo-600 text-white' : 'text-slate-400 hover:bg-slate-900 hover:text-slate-100' }}">
                <svg class="mr-3 h-5 w-5 {{ request()->routeIs('debts.*') ? 'text-white' : 'text-slate-400 group-hover:text-slate-200' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>
                Hutang
            </a>

            <!-- Nav Item: Pembayaran -->
            <a href="{{ route('debt-payments.index') }}" 
               class="group flex items-center px-4 py-3 text-sm font-semibold rounded-xl transition duration-150 ease-in-out {{ request()->routeIs('debt-payments.*') ? 'bg-indigo-600 text-white' : 'text-slate-400 hover:bg-slate-900 hover:text-slate-100' }}">
                <svg class="mr-3 h-5 w-5 {{ request()->routeIs('debt-payments.*') ? 'text-white' : 'text-slate-400 group-hover:text-slate-200' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                Pembayaran
            </a>

            <div class="pt-4 pb-2">
                <p class="px-4 text-xs font-bold uppercase tracking-widest text-slate-600">Transaksi</p>
            </div>

            <!-- Nav Item: Kasir/POS -->
            <a href="{{ route('pos.index') }}" 
               class="group flex items-center px-4 py-3 text-sm font-semibold rounded-xl transition duration-150 ease-in-out {{ request()->routeIs('pos.*') ? 'bg-emerald-600 text-white' : 'text-slate-400 hover:bg-slate-900 hover:text-slate-100' }}">
                <svg class="mr-3 h-5 w-5 {{ request()->routeIs('pos.*') ? 'text-white' : 'text-slate-400 group-hover:text-slate-200' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                Kasir / POS
            </a>

            <!-- Nav Item: Riwayat & Log -->
            <a href="{{ route('history.index') }}" 
               class="group flex items-center px-4 py-3 text-sm font-semibold rounded-xl transition duration-150 ease-in-out {{ request()->routeIs('history.*') ? 'bg-indigo-600 text-white' : 'text-slate-400 hover:bg-slate-900 hover:text-slate-100' }}">
                <svg class="mr-3 h-5 w-5 {{ request()->routeIs('history.*') ? 'text-white' : 'text-slate-400 group-hover:text-slate-200' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Riwayat & Log
            </a>
            
        </div>
    </div>

    <!-- User Profile Dropdown / Logout section at bottom -->
    <div :class="{'block': open, 'hidden': ! open}" class="p-4 border-t border-slate-900 md:block bg-slate-950">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center space-x-3">
                <div class="w-9 h-9 rounded-full bg-slate-800 flex items-center justify-center font-bold text-slate-300">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <p class="text-sm font-semibold text-white leading-none">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-slate-500 mt-1 truncate max-w-[120px]">{{ Auth::user()->email }}</p>
                </div>
            </div>
            
            <a href="{{ route('profile.edit') }}" class="text-slate-500 hover:text-white transition" title="Edit Profile">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </a>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center px-4 py-2.5 bg-slate-900 hover:bg-red-950/40 hover:text-red-400 text-slate-400 font-semibold rounded-xl text-xs transition duration-150">
                <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                Keluar Aplikasi
            </button>
        </form>
    </div>
</nav>
