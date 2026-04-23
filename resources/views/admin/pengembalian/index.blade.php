<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengembalian - SarPras Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .tab-button.active {
            background: linear-gradient(to right, #6366f1, #8b5cf6);
            color: white;
            box-shadow: 0 4px 14px 0 rgba(99, 102, 241, 0.39);
        }
        .modal {
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
        .hidden {
            display: none !important;
        }
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .animate-spin {
            animation: spin 1s linear infinite;
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
                        <button id="mobile-menu-button" class="lg:hidden p-2 rounded-lg text-gray-600 hover:bg-gray-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>

                        <div class="flex-1">
                            <h1 class="text-2xl font-bold text-gray-900">Pengembalian Item</h1>
                            <p class="text-sm text-gray-500 mt-0.5">Kelola pengembalian barang yang dipinjam</p>
                        </div>

                        <div class="flex items-center space-x-3">
                            <div class="relative">
                                <input type="text" id="searchInput" placeholder="Cari kode/nama peminjam/barang..." value="{{ request('search') }}" class="pl-10 pr-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 w-64">
                                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <div class="flex items-center space-x-3 pl-3 border-l border-gray-200">
                                <div class="hidden sm:block text-right">
                                    <p class="text-sm font-semibold text-gray-900">{{ Auth::user()->name ?? 'Petugas' }}</p>
                                    <p class="text-xs text-gray-500">{{ Auth::user()->role ?? 'Staff' }}</p>
                                </div>
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-600 to-violet-500 flex items-center justify-center text-white font-semibold uppercase">
                                    {{ substr(Auth::user()->name ?? 'P', 0, 1) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="p-4 sm:p-6 lg:p-8">
                <!-- Stats Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-gray-600 text-sm font-medium mb-1">Jatuh Tempo Hari Ini</h3>
                        <p class="text-3xl font-bold text-gray-900">{{ $jatuhTempoHariIni }}</p>
                        <p class="text-xs text-gray-500 mt-2">Harus dikembalikan</p>
                    </div>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-gray-600 text-sm font-medium mb-1">Terlambat</h3>
                        <p class="text-3xl font-bold text-gray-900">{{ $terlambat }}</p>
                        <p class="text-xs text-red-600 mt-2 font-medium">Perlu tindak lanjut</p>
                    </div>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-gray-600 text-sm font-medium mb-1">Dikembalikan Hari Ini</h3>
                        <p class="text-3xl font-bold text-gray-900">{{ $dikembalikanHariIni }}</p>
                        <p class="text-xs text-gray-500 mt-2">Sudah diproses</p>
                    </div>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-gray-600 text-sm font-medium mb-1">Total Aktif</h3>
                        <p class="text-3xl font-bold text-gray-900">{{ $totalAktif }}</p>
                        <p class="text-xs text-gray-500 mt-2">Sedang dipinjam</p>
                    </div>
                </div>

                <!-- Filters & Tabs -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <!-- Tabs -->
                    <div class="border-b border-gray-200">
                        <div class="px-6 py-4">
                            <div class="flex items-center justify-between">
                                <div class="flex space-x-2">
                                    <button onclick="switchTab('jadwal')" id="tab-jadwal" class="tab-button px-6 py-2.5 bg-gradient-to-r from-indigo-600 to-violet-500 text-white rounded-lg font-semibold transition-all">
                                        Jatuh Tempo ({{ $jatuhTempoHariIni }})
                                    </button>
                                    <button onclick="switchTab('terlambat')" id="tab-terlambat" class="tab-button px-6 py-2.5 bg-gray-100 text-gray-700 rounded-lg font-semibold hover:bg-gray-200 transition-all">
                                        Terlambat ({{ $terlambat }})
                                    </button>
                                    <button onclick="switchTab('semua')" id="tab-semua" class="tab-button px-6 py-2.5 bg-gray-100 text-gray-700 rounded-lg font-semibold hover:bg-gray-200 transition-all">
                                        Semua Aktif ({{ $totalAktif }})
                                    </button>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <select id="filterKategori" class="px-4 py-2 border border-gray-200 rounded-lg text-sm font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                        <option value="">Semua Kategori</option>
                                        @foreach($kategoris as $kategori)
                                            <option value="{{ $kategori->id }}" {{ request('kategori') == $kategori->id ? 'selected' : '' }}>
                                                {{ $kategori->nama_kategori }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button onclick="resetFilters()" class="px-4 py-2 text-sm text-indigo-600 hover:text-indigo-700 font-medium">
                                        Refresh
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab Content: Jatuh Tempo -->
<div id="content-jadwal" class="tab-content">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4 text-left">
                        <input type="checkbox" id="selectAll" class="w-4 h-4 text-indigo-600 rounded border-gray-300 focus:ring-indigo-500">
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kode</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Peminjam</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Item</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tgl Pinjam</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tgl Kembali</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Sisa Waktu</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($peminjamanJatuhTempo as $pinjam)
                    @include('admin.pengembalian._row', ['pinjam' => $pinjam])
                @empty
                    <tr>
                        <td colspan="9" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <h3 class="text-lg font-semibold text-gray-900 mb-1">Tidak Ada Item Jatuh Tempo</h3>
                                <p class="text-gray-600">Semua item dikembalikan tepat waktu.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

                    <!-- Tab Content: Terlambat -->
<div id="content-terlambat" class="tab-content hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-red-50 border-b border-red-100">
                <tr>
                    <th class="px-6 py-4 text-left">
                        <input type="checkbox" id="selectAllTerlambat" class="w-4 h-4 text-indigo-600 rounded border-gray-300 focus:ring-indigo-500">
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kode</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Peminjam</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Item</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tgl Pinjam</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Seharusnya Kembali</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Terlambat</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Denda</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($peminjamanTerlambat as $pinjam)
                    @include('admin.pengembalian._row_overdue', ['pinjam' => $pinjam])
                @empty
                    <tr>
                        <td colspan="9" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <h3 class="text-lg font-semibold text-gray-900 mb-1">Tidak Ada Item Terlambat</h3>
                                <p class="text-gray-600">Semua peminjaman dikembalikan tepat waktu.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

                    <!-- Tab Content: Semua Aktif -->
<div id="content-semua" class="tab-content hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4 text-left">
                        <input type="checkbox" id="selectAllSemua" class="w-4 h-4 text-indigo-600 rounded border-gray-300 focus:ring-indigo-500">
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kode</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Peminjam</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Item</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tgl Pinjam</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tgl Kembali</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Sisa Waktu</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($peminjamans as $pinjam)
                    @include('admin.pengembalian._row_all', ['pinjam' => $pinjam])
                @empty
                    <tr>
                        <td colspan="9" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                </svg>
                                <h3 class="text-lg font-semibold text-gray-900 mb-1">Tidak Ada Peminjaman Aktif</h3>
                                <p class="text-gray-600">Belum ada peminjaman yang sedang berlangsung.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

                    <!-- Pagination -->
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <p class="text-sm text-gray-600">
                            Menampilkan <span class="font-semibold">{{ $peminjamans->firstItem() ?? 0 }}-{{ $peminjamans->lastItem() ?? 0 }}</span> 
                            dari <span class="font-semibold">{{ $peminjamans->total() }}</span> item
                        </p>
                        <div class="flex items-center space-x-2">
                            {{ $peminjamans->links() }}
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Return Modal -->
    <div id="returnModal" class="modal hidden">
        <div class="bg-white rounded-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between rounded-t-2xl">
                <h3 class="text-xl font-bold text-gray-900">Proses Pengembalian</h3>
                <button onclick="closeModal('returnModal')" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="p-6 space-y-6" id="modalReturnContent">
                <!-- Content will be filled by JavaScript -->
            </div>
        </div>
    </div>

    <!-- Scan QR Modal -->
    <div id="scanQRModal" class="modal hidden">
        <div class="bg-white rounded-2xl max-w-md w-full">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-gray-900">Scan QR Code</h3>
                    <button onclick="closeModal('scanQRModal')" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="bg-gray-100 rounded-xl h-64 flex items-center justify-center mb-4">
                    <div class="text-center p-6">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                        </svg>
                        <p class="text-sm text-gray-600 mb-2">Masukkan kode peminjaman</p>
                        <div class="flex space-x-2">
                            <input type="text" id="scanKode" maxlength="5" class="flex-1 px-4 py-2 border border-gray-200 rounded-lg text-center uppercase font-bold text-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="XXXXX">
                            <button onclick="processScan()" class="px-4 py-2 bg-gradient-to-r from-indigo-600 to-violet-500 text-white rounded-lg font-semibold hover:shadow-lg transition-all">
                                Cari
                            </button>
                        </div>
                    </div>
                </div>
                <button onclick="closeModal('scanQRModal')" class="w-full px-5 py-2.5 bg-gray-200 text-gray-700 rounded-xl font-semibold hover:bg-gray-300 transition-all">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div id="successModal" class="modal hidden">
        <div class="bg-white rounded-2xl max-w-md w-full p-6">
            <div class="text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2" id="successTitle">Berhasil!</h3>
                <p class="text-gray-600 mb-6" id="successMessage"></p>
                <button onclick="closeModal('successModal')" class="w-full px-4 py-3 bg-gradient-to-r from-indigo-600 to-violet-500 text-white rounded-xl font-semibold hover:shadow-lg transition-all">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- Detail Peminjaman Modal -->
<div id="detailPeminjamanModal" class="modal hidden">
    <div class="bg-white rounded-2xl max-w-3xl w-full max-h-[90vh] overflow-y-auto">
        <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between rounded-t-2xl">
            <h3 class="text-xl font-bold text-gray-900">Detail Peminjaman</h3>
            <button onclick="closeModal('detailPeminjamanModal')" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="p-6" id="detailPeminjamanContent">
            <!-- Content will be filled by JavaScript -->
        </div>
        <div class="sticky bottom-0 bg-white border-t border-gray-200 px-6 py-4 flex justify-end">
            <button onclick="closeModal('detailPeminjamanModal')" class="px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-violet-500 text-white rounded-xl font-semibold hover:shadow-lg transition-all">
                Tutup
            </button>
        </div>
    </div>
</div>


    <script>
        const csrfToken = '{{ csrf_token() }}';

        // ================ TAB FUNCTIONS ================
        function switchTab(tab) {
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });
            
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('active', 'bg-gradient-to-r', 'from-indigo-600', 'to-violet-500', 'text-white', 'shadow-lg');
                button.classList.add('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200');
            });
            
            document.getElementById(`content-${tab}`).classList.remove('hidden');
            
            const activeTab = document.getElementById(`tab-${tab}`);
            activeTab.classList.remove('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200');
            activeTab.classList.add('active', 'bg-gradient-to-r', 'from-indigo-600', 'to-violet-500', 'text-white', 'shadow-lg');
        }

        // ================ FILTER FUNCTIONS ================
        function applyFilters() {
            const url = new URL(window.location.href);
            const kategori = document.getElementById('filterKategori')?.value;
            const search = document.getElementById('searchInput')?.value;
            
            if (kategori) url.searchParams.set('kategori', kategori);
            else url.searchParams.delete('kategori');
            
            if (search) url.searchParams.set('search', search);
            else url.searchParams.delete('search');
            
            window.location.href = url.toString();
        }

        function resetFilters() {
            window.location.href = '{{ route("admin.pengembalian.index") }}';
        }

        document.getElementById('filterKategori')?.addEventListener('change', applyFilters);
        
        let searchTimeout;
        document.getElementById('searchInput')?.addEventListener('keyup', function(e) {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => applyFilters(), 500);
        });

        // ================ MODAL FUNCTIONS ================
        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

        // ================ RETURN FUNCTIONS ================
        function openReturnModal(id) {
            fetch(`/admin/pengembalian/${id}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => response.json())
            .then(data => {
                const content = document.getElementById('modalReturnContent');
                const payload = data.data ?? data;
                const dendaKondisiOptions = (data.denda_kondisi && data.denda_kondisi.length)
                    ? data.denda_kondisi
                    : [
                        { nama: 'Rusak Ringan', jumlah: 0 },
                        { nama: 'Rusak Berat', jumlah: 0 },
                        { nama: 'Hilang', jumlah: 0 }
                    ];
                const dendaKondisiMap = Object.fromEntries(dendaKondisiOptions.map(item => [item.nama, item.jumlah]));
                
                const tipe = payload.tipe_pinjam === 'hari' ? 'Per Hari' : 'Per Jam';
                const tanggalPinjam = payload.tipe_pinjam === 'hari' 
                    ? new Date(payload.tanggal_pinjam).toLocaleDateString('id-ID', {day: 'numeric', month: 'long', year: 'numeric'})
                    : new Date(payload.tanggal_pinjam_jam).toLocaleDateString('id-ID', {day: 'numeric', month: 'long', year: 'numeric'}) + ' ' + payload.jam_pinjam;
                
                const tanggalKembali = payload.tipe_pinjam === 'hari'
                    ? new Date(payload.tanggal_kembali).toLocaleDateString('id-ID', {day: 'numeric', month: 'long', year: 'numeric'})
                    : new Date(payload.tanggal_pinjam_jam).toLocaleDateString('id-ID', {day: 'numeric', month: 'long', year: 'numeric'}) + ' ' + payload.jam_kembali;
                
                // Hitung denda keterlambatan
                let keterlambatan = '';
                let isTerlambat = false;
                let lateAmount = 0;

                if (payload.tipe_pinjam === 'hari') {
                    const tglKembali = new Date(payload.tanggal_kembali);
                    const now = new Date();
                    const selisih = Math.floor((now - tglKembali) / (1000 * 60 * 60 * 24));
                    if (selisih > 0) {
                        isTerlambat = true;
                        lateAmount = selisih * 5000;
                        keterlambatan = selisih + ' hari';
                    }
                } else {
                    const jamKembali = new Date(payload.tanggal_pinjam_jam + ' ' + payload.jam_kembali);
                    const now = new Date();
                    const selisih = Math.floor((now - jamKembali) / (1000 * 60 * 60));
                    if (selisih > 0) {
                        isTerlambat = true;
                        lateAmount = selisih * 2000;
                        keterlambatan = selisih + ' jam';
                    }
                }

                content.innerHTML = `
                    <div class="bg-indigo-50 rounded-xl p-4 border border-indigo-100">
                        <h4 class="text-sm font-bold text-gray-900 mb-3">Informasi Item</h4>
                        <div class="space-y-2">
                            <p><span class="font-semibold">Item:</span> ${payload.barang.nama_barang}</p>
                            <p><span class="font-semibold">Kode:</span> BRG-${String(payload.barang.id).padStart(3, '0')}</p>
                            <p><span class="font-semibold">Kode Pinjam:</span> <span class="px-2 py-1 bg-purple-100 text-purple-800 rounded-lg font-mono">${payload.kode_peminjaman || '-'}</span></p>
                            <p><span class="font-semibold">Peminjam:</span> ${payload.user.name}</p>
                            <p><span class="font-semibold">Kelas/Role:</span> ${payload.user.role == 'siswa' ? (payload.user.profile?.kelas?.nama_kelas ?? 'Siswa') : payload.user.role}</p>
                            <p><span class="font-semibold">Tipe:</span> ${tipe}</p>
                            <p><span class="font-semibold">Tanggal Pinjam:</span> ${tanggalPinjam}</p>
                            <p><span class="font-semibold">Tanggal Kembali:</span> ${tanggalKembali}</p>
                            <p><span class="font-semibold">Status:</span> 
                                ${isTerlambat 
                                    ? '<span class="text-red-600 font-semibold">Terlambat ' + keterlambatan + '</span>' 
                                    : '<span class="text-green-600 font-semibold">Tepat Waktu</span>'}
                            </p>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-4">
                        <h4 class="text-sm font-bold text-gray-900 mb-3">Pemeriksaan Kondisi</h4>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Kondisi Item</label>
                                <select id="kondisi" class="w-full px-4 py-2 border border-gray-200 rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                    <option value="Baik">Baik</option>
                                    ${dendaKondisiOptions.map(option => `<option value="${option.nama}">${option.nama}</option>`).join('')}
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Denda Kondisi (Rp)</label>
                                <input id="dendaKondisiAmount" type="number" min="0" value="" placeholder="Masukkan denda kondisi" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                                <p class="text-xs text-gray-500 mt-1">Pilih kondisi lalu masukkan denda kondisi secara manual.</p>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Catatan</label>
                                <textarea id="catatan" rows="3" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Tambahkan catatan jika ada kerusakan atau masalah..."></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="bg-red-50 rounded-xl p-4 border border-red-100">
                        <h4 class="text-sm font-bold text-red-900 mb-3">Rincian Denda</h4>
                        <div class="space-y-2">
                            <p><span class="font-semibold">Denda Keterlambatan:</span> <span id="lateAmountText">Rp ${lateAmount.toLocaleString('id-ID')}</span></p>
                            <p><span class="font-semibold">Denda Kondisi:</span> <span id="conditionAmountText">Rp 0</span></p>
                            <p class="text-lg"><span class="font-semibold">Total Denda:</span> <span id="totalDendaText" class="text-red-600 font-bold">Rp ${lateAmount.toLocaleString('id-ID')}</span></p>
                            <div class="flex items-center space-x-2 mt-3">
                                <input type="checkbox" id="dendaBayar" class="w-4 h-4 text-indigo-600 rounded border-gray-300 focus:ring-indigo-500">
                                <label for="dendaBayar" class="text-sm font-medium text-gray-700">Denda sudah dibayar</label>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" id="returnId" value="${payload.id}">
                    
                    <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                        <button onclick="closeModal('returnModal')" class="px-5 py-2.5 border border-gray-200 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition-all">
                            Batal
                        </button>
                        <button onclick="processReturn()" class="px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-violet-500 text-white rounded-xl font-semibold hover:shadow-lg hover:shadow-indigo-300 transition-all">
                            Proses Pengembalian
                        </button>
                    </div>
                `;

                const kondisiSelect = document.getElementById('kondisi');
                const dendaKondisiInput = document.getElementById('dendaKondisiAmount');
                const conditionAmountText = document.getElementById('conditionAmountText');
                const totalDendaText = document.getElementById('totalDendaText');

                const updateTotal = () => {
                    const conditionAmount = Number(dendaKondisiInput.value) || 0;
                    conditionAmountText.innerText = `Rp ${conditionAmount.toLocaleString('id-ID')}`;
                    totalDendaText.innerText = `Rp ${(lateAmount + conditionAmount).toLocaleString('id-ID')}`;
                };

                kondisiSelect.addEventListener('change', () => {
                    dendaKondisiInput.value = '';
                    updateTotal();
                });
                dendaKondisiInput.addEventListener('input', updateTotal);
                dendaKondisiInput.value = '';
                updateTotal();
                
                openModal('returnModal');
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal mengambil data peminjaman');
            });
        }

        // ================ DETAIL PEMINJAMAN FUNCTIONS ================
function showDetailPeminjaman(id) {
    const modal = document.getElementById('detailPeminjamanModal');
    const content = document.getElementById('detailPeminjamanContent');
    
    // Tampilkan loading
    content.innerHTML = `
        <div class="text-center py-12">
            <div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-indigo-600 border-t-transparent"></div>
            <p class="mt-4 text-gray-600">Memuat detail peminjaman...</p>
        </div>
    `;
    modal.classList.remove('hidden');
    
    fetch(`/admin/pengembalian/${id}`, {
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        }
    })
    .then(response => response.json())
    .then(data => {
        const pinjam = data.data ?? data;
        const dendaKondisiOptions = (data.denda_kondisi && data.denda_kondisi.length) ? data.denda_kondisi : [];
        
        // Format tanggal
        const formatDate = (date) => {
            if (!date) return '-';
            return new Date(date).toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });
        };
        
        const formatDateTime = (date, time) => {
            if (!date) return '-';
            return `${formatDate(date)} ${time || ''}`;
        };
        
        // Status badge
        const getStatusBadge = (status) => {
            const badges = {
                'menunggu': 'bg-yellow-100 text-yellow-800',
                'disetujui': 'bg-blue-100 text-blue-800',
                'dipinjam': 'bg-green-100 text-green-800',
                'dikembalikan': 'bg-gray-100 text-gray-800',
                'ditolak': 'bg-red-100 text-red-800'
            };
            const labels = {
                'menunggu': 'Menunggu Persetujuan',
                'disetujui': 'Disetujui',
                'dipinjam': 'Sedang Dipinjam',
                'dikembalikan': 'Selesai',
                'ditolak': 'Ditolak'
            };
            return { class: badges[status] || 'bg-gray-100 text-gray-800', label: labels[status] || status };
        };
        
        const status = getStatusBadge(pinjam.status);
        const tipe = pinjam.tipe_pinjam === 'hari' ? 'Per Hari' : 'Per Jam';
        
        // Hitung denda keterlambatan
        let isTerlambat = false;
        let keterlambatanText = '';
        let dendaTerlambat = 0;
        
        if (pinjam.status === 'disetujui' || pinjam.status === 'dipinjam') {
            const now = new Date();
            if (pinjam.tipe_pinjam === 'hari') {
                const tglKembali = new Date(pinjam.tanggal_kembali);
                tglKembali.setHours(0, 0, 0, 0);
                if (now > tglKembali) {
                    const selisih = Math.ceil((now - tglKembali) / (1000 * 60 * 60 * 24));
                    isTerlambat = true;
                    keterlambatanText = `${selisih} hari`;
                    dendaTerlambat = selisih * 5000;
                }
            } else {
                const jamKembali = new Date(pinjam.tanggal_pinjam_jam + 'T' + pinjam.jam_kembali);
                if (now > jamKembali) {
                    const selisih = Math.ceil((now - jamKembali) / (1000 * 60 * 60));
                    isTerlambat = true;
                    keterlambatanText = `${selisih} jam`;
                    dendaTerlambat = selisih * 2000;
                }
            }
        }
        
        const imagePath = pinjam.barang.gambar 
            ? `/storage/${pinjam.barang.gambar}`
            : 'https://images.unsplash.com/photo-1593642632823-8f785ba67e45?w=400';
        
        content.innerHTML = `
            <div class="space-y-6">
                <!-- Header dengan status -->
                <div class="flex items-center justify-between p-4 ${status.class} rounded-xl">
                    <div class="flex items-center space-x-3">
                        <div class="flex-1">
                            <p class="font-semibold">Status: ${status.label}</p>
                            <p class="text-sm opacity-75">Kode: ${pinjam.kode_peminjaman || '-'}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm">ID: #${pinjam.id}</p>
                    </div>
                </div>
                
                <!-- Info Barang -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="md:col-span-1">
                        <img src="${imagePath}" alt="${pinjam.barang.nama_barang}" 
                             class="w-full h-48 object-cover rounded-xl shadow-md">
                    </div>
                    <div class="md:col-span-2 space-y-4">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 mb-1">${pinjam.barang.nama_barang}</h3>
                            <div class="flex flex-wrap gap-2">
                                <span class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-xs font-semibold">
                                    ${pinjam.barang.kategori?.nama_kategori || 'Lainnya'}
                                </span>
                                <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-semibold">
                                    Jumlah: ${pinjam.jumlah} unit
                                </span>
                                <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">
                                    Tipe: ${tipe}
                                </span>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <p class="text-xs text-gray-500 mb-1">Peminjam</p>
                                <p class="font-semibold text-gray-900">${pinjam.user.name}</p>
                                <p class="text-xs text-gray-500 capitalize">${pinjam.user.role}</p>
                            </div>
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <p class="text-xs text-gray-500 mb-1">Tanggal Pengajuan</p>
                                <p class="font-semibold text-gray-900">${formatDateTime(pinjam.created_at)}</p>
                            </div>
                            ${pinjam.alasan ? `
                            <div class="bg-gray-50 p-3 rounded-lg col-span-2">
                                <p class="text-xs text-gray-500 mb-1">Alasan Peminjaman</p>
                                <p class="text-sm text-gray-900">${pinjam.alasan}</p>
                            </div>
                            ` : ''}
                        </div>
                    </div>
                </div>
                
                <!-- Timeline Peminjaman -->
                <div class="border-t border-gray-200 pt-6">
                    <h4 class="font-bold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Timeline Peminjaman
                    </h4>
                    
                    <div class="space-y-4">
                        ${pinjam.tipe_pinjam == 'hari' ? `
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-900">Tanggal Ambil</p>
                                <p class="text-sm text-gray-600">${formatDate(pinjam.tanggal_pinjam)}</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0 w-8 h-8 ${isTerlambat ? 'bg-red-100' : 'bg-orange-100'} rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 ${isTerlambat ? 'text-red-600' : 'text-orange-600'}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-900">Tanggal Kembali</p>
                                <p class="text-sm text-gray-600">${formatDate(pinjam.tanggal_kembali)}</p>
                                ${isTerlambat ? `<p class="text-xs text-red-600 mt-1 font-semibold">Terlambat ${keterlambatanText}</p>` : ''}
                            </div>
                        </div>
                        ` : `
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-900">Tanggal & Jam Ambil</p>
                                <p class="text-sm text-gray-600">${formatDate(pinjam.tanggal_pinjam_jam)} ${pinjam.jam_pinjam}</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0 w-8 h-8 ${isTerlambat ? 'bg-red-100' : 'bg-orange-100'} rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 ${isTerlambat ? 'text-red-600' : 'text-orange-600'}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-900">Tanggal & Jam Kembali</p>
                                <p class="text-sm text-gray-600">${formatDate(pinjam.tanggal_pinjam_jam)} ${pinjam.jam_kembali}</p>
                                ${isTerlambat ? `<p class="text-xs text-red-600 mt-1 font-semibold">Terlambat ${keterlambatanText}</p>` : ''}
                            </div>
                        </div>
                        `}
                        
                        <!-- Durasi -->
                        <div class="mt-4 p-4 bg-gradient-to-r from-indigo-50 to-violet-50 rounded-xl">
                            <div class="flex justify-between items-center">
                                <span class="font-semibold text-indigo-900">Durasi Peminjaman:</span>
                                <span class="text-xl font-bold text-indigo-700">
                                    ${pinjam.tipe_pinjam == 'hari' 
                                        ? Math.ceil((new Date(pinjam.tanggal_kembali) - new Date(pinjam.tanggal_pinjam)) / (1000 * 60 * 60 * 24)) + 1 + ' hari'
                                        : pinjam.jumlah_jam + ' jam'}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Informasi Denda (jika ada) -->
                ${(pinjam.denda > 0 || isTerlambat) ? `
                <div class="border-t border-gray-200 pt-6">
                    <div class="bg-red-50 p-4 rounded-xl border border-red-200">
                        <h4 class="font-bold text-red-900 mb-3">Rincian Denda</h4>
                        <div class="space-y-2">
                            ${dendaTerlambat > 0 ? `
                            <div class="flex justify-between">
                                <span>Denda Keterlambatan (${keterlambatanText})</span>
                                <span class="font-semibold">Rp ${dendaTerlambat.toLocaleString('id-ID')}</span>
                            </div>
                            ` : ''}
                            ${pinjam.denda_kondisi > 0 ? `
                            <div class="flex justify-between">
                                <span>Denda Kondisi (${pinjam.kondisi_saat_kembali || '-'})</span>
                                <span class="font-semibold">Rp ${pinjam.denda_kondisi.toLocaleString('id-ID')}</span>
                            </div>
                            ` : ''}
                            <div class="flex justify-between pt-2 border-t border-red-200">
                                <span class="font-bold">Total Denda</span>
                                <span class="font-bold text-red-700">Rp ${(pinjam.denda || dendaTerlambat).toLocaleString('id-ID')}</span>
                            </div>
                            ${pinjam.denda_bayar ? `
                            <div class="text-green-600 text-sm mt-2">
                                ✓ Denda sudah dibayar
                            </div>
                            ` : ''}
                        </div>
                    </div>
                </div>
                ` : ''}
                
                <!-- Catatan -->
                ${pinjam.catatan_pengembalian ? `
                <div class="border-t border-gray-200 pt-6">
                    <h4 class="font-bold text-gray-900 mb-2">Catatan Pengembalian</h4>
                    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4">
                        <p class="text-sm text-gray-700">${pinjam.catatan_pengembalian}</p>
                    </div>
                </div>
                ` : ''}
                
                <!-- Informasi Tambahan -->
                <div class="border-t border-gray-200 pt-6">
                    <h4 class="font-bold text-gray-900 mb-3">Informasi Lainnya</h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Diproses Oleh</p>
                            <p class="font-semibold text-gray-900">${pinjam.diproses_oleh ? 'Petugas' : '-'}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Kondisi Saat Kembali</p>
                            <p class="font-semibold text-gray-900">${pinjam.kondisi_saat_kembali || '-'}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Terakhir Diupdate</p>
                            <p class="font-semibold text-gray-900">${formatDateTime(pinjam.updated_at)}</p>
                        </div>
                    </div>
                </div>
            </div>
        `;
    })
    .catch(error => {
        console.error('Error:', error);
        content.innerHTML = `
            <div class="text-center py-12 text-red-600">
                <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-lg font-semibold mb-2">Gagal memuat detail</p>
                <p class="text-sm text-gray-600">${error.message}</p>
            </div>
        `;
    });
}

        function processReturn() {
            const id = document.getElementById('returnId').value;
            const kondisi = document.getElementById('kondisi').value;
            const dendaKondisiAmount = Number(document.getElementById('dendaKondisiAmount')?.value) || 0;
            const catatan = document.getElementById('catatan')?.value || '';
            const dendaBayar = document.getElementById('dendaBayar')?.checked || false;
            
            const btn = event.currentTarget;
            const originalText = btn.innerHTML;
            btn.innerHTML = '<svg class="animate-spin inline-block w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Memproses...';
            btn.disabled = true;
            
            fetch(`/admin/pengembalian/${id}/return`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    kondisi: kondisi,
                    denda_kondisi_amount: dendaKondisiAmount,
                    catatan: catatan,
                    denda_bayar: dendaBayar
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    closeModal('returnModal');
                    
                    document.getElementById('successTitle').innerHTML = '✅ Pengembalian Berhasil!';
                    let message = data.message;
                    if (data.data.denda > 0) {
                        message += `<br>Total Denda: Rp ${data.data.denda.toLocaleString('id-ID')}`;
                        if (data.data.denda_terlambat > 0) {
                            message += `<br>Denda Keterlambatan: Rp ${data.data.denda_terlambat.toLocaleString('id-ID')}`;
                        }
                        if (data.data.denda_kondisi > 0) {
                            message += `<br>Denda Kondisi: Rp ${data.data.denda_kondisi.toLocaleString('id-ID')}`;
                        }
                    }
                    document.getElementById('successMessage').innerHTML = message;
                    
                    openModal('successModal');
                    
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                } else {
                    alert('❌ Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('❌ Gagal memproses pengembalian');
            })
            .finally(() => {
                btn.innerHTML = originalText;
                btn.disabled = false;
            });
        }

        // ================ SCAN QR FUNCTIONS ================
        function processScan() {
            const kode = document.getElementById('scanKode').value.trim().toUpperCase();
            
            if (kode.length !== 5) {
                alert('Kode peminjaman harus 5 karakter!');
                return;
            }
            
            fetch('/admin/pengembalian/scan', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ kode_peminjaman: kode })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    closeModal('scanQRModal');
                    openReturnModal(data.data.id);
                } else {
                    alert('❌ ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('❌ Kode tidak ditemukan atau sudah diproses');
            });
        }

        // ================ REMINDER FUNCTIONS ================
        function sendReminder(id) {
            if (!confirm('Kirim pengingat ke peminjam?')) return;
            
            fetch(`/admin/pengembalian/${id}/reminder`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('✅ ' + data.message);
                } else {
                    alert('❌ ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('❌ Gagal mengirim pengingat');
            });
        }

        function sendBulkReminder() {
            alert('Fitur kirim pengingat massal akan segera hadir!');
        }


        // ================ CLOSE MODAL OUTSIDE ================
        window.addEventListener('click', function(e) {
            if (e.target.classList.contains('modal')) {
                e.target.classList.add('hidden');
            }
        });

        // ================ ENTER KEY FOR SCAN ================
        document.getElementById('scanKode')?.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                processScan();
            }
        });
    </script>
</body>
</html>