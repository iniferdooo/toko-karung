<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight">
            {{ __('Tambah Pelanggan') }}
        </h2>
        <p class="text-sm text-slate-500 mt-1">Daftarkan pelanggan baru ke dalam sistem database.</p>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto">
            @if ($errors->any())
                <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-2xl">
                    <ul class="list-disc pl-5 text-xs space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 md:p-8">
                <form method="POST" action="{{ route('customers.store') }}">
                    @csrf
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2" for="name">Nama Pelanggan <span class="text-rose-500">*</span></label>
                            <input id="name" name="name" type="text" value="{{ old('name') }}" placeholder="Contoh: Ahmad Fauzi" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition text-sm" required>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2" for="phone">Nomor Telepon</label>
                            <input id="phone" name="phone" type="text" value="{{ old('phone') }}" placeholder="Contoh: 08123456789" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition text-sm">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2" for="address">Alamat Lengkap</label>
                            <textarea id="address" name="address" rows="3" placeholder="Contoh: Jl. Diponegoro No. 45, Surabaya" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition text-sm">{{ old('address') }}</textarea>
                        </div>

                        <div class="flex items-center justify-end pt-4 border-t border-slate-50 space-x-3">
                            <a href="{{ route('customers.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-xl text-sm transition">Batal</a>
                            <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-sm shadow-md shadow-indigo-500/20 transition">Simpan Pelanggan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
