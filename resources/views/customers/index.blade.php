<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight">
                    {{ __('Daftar Pelanggan') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1">Kelola data pelanggan yang terdaftar untuk pencatatan piutang.</p>
            </div>
            <a href="{{ route('quick-add.index') }}?tab=pelanggan" class="inline-flex items-center px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm rounded-xl shadow-md shadow-indigo-500/20 transition duration-150">
                <svg class="h-4.5 w-4.5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Tambah Pelanggan
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
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest w-16 text-center">No</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Nama Pelanggan</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Nomor Telepon</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Alamat</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest text-center w-36">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($customers as $customer)
                            <tr class="hover:bg-slate-50/30 transition">
                                <td class="px-6 py-4 text-sm text-slate-500 text-center font-medium">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 text-sm font-semibold text-slate-800">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 rounded-full bg-indigo-50 text-indigo-600 font-bold text-xs flex items-center justify-center">
                                            {{ strtoupper(substr($customer->name, 0, 1)) }}
                                        </div>
                                        <span>{{ $customer->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600 font-mono">{{ $customer->phone ?? '—' }}</td>
                                <td class="px-6 py-4 text-sm text-slate-600 max-w-xs truncate" title="{{ $customer->address }}">{{ $customer->address ?? '—' }}</td>
                                <td class="px-6 py-4 text-sm text-center font-medium whitespace-nowrap">
                                    <div class="flex items-center justify-center space-x-3">
                                        <!-- Edit Link -->
                                        <a href="{{ route('customers.edit', $customer) }}" class="inline-flex items-center px-3 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-bold text-xs rounded-lg transition">
                                            <svg class="h-3.5 w-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Edit
                                        </a>
                                        <!-- Delete Form -->
                                        <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus pelanggan ini? Semua data hutang terkait juga akan terpengaruh.');">
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
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center space-y-3">
                                        <div class="w-12 h-12 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center">
                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                            </svg>
                                        </div>
                                        <p class="text-sm text-slate-500 font-semibold">Tidak ada data pelanggan.</p>
                                        <a href="{{ route('quick-add.index') }}?tab=pelanggan" class="text-xs font-bold text-indigo-600 hover:text-indigo-800">Tambah Sekarang →</a>
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
