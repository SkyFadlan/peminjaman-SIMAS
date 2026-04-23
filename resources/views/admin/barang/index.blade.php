<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Buku - SIMAS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        
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
        
        /* Tabel compact - tidak perlu scroll horizontal */
        .barang-table {
            width: 100%;
            table-layout: fixed;
        }
        
        .barang-table th, .barang-table td {
            padding: 12px 8px;
            vertical-align: middle;
        }
        
        /* Lebar kolom tetap */
        .barang-table th:nth-child(1), .barang-table td:nth-child(1) { width: 60px; text-align: center; }  /* Cover */
        .barang-table th:nth-child(2), .barang-table td:nth-child(2) { width: 85px; }  /* Kode */
        .barang-table th:nth-child(3), .barang-table td:nth-child(3) { width: auto; }  /* Judul */
        .barang-table th:nth-child(4), .barang-table td:nth-child(4) { width: 100px; }  /* Kategori */
        .barang-table th:nth-child(5), .barang-table td:nth-child(5) { width: 60px; text-align: center; }  /* Total */
        .barang-table th:nth-child(6), .barang-table td:nth-child(6) { width: 70px; text-align: center; }  /* Dipinjam */
        .barang-table th:nth-child(7), .barang-table td:nth-child(7) { width: 70px; text-align: center; }  /* Tersedia */
        .barang-table th:nth-child(8), .barang-table td:nth-child(8) { width: 85px; text-align: center; }  /* Status */
        .barang-table th:nth-child(9), .barang-table td:nth-child(9) { width: 100px; text-align: center; }  /* Aksi */
        
        .book-cover {
            width: 40px;
            height: 55px;
            object-fit: cover;
            border-radius: 6px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            cursor: pointer;
            transition: transform 0.2s;
        }
        
        .book-cover:hover {
            transform: scale(1.1);
        }
        
        /* Badge */
        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            white-space: nowrap;
        }
        
        .badge-blue { background: #dbeafe; color: #1e40af; }
        .badge-green { background: #dcfce7; color: #166534; }
        .badge-yellow { background: #fef3c7; color: #92400e; }
        .badge-red { background: #fee2e2; color: #991b1b; }
        .badge-purple { background: #f3e8ff; color: #6b21a5; }
        
        /* Truncate teks */
        .truncate-text {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 200px;
        }
        
        /* Responsive */
        @media (max-width: 1024px) {
            .barang-table th:nth-child(6), .barang-table td:nth-child(6),
            .barang-table th:nth-child(7), .barang-table td:nth-child(7) {
                display: none;
            }
        }
    </style>
</head>
<body class="bg-slate-50">
    
    <div class="flex min-h-screen">
        @include('components.sidebar_admin')

        <div class="flex-1 lg:ml-64">
            <!-- Top Navbar -->
            <nav class="bg-white border-b border-gray-200 sticky top-0 z-40">
                <div class="px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between h-16">
                        <button id="mobile-menu-button" class="lg:hidden p-2 rounded-lg text-gray-600 hover:bg-gray-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>

                        <div class="flex-1">
                            <h1 class="text-xl font-bold text-gray-900">📚 Data Buku</h1>
                            <p class="text-xs text-gray-500 mt-0.5">Kelola inventaris buku perpustakaan</p>
                        </div>

                        <div class="flex items-center space-x-3">
                            @if(session('success'))
                            <div id="success-notification" class="bg-green-100 border border-green-400 text-green-700 px-3 py-1.5 rounded-lg text-xs">
                                {{ session('success') }}
                            </div>
                            <script>
                                setTimeout(() => {
                                    const notification = document.getElementById('success-notification');
                                    if (notification) notification.remove();
                                }, 3000);
                            </script>
                            @endif
                            
                            <div class="flex items-center space-x-2 pl-3 border-l border-gray-200">
                                <div class="hidden sm:block text-right">
                                    <p class="text-sm font-semibold text-gray-900">Admin</p>
                                    <p class="text-xs text-gray-500">Administrator</p>
                                </div>
                                <button class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-cyan-400 flex items-center justify-center text-white font-semibold text-sm">
                                    A
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <main class="p-4 sm:p-6">
                <!-- Stats Cards - Lebih kecil -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-6">
                    <div class="bg-white rounded-xl shadow-sm p-3">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Total Buku</p>
                                <p class="text-xl font-bold text-gray-900">{{ $totalBarang ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                    
                </div>

                <!-- Filters & Table -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <!-- Filters -->
                    <div class="p-3 border-b border-gray-100 bg-gray-50">
                        <div class="flex flex-wrap items-center justify-between gap-2">
                            <select id="filterKategori" class="px-3 py-1.5 border border-gray-200 rounded-lg text-xs font-medium focus:ring-1 focus:ring-blue-500 bg-white">
                                <option value="">📚 Semua Kategori</option>
                                @foreach($kategoris ?? [] as $kategori)
                                <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                                @endforeach
                            </select>
                            
                            <div class="flex items-center gap-2">
                                <div class="relative">
                                    <input type="text" id="searchInput" placeholder="🔍 Cari buku..." class="pl-8 pr-3 py-1.5 border border-gray-200 rounded-lg text-xs focus:outline-none focus:ring-1 focus:ring-blue-500 w-48">
                                    <svg class="w-3.5 h-3.5 text-gray-400 absolute left-2.5 top-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <button id="tambahBarangBtn" class="px-3 py-1.5 bg-gradient-to-r from-blue-600 to-cyan-500 text-white rounded-lg text-xs font-semibold hover:shadow-md transition-all flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    <span>Tambah</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Tabel Compact -->
                    <div class="overflow-x-auto">
                        <table class="barang-table">
                            <thead class="bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th class="text-xs font-semibold text-gray-600 uppercase">Cover</th>
                                    <th class="text-xs font-semibold text-gray-600 uppercase">Kode</th>
                                    <th class="text-xs font-semibold text-gray-600 uppercase">Judul Buku</th>
                                    <th class="text-xs font-semibold text-gray-600 uppercase">Kategori</th>
                                    <th class="text-xs font-semibold text-gray-600 uppercase">Total</th>
                                    <th class="text-xs font-semibold text-gray-600 uppercase">Dipinjam</th>
                                    <th class="text-xs font-semibold text-gray-600 uppercase">Tersedia</th>
                                    <th class="text-xs font-semibold text-gray-600 uppercase">Status</th>
                                    <th class="text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($barangs ?? [] as $barang)
                                @php
                                    $dipinjam = $barang->peminjamans ? $barang->peminjamans->sum('jumlah') : 0;
                                    $tersedia = $barang->jumlah;
                                    $imagePath = $barang->gambar ? Storage::url($barang->gambar) : 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=80';
                                @endphp
                                <tr class="barang-row hover:bg-gray-50" 
                                    data-kategori="{{ $barang->kategori_id }}" 
                                    data-nama="{{ strtolower($barang->nama_barang) }}">
                                    
                                    <td class="text-center">
                                        <img src="{{ $imagePath }}" 
                                             alt="{{ $barang->nama_barang }}" 
                                             class="book-cover mx-auto"
                                             onclick="showImagePreview('{{ $imagePath }}', '{{ $barang->nama_barang }}')">
                                    </td>
                                    
                                    <td>
                                        <span class="badge badge-purple text-xs">{{ str_pad($barang->id, 3, '0', STR_PAD_LEFT) }}</span>
                                    </td>
                                    
                                    <td>
                                        <p class="text-sm font-semibold text-gray-800 truncate-text">{{ $barang->nama_barang }}</p>
                                        <p class="text-xs text-gray-500 truncate-text">{{ Str::limit($barang->deskripsi ?? 'Tanpa deskripsi', 40) }}</p>
                                    </td>
                                    
                                    <td>
                                        <span class="badge badge-blue text-xs">📖 {{ $barang->kategori->nama_kategori ?? '-' }}</span>
                                    </td>
                                    
                                    <td class="text-center">
                                        <span class="text-sm font-semibold">{{ $dipinjam + $tersedia }}</span>
                                    </td>
                                    
                                    <td class="text-center">
                                        <span class="text-sm text-orange-600 font-semibold">{{ $dipinjam }}</span>
                                    </td>
                                    
                                    <td class="text-center">
                                        <span class="text-sm font-semibold {{ $tersedia > 0 ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $tersedia }}
                                        </span>
                                    </td>
                                    
                                    <td class="text-center">
                                        @if($tersedia > 5)
                                            <span class="badge badge-green">Tersedia</span>
                                        @elseif($tersedia > 0)
                                            <span class="badge badge-yellow">Terbatas</span>
                                        @else
                                            <span class="badge badge-red">Habis</span>
                                        @endif
                                    </td>
                                    
                                    <td class="text-center">
                                        <div class="flex items-center justify-center gap-1">
                                            <button onclick="viewBarang({{ json_encode($barang) }})" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded" title="Detail">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </button>
                                            <button onclick="editBarang({{ $barang->id }})" class="p-1.5 text-green-600 hover:bg-green-50 rounded" title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </button>
                                            <form action="{{ route('admin.barang.destroy', $barang->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1.5 text-red-600 hover:bg-red-50 rounded" title="Hapus">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="py-8 text-center text-gray-500">
                                        Belum ada data buku
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    @if(isset($barangs) && $barangs->hasPages())
                    <div class="px-3 py-3 bg-gray-50 border-t border-gray-100">
                        <div class="flex items-center justify-between">
                            <p class="text-xs text-gray-500">
                                {{ $barangs->firstItem() }}-{{ $barangs->lastItem() }} dari {{ $barangs->total() }}
                            </p>
                            <div class="flex items-center gap-1">
                                {{ $barangs->links() }}
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </main>
        </div>
    </div>

    <!-- Image Preview Modal -->
    <div id="imagePreviewModal" class="modal-overlay hidden">
        <div class="modal-content max-w-sm">
            <div class="sticky top-0 bg-white border-b px-4 py-3 flex items-center justify-between">
                <h3 class="text-lg font-bold">Cover Buku</h3>
                <button onclick="closeImagePreview()" class="p-1 hover:bg-gray-100 rounded">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="p-4 text-center">
                <img id="previewImageLarge" src="" alt="Preview" class="mx-auto max-h-80 rounded-lg shadow">
                <p id="previewImageTitle" class="mt-3 text-gray-700 font-semibold text-sm"></p>
            </div>
        </div>
    </div>

    <!-- MODAL TAMBAH BARANG -->
    <div id="addBarangModal" class="modal-overlay hidden">
        <div class="modal-content max-w-2xl">
            <div class="sticky top-0 bg-white border-b px-6 py-4 flex items-center justify-between">
                <h3 class="text-xl font-bold">Tambah Buku</h3>
                <button type="button" id="closeAddBarangModal" class="p-2 hover:bg-gray-100 rounded">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="p-6">
                <form id="addBarangForm" action="{{ route('admin.barang.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold mb-1">Judul Buku <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_barang" class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-blue-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-1">Kategori <span class="text-red-500">*</span></label>
                            <select name="kategori_id" class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-blue-500" required>
                                <option value="">Pilih</option>
                                @foreach($kategoris ?? [] as $kategori)
                                <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold mb-1">Jumlah Stok</label>
                        <input type="number" name="jumlah" min="0" class="w-full px-3 py-2 border rounded-lg text-sm">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold mb-1">Deskripsi</label>
                        <textarea name="deskripsi" rows="3" class="w-full px-3 py-2 border rounded-lg text-sm"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1">Cover Buku</label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center cursor-pointer hover:border-blue-400" id="gambarUploadArea">
                            <svg class="w-10 h-10 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <p class="text-xs text-gray-600">Klik atau drag & drop</p>
                            <p class="text-xs text-gray-500">Max 2MB</p>
                            <input type="file" name="gambar" id="gambarInput" class="hidden" accept="image/*">
                            <div id="gambarPreview" class="mt-2 hidden">
                                <img id="previewImage" class="mx-auto max-h-32 rounded">
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 pt-2">
                        <button type="button" id="cancelAddBarangBtn" class="px-4 py-2 border rounded-lg text-sm font-semibold hover:bg-gray-50">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-gradient-to-r from-blue-600 to-cyan-500 text-white rounded-lg text-sm font-semibold">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL DETAIL BARANG -->
    <div id="viewBarangModal" class="modal-overlay hidden">
        <div class="modal-content max-w-2xl">
            <div class="sticky top-0 bg-white border-b px-6 py-4 flex items-center justify-between">
                <h3 class="text-xl font-bold">Detail Buku</h3>
                <button type="button" id="closeViewBarangModal" class="p-2 hover:bg-gray-100 rounded">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="p-6">
                <div id="barangDetailContent"></div>
                <div class="mt-6 flex justify-end">
                    <button type="button" id="closeViewBarangBtn" class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-cyan-500 text-white rounded-xl font-semibold">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let sidebarElement;
        
        function showAddBarangModal() {
            document.getElementById('addBarangModal').classList.remove('hidden');
        }
        
        function hideAddBarangModal() {
            document.getElementById('addBarangModal').classList.add('hidden');
            document.getElementById('addBarangForm')?.reset();
            document.getElementById('gambarPreview')?.classList.add('hidden');
        }
        
        function showImagePreview(url, title) {
            document.getElementById('previewImageLarge').src = url;
            document.getElementById('previewImageTitle').innerText = title;
            document.getElementById('imagePreviewModal').classList.remove('hidden');
        }
        
        function closeImagePreview() {
            document.getElementById('imagePreviewModal').classList.add('hidden');
        }
        
        function viewBarang(data) {
            const dipinjam = data.peminjamans ? data.peminjamans.reduce((s, p) => s + p.jumlah, 0) : 0;
            const tersedia = data.jumlah;
            const imagePath = data.gambar ? `/storage/${data.gambar}` : 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=150';
            
            let statusHtml = tersedia > 5 ? '<span class="badge badge-green">Tersedia</span>' : (tersedia > 0 ? '<span class="badge badge-yellow">Stok Terbatas</span>' : '<span class="badge badge-red">Habis</span>');
            
            document.getElementById('barangDetailContent').innerHTML = `
                <div class="flex flex-col md:flex-row gap-6">
                    <div class="w-36 h-48 overflow-hidden rounded-lg shadow">
                        <img src="${imagePath}" class="w-full h-full object-cover">
                    </div>
                    <div class="flex-1">
                        <h4 class="text-xl font-bold mb-2">${data.nama_barang}</h4>
                        <div class="flex gap-2 mb-4">${statusHtml}</div>
                        <div class="grid grid-cols-2 gap-3 text-sm">
                            <div><span class="text-gray-500">Kode:</span> <br><strong>BRG-${String(data.id).padStart(3, '0')}</strong></div>
                            <div><span class="text-gray-500">Kategori:</span> <br><strong>📖 ${data.kategori?.nama_kategori || '-'}</strong></div>
                            <div><span class="text-gray-500">Total:</span> <br><strong>${dipinjam + tersedia} eks</strong></div>
                            <div><span class="text-gray-500">Dipinjam:</span> <br><strong class="text-orange-600">${dipinjam} eks</strong></div>
                            <div><span class="text-gray-500">Tersedia:</span> <br><strong class="${tersedia > 0 ? 'text-green-600' : 'text-red-600'}">${tersedia} eks</strong></div>
                        </div>
                        ${data.deskripsi ? `<div class="mt-4 p-3 bg-blue-50 rounded"><p class="text-xs text-gray-700">${data.deskripsi}</p></div>` : ''}
                    </div>
                </div>
            `;
            document.getElementById('viewBarangModal').classList.remove('hidden');
        }
        
        function hideViewBarangModal() {
            document.getElementById('viewBarangModal').classList.add('hidden');
        }
        
        function editBarang(id) {
            window.location.href = `/admin/barang/${id}/edit`;
        }
        
        function filterBarang() {
            const search = document.getElementById('searchInput').value.toLowerCase();
            const kategori = document.getElementById('filterKategori').value;
            document.querySelectorAll('.barang-row').forEach(row => {
                const nama = row.getAttribute('data-nama');
                const kat = row.getAttribute('data-kategori');
                row.style.display = (!search || nama.includes(search)) && (!kategori || kat === kategori) ? '' : 'none';
            });
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('tambahBarangBtn')?.addEventListener('click', showAddBarangModal);
            document.getElementById('closeAddBarangModal')?.addEventListener('click', hideAddBarangModal);
            document.getElementById('cancelAddBarangBtn')?.addEventListener('click', hideAddBarangModal);
            document.getElementById('closeViewBarangBtn')?.addEventListener('click', hideViewBarangModal);
            document.getElementById('closeViewBarangModal')?.addEventListener('click', hideViewBarangModal);
            document.getElementById('searchInput')?.addEventListener('input', filterBarang);
            document.getElementById('filterKategori')?.addEventListener('change', filterBarang);
            
            const uploadArea = document.getElementById('gambarUploadArea');
            const gambarInput = document.getElementById('gambarInput');
            if (uploadArea && gambarInput) {
                uploadArea.addEventListener('click', () => gambarInput.click());
                gambarInput.addEventListener('change', (e) => {
                    if (e.target.files?.[0]) {
                        const reader = new FileReader();
                        reader.onload = (ev) => {
                            document.getElementById('previewImage').src = ev.target.result;
                            document.getElementById('gambarPreview').classList.remove('hidden');
                        };
                        reader.readAsDataURL(e.target.files[0]);
                    }
                });
            }
            
            const mobileBtn = document.getElementById('mobile-menu-button');
            const sidebar = document.querySelector('aside');
            if (mobileBtn && sidebar) mobileBtn.addEventListener('click', () => sidebar.classList.toggle('-translate-x-full'));
            
            document.addEventListener('keydown', (e) => { if (e.key === 'Escape') { hideAddBarangModal(); hideViewBarangModal(); closeImagePreview(); } });
            document.addEventListener('click', (e) => {
                if (e.target.classList?.contains('modal-overlay')) e.target.classList.add('hidden');
            });
        });
        
        window.showAddBarangModal = showAddBarangModal;
        window.hideAddBarangModal = hideAddBarangModal;
        window.viewBarang = viewBarang;
        window.hideViewBarangModal = hideViewBarangModal;
        window.editBarang = editBarang;
        window.showImagePreview = showImagePreview;
        window.closeImagePreview = closeImagePreview;
    </script>
</body>
</html>