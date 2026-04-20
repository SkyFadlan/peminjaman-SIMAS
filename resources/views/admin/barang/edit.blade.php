<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Barang - SIMAS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        
        /* Style untuk modal (tetap sama) */
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
        
        /* Form styles */
        .form-input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        
        .form-label {
            font-weight: 600;
            font-size: 0.875rem;
            color: #374151;
            margin-bottom: 0.5rem;
            display: block;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .input-error {
            border-color: #ef4444 !important;
        }
        
        .error-message {
            color: #ef4444;
            font-size: 0.75rem;
            margin-top: 0.25rem;
        }
        
        /* Step indicator */
        .step-active {
            background: linear-gradient(135deg, #2563eb 0%, #06b6d4 100%);
            color: white;
        }
        
        .step-inactive {
            background-color: #f3f4f6;
            color: #9ca3af;
        }
        
        /* Badge kategori */
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
                            <h1 class="text-2xl font-bold text-gray-900">Edit Barang</h1>
                            <p class="text-sm text-gray-500 mt-0.5">Ubah data inventaris sarana prasarana</p>
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
                <!-- Breadcrumb -->
                <div class="mb-6">
                    <nav class="flex" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-3">
                            <li class="inline-flex items-center">
                                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                                    </svg>
                                    Dashboard
                                </a>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    <a href="{{ route('admin.barang.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">Data Barang</a>
                                </div>
                            </li>
                            <li aria-current="page">
                                <div class="flex items-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Edit Barang</span>
                                </div>
                            </li>
                        </ol>
                    </nav>
                </div>

                <!-- Form Edit Barang -->
                <div class="max-w-4xl mx-auto">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <!-- Header Form dengan Info Barang -->
                        <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-cyan-50 border-b border-gray-200">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-cyan-400 rounded-xl flex items-center justify-center text-white mr-4">
                                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h2 class="text-xl font-bold text-gray-900">{{ $barang->nama_barang }}</h2>
                                        <div class="flex items-center mt-1">
                                            <span class="text-sm text-gray-600 mr-3">Kode: <span class="font-semibold">BRG-{{ str_pad($barang->id, 3, '0', STR_PAD_LEFT) }}</span></span>
                                            <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-medium">
                                                {{ $barang->kategori->nama_kategori ?? 'Tidak ada kategori' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-gray-500">Dibuat: {{ $barang->created_at->format('d/m/Y') }}</p>
                                    <p class="text-sm text-gray-500">Terakhir diupdate: {{ $barang->updated_at->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Progress Step Indicator -->
                        <div class="px-6 pt-6 pb-2 border-b border-gray-200">
                            <div class="flex items-center justify-between max-w-2xl mx-auto">
                                <div class="flex items-center flex-1">
                                    <div class="w-8 h-8 step-active rounded-full flex items-center justify-center text-sm font-bold">1</div>
                                    <div class="flex-1 h-1 mx-2 bg-gradient-to-r from-blue-600 to-cyan-500"></div>
                                </div>
                                <div class="flex items-center flex-1">
                                    <div class="w-8 h-8 step-active rounded-full flex items-center justify-center text-sm font-bold">2</div>
                                    <div class="flex-1 h-1 mx-2 bg-gradient-to-r from-blue-600 to-cyan-500"></div>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-8 h-8 step-active rounded-full flex items-center justify-center text-sm font-bold">3</div>
                                </div>
                            </div>
                            <div class="flex justify-between max-w-2xl mx-auto mt-2 text-xs text-gray-500">
                                <span>Informasi Dasar</span>
                                <span>Detail Barang</span>
                                <span>Upload Gambar</span>
                            </div>
                        </div>

                        <!-- Form Body -->
                        <form action="{{ route('admin.barang.update', $barang->id) }}" method="POST" enctype="multipart/form-data" class="p-6">
                            @csrf
                            @method('PUT')
                            
                            <!-- Step 1: Informasi Dasar -->
                            <div class="space-y-6">
                                <h4 class="text-sm font-bold text-gray-900 flex items-center">
                                    <span class="w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-xs mr-2">1</span>
                                    Informasi Dasar Barang
                                </h4>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="form-group">
                                        <label for="nama_barang" class="form-label">Nama Barang <span class="text-red-500">*</span></label>
                                        <input type="text" 
                                               id="nama_barang" 
                                               name="nama_barang" 
                                               value="{{ old('nama_barang', $barang->nama_barang) }}" 
                                               class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nama_barang') border-red-500 @enderror"
                                               placeholder="Contoh: Proyektor LCD Epson"
                                               required>
                                        @error('nama_barang')
                                            <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="kategori_id" class="form-label">Kategori <span class="text-red-500">*</span></label>
                                        <select id="kategori_id" 
                                                name="kategori_id" 
                                                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('kategori_id') border-red-500 @enderror"
                                                required>
                                            <option value="">Pilih Kategori</option>
                                            @foreach($kategoris ?? [] as $kategori)
                                            <option value="{{ $kategori->id }}" {{ old('kategori_id', $barang->kategori_id) == $kategori->id ? 'selected' : '' }}>
                                                {{ $kategori->nama_kategori }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('kategori_id')
                                            <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Step 2: Detail Barang -->
                            <div class="space-y-6 mt-8 pt-6 border-t border-gray-200">
                                <h4 class="text-sm font-bold text-gray-900 flex items-center">
                                    <span class="w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-xs mr-2">2</span>
                                    Detail Barang
                                </h4>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="form-group">
                                        <label for="jumlah" class="form-label">Jumlah <span class="text-red-500">*</span></label>
                                        <input type="number" 
                                               id="jumlah" 
                                               name="jumlah" 
                                               min="0"
                                               value="{{ old('jumlah', $barang->jumlah) }}" 
                                               class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('jumlah') border-red-500 @enderror"
                                               placeholder="0"
                                               required>
                                        @error('jumlah')
                                            <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="satuan" class="form-label">Satuan</label>
                                        <input type="text" 
                                               id="satuan" 
                                               name="satuan" 
                                               value="{{ old('satuan', $barang->satuan ?? 'unit') }}" 
                                               class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                               placeholder="Contoh: unit, buah, set">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="deskripsi" class="form-label">Deskripsi Barang</label>
                                    <textarea id="deskripsi" 
                                              name="deskripsi" 
                                              rows="4" 
                                              class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('deskripsi') border-red-500 @enderror"
                                              placeholder="Deskripsi lengkap barang, spesifikasi, kondisi, dll.">{{ old('deskripsi', $barang->deskripsi) }}</textarea>
                                    @error('deskripsi')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Step 3: Upload Gambar -->
                            <div class="space-y-6 mt-8 pt-6 border-t border-gray-200">
                                <h4 class="text-sm font-bold text-gray-900 flex items-center">
                                    <span class="w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-xs mr-2">3</span>
                                    Upload Gambar Barang
                                </h4>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Current Image -->
                                    <div>
                                        <label class="form-label">Gambar Saat Ini</label>
                                        @if($barang->gambar)
                                            <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                                                <img src="{{ asset('storage/' . $barang->gambar) }}" 
                                                     alt="{{ $barang->nama_barang }}" 
                                                     class="max-h-48 mx-auto rounded-lg">
                                                <div class="flex items-center justify-center mt-3">
                                                    <span class="text-xs text-gray-500">File: {{ basename($barang->gambar) }}</span>
                                                </div>
                                            </div>
                                        @else
                                            <div class="border border-gray-200 rounded-lg p-8 bg-gray-50 text-center">
                                                <svg class="w-16 h-16 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                <p class="text-sm text-gray-500">Belum ada gambar</p>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Upload New Image -->
                                    <div>
                                        <label class="form-label">Upload Gambar Baru <span class="text-gray-500 text-xs">(Opsional)</span></label>
                                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-400 transition-colors cursor-pointer" id="gambarUploadArea">
                                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <p class="text-sm text-gray-600 mb-1">Klik untuk upload atau drag & drop</p>
                                            <p class="text-xs text-gray-500">PNG, JPG, JPEG (Max. 2MB)</p>
                                            <p class="text-xs text-gray-400 mt-2">Kosongkan jika tidak ingin mengubah gambar</p>
                                            <input type="file" name="gambar" id="gambarInput" class="hidden" accept="image/*">
                                            <div id="gambarPreview" class="mt-3 hidden">
                                                <img id="previewImage" class="mx-auto max-h-40 rounded-lg">
                                                <p class="text-xs text-green-600 mt-2">Gambar baru siap diupload</p>
                                            </div>
                                        </div>
                                        @error('gambar')
                                            <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Additional Info (Read-only) -->
                            <div class="mt-8 pt-6 border-t border-gray-200">
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <h5 class="text-sm font-semibold text-gray-700 mb-3">Informasi Sistem</h5>
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                        <div>
                                            <span class="text-gray-500">ID Barang:</span>
                                            <span class="font-semibold ml-2">#{{ $barang->id }}</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-500">Dibuat:</span>
                                            <span class="font-semibold ml-2">{{ $barang->created_at->format('d/m/Y') }}</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-500">Diupdate:</span>
                                            <span class="font-semibold ml-2">{{ $barang->updated_at->format('d/m/Y') }}</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-500">Status:</span>
                                            <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium ml-2">Aktif</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="flex justify-end space-x-3 pt-6 mt-6 border-t border-gray-200">
                                <a href="{{ route('admin.barang.index') }}" 
                                   class="px-5 py-2.5 border border-gray-200 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition-all inline-flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                    </svg>
                                    Batal
                                </a>
                                <button type="submit" 
                                        class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-cyan-500 text-white rounded-xl font-semibold hover:shadow-lg hover:shadow-blue-300 transition-all inline-flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                                    </svg>
                                    Update Barang
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Card Tips -->
                    <div class="mt-4 bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3 flex-1 md:flex md:justify-between">
                                <p class="text-sm text-blue-700">
                                    <span class="font-semibold">Tips:</span> 
                                    Upload gambar dengan format JPG/PNG maksimal 2MB untuk tampilan yang lebih baik. 
                                    Gambar akan otomatis terkompresi.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Danger Zone (untuk delete) -->
                    <div class="mt-6 bg-red-50 border border-red-200 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                                <div>
                                    <h5 class="text-sm font-bold text-red-800">Danger Zone</h5>
                                    <p class="text-xs text-red-600">Hati-hati! Tindakan ini tidak dapat dibatalkan.</p>
                                </div>
                            </div>
                            <form action="{{ route('admin.barang.destroy', $barang->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus barang {{ $barang->nama_barang }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg text-sm font-semibold hover:bg-red-700 transition-colors">
                                    Hapus Barang
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- SCRIPT -->
    <script>
        // Debug - Pastikan script berjalan
        console.log('Script Edit Barang loaded successfully');
        
        // Deklarasi variabel
        let sidebarElement;
        
        // Mobile menu toggle
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            sidebarElement = document.querySelector('aside');
            if (mobileMenuButton && sidebarElement) {
                mobileMenuButton.addEventListener('click', () => {
                    sidebarElement.classList.toggle('-translate-x-full');
                });
            }

            // Auto-hide success notification if exists
            const successNotif = document.getElementById('success-notification');
            if (successNotif) {
                setTimeout(() => {
                    successNotif.remove();
                }, 3000);
            }

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
        });

        // Confirm before leaving with unsaved changes
        let formChanged = false;
        const form = document.querySelector('form');
        if (form) {
            const inputs = form.querySelectorAll('input:not([type="file"]), select, textarea');
            inputs.forEach(input => {
                input.addEventListener('change', () => {
                    formChanged = true;
                });
                input.addEventListener('keyup', () => {
                    formChanged = true;
                });
            });

            window.addEventListener('beforeunload', function(e) {
                if (formChanged) {
                    e.preventDefault();
                    e.returnValue = '';
                }
            });

            form.addEventListener('submit', function() {
                formChanged = false;
            });
        }
    </script>
</body>
</html>