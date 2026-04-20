<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Petugas - SIMAS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @php
        use Carbon\Carbon;
    @endphp
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .hover-scale {
            transition: transform 0.2s ease;
        }
        .hover-scale:hover {
            transform: scale(1.02);
        }
    </style>
</head>
<body class="bg-slate-50">
    
    <div class="flex min-h-screen">
        <!-- Sidebar Component -->
        @include('components.sidebar_petugas')

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
                            <h1 class="text-2xl font-bold text-gray-900">Dashboard Petugas</h1>
                            <p class="text-sm text-gray-500 mt-0.5">Selamat datang kembali, {{ Auth::user()->name ?? 'Petugas' }}</p>
                        </div>

                        <!-- Right Side Actions -->
                        <div class="flex items-center space-x-3">

                            <!-- Profile Dropdown -->
                            <div class="flex items-center space-x-3 pl-3 border-l border-gray-200">
                                <div class="hidden sm:block text-right">
                                    <p class="text-sm font-semibold text-gray-900">{{ Auth::user()->name ?? 'Petugas' }}</p>
                                    <p class="text-xs text-gray-500">{{ ucfirst(Auth::user()->role ?? 'Staff') }}</p>
                                </div>
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-600 to-violet-500 flex items-center justify-center text-white font-semibold uppercase">
                                    {{ substr(Auth::user()->name ?? 'P', 0, 1) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Dashboard Content -->
            <main class="p-4 sm:p-6 lg:p-8">
                <!-- Quick Actions Bar -->
                <div class="mb-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <a href="{{ route('petugas.permintaan.index') }}" class="p-4 bg-white border-2 border-indigo-200 text-indigo-700 rounded-xl font-semibold hover:bg-indigo-50 transition-all flex items-center justify-between group hover-scale">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                </svg>
                            </div>
                            <span>Proses Permintaan</span>
                            @if($pendingCount > 0)
                                <span class="px-2 py-1 bg-red-500 text-white text-xs rounded-full">{{ $pendingCount }}</span>
                            @endif
                        </div>
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                    <a href="{{ route('petugas.pengembalian.index') }}" class="p-4 bg-white border-2 border-indigo-200 text-indigo-700 rounded-xl font-semibold hover:bg-indigo-50 transition-all flex items-center justify-between group hover-scale">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <span>Terima Kembali</span>
                            @if($jatuhTempoHariIni > 0)
                                <span class="px-2 py-1 bg-orange-500 text-white text-xs rounded-full">{{ $jatuhTempoHariIni }}</span>
                            @endif
                        </div>
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                    <a href="{{ route('petugas.laporan.index') }}" class="p-4 bg-white border-2 border-indigo-200 text-indigo-700 rounded-xl font-semibold hover:bg-indigo-50 transition-all flex items-center justify-between group hover-scale">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            <span>Buat Laporan</span>
                        </div>
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- Card 1: Permintaan Pending -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all hover-scale">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            @if($pendingCount > 0)
                                <span class="text-xs font-semibold text-orange-600 bg-orange-50 px-2.5 py-1 rounded-full">Perlu Aksi</span>
                            @endif
                        </div>
                        <h3 class="text-gray-600 text-sm font-medium mb-1">Permintaan Pending</h3>
                        <p class="text-3xl font-bold text-gray-900">{{ $pendingCount }}</p>
                        <p class="text-xs text-gray-500 mt-2">Menunggu persetujuan</p>
                    </div>

                    <!-- Card 2: Sedang Dipinjam -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all hover-scale">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-violet-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                </svg>
                            </div>
                            @if($persentaseKenaikan > 0)
                                <span class="text-xs font-semibold text-green-600 bg-green-50 px-2.5 py-1 rounded-full">+{{ $persentaseKenaikan }}%</span>
                            @endif
                        </div>
                        <h3 class="text-gray-600 text-sm font-medium mb-1">Sedang Dipinjam</h3>
                        <p class="text-3xl font-bold text-gray-900">{{ $sedangDipinjam }}</p>
                        <p class="text-xs text-gray-500 mt-2">Item aktif</p>
                    </div>

                    <!-- Card 3: Harus Kembali Hari Ini -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all hover-scale">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            @if($jatuhTempoHariIni > 0)
                                <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-2.5 py-1 rounded-full">Hari Ini</span>
                            @endif
                        </div>
                        <h3 class="text-gray-600 text-sm font-medium mb-1">Jatuh Tempo Hari Ini</h3>
                        <p class="text-3xl font-bold text-gray-900">{{ $jatuhTempoHariIni }}</p>
                        <p class="text-xs text-gray-500 mt-2">Perlu follow up</p>
                    </div>

                    <!-- Card 4: Terlambat -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all hover-scale">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                            </div>
                            @if($terlambat > 0)
                                <span class="text-xs font-semibold text-red-600 bg-red-50 px-2.5 py-1 rounded-full">Urgent</span>
                            @endif
                        </div>
                        <h3 class="text-gray-600 text-sm font-medium mb-1">Terlambat</h3>
                        <p class="text-3xl font-bold text-gray-900">{{ $terlambat }}</p>
                        <p class="text-xs text-gray-500 mt-2">Perlu tindak lanjut</p>
                    </div>
                </div>

                <!-- Main Content Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                    <!-- Permintaan Terbaru -->
                    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-6 border-b border-gray-100">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h2 class="text-lg font-bold text-gray-900">Permintaan Terbaru</h2>
                                    <p class="text-sm text-gray-500 mt-1">Perlu diproses segera</p>
                                </div>
                                <a href="{{ route('petugas.permintaan.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-700">
                                    Lihat Semua →
                                </a>
                            </div>
                        </div>
                        <div class="divide-y divide-gray-100">
                            @forelse($permintaanTerbaru as $permintaan)
                                @php
                                    $inisial = strtoupper(substr($permintaan->user->name, 0, 2));
                                    $warna = ['from-indigo-500 to-violet-400', 'from-pink-500 to-purple-400', 'from-green-500 to-teal-400', 'from-orange-500 to-amber-400', 'from-blue-500 to-cyan-400'][$loop->index % 5];
                                    $role = $permintaan->user->role == 'siswa' ? 'Siswa' : 'Petugas';
                                    
                                    // ✅ PERBAIKAN: Hapus Carbon\Carbon, cukup Carbon
                                    $durasi = $permintaan->tipe_pinjam == 'hari' 
                                        ? Carbon::parse($permintaan->tanggal_pinjam)->diffInDays($permintaan->tanggal_kembali) + 1 . ' hari'
                                        : Carbon::parse($permintaan->jam_pinjam)->diffInHours($permintaan->jam_kembali) . ' jam';
                                    
                                    // ✅ PERBAIKAN: Hapus Carbon\Carbon
                                    $tanggal = $permintaan->tipe_pinjam == 'hari'
                                        ? Carbon::parse($permintaan->tanggal_pinjam)->format('d M') . ' - ' . Carbon::parse($permintaan->tanggal_kembali)->format('d M Y')
                                        : Carbon::parse($permintaan->tanggal_pinjam_jam)->format('d M Y');
                                @endphp
                                <div class="p-6 hover:bg-gray-50 transition-colors">
                                    <div class="flex items-start justify-between">
                                        <div class="flex items-start space-x-4 flex-1">
                                            <div class="w-12 h-12 bg-gradient-to-br {{ $warna }} rounded-full flex items-center justify-center text-white font-bold flex-shrink-0 uppercase">
                                                {{ $inisial }}
                                            </div>
                                            <div class="flex-1">
                                                <div class="flex items-center space-x-2 mb-1">
                                                    <h3 class="font-semibold text-gray-900">{{ $permintaan->user->name }}</h3>
                                                    <span class="px-2 py-0.5 bg-blue-100 text-blue-700 rounded text-xs font-medium">{{ $role }}</span>
                                                </div>
                                                <p class="text-sm text-gray-600 mb-2">{{ $permintaan->created_at->diffForHumans() }}</p>
                                                <div class="flex items-center space-x-2">
                                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                                    </svg>
                                                    <span class="text-sm font-medium text-gray-900">{{ $permintaan->barang->nama_barang }}</span>
                                                </div>
                                                <p class="text-xs text-gray-500 mt-1">
                                                    Durasi: {{ $durasi }} • Tgl: {{ $tanggal }}
                                                    @if($permintaan->jumlah > 1)
                                                        • Jumlah: {{ $permintaan->jumlah }} unit
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2 ml-4">
                                            <a href="{{ route('petugas.permintaan.index') }}?search={{ $permintaan->id }}" 
                                               class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors" 
                                               title="Setujui">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            </a>
                                            <button onclick="openRejectModal({{ $permintaan->id }})" 
                                                    class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" 
                                                    title="Tolak">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="p-12 text-center">
                                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-1">Tidak Ada Permintaan</h3>
                                    <p class="text-gray-600">Belum ada permintaan peminjaman yang masuk</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Pengembalian Hari Ini & Statistik -->
                    <div class="space-y-6">
                        <!-- Pengembalian Hari Ini -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                            <div class="p-6 border-b border-gray-100">
                                <h2 class="text-lg font-bold text-gray-900">Pengembalian Hari Ini</h2>
                                <p class="text-sm text-gray-500 mt-1">Jatuh tempo hari ini</p>
                            </div>
                            <div class="p-6">
                                <div class="space-y-4">
                                    @forelse($pengembalianHariIni as $pengembalian)
                                        @php
                                            $jamKembali = $pengembalian->tipe_pinjam == 'hari' 
                                                ? '23:59' 
                                                : $pengembalian->jam_kembali;
                                        @endphp
                                        <div class="flex items-start space-x-3">
                                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </div>
                                            <div class="flex-1">
                                                <p class="text-sm font-semibold text-gray-900">{{ $pengembalian->user->name }}</p>
                                                <p class="text-xs text-gray-500">{{ $pengembalian->barang->nama_barang }} • {{ $jamKembali }}</p>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-center py-4">
                                            <p class="text-sm text-gray-500">Tidak ada pengembalian hari ini</p>
                                        </div>
                                    @endforelse
                                    
                                    @if($terlambat > 0)
                                        <div class="flex items-start space-x-3 pt-2 border-t border-gray-100">
                                            <div class="w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center flex-shrink-0">
                                                <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                                </svg>
                                            </div>
                                            <div class="flex-1">
                                                <p class="text-sm font-semibold text-gray-900">Terlambat: {{ $terlambat }} item</p>
                                                <p class="text-xs text-orange-600 font-medium">Perlu follow up segera</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Quick Stats -->
                        <div class="bg-gradient-to-br from-indigo-600 to-violet-500 rounded-xl shadow-lg p-6 text-white">
                            <h3 class="font-bold mb-4">Statistik Hari Ini</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-indigo-100">Disetujui</span>
                                    <span class="text-2xl font-bold">{{ $statistikHariIni['disetujui'] }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-indigo-100">Ditolak</span>
                                    <span class="text-2xl font-bold">{{ $statistikHariIni['ditolak'] }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-indigo-100">Dikembalikan</span>
                                    <span class="text-2xl font-bold">{{ $statistikHariIni['dikembalikan'] }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Aktivitas Saya -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                            <div class="p-6 border-b border-gray-100">
                                <h2 class="text-lg font-bold text-gray-900">Aktivitas Saya</h2>
                                <p class="text-sm text-gray-500 mt-1">Log aktivitas terbaru</p>
                            </div>
                            <div class="p-6">
                                <div class="space-y-4">
                                    @forelse($aktivitasSaya as $aktivitas)
                                        @php
                                            $icon = '';
                                            $warna = '';
                                            $pesan = '';
                                            
                                            switch($aktivitas->status) {
                                                case 'disetujui':
                                                    $icon = 'M5 13l4 4L19 7';
                                                    $warna = 'text-green-600 bg-green-100';
                                                    $pesan = 'Menyetujui peminjaman ' . $aktivitas->barang->nama_barang;
                                                    break;
                                                case 'ditolak':
                                                    $icon = 'M6 18L18 6M6 6l12 12';
                                                    $warna = 'text-red-600 bg-red-100';
                                                    $pesan = 'Menolak peminjaman ' . $aktivitas->barang->nama_barang;
                                                    break;
                                                case 'dikembalikan':
                                                    $icon = 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z';
                                                    $warna = 'text-blue-600 bg-blue-100';
                                                    $pesan = 'Menerima pengembalian ' . $aktivitas->barang->nama_barang;
                                                    break;
                                            }
                                        @endphp
                                        <div class="flex items-start space-x-3">
                                            <div class="w-8 h-8 {{ $warna }} rounded-full flex items-center justify-center flex-shrink-0">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"></path>
                                                </svg>
                                            </div>
                                            <div class="flex-1">
                                                <p class="text-sm text-gray-900">{{ $pesan }}</p>
                                                <p class="text-xs text-gray-500">{{ $aktivitas->updated_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-center py-4">
                                            <p class="text-sm text-gray-500">Belum ada aktivitas hari ini</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Alert Terlambat -->
                @if($itemTerlambat->count() > 0)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-lg font-bold text-gray-900">Item Terlambat - Perlu Tindak Lanjut</h2>
                                <p class="text-sm text-gray-500 mt-1">Prioritas tinggi</p>
                            </div>
                            <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm font-semibold">{{ $terlambat }} Item</span>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b border-gray-100">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Peminjam</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Item</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tgl Pinjam</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Terlambat</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kontak</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($itemTerlambat as $item)
                                    @php
                                        $inisial = strtoupper(substr($item->user->name, 0, 2));
                                        
                                        // ✅ PERBAIKAN: Hapus Carbon\Carbon
                                        if ($item->tipe_pinjam == 'hari') {
                                            $tglKembali = Carbon::parse($item->tanggal_kembali);
                                            $hariTerlambat = $tglKembali->diffInDays(Carbon::today());
                                            $keterlambatan = $hariTerlambat . ' hari';
                                        } else {
                                            $jamKembali = Carbon::parse($item->jam_kembali);
                                            $jamTerlambat = $jamKembali->diffInHours(Carbon::now());
                                            $keterlambatan = $jamTerlambat . ' jam';
                                        }
                                    @endphp
                                    <tr class="hover:bg-red-50 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center text-red-700 font-semibold mr-3 uppercase">
                                                    {{ $inisial }}
                                                </div>
                                                <div>
                                                    <p class="text-sm font-semibold text-gray-900">{{ $item->user->name }}</p>
                                                    <p class="text-xs text-gray-500">{{ $item->user->role == 'siswa' ? 'Siswa' : 'Petugas' }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <p class="text-sm font-medium text-gray-900">{{ $item->barang->nama_barang }}</p>
                                            <p class="text-xs text-gray-500">{{ $item->barang->kategori->nama_kategori ?? 'Lainnya' }}</p>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600">
                                            {{-- ✅ PERBAIKAN: Hapus Carbon\Carbon --}}
                                            {{ Carbon::parse($item->tanggal_pinjam)->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-bold">{{ $keterlambatan }}</span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $item->user->no_telp ?? '-' }}</td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center space-x-2">
                                                <a href="{{ route('petugas.pengembalian.index') }}?search={{ $item->kode_peminjaman }}" 
                                                   class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors" 
                                                   title="Proses Pengembalian">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                </a>
                                                <button onclick="sendReminder({{ $item->id }})" 
                                                        class="p-2 text-orange-600 hover:bg-orange-50 rounded-lg transition-colors" 
                                                        title="Kirim Pengingat">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
            </main>
        </div>
    </div>

    <script>
        // CSRF Token
        const csrfToken = '{{ csrf_token() }}';

        // Mobile menu toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const sidebar = document.querySelector('aside');
        
        if (mobileMenuButton && sidebar) {
            mobileMenuButton.addEventListener('click', () => {
                sidebar.classList.toggle('-translate-x-full');
            });
        }

        // ================ REJECT MODAL ================
        function openRejectModal(id) {
            // Redirect ke halaman permintaan dengan parameter reject
            window.location.href = '{{ route("petugas.permintaan.index") }}?reject=' + id;
        }

        // ================ SEND REMINDER ================
        function sendReminder(id) {
            if (!confirm('Kirim pengingat ke peminjam?')) return;
            
            fetch(`/petugas/pengembalian/${id}/reminder`, {
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

        // Auto refresh data setiap 30 detik
        setTimeout(() => {
            window.location.reload();
        }, 30000);
    </script>
</body>
</html>