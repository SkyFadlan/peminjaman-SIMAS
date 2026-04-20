<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Barang - SIMAS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        
        /* Style untuk modal */
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
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
        }
        
        .hidden {
            display: none !important;
        }
        
        /* Badge untuk kategori */
        .badge-kategori {
            background-color: #dbeafe;
            color: #1e40af;
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
                            <h1 class="text-2xl font-bold text-gray-900">Data Barang</h1>
                            <p class="text-sm text-gray-500 mt-0.5">Kelola inventaris sarana prasarana sekolah</p>
                        </div>

                        <!-- Right Side Actions -->
                        <div class="flex items-center space-x-3">
                            <!-- Notifikasi Success -->
                            @if(session('success'))
                            <div id="success-notification" class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded-lg">
                                {{ session('success') }}
                            </div>
                            <script>
                                setTimeout(() => {
                                    const notification = document.getElementById('success-notification');
                                    if (notification) notification.remove();
                                }, 3000);
                            </script>
                            @endif
                            
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
            <main class="p-4 sm:p-6 lg:p-8">
                <!-- Action Bar -->
                <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="flex flex-wrap items-center gap-3">
                        <button id="tambahBarangBtn" class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-cyan-500 text-white rounded-xl font-semibold hover:shadow-lg hover:shadow-blue-300 transition-all flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span>Tambah Aset</span>
                        </button>
                    </div>
                </div>

                <!-- Stats Cards (Data Dinamis dari Database) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- Stats akan diisi dengan data dari database -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-gray-600 text-sm font-medium mb-1">Total Aset</h3>
                        <p class="text-3xl font-bold text-gray-900">{{ $totalBarang ?? 342 }}</p>
                        <p class="text-xs text-gray-500 mt-2">Semua kategori</p>
                    </div>
                </div>

                <!-- Filters & Table -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <!-- Filters -->
                    <div class="p-6 border-b border-gray-100">
                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                            <div class="flex flex-wrap items-center gap-3">
                                <select id="filterKategori" class="px-4 py-2 border border-gray-200 rounded-lg text-sm font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">Semua Kategori</option>
                                    @foreach($kategoris ?? [] as $kategori)
                                    <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="relative">
                                    <input type="text" id="searchInput" placeholder="Cari aset..." class="pl-10 pr-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 w-64">
                                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b border-gray-100">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kode Aset</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama Aset</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kategori</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Jumlah</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Dipinjam</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tersedia</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100" id="barangTableBody">
                                <!-- Data akan diisi dengan data dari database -->
                                @forelse($barangs ?? [] as $barang)
                                <tr class="hover:bg-gray-50 barang-row" 
                                    data-kategori="{{ $barang->kategori_id }}" 
                                    data-nama="{{ strtolower($barang->nama_barang) }}">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-2">
                                            <div class="w-8 h-8 bg-blue-100 rounded flex items-center justify-center">
                                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                                                </svg>
                                            </div>
                                            <span class="text-sm font-semibold text-gray-900">BRG-{{ str_pad($barang->id, 3, '0', STR_PAD_LEFT) }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-cyan-400 rounded-lg flex items-center justify-center mr-3">
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-gray-900">{{ $barang->nama_barang }}</p>
                                                <p class="text-xs text-gray-500 truncate max-w-xs">{{ $barang->deskripsi ?? 'Tanpa deskripsi' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-medium">
                                            {{ $barang->kategori->nama_kategori ?? 'Tidak ada kategori' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-sm font-semibold text-gray-900">{{ $barang->jumlah + $barang->peminjamans->sum('jumlah') }} unit</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-sm font-semibold text-gray-900">{{ $barang->peminjamans->sum('jumlah') }} unit</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-sm font-semibold text-gray-900">{{ $barang->jumlah }} unit</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-2">
                                            <button onclick="viewBarang({{ json_encode($barang) }})" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Detail">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </button>
                                            <button onclick="editBarang({{ $barang->id }})" class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors" title="Edit">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </button>
                                            <form action="{{ route('admin.barang.destroy', $barang->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Yakin hapus barang ini?')" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                        Belum ada data barang
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- PAGINATION -->
                    @if(isset($barangs) && $barangs->hasPages())
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                        <div class="flex flex-col items-center space-y-2">
                            <!-- Informasi halaman -->
                            <div class="text-sm text-gray-700">
                                Menampilkan {{ $barangs->firstItem() }} - {{ $barangs->lastItem() }} 
                                dari {{ $barangs->total() }} data
                            </div>
                            
                            <!-- Tombol navigasi -->
                            <div class="flex items-center space-x-1">
                                {{-- Previous Page Link --}}
                                @if($barangs->onFirstPage())
                                    <span class="px-3 py-1 text-gray-400 bg-gray-100 rounded cursor-not-allowed">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                        </svg>
                                    </span>
                                @else
                                    <a href="{{ $barangs->previousPageUrl() }}" class="px-3 py-1 text-blue-600 bg-blue-50 rounded hover:bg-blue-100">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                        </svg>
                                    </a>
                                @endif

                                {{-- Pagination Elements --}}
                                @foreach($barangs->getUrlRange(1, $barangs->lastPage()) as $page => $url)
                                    @if($page == $barangs->currentPage())
                                        <span class="px-3 py-1 text-white bg-blue-600 rounded">{{ $page }}</span>
                                    @else
                                        <a href="{{ $url }}" class="px-3 py-1 text-gray-600 bg-gray-100 rounded hover:bg-gray-200">{{ $page }}</a>
                                    @endif
                                @endforeach

                                {{-- Next Page Link --}}
                                @if($barangs->hasMorePages())
                                    <a href="{{ $barangs->nextPageUrl() }}" class="px-3 py-1 text-blue-600 bg-blue-50 rounded hover:bg-blue-100">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                @else
                                    <span class="px-3 py-1 text-gray-400 bg-gray-100 rounded cursor-not-allowed">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif

                </div>
            </main>
        </div>
    </div>

    <!-- MODAL TAMBAH BARANG -->
    <div id="addBarangModal" class="modal-overlay hidden">
        <div class="modal-content max-w-3xl">
            <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between rounded-t-2xl">
                <h3 class="text-xl font-bold text-gray-900">Tambah Barang Baru</h3>
                <button type="button" id="closeAddBarangModal" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="p-6">
                <form id="addBarangForm" action="{{ route('admin.barang.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    <!-- Basic Info Section -->
                    <div>
                        <h4 class="text-sm font-bold text-gray-900 mb-4 flex items-center">
                            <span class="w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-xs mr-2">1</span>
                            Informasi Dasar
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Barang <span class="text-red-500">*</span></label>
                                <input type="text" name="nama_barang" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Contoh: Proyektor LCD Epson" required>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori <span class="text-red-500">*</span></label>
                                <select name="kategori_id" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach($kategoris ?? [] as $kategori)
                                    <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Jumlah <span class="text-red-500">*</span></label>
                                <input type="number" name="jumlah" min="0" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="0" required>
                            </div>
                        </div>
                        <div class="mt-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi</label>
                            <textarea name="deskripsi" rows="3" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Deskripsi lengkap barang"></textarea>
                        </div>
                    </div>

                    <!-- Additional Info Section -->
                    <div>
                        <div class="mt-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Upload Gambar Barang</label>
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-400 transition-colors cursor-pointer" id="gambarUploadArea">
                                <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <p class="text-sm text-gray-600 mb-1">Klik untuk upload atau drag & drop</p>
                                <p class="text-xs text-gray-500">PNG, JPG, JPEG (Max. 2MB)</p>
                                <input type="file" name="gambar" id="gambarInput" class="hidden" accept="image/*">
                                <div id="gambarPreview" class="mt-3 hidden">
                                    <img id="previewImage" class="mx-auto max-h-40 rounded-lg">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                        <button type="button" id="cancelAddBarangBtn" class="px-5 py-2.5 border border-gray-200 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition-all">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-cyan-500 text-white rounded-xl font-semibold hover:shadow-lg hover:shadow-blue-300 transition-all">
                            Simpan Barang
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL DETAIL BARANG -->
    <div id="viewBarangModal" class="modal-overlay hidden">
        <div class="modal-content max-w-3xl">
            <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between rounded-t-2xl">
                <h3 class="text-xl font-bold text-gray-900">Detail Barang</h3>
                <button type="button" id="closeViewBarangModal" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="p-6">
                <div id="barangDetailContent">
                    <!-- Konten akan diisi oleh JavaScript -->
                </div>
                <div class="mt-6 flex justify-end">
                    <button type="button" id="closeViewBarangBtn" class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-cyan-500 text-white rounded-xl font-semibold hover:shadow-lg hover:shadow-blue-300 transition-all">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- SCRIPT -->
    <script>
        // Debug - Pastikan script berjalan
        console.log('Script Data Barang loaded successfully');
        
        // Deklarasi variabel
        let sidebarElement;
        
        // Fungsi untuk modal
        function showAddBarangModal() {
            console.log('showAddBarangModal called');
            const modal = document.getElementById('addBarangModal');
            if (modal) {
                modal.classList.remove('hidden');
                console.log('Modal should be visible now');
            } else {
                console.error('Add barang modal not found!');
            }
        }
        
        function hideAddBarangModal() {
            const modal = document.getElementById('addBarangModal');
            if (modal) {
                modal.classList.add('hidden');
                // Reset form
                const form = document.getElementById('addBarangForm');
                if (form) form.reset();
                // Reset preview gambar
                document.getElementById('gambarPreview').classList.add('hidden');
            }
        }
        
        function viewBarang(barangData) {
            const modal = document.getElementById('viewBarangModal');
            const contentDiv = document.getElementById('barangDetailContent');
            
            // Buat konten detail TANPA status/kondisi
            contentDiv.innerHTML = `
                <div class="flex flex-col md:flex-row gap-6 mb-6">
                    <div class="flex-1">
                        <h4 class="text-lg font-bold text-gray-900 mb-2">${barangData.nama_barang}</h4>
                        <p class="text-sm text-gray-600 mb-4">${barangData.deskripsi || 'Tidak ada deskripsi'}</p>
                        
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Kode Barang</label>
                                <p class="text-gray-900">BRG-${String(barangData.id).padStart(3, '0')}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Kategori</label>
                                <p class="text-gray-900">${barangData.kategori?.nama_kategori || 'Tidak ada kategori'}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Jumlah Total</label>
                                <p class="text-gray-900">${barangData.jumlah + (barangData.peminjamans ? barangData.peminjamans.reduce((sum, p) => sum + p.jumlah, 0) : 0)} unit</p>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Sedang Dipinjam</label>
                                <p class="text-gray-900">${barangData.peminjamans ? barangData.peminjamans.reduce((sum, p) => sum + p.jumlah, 0) : 0} unit</p>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Tersedia</label>
                                <p class="text-gray-900">${barangData.jumlah} unit</p>
                            </div>
                        </div>
                    </div>
                    
                    ${barangData.gambar ? `
                    <div class="w-full md:w-48">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Gambar Barang</label>
                        <img src="/storage/${barangData.gambar}" alt="${barangData.nama_barang}" class="w-full h-48 object-cover rounded-lg">
                    </div>
                    ` : ''}
                </div>
            `;
            
            if (modal) {
                modal.classList.remove('hidden');
            }
        }
        
        function hideViewBarangModal() {
            const modal = document.getElementById('viewBarangModal');
            if (modal) {
                modal.classList.add('hidden');
            }
        }
        
        function editBarang(barangId) {
            // Redirect ke halaman edit
            window.location.href = `/admin/barang/${barangId}/edit`;
        }
        
        // Fungsi untuk filter pencarian
        function filterBarang() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const kategoriFilter = document.getElementById('filterKategori').value;
            
            // Ambil semua baris
            const rows = document.querySelectorAll('.barang-row');
            
            rows.forEach(row => {
                const nama = row.getAttribute('data-nama');
                const kategori = row.getAttribute('data-kategori');
                
                const matchesSearch = !searchTerm || nama.includes(searchTerm);
                const matchesKategori = !kategoriFilter || kategori === kategoriFilter;
                
                if (matchesSearch && matchesKategori) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
        
        // Inisialisasi event listeners setelah DOM siap
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM fully loaded - Data Barang');
            
            // Setup untuk tombol tambah barang
            const tambahBtn = document.getElementById('tambahBarangBtn');
            if (tambahBtn) {
                tambahBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    showAddBarangModal();
                });
            }
            
            // Setup untuk tombol close modal tambah
            const closeAddBtn = document.getElementById('closeAddBarangModal');
            const cancelAddBtn = document.getElementById('cancelAddBarangBtn');
            if (closeAddBtn) closeAddBtn.addEventListener('click', hideAddBarangModal);
            if (cancelAddBtn) cancelAddBtn.addEventListener('click', hideAddBarangModal);
            
            // Setup untuk tombol close modal view
            const closeViewBtn = document.getElementById('closeViewBarangBtn');
            const closeViewModal = document.getElementById('closeViewBarangModal');
            if (closeViewBtn) closeViewBtn.addEventListener('click', hideViewBarangModal);
            if (closeViewModal) closeViewModal.addEventListener('click', hideViewBarangModal);
            
            // Setup untuk upload gambar
            const gambarUploadArea = document.getElementById('gambarUploadArea');
            const gambarInput = document.getElementById('gambarInput');
            const gambarPreview = document.getElementById('gambarPreview');
            const previewImage = document.getElementById('previewImage');
            
            if (gambarUploadArea && gambarInput) {
                gambarUploadArea.addEventListener('click', () => gambarInput.click());
                
                gambarUploadArea.addEventListener('dragover', (e) => {
                    e.preventDefault();
                    gambarUploadArea.classList.add('border-blue-400', 'bg-blue-50');
                });
                
                gambarUploadArea.addEventListener('dragleave', () => {
                    gambarUploadArea.classList.remove('border-blue-400', 'bg-blue-50');
                });
                
                gambarUploadArea.addEventListener('drop', (e) => {
                    e.preventDefault();
                    gambarUploadArea.classList.remove('border-blue-400', 'bg-blue-50');
                    if (e.dataTransfer.files.length) {
                        gambarInput.files = e.dataTransfer.files;
                        previewGambar(e.dataTransfer.files[0]);
                    }
                });
                
                gambarInput.addEventListener('change', (e) => {
                    if (e.target.files.length) {
                        previewGambar(e.target.files[0]);
                    }
                });
            }
            
            function previewGambar(file) {
                if (file.size > 2 * 1024 * 1024) {
                    alert('Ukuran gambar maksimal 2MB');
                    return;
                }
                
                const reader = new FileReader();
                reader.onload = (e) => {
                    previewImage.src = e.target.result;
                    gambarPreview.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
            
            // Setup untuk filter pencarian
            const searchInput = document.getElementById('searchInput');
            const filterKategori = document.getElementById('filterKategori');
            if (searchInput) searchInput.addEventListener('input', filterBarang);
            if (filterKategori) filterKategori.addEventListener('change', filterBarang);
            
            // Mobile menu toggle
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            sidebarElement = document.querySelector('aside');
            if (mobileMenuButton && sidebarElement) {
                mobileMenuButton.addEventListener('click', () => {
                    sidebarElement.classList.toggle('-translate-x-full');
                });
            }
            
            // Close modal dengan ESC key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    hideAddBarangModal();
                    hideViewBarangModal();
                }
            });
            
            // Close modal dengan klik di luar
            document.addEventListener('click', function(e) {
                const addModal = document.getElementById('addBarangModal');
                const viewModal = document.getElementById('viewBarangModal');
                
                if (addModal && !addModal.classList.contains('hidden') && e.target === addModal) {
                    hideAddBarangModal();
                }
                
                if (viewModal && !viewModal.classList.contains('hidden') && e.target === viewModal) {
                    hideViewBarangModal();
                }
            });
        });
        
        // Export fungsi ke global scope
        window.showAddBarangModal = showAddBarangModal;
        window.hideAddBarangModal = hideAddBarangModal;
        window.viewBarang = viewBarang;
        window.hideViewBarangModal = hideViewBarangModal;
        window.editBarang = editBarang;
    </script>
</body>
</html>