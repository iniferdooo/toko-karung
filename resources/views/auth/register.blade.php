<x-guest-layout>
    <div class="mb-6">
        <h2 class="text-xl font-extrabold text-slate-800">Daftar Akun Baru</h2>
        <p class="text-xs text-slate-500 mt-1">Buat akun pengelola untuk mulai menggunakan sistem kasir & piutang.</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="mt-6 flex flex-col gap-4">
            <x-primary-button class="w-full">
                {{ __('Daftar Sekarang') }}
            </x-primary-button>

            <div class="text-center mt-1">
                <span class="text-xs text-slate-400">Sudah terdaftar?</span>
                <a href="{{ route('login') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 transition ml-1">
                    {{ __('Masuk') }}
                </a>
            </div>
        </div>
    </form>
</x-guest-layout>
