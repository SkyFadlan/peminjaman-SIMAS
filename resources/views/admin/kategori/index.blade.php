<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kategori - SIMAS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        
        /* Style sederhana untuk modal */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            padding: 20px;
        }
        
        .modal-content {
            background: white;
            border-radius: 16px;
            max-width: 500px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
        }
        
        .hidden {
            display: none !important;
        }
    </style>
</head>
<body class="bg-slate-50">
    
    <div class="flex min-h-screen">
        <!-- Sidebar Component -->
        @include('components.sidebar_admin')

        <!-- Main Content -->
        <div class="flex-1 lg:ml-64">
            <!-- Top Navbar -->
            <nav class="bg-white border-b border-gray-200 sticky top-0 z-40">
                <div class="px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between h-16">
                        <!-- Mobile Menu Button -->
                        <button id="mobile-menu-button" class="lg:hidden p-2 rounded-lg text-gray-600 hover:bg-gray-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>

                        <!-- Page Title -->
                        <div class="flex-1">
                            <h1 class="text-2xl font-bold text-gray-900">Data Kategori</h1>
                            <p class="text-sm text-gray-500 mt-0.5">Kelola kategori aset sarana prasarana</p>
                        </div>

                        <!-- Right Side Actions -->
                        <div class="flex items-center space-x-3">
                            <button class="p-2 text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </button>
                            <div class="flex items-center space-x-3 pl-3 border-l border-gray-200">
                                <div class="hidden sm:block text-right">
                                    <p class="text-sm font-semibold text-gray-900">Admin User</p>
                                    <p class="text-xs text-gray-500">Administrator</p>
                                </div>
                                <button class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-cyan-400 flex items-center justify-center text-white font-semibold">
                                    A
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="p-4 sm:p-6 lg:px-8">
                <!-- Action Bar -->
                <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="flex items-center space-x-3">
                        <!-- HAPUS onclick dan ganti dengan id -->
                        <button id="tambahKategoriBtn" class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-cyan-500 text-white rounded-xl font-semibold hover:shadow-lg hover:shadow-blue-300 transition-all flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span>Tambah Kategori</span>
                        </button>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-gray-600 text-sm font-medium mb-1">Total Kategori</h3>
                        <p class="text-3xl font-bold text-gray-900">{{ $kategoris->count() }}</p>
                    </div>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-gray-600 text-sm font-medium mb-1">Paling Banyak</h3>
                        <p class="text-xl font-bold text-gray-900">{{ $mostPopularCategory ?? 'Belum ada data' }}</p>
                    </div>
                </div>

                <!-- Category Cards Grid -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
                    <div class="p-6 border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-bold text-gray-900">Daftar Kategori</h2>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                            
                            @php
                                $colors = [
                                    ['bg' => 'bg-blue-50', 'border' => 'border-blue-100', 'icon_bg' => 'from-blue-500 to-cyan-400', 'text' => 'text-blue-600'],
                                    ['bg' => 'bg-green-50', 'border' => 'border-green-100', 'icon_bg' => 'from-green-500 to-teal-400', 'text' => 'text-green-600'],
                                    ['bg' => 'bg-purple-50', 'border' => 'border-purple-100', 'icon_bg' => 'from-purple-500 to-pink-400', 'text' => 'text-purple-600'],
                                    ['bg' => 'bg-orange-50', 'border' => 'border-orange-100', 'icon_bg' => 'from-orange-500 to-amber-400', 'text' => 'text-orange-600'],
                                ];
                            @endphp

                            @forelse($kategoris as $index => $kategori)
                                @php
                                    $style = $colors[$index % count($colors)];
                                @endphp

                                <div class="group {{ $style['bg'] }} rounded-xl p-6 border {{ $style['border'] }} hover:shadow-lg hover:-translate-y-1 transition-all">
                                    <div class="flex items-start justify-between mb-4">
                                        <div class="w-12 h-12 bg-gradient-to-br {{ $style['icon_bg'] }} rounded-lg flex items-center justify-center">
                                            <span class="text-white text-xl font-bold">{{ substr($kategori->nama_kategori, 0, 1) }}</span>
                                        </div>
                                    </div>
                                    <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $kategori->nama_kategori }}</h3>
                                    <p class="text-sm text-gray-600 mb-4">{{ Str::limit($kategori->deskripsi, 40) ?? 'Tidak ada deskripsi' }}</p>
                                    
                                    <div class="flex items-center justify-between">
                                        <span class="text-2xl font-bold {{ $style['text'] }}">
                                            {{ $kategori->barang_count ?? 0 }} item
                                        </span>
                                        
                                        <div class="flex items-center space-x-1">
                                            <button onclick="editCategory({{ $kategori->id }}, '{{ addslashes($kategori->nama_kategori) }}', '{{ addslashes($kategori->deskripsi) }}')" 
                                                class="p-2 bg-white rounded-lg hover:bg-gray-100 transition-colors">
                                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </button>

                                            <form action="{{ route('admin.kategori.destroy', $kategori->id) }}" method="POST" onsubmit="return confirm('Yakin hapus kategori ini?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 bg-white rounded-lg hover:bg-red-50 transition-colors">
                                                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-full text-center py-10">
                                    <p class="text-gray-500">Belum ada kategori yang ditambahkan.</p>
                                </div>
                            @endforelse

                            <!-- Tombol Tambah Kategori -->
                            <div id="tambahKategoriCard" class="group bg-gradient-to-br from-gray-50 to-slate-50 rounded-xl p-6 border-2 border-dashed border-gray-300 hover:border-blue-400 hover:shadow-lg transition-all cursor-pointer flex items-center justify-center min-h-[200px]">
                                <div class="text-center">
                                    <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:bg-blue-100 transition-colors">
                                        <svg class="w-6 h-6 text-gray-400 group-hover:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                    </div>
                                    <p class="text-sm font-semibold text-gray-600 group-hover:text-blue-600 transition-colors">Tambah Kategori</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- MODAL TAMBAH KATEGORI -->
    <div id="addCategoryModal" class="modal-overlay hidden">
        <div class="modal-content">
            <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between rounded-t-2xl">
                <h3 class="text-xl font-bold text-gray-900">Tambah Kategori Baru</h3>
                <button type="button" id="closeAddModal" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="p-6">
                <form id="addCategoryForm" action="{{ route('admin.kategori.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Kategori <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_kategori" required class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Contoh: Elektronik">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi</label>
                        <textarea name="deskripsi" rows="3" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Deskripsi kategori (opsional)"></textarea>
                    </div>
                    <div class="flex justify-end space-x-3 pt-4">
                        <button type="button" id="cancelAddBtn" class="px-5 py-2.5 border border-gray-200 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition-all">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-cyan-500 text-white rounded-xl font-semibold hover:shadow-lg hover:shadow-blue-300 transition-all">
                            Simpan Kategori
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL EDIT KATEGORI -->
    <div id="editCategoryModal" class="modal-overlay hidden">
        <div class="modal-content">
            <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between rounded-t-2xl">
                <h3 class="text-xl font-bold text-gray-900">Edit Kategori</h3>
                <button type="button" id="closeEditModal" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="p-6">
                <form id="editCategoryForm" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Kategori *</label>
                        <input type="text" id="editNama" name="nama_kategori" required class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi</label>
                        <textarea id="editDeskripsi" name="deskripsi" rows="3" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>
                    <div class="flex justify-end space-x-3 pt-4">
                        <button type="button" id="cancelEditBtn" class="px-5 py-2.5 border border-gray-200 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition-all">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-cyan-500 text-white rounded-xl font-semibold hover:shadow-lg hover:shadow-blue-300 transition-all">
                            Update Kategori
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- SCRIPT DI BAWAH SEBELUM </body> -->
    <script>
        // Debug - Pastikan script berjalan
        console.log('Script loaded successfully');
        
        // Deklarasi variabel di scope global
        let sidebarElement; // Jangan gunakan nama 'sidebar' untuk menghindari konflik
        
        // Fungsi untuk modal tambah kategori
        function showAddCategoryModal() {
            console.log('showAddCategoryModal called');
            const modal = document.getElementById('addCategoryModal');
            console.log('Modal element:', modal);
            if (modal) {
                modal.classList.remove('hidden');
                console.log('Modal should be visible now');
            } else {
                console.error('Modal not found!');
            }
        }
        
        function hideAddCategoryModal() {
            const modal = document.getElementById('addCategoryModal');
            if (modal) {
                modal.classList.add('hidden');
                // Reset form
                const form = document.getElementById('addCategoryForm');
                if (form) form.reset();
            }
        }
        
        // Fungsi untuk modal edit kategori
        function editCategory(id, nama, deskripsi) {
            console.log('Edit category:', id, nama);
            
            // Set values ke form
            document.getElementById('editNama').value = nama;
            document.getElementById('editDeskripsi').value = deskripsi;
            
            // Set action URL form update
            let form = document.getElementById('editCategoryForm');
            form.action = "{{ url('admin/kategori') }}/" + id;
            
            // Tampilkan modal
            const modal = document.getElementById('editCategoryModal');
            if (modal) {
                modal.classList.remove('hidden');
            }
        }
        
        function hideEditCategoryModal() {
            const modal = document.getElementById('editCategoryModal');
            if (modal) {
                modal.classList.add('hidden');
            }
        }
        
        // Inisialisasi event listeners setelah DOM siap
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM fully loaded');
            
            // Setup untuk tombol tambah kategori (action bar)
            const tambahBtn = document.getElementById('tambahKategoriBtn');
            if (tambahBtn) {
                console.log('Tambah button found in action bar');
                tambahBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    console.log('Action bar button clicked');
                    showAddCategoryModal();
                });
            }
            
            // Setup untuk card tambah kategori
            const tambahCard = document.getElementById('tambahKategoriCard');
            if (tambahCard) {
                console.log('Tambah card found');
                tambahCard.addEventListener('click', function(e) {
                    e.preventDefault();
                    console.log('Card button clicked');
                    showAddCategoryModal();
                });
            }
            
            // Setup untuk tombol close modal tambah
            const closeAddBtn = document.getElementById('closeAddModal');
            const cancelAddBtn = document.getElementById('cancelAddBtn');
            if (closeAddBtn) {
                closeAddBtn.addEventListener('click', hideAddCategoryModal);
            }
            if (cancelAddBtn) {
                cancelAddBtn.addEventListener('click', hideAddCategoryModal);
            }
            
            // Setup untuk tombol close modal edit
            const closeEditBtn = document.getElementById('closeEditModal');
            const cancelEditBtn = document.getElementById('cancelEditBtn');
            if (closeEditBtn) {
                closeEditBtn.addEventListener('click', hideEditCategoryModal);
            }
            if (cancelEditBtn) {
                cancelEditBtn.addEventListener('click', hideEditCategoryModal);
            }
            
            // Mobile menu toggle - gunakan variabel yang berbeda
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            sidebarElement = document.querySelector('aside'); // Gunakan variabel yang berbeda
            if (mobileMenuButton && sidebarElement) {
                mobileMenuButton.addEventListener('click', () => {
                    sidebarElement.classList.toggle('-translate-x-full');
                });
            }
            
            // Close modal dengan ESC key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    hideAddCategoryModal();
                    hideEditCategoryModal();
                }
            });
            
            // Close modal dengan klik di luar
            document.addEventListener('click', function(e) {
                const addModal = document.getElementById('addCategoryModal');
                const editModal = document.getElementById('editCategoryModal');
                
                if (addModal && !addModal.classList.contains('hidden') && e.target === addModal) {
                    hideAddCategoryModal();
                }
                
                if (editModal && !editModal.classList.contains('hidden') && e.target === editModal) {
                    hideEditCategoryModal();
                }
            });
        });
        
        // Export fungsi ke global scope untuk onclick di HTML
        window.showAddCategoryModal = showAddCategoryModal;
        window.hideAddCategoryModal = hideAddCategoryModal;
        window.editCategory = editCategory;
        window.hideEditCategoryModal = hideEditCategoryModal;
    </script>
</body>
</html>