<x-guest-layout>
    <div class="mb-6">
        <h2 class="text-xl font-extrabold text-slate-800">Selamat Datang Kembali</h2>
        <p class="text-xs text-slate-500 mt-1">Silakan masuk untuk mengelola kasir dan piutang toko Anda.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <div class="flex justify-between items-center">
                <x-input-label for="password" :value="__('Password')" />
                @if (Route::has('password.request'))
                    <a class="text-xs font-semibold text-slate-400 hover:text-indigo-600 transition" href="{{ route('password.request') }}">
                        {{ __('Lupa password?') }}
                    </a>
                @endif
            </div>

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center cursor-pointer select-none">
                <input id="remember_me" type="checkbox" class="rounded border-slate-200 text-indigo-600 shadow-sm focus:ring-indigo-500/20 focus:border-indigo-600" name="remember">
                <span class="ms-2 text-xs font-bold text-slate-500">{{ __('Ingat saya di perangkat ini') }}</span>
            </label>
        </div>

        <div class="mt-6 flex flex-col gap-4">
            <x-primary-button class="w-full">
                {{ __('Masuk ke Aplikasi') }}
            </x-primary-button>

            @if (Route::has('register'))
                <div class="text-center mt-1">
                    <span class="text-xs text-slate-400">Belum memiliki akun?</span>
                    <a href="{{ route('register') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 transition ml-1">
                        {{ __('Daftar Baru') }}
                    </a>
                </div>
            @endif
        </div>
    </form>
</x-guest-layout>
