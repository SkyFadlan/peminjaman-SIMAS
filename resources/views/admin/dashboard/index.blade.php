<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - SarPras</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
        .chart-bar {
            transition: height 0.5s ease, background 0.3s ease;
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
                            <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
                            <p class="text-sm text-gray-500 mt-0.5">Selamat datang kembali, {{ Auth::user()->name ?? 'Admin' }}</p>
                        </div>

                        <!-- Right Side Actions -->
                        <div class="flex items-center space-x-3">

                            <!-- Profile Dropdown -->
                            <div class="flex items-center space-x-3 pl-3 border-l border-gray-200">
                                <div class="hidden sm:block text-right">
                                    <p class="text-sm font-semibold text-gray-900">{{ Auth::user()->name ?? 'Admin User' }}</p>
                                    <p class="text-xs text-gray-500">Admin</p>
                                </div>
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-cyan-400 flex items-center justify-center text-white font-semibold uppercase">
                                    {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Dashboard Content -->
            <main class="p-4 sm:p-6 lg:p-8">
                <!-- Welcome Banner -->
                <div class="bg-gradient-to-r from-blue-600 to-cyan-500 rounded-2xl p-6 mb-8 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-2xl font-bold mb-2">Halo, {{ Auth::user()->name ?? 'Admin' }}! 👋</h2>
                            <p class="text-blue-100">Berikut ringkasan aktivitas SarPras hari ini.</p>
                        </div>
                        <div class="flex space-x-4">
                            <div class="bg-white/20 backdrop-blur-sm rounded-lg px-4 py-2 text-center">
                                <p class="text-xs text-blue-100">Disetujui Hari Ini</p>
                                <p class="text-2xl font-bold">{{ $disetujuiHariIni }}</p>
                            </div>
                            <div class="bg-white/20 backdrop-blur-sm rounded-lg px-4 py-2 text-center">
                                <p class="text-xs text-blue-100">Dikembalikan</p>
                                <p class="text-2xl font-bold">{{ $dikembalikanHariIni }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Card 1: Pemesanan -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all hover-scale">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
        </div>
        <h3 class="text-gray-600 text-sm font-medium mb-1">Permintaan</h3>
        <p class="text-3xl font-bold text-gray-900">{{ $pemesanan }}</p>
        <p class="text-xs text-gray-500 mt-2">Menunggu persetujuan</p>
    </div>

    <!-- Card 2: Dipinjam -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all hover-scale">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
        <h3 class="text-gray-600 text-sm font-medium mb-1">Dipinjam</h3>
        <p class="text-3xl font-bold text-gray-900">{{ $dipinjam }}</p>
        <p class="text-xs text-gray-500 mt-2">Sedang dipinjam</p>
    </div>

    <!-- Card 3: Terlambat -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all hover-scale">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            @if($terlambatPersentase != 0)
                <span class="text-xs font-semibold {{ $terlambatPersentase > 0 ? 'text-red-600 bg-red-50' : 'text-green-600 bg-green-50' }} px-2.5 py-1 rounded-full">
                    {{ $terlambatPersentase > 0 ? '+' : '' }}{{ $terlambatPersentase }}%
                </span>
            @endif
        </div>
        <h3 class="text-gray-600 text-sm font-medium mb-1">Terlambat</h3>
        <p class="text-3xl font-bold text-gray-900">{{ $terlambat }}</p>
        <p class="text-xs text-gray-500 mt-2">Perlu tindak lanjut</p>
    </div>

    <!-- Card 4: Total Aset -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all hover-scale">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-cyan-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
            </div>
            @if($asetPersentase != 0)
                <span class="text-xs font-semibold {{ $asetPersentase > 0 ? 'text-green-600 bg-green-50' : 'text-red-600 bg-red-50' }} px-2.5 py-1 rounded-full">
                    {{ $asetPersentase > 0 ? '+' : '' }}{{ $asetPersentase }}%
                </span>
            @endif
        </div>
        <h3 class="text-gray-600 text-sm font-medium mb-1">Total Aset</h3>
        <p class="text-3xl font-bold text-gray-900">{{ $totalAset }}</p>
        <p class="text-xs text-gray-500 mt-2">Item terdaftar</p>
    </div>
</div>

                <!-- Quick Stats Row -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
    <div class="bg-gradient-to-r from-blue-500 to-cyan-400 rounded-xl p-4 text-white">
        <p class="text-xs text-blue-100">Total Siswa</p>
        <p class="text-2xl font-bold">{{ $totalSiswa }}</p>
        <div class="flex justify-between mt-2 text-xs">
            <span>Siswa yang sudah terdaftar</span>
        </div>
    </div>

    <div class="bg-white rounded-xl p-4 border border-gray-100">
        <p class="text-xs text-gray-500">Total Pemesanan</p>
        <p class="text-2xl font-bold text-gray-900">{{ $totalPemesanan }}</p>
        <p class="text-xs text-gray-400 mt-2">Menunggu approval</p>
    </div>

    <!-- CARD TOTAL DENDA - UKURAN KECIL -->
    <div class="bg-gradient-to-r from-orange-500 to-red-500 rounded-xl p-4 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-orange-100">Total Denda</p>
                <p class="text-2xl font-bold">Rp {{ number_format($totalDenda, 0, ',', '.') }}</p>
            </div>
            <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
        <p class="text-xs text-orange-100 mt-2">Dari pengembalian barang</p>
    </div>
</div>

                <!-- Charts & Tables Row -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                    <!-- Chart: Statistik Peminjaman -->
                    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h2 class="text-lg font-bold text-gray-900">Statistik Peminjaman</h2>
                                <p class="text-sm text-gray-500 mt-1">7 hari terakhir</p>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="w-3 h-3 bg-gradient-to-r from-blue-500 to-cyan-400 rounded-full"></span>
                                <span class="text-sm text-gray-600">Jumlah Transaksi</span>
                            </div>
                        </div>
                        
                        <!-- Dynamic Chart -->
                        <div class="space-y-4">
                            @foreach($statistikHari as $index => $hari)
                                @php
                                    $jumlah = $statistikJumlah[$index];
                                    $persentase = $maxJumlah > 0 ? round(($jumlah / $maxJumlah) * 100) : 0;
                                    $warna = $index % 2 == 0 ? 'from-blue-500 to-cyan-400' : 'from-blue-400 to-cyan-300';
                                @endphp
                                <div class="flex items-center space-x-4 group">
                                    <span class="text-sm font-medium text-gray-600 w-16">{{ $hari }}</span>
                                    <div class="flex-1 bg-gray-100 rounded-full h-8 relative overflow-hidden">
                                        <div class="chart-bar absolute inset-y-0 left-0 bg-gradient-to-r {{ $warna }} rounded-full transition-all duration-500 group-hover:brightness-110"
                                             style="width: {{ $persentase }}%">
                                        </div>
                                        <span class="absolute inset-0 flex items-center justify-end pr-3 text-sm font-semibold {{ $jumlah > 0 ? 'text-white' : 'text-gray-700' }}">
                                            {{ $jumlah }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Quick Actions & System Status -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h2 class="text-lg font-bold text-gray-900 mb-6">Quick Actions</h2>
                        <div class="space-y-3">
                            <a href="{{ route('admin.barang.create') }}" 
                               class="w-full p-4 bg-gradient-to-r from-blue-600 to-cyan-500 text-white rounded-lg font-semibold hover:shadow-lg transition-all flex items-center justify-between group">
                                <span>Tambah Aset Baru</span>
                                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                            </a>
                            <a href="{{ route('admin.pengguna.index') }}" 
                               class="w-full p-4 bg-blue-50 text-blue-700 rounded-lg font-semibold hover:bg-blue-100 transition-colors flex items-center justify-between group">
                                <span>Kelola Pengguna</span>
                                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </a>
                            <a href="{{ route('admin.riwayat.index') }}" 
                               class="w-full p-4 bg-cyan-50 text-cyan-700 rounded-lg font-semibold hover:bg-cyan-100 transition-colors flex items-center justify-between group">
                                <span>Laporan & Riwayat</span>
                                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </a>
                        </div>

                        <!-- System Status -->
                        <div class="mt-6 pt-6 border-t border-gray-100">
                            <h3 class="text-sm font-semibold text-gray-900 mb-3">System Status</h3>
                            <div class="space-y-2">
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-600">Server</span>
                                    <span class="flex items-center text-green-600 font-medium">
                                        <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                                        Online
                                    </span>
                                </div>
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-600">Last Login</span>
                                    <span class="text-gray-600 font-medium">{{ Auth::user()->last_login_at ? Auth::user()->last_login_at->diffForHumans() : 'Pertama kali' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tables Row -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                    <!-- Daftar Terlambat -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-6 border-b border-gray-100">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h2 class="text-lg font-bold text-gray-900">Daftar Terlambat</h2>
                                    <p class="text-sm text-gray-500 mt-1">Pengembalian melewati batas waktu</p>
                                </div>
                                <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm font-semibold">{{ $terlambat }}</span>
                            </div>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50 border-b border-gray-100">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Peminjam</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Item</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Terlambat</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @forelse($daftarTerlambat as $item)
                                        @php
                                            $inisial = strtoupper(substr($item->user->name, 0, 2));
                                            $kelas = $item->user->role == 'siswa' ? 'Siswa' : 'Petugas';
                                        @endphp
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center">
                                                    <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center text-red-700 font-semibold text-sm mr-3 uppercase">
                                                        {{ $inisial }}
                                                    </div>
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-900">{{ $item->user->name }}</p>
                                                        <p class="text-xs text-gray-500">{{ $kelas }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <p class="text-sm text-gray-900">{{ $item->barang->nama_barang }}</p>
                                                <p class="text-xs text-gray-500">{{ $item->barang->kategori->nama_kategori ?? '-' }}</p>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-xs font-medium">{{ $item->lama_terlambat }}</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-6 py-8 text-center">
                                                <div class="flex flex-col items-center">
                                                    <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    <p class="text-gray-600">Tidak ada keterlambatan</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @if($terlambat > 0)
                        <div class="p-4 bg-gray-50 border-t border-gray-100">
                            <a href="{{ route('admin.riwayat.index') }}?filter=terlambat" 
                               class="w-full text-sm font-semibold text-blue-600 hover:text-blue-700 flex items-center justify-center space-x-1">
                                <span>Lihat Semua Keterlambatan</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                        @endif
                    </div>

                    <!-- Aktivitas Terbaru -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-6 border-b border-gray-100">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h2 class="text-lg font-bold text-gray-900">Aktivitas Terbaru</h2>
                                    <p class="text-sm text-gray-500 mt-1">Log aktivitas sistem</p>
                                </div>
                                <span class="text-xs text-gray-500">{{ now()->format('d M Y H:i') }}</span>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                @forelse($aktivitasTerbaru as $aktivitas)
                                    <div class="flex items-start space-x-3">
                                        <div class="w-8 h-8 {{ $aktivitas->icon_bg }} rounded-full flex items-center justify-center flex-shrink-0">
                                            <svg class="w-4 h-4 {{ $aktivitas->icon_color }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $aktivitas->icon_path }}"></path>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm text-gray-900">
                                                <span class="font-semibold">{{ $aktivitas->user->name }}</span> 
                                                {{ $aktivitas->deskripsi }} 
                                                <span class="font-semibold">{{ $aktivitas->barang->nama_barang }}</span>
                                            </p>
                                            <p class="text-xs text-gray-500 mt-1">{{ $aktivitas->waktu }}</p>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-4">
                                        <p class="text-gray-500">Belum ada aktivitas</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                        <div class="p-4 bg-gray-50 border-t border-gray-100">
                            <a href="{{ route('admin.riwayat.index') }}" 
                               class="w-full text-sm font-semibold text-blue-600 hover:text-blue-700 flex items-center justify-center space-x-1">
                                <span>Lihat Semua Aktivitas</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Daftar Pemesanan -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-100">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div>
                                <h2 class="text-lg font-bold text-gray-900">Daftar Pemesanan</h2>
                                <p class="text-sm text-gray-500 mt-1">Menunggu persetujuan admin</p>
                            </div>
                            <div class="flex items-center space-x-2">
                                <input type="text" 
                                       id="searchPemesanan" 
                                       placeholder="Cari pemesanan..." 
                                       class="px-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 w-64">
                                <button onclick="filterPemesanan()" 
                                        class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700 transition-colors">
                                    Filter
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b border-gray-100">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Peminjam</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Item</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Durasi</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($daftarPemesanan as $pemesanan)
                                    @php
                                        $inisial = strtoupper(substr($pemesanan->user->name, 0, 2));
                                        $warna = ['bg-blue-100', 'bg-cyan-100', 'bg-indigo-100'][$loop->index % 3];
                                        $warnaText = ['text-blue-700', 'text-cyan-700', 'text-indigo-700'][$loop->index % 3];
                                        
                                        if ($pemesanan->tipe_pinjam == 'hari') {
                                            $durasi = Carbon\Carbon::parse($pemesanan->tanggal_pinjam)->diffInDays($pemesanan->tanggal_kembali) + 1 . ' hari';
                                            $tanggal = Carbon\Carbon::parse($pemesanan->tanggal_pinjam)->format('d M Y');
                                        } else {
                                            $durasi = Carbon\Carbon::parse($pemesanan->jam_pinjam)->diffInHours($pemesanan->jam_kembali) . ' jam';
                                            $tanggal = Carbon\Carbon::parse($pemesanan->tanggal_pinjam_jam)->format('d M Y');
                                        }
                                    @endphp
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">#{{ str_pad($pemesanan->id, 3, '0', STR_PAD_LEFT) }}</td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <div class="w-8 h-8 {{ $warna }} rounded-full flex items-center justify-center {{ $warnaText }} font-semibold text-sm mr-3 uppercase">
                                                    {{ $inisial }}
                                                </div>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900">{{ $pemesanan->user->name }}</p>
                                                    <p class="text-xs text-gray-500">{{ $pemesanan->user->role == 'siswa' ? 'Siswa' : 'Petugas' }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <p class="text-sm text-gray-900">{{ $pemesanan->barang->nama_barang }}</p>
                                            <p class="text-xs text-gray-500">{{ $pemesanan->barang->kategori->nama_kategori ?? '-' }}</p>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $tanggal }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $durasi }}</td>
                                        <td class="px-6 py-4">
                                            <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-medium">Pending</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center space-x-2">
                                                <button onclick="detailPemesanan({{ $pemesanan->id }})" 
                                                        class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" 
                                                        title="Detail">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center">
                                                <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                                <h3 class="text-base font-semibold text-gray-900 mb-1">Tidak Ada Pemesanan</h3>
                                                <p class="text-sm text-gray-600">Semua pemesanan telah diproses</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    @if($daftarPemesanan->hasPages())
                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
                            <p class="text-sm text-gray-600">
                                Menampilkan {{ $daftarPemesanan->firstItem() ?? 0 }}-{{ $daftarPemesanan->lastItem() ?? 0 }} 
                                dari {{ $daftarPemesanan->total() }} pemesanan
                            </p>
                            <div class="flex items-center space-x-2">
                                {{ $daftarPemesanan->links() }}
                            </div>
                        </div>
                    @endif
                </div>
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

        // Filter pemesanan - PERBAIKAN
        function filterPemesanan() {
            const search = document.getElementById('searchPemesanan').value;
            window.location.href = '{{ route("admin.barang.index") }}?search=' + encodeURIComponent(search);
        }

        // Approve pemesanan
        function approvePemesanan(id) {
            if (confirm('Setujui pemesanan ini?')) {
                fetch(`/admin/peminjaman/${id}/approve`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('✅ Pemesanan disetujui');
                        window.location.reload();
                    } else {
                        alert('❌ ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('❌ Gagal menyetujui pemesanan');
                });
            }
        }

        // Reject pemesanan
        function rejectPemesanan(id) {
            const alasan = prompt('Masukkan alasan penolakan:');
            if (alasan && alasan.trim() !== '') {
                fetch(`/admin/peminjaman/${id}/reject`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ alasan_penolakan: alasan })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('✅ Pemesanan ditolak');
                        window.location.reload();
                    } else {
                        alert('❌ ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('❌ Gagal menolak pemesanan');
                });
            }
        }

        // Detail pemesanan
        function detailPemesanan(id) {
            window.location.href = `/admin/peminjaman/${id}`;
        }

        // Backup data
        function backupData() {
            if (confirm('Lakukan backup database?')) {
                fetch('/admin/backup', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('✅ Backup berhasil! File: ' + data.filename);
                    } else {
                        alert('❌ ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('❌ Gagal melakukan backup');
                });
            }
        }
    </script>
</body>
</html>