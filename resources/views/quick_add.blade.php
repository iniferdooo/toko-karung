<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight">
            {{ __('Pusat Tambah Data') }}
        </h2>
        <p class="text-sm text-slate-500 mt-1">Tambah barang, pelanggan, hutang, atau pembayaran dari satu tempat dengan mudah.</p>
    </x-slot>

    <div class="py-6" x-data="{ 
        activeTab: new URLSearchParams(window.location.search).get('tab') || 'pelanggan',
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
                    // Add to both selectors if available
                    const option = new Option(data.category.name, data.category.id, true, true);
                    const selects = document.querySelectorAll('.category-selector');
                    selects.forEach(select => {
                        select.add(option.cloneNode(true));
                    });
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
        <div class="max-w-4xl mx-auto">
            <!-- Messages -->
            @if (session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl flex items-center space-x-3">
                    <svg class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="font-semibold text-sm">{{ session('success') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-2xl">
                    <div class="flex items-center space-x-2 mb-2">
                        <svg class="h-5 w-5 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <span class="font-bold text-sm">Gagal Menyimpan Data:</span>
                    </div>
                    <ul class="list-disc pl-5 text-xs space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Tabs Navigation -->
            <div class="bg-white p-2 rounded-2xl shadow-sm border border-slate-100 flex flex-wrap gap-1 mb-6">
                <!-- Tab Button: Pelanggan -->
                <button @click="activeTab = 'pelanggan'" 
                        :class="activeTab === 'pelanggan' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/20' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50'"
                        class="flex-1 flex items-center justify-center px-4 py-3 text-sm font-bold rounded-xl transition duration-150">
                    <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Pelanggan
                </button>

                <!-- Tab Button: Kategori -->
                <button @click="activeTab = 'kategori'" 
                        :class="activeTab === 'kategori' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/20' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50'"
                        class="flex-1 flex items-center justify-center px-4 py-3 text-sm font-bold rounded-xl transition duration-150">
                    <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Kategori
                </button>

                <!-- Tab Button: Produk -->
                <button @click="activeTab = 'produk'" 
                        :class="activeTab === 'produk' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/20' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50'"
                        class="flex-1 flex items-center justify-center px-4 py-3 text-sm font-bold rounded-xl transition duration-150">
                    <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    Produk
                </button>

                <!-- Tab Button: Hutang -->
                <button @click="activeTab = 'hutang'" 
                        :class="activeTab === 'hutang' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/20' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50'"
                        class="flex-1 flex items-center justify-center px-4 py-3 text-sm font-bold rounded-xl transition duration-150">
                    <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Hutang
                </button>

                <!-- Tab Button: Pembayaran -->
                <button @click="activeTab = 'pembayaran'" 
                        :class="activeTab === 'pembayaran' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/20' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50'"
                        class="flex-1 flex items-center justify-center px-4 py-3 text-sm font-bold rounded-xl transition duration-150">
                    <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z" />
                    </svg>
                    Pembayaran
                </button>
            </div>

            <!-- Tab Content Panel -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 md:p-8">
                
                <!-- FORM 1: Pelanggan -->
                <div x-show="activeTab === 'pelanggan'" x-transition>
                    <div class="mb-6">
                        <h3 class="text-lg font-bold text-slate-800">Tambah Pelanggan Baru</h3>
                        <p class="text-xs text-slate-400 mt-1">Daftarkan pelanggan baru ke dalam sistem sebelum membuat hutang.</p>
                    </div>

                    <form method="POST" action="{{ route('customers.store') }}">
                        @csrf
                        <input type="hidden" name="redirect_to" value="quick-add.index">
                        
                        <div class="space-y-5">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2" for="cust_name">Nama Lengkap <span class="text-rose-500">*</span></label>
                                <input id="cust_name" name="name" type="text" value="{{ old('name') }}" placeholder="Contoh: Budi Santoso" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition text-sm" required>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2" for="cust_phone">Nomor Telepon/WA</label>
                                <input id="cust_phone" name="phone" type="text" value="{{ old('phone') }}" placeholder="Contoh: 08123456789" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2" for="cust_address">Alamat Lengkap</label>
                                <textarea id="cust_address" name="address" rows="3" placeholder="Contoh: Jl. Merdeka No. 12, Bandung" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition text-sm">{{ old('address') }}</textarea>
                            </div>

                            <div class="flex items-center justify-end pt-4 border-t border-slate-50 space-x-3">
                                <a href="{{ route('customers.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-xl text-sm transition">Lihat Semua</a>
                                <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-sm shadow-md shadow-indigo-500/20 transition">Simpan Pelanggan</button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- FORM 2: Kategori -->
                <div x-show="activeTab === 'kategori'" x-transition>
                    <div class="mb-6">
                        <h3 class="text-lg font-bold text-slate-800">Tambah Kategori Produk</h3>
                        <p class="text-xs text-slate-400 mt-1">Buat kategori barang (misal: Karung Goni, Karung Plastik).</p>
                    </div>

                    <form method="POST" action="{{ route('categories.store') }}">
                        @csrf
                        <div class="space-y-5">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2" for="cat_name">Nama Kategori <span class="text-rose-500">*</span></label>
                                <input id="cat_name" name="name" type="text" value="{{ old('name') }}" placeholder="Contoh: Karung Plastik Tebal" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition text-sm" required>
                            </div>

                            <div class="flex items-center justify-end pt-4 border-t border-slate-50">
                                <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-sm shadow-md shadow-indigo-500/20 transition">Simpan Kategori</button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- FORM 3: Produk -->
                <div x-show="activeTab === 'produk'" x-transition>
                    <div class="mb-6 flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-bold text-slate-800">Tambah Produk Baru</h3>
                            <p class="text-xs text-slate-400 mt-1">Tambahkan produk baru beserta data stok awal ke dalam gudang.</p>
                        </div>
                        <button type="button" @click="showCatModal = true" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-lg transition">+ Kategori Baru</button>
                    </div>

                    <form method="POST" action="{{ route('products.store') }}">
                        @csrf
                        
                        <div class="space-y-5">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2" for="prod_category">Kategori <span class="text-rose-500">*</span></label>
                                    <select id="prod_category" name="category_id" class="category-selector w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition text-sm" required>
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach ($categories as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2" for="prod_sku">SKU/Kode Barang <span class="text-rose-500">*</span></label>
                                    <input id="prod_sku" name="sku" type="text" value="{{ old('sku') }}" placeholder="Contoh: KR-PL-01" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition text-sm" required>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2" for="prod_name">Nama Barang <span class="text-rose-500">*</span></label>
                                    <input id="prod_name" name="name" type="text" value="{{ old('name') }}" placeholder="Contoh: Karung Goni Ukuran 50kg" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition text-sm" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2" for="prod_unit">Satuan <span class="text-rose-500">*</span></label>
                                    <input id="prod_unit" name="unit" type="text" value="{{ old('unit', 'pcs') }}" placeholder="Contoh: pcs, rol, bal" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition text-sm" required>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2" for="prod_stock">Stok Awal <span class="text-rose-500">*</span></label>
                                    <input id="prod_stock" name="stock" type="number" value="{{ old('stock', 0) }}" min="0" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition text-sm" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2" for="prod_pur_price">Harga Beli (Rp) <span class="text-rose-500">*</span></label>
                                    <input id="prod_pur_price" name="purchase_price" type="number" step="0.01" value="{{ old('purchase_price') }}" placeholder="0" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition text-sm" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2" for="prod_sell_price">Harga Jual (Rp) <span class="text-rose-500">*</span></label>
                                    <input id="prod_sell_price" name="selling_price" type="number" step="0.01" value="{{ old('selling_price') }}" placeholder="0" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition text-sm" required>
                                </div>
                            </div>

                            <div class="flex items-center justify-end pt-4 border-t border-slate-50 space-x-3">
                                <a href="{{ route('products.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-xl text-sm transition">Lihat Gudang</a>
                                <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-sm shadow-md shadow-indigo-500/20 transition">Simpan Produk</button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- FORM 4: Hutang -->
                <div x-show="activeTab === 'hutang'" x-transition x-data="{ total: 0, sisa: 0 }">
                    <div class="mb-6">
                        <h3 class="text-lg font-bold text-slate-800">Buat Hutang Baru</h3>
                        <p class="text-xs text-slate-400 mt-1">Catat transaksi hutang baru untuk pelanggan yang membeli barang secara kredit.</p>
                    </div>

                    <form method="POST" action="{{ route('debts.store') }}">
                        @csrf
                        <div class="space-y-5">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2" for="debt_cust">Nama Pelanggan <span class="text-rose-500">*</span></label>
                                    <select id="debt_cust" name="customer_id" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition text-sm" required>
                                        <option value="">-- Pilih Pelanggan --</option>
                                        @foreach ($customers as $cust)
                                            <option value="{{ $cust->id }}" {{ old('customer_id') == $cust->id ? 'selected' : '' }}>{{ $cust->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2" for="debt_status">Status Pembayaran <span class="text-rose-500">*</span></label>
                                    <select id="debt_status" name="status" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition text-sm" required>
                                        <option value="unpaid" selected>Belum Lunas</option>
                                        <option value="paid">Lunas</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2" for="debt_total">Total Nilai Hutang (Rp) <span class="text-rose-500">*</span></label>
                                    <input id="debt_total" name="total_amount" type="number" step="0.01" x-model="total" @input="sisa = total" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition text-sm" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2" for="debt_remaining">Sisa Hutang (Rp) <span class="text-rose-500">*</span></label>
                                    <input id="debt_remaining" name="remaining_amount" type="number" step="0.01" x-model="sisa" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition text-sm" required>
                                    <span class="text-[10px] text-slate-400 mt-1 block">Secara default disamakan dengan total nilai hutang.</span>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2" for="debt_date_input">Tanggal Hutang <span class="text-rose-500">*</span></label>
                                    <input id="debt_date_input" name="debt_date" type="date" value="{{ date('Y-m-d') }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition text-sm" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2" for="debt_due">Tanggal Jatuh Tempo</label>
                                    <input id="debt_due" name="due_date" type="date" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition text-sm">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2" for="debt_notes">Catatan Transaksi</label>
                                <textarea id="debt_notes" name="notes" rows="3" placeholder="Contoh: Pengambilan 100 lembar Karung Goni tebal" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition text-sm"></textarea>
                            </div>

                            <div class="flex items-center justify-end pt-4 border-t border-slate-50 space-x-3">
                                <a href="{{ route('debts.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-xl text-sm transition">Daftar Hutang</a>
                                <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-sm shadow-md shadow-indigo-500/20 transition">Simpan Hutang</button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- FORM 5: Pembayaran -->
                <div x-show="activeTab === 'pembayaran'" x-transition>
                    <div class="mb-6">
                        <h3 class="text-lg font-bold text-slate-800">Catat Pembayaran Cicilan</h3>
                        <p class="text-xs text-slate-400 mt-1">Catat transaksi pembayaran/cicilan hutang dari pelanggan.</p>
                    </div>

                    <form method="POST" action="{{ route('debt-payments.store') }}">
                        @csrf
                        <div class="space-y-5">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2" for="pay_debt">Pilih Hutang Pelanggan <span class="text-rose-500">*</span></label>
                                <select id="pay_debt" name="debt_id" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition text-sm" required>
                                    <option value="">-- Pilih Hutang yang Belum Lunas --</option>
                                    @foreach ($debts as $d)
                                        <option value="{{ $d->id }}">
                                            {{ $d->customer->name ?? 'Tanpa Pelanggan' }} — Rp {{ number_format($d->remaining_amount, 0, ',', '.') }} sisa (Tgl: {{ $d->debt_date }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2" for="pay_amount">Jumlah Pembayaran (Rp) <span class="text-rose-500">*</span></label>
                                    <input id="pay_amount" name="amount_paid" type="number" step="0.01" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition text-sm" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2" for="pay_date">Tanggal Pembayaran <span class="text-rose-500">*</span></label>
                                    <input id="pay_date" name="payment_date" type="date" value="{{ date('Y-m-d') }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition text-sm" required>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2" for="pay_notes">Catatan Pembayaran</label>
                                <textarea id="pay_notes" name="notes" rows="3" placeholder="Contoh: Pembayaran cicilan pertama cash" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition text-sm"></textarea>
                            </div>

                            <div class="flex items-center justify-end pt-4 border-t border-slate-50 space-x-3">
                                <a href="{{ route('debt-payments.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-xl text-sm transition">Daftar Pembayaran</a>
                                <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-sm shadow-md shadow-indigo-500/20 transition">Simpan Pembayaran</button>
                            </div>
                        </div>
                    </form>
                </div>

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
