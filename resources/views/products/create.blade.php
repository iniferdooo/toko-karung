<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight">
            {{ __('Tambah Produk Baru') }}
        </h2>
        <p class="text-sm text-slate-500 mt-1">Daftarkan produk baru beserta rincian harga dan stok awal.</p>
    </x-slot>

    <div class="py-6" x-data="{
        showCatModal: false,
        newCatName: '',
        catError: '',
        submitCategory() {
            if (!this.newCatName.trim()) {
                this.catError = 'Nama kategori wajib diisi';
                return;
            }
            this.catError = '';
            
            fetch('{{ route('categories.store') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=&quot;csrf-token&quot;]').getAttribute('content')
                },
                body: JSON.stringify({ name: this.newCatName })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const option = new Option(data.category.name, data.category.id, true, true);
                    document.getElementById('category_id').add(option);
                    this.newCatName = '';
                    this.showCatModal = false;
                    alert('Kategori berhasil ditambahkan!');
                } else {
                    this.catError = data.message || 'Gagal menambahkan kategori';
                }
            })
            .catch(err => {
                this.catError = 'Nama kategori sudah terdaftar atau terjadi kesalahan.';
            });
        }
    }">
        <div class="max-w-3xl mx-auto">
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
                <form method="POST" action="{{ route('products.store') }}">
                    @csrf
                    <div class="space-y-6">
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <label class="block text-sm font-bold text-slate-700" for="category_id">Kategori <span class="text-rose-500">*</span></label>
                                    <button type="button" @click="showCatModal = true" class="text-xs font-bold text-indigo-600 hover:text-indigo-800">
                                        + Kategori Baru
                                    </button>
                                </div>
                                <select id="category_id" name="category_id" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition text-sm" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2" for="sku">SKU/Kode Barang <span class="text-rose-500">*</span></label>
                                <input id="sku" name="sku" type="text" value="{{ old('sku') }}" placeholder="Contoh: KR-PL-01" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition text-sm" required>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2" for="name">Nama Barang <span class="text-rose-500">*</span></label>
                                <input id="name" name="name" type="text" value="{{ old('name') }}" placeholder="Contoh: Karung Goni 50kg" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition text-sm" required>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2" for="unit">Satuan Barang <span class="text-rose-500">*</span></label>
                                <input id="unit" name="unit" type="text" value="{{ old('unit', 'pcs') }}" placeholder="Contoh: pcs, rol, bal" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition text-sm" required>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2" for="stock">Stok Awal <span class="text-rose-500">*</span></label>
                                <input id="stock" name="stock" type="number" value="{{ old('stock', 0) }}" min="0" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition text-sm" required>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2" for="purchase_price">Harga Beli (Rp) <span class="text-rose-500">*</span></label>
                                <input id="purchase_price" name="purchase_price" type="number" step="0.01" value="{{ old('purchase_price') }}" placeholder="0" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition text-sm" required>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2" for="selling_price">Harga Jual (Rp) <span class="text-rose-500">*</span></label>
                                <input id="selling_price" name="selling_price" type="number" step="0.01" value="{{ old('selling_price') }}" placeholder="0" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition text-sm" required>
                            </div>
                        </div>

                        <div class="flex items-center justify-end pt-4 border-t border-slate-50 space-x-3">
                            <a href="{{ route('products.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-xl text-sm transition">Batal</a>
                            <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-sm shadow-md shadow-indigo-500/20 transition">Simpan Produk</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- MODAL INLINE CATEGORY -->
        <div x-show="showCatModal" 
             class="fixed inset-0 z-50 overflow-y-auto" 
             style="display: none;" 
             x-transition>
            <!-- Overlay -->
            <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity" @click="showCatModal = false"></div>

            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-md p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h4 class="text-md font-bold text-slate-800">Tambah Kategori Baru</h4>
                        <button type="button" @click="showCatModal = false" class="text-slate-400 hover:text-slate-600">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-600 mb-1" for="modal_cat_name">Nama Kategori</label>
                            <input id="modal_cat_name" x-model="newCatName" type="text" placeholder="Contoh: Goni Tebal" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition text-sm">
                            <p x-show="catError" x-text="catError" class="text-xs text-rose-500 mt-1" style="display: none;"></p>
                        </div>

                        <div class="flex items-center justify-end space-x-2 pt-2">
                            <button type="button" @click="showCatModal = false" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-lg text-xs transition">Batal</button>
                            <button type="button" @click="submitCategory()" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg text-xs shadow-md shadow-indigo-500/20 transition">Simpan Kategori</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
