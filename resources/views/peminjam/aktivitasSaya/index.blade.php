<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aktivitas Saya - SarPras Siswa</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .tab-button.active {
            background: linear-gradient(to right, #c026d3, #ec4899);
            color: white;
            box-shadow: 0 4px 14px 0 rgba(192, 38, 211, 0.39);
        }
        .status-menunggu { background: #fef3c7; color: #92400e; }
        .status-disetujui { background: #dbeafe; color: #1e40af; }
        .status-dipinjam { background: #dcfce7; color: #166534; }
        .status-dikembalikan { background: #f3f4f6; color: #374151; }
        .status-ditolak { background: #fee2e2; color: #991b1b; }
        .status-terlambat { background: #fee2e2; color: #991b1b; }
        
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
    </style>
</head>
<body class="bg-gradient-to-br from-fuchsia-50 via-pink-50 to-purple-50 min-h-screen">
    
    <!-- Navbar Component -->
    @include('components.navbar_peminjam')

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Aktivitas Peminjaman Saya</h1>
            <p class="text-gray-600">Kelola dan pantau semua aktivitas peminjaman Anda</p>
        </div>

        <!-- Stats Overview -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Active Loans -->
            <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-fuchsia-600 to-pink-500 rounded-xl flex items-center justify-center shadow-lg shadow-fuchsia-200">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <h3 class="text-gray-600 text-sm font-medium mb-1">Sedang Dipinjam</h3>
                <p class="text-3xl font-bold text-gray-900">{{ $sedangDipinjam }}</p>
                <p class="text-xs text-fuchsia-600 mt-2 font-medium">Item aktif</p>
            </div>

            <!-- Due Today -->
            <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-amber-400 rounded-xl flex items-center justify-center shadow-lg shadow-orange-200">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
                <h3 class="text-gray-600 text-sm font-medium mb-1">Jatuh Tempo Hari Ini</h3>
                <p class="text-3xl font-bold text-gray-900">{{ $jatuhTempoHariIni }}</p>
                <p class="text-xs text-orange-600 mt-2 font-medium">Perlu dikembalikan</p>
            </div>

            <!-- Overdue -->
            <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-rose-400 rounded-xl flex items-center justify-center shadow-lg shadow-red-200">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <h3 class="text-gray-600 text-sm font-medium mb-1">Terlambat</h3>
                <p class="text-3xl font-bold text-gray-900">{{ $terlambat }}</p>
                <p class="text-xs text-gray-500 mt-2 font-medium">{{ $terlambat > 0 ? 'Kena denda' : 'Tidak ada keterlambatan' }}</p>
            </div>

            <!-- Total Borrowed -->
            <div class="bg-gradient-to-br from-fuchsia-600 to-pink-500 rounded-2xl p-6 shadow-lg shadow-fuchsia-200 text-white">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                </div>
                <h3 class="text-fuchsia-100 text-sm font-medium mb-1">Total Peminjaman</h3>
                <p class="text-3xl font-bold">{{ $totalPeminjaman }}</p>
                <p class="text-xs text-fuchsia-200 mt-2">Sepanjang waktu</p>
            </div>
        </div>

        <!-- Tabs -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
            <div class="border-b border-gray-200">
                <div class="px-6 py-4">
                    <div class="flex flex-wrap gap-3">
                        <button onclick="switchTab('active')" id="tab-active" class="tab-button active px-6 py-3 rounded-xl font-semibold text-sm transition-all">
                            Sedang Dipinjam ({{ $sedangDipinjam }})
                        </button>
                        <button onclick="switchTab('duetoday')" id="tab-duetoday" class="tab-button px-6 py-3 bg-gray-100 text-gray-700 rounded-xl font-semibold text-sm hover:bg-gray-200 transition-all">
                            Jatuh Tempo Hari Ini ({{ $jatuhTempoHariIni }})
                        </button>
                        <button onclick="switchTab('overdue')" id="tab-overdue" class="tab-button px-6 py-3 bg-gray-100 text-gray-700 rounded-xl font-semibold text-sm hover:bg-gray-200 transition-all">
                            Terlambat ({{ $terlambat }})
                        </button>
                        <button onclick="switchTab('history')" id="tab-history" class="tab-button px-6 py-3 bg-gray-100 text-gray-700 rounded-xl font-semibold text-sm hover:bg-gray-200 transition-all">
                            Riwayat
                        </button>
                    </div>
                </div>
            </div>

            <!-- Tab Content: Active Loans -->
            <div id="content-active" class="tab-content p-6">
                @if($peminjamanAktif->count() > 0)
                    <div class="space-y-4">
                        @foreach($peminjamanAktif as $pinjam)
                            @php
                                $statusClass = '';
                                $statusLabel = '';
                                
                                switch($pinjam->status) {
                                    case 'menunggu':
                                        $statusClass = 'bg-yellow-100 text-yellow-800';
                                        $statusLabel = 'Menunggu Persetujuan';
                                        break;
                                    case 'disetujui':
                                        $statusClass = 'bg-blue-100 text-blue-800';
                                        $statusLabel = 'Disetujui';
                                        break;
                                    case 'dipinjam':
                                        $statusClass = 'bg-green-100 text-green-800';
                                        $statusLabel = 'Dipinjam';
                                        break;
                                }
                                
                                                                    // 🔥 PERBAIKAN: Hitung sisa waktu dengan TODAY()
                                    $hariIni = \Carbon\Carbon::today();
                                    $tanggalKembali = \Carbon\Carbon::parse($pinjam->tanggal_kembali);

                                    if ($hariIni->lt($tanggalKembali)) {
                                        $selisih = $hariIni->diffInDays($tanggalKembali);
                                        $sisaWaktu = $selisih . ' hari lagi';
                                        $sisaWarna = 'text-emerald-600';
                                    } elseif ($hariIni->eq($tanggalKembali)) {
                                        $sisaWaktu = 'Hari ini (jatuh tempo)';
                                        $sisaWarna = 'text-orange-600';
                                    } else {
                                        $selisih = $tanggalKembali->diffInDays($hariIni);
                                        $sisaWaktu = $selisih . ' hari terlambat'; // 🔥 INI YAKIN!
                                        $sisaWarna = 'text-red-600';
                                    }
                                
                                $imagePath = $pinjam->barang->gambar 
                                    ? Storage::url($pinjam->barang->gambar) 
                                    : 'https://images.unsplash.com/photo-1593642632823-8f785ba67e45?w=150';
                                
                                $bgColor = $pinjam->status == 'menunggu' ? 'bg-yellow-50 border-yellow-200' : 'bg-white border-gray-200';
                            @endphp
                            
                            <div class="{{ $bgColor }} border-2 rounded-2xl p-6 hover:shadow-md transition-all">
                                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                                    <div class="flex items-start space-x-4 flex-1">
                                        <img src="{{ $imagePath }}" alt="{{ $pinjam->barang->nama_barang }}" class="w-20 h-20 object-cover rounded-xl shadow-md flex-shrink-0">
                                        <div class="flex-1">
                                            <div class="flex items-center space-x-2 mb-2 flex-wrap gap-1">
                                                <span class="px-3 py-1 {{ $statusClass }} rounded-full text-xs font-bold">{{ $statusLabel }}</span>
                                                <span class="px-3 py-1 bg-fuchsia-100 text-fuchsia-700 rounded-full text-xs font-semibold">{{ $pinjam->barang->kategori->nama_kategori ?? 'Lainnya' }}</span>
                                                @if($pinjam->kode_peminjaman)
                                                    <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-semibold">
                                                        Kode: {{ $pinjam->kode_peminjaman }}
                                                    </span>
                                                @endif
                                            </div>
                                            <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $pinjam->barang->nama_barang }}</h3>
                                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-sm">
                                                <div>
                                                    <p class="text-gray-500 text-xs">Tanggal Pinjam</p>
                                                    <p class="font-semibold text-gray-900">
                                                        @if($pinjam->tipe_pinjam == 'hari')
                                                            {{ \Carbon\Carbon::parse($pinjam->tanggal_pinjam)->format('d M Y') }}
                                                        @else
                                                            {{ \Carbon\Carbon::parse($pinjam->tanggal_pinjam_jam)->format('d M Y') }}
                                                        @endif
                                                    </p>
                                                </div>
                                                <div>
                                                    <p class="text-gray-500 text-xs">Tanggal Kembali</p>
                                                    <p class="font-semibold text-gray-900">
                                                        @if($pinjam->tipe_pinjam == 'hari')
                                                            {{ \Carbon\Carbon::parse($pinjam->tanggal_kembali)->format('d M Y') }}
                                                        @else
                                                            {{ \Carbon\Carbon::parse($pinjam->tanggal_pinjam_jam)->format('d M Y') }} {{ $pinjam->jam_kembali }}
                                                        @endif
                                                    </p>
                                                </div>
                                                <div>
                                                    <p class="text-gray-500 text-xs">Durasi</p>
                                                    <p class="font-semibold text-gray-900">
                                                        @if($pinjam->tipe_pinjam == 'hari')
                                                            {{ \Carbon\Carbon::parse($pinjam->tanggal_pinjam)->diffInDays($pinjam->tanggal_kembali) + 1 }} hari
                                                        @else
                                                            {{ \Carbon\Carbon::parse($pinjam->jam_pinjam)->diffInHours($pinjam->jam_kembali) }} jam
                                                        @endif
                                                    </p>
                                                </div>
                                                <div>
                                                    <p class="text-gray-500 text-xs">Sisa Waktu</p>
                                                    <p class="font-semibold {{ $sisaWarna }}">{{ $sisaWaktu ?: '-' }}</p>
                                                </div>
                                            </div>
                                            @if($pinjam->alasan)
                                                <div class="mt-2 text-xs text-gray-500">
                                                    <span class="font-medium">Alasan:</span> {{ $pinjam->alasan }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex flex-col space-y-2 lg:w-48">
                                        @if($pinjam->status == 'disetujui')
                                            <button onclick="showKodePeminjaman('{{ $pinjam->kode_peminjaman }}')" class="px-4 py-2.5 bg-gradient-to-r from-fuchsia-600 to-pink-500 text-white rounded-xl font-semibold hover:shadow-lg hover:shadow-fuchsia-300 transition-all text-sm">
                                                Tampilkan Kode
                                            </button>
                                        @endif
                                        @if($pinjam->status == 'dipinjam')
                                            <button onclick="openReturnModal({{ $pinjam->id }})" class="px-4 py-2.5 bg-gradient-to-r from-emerald-600 to-green-500 text-white rounded-xl font-semibold hover:shadow-lg hover:shadow-emerald-300 transition-all text-sm">
                                                Kembalikan
                                            </button>
                                        @endif
                                        <button onclick="showDetail({{ $pinjam->id }})" class="px-4 py-2.5 bg-white border-2 border-gray-200 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition-all text-sm flex items-center justify-center space-x-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            <span>Detail</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="w-24 h-24 bg-gradient-to-br from-fuchsia-600 to-pink-500 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg shadow-fuchsia-200">
                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Peminjaman Aktif</h3>
                        <p class="text-gray-600 mb-4">Anda belum memiliki peminjaman yang sedang berlangsung.</p>
                        <a href="{{ route('peminjam.beranda') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-fuchsia-600 to-pink-500 text-white rounded-xl font-semibold hover:shadow-lg hover:shadow-fuchsia-300 transition-all">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Pinjam Barang Sekarang
                        </a>
                    </div>
                @endif
            </div>

            <!-- Tab Content: Due Today -->
            <div id="content-duetoday" class="tab-content hidden p-6">
                @if($peminjamanJatuhTempo->count() > 0)
                    <div class="bg-orange-50 border-2 border-orange-200 rounded-xl p-4 mb-6">
                        <div class="flex items-start space-x-3">
                            <svg class="w-6 h-6 text-orange-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <h3 class="font-bold text-orange-900 mb-1">Item Jatuh Tempo Hari Ini</h3>
                                <p class="text-sm text-orange-700">Segera kembalikan item berikut untuk menghindari denda keterlambatan.</p>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        @foreach($peminjamanJatuhTempo as $pinjam)
                            @php
                                $imagePath = $pinjam->barang->gambar 
                                    ? Storage::url($pinjam->barang->gambar) 
                                    : 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=150';
                            @endphp
                            
                            <div class="bg-gradient-to-r from-orange-50 to-amber-50 border-2 border-orange-300 rounded-2xl p-6 hover:shadow-md transition-all">
                                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                                    <div class="flex items-start space-x-4 flex-1">
                                        <img src="{{ $imagePath }}" alt="{{ $pinjam->barang->nama_barang }}" class="w-20 h-20 object-cover rounded-xl shadow-md flex-shrink-0">
                                        <div class="flex-1">
                                            <div class="flex items-center space-x-2 mb-2 flex-wrap gap-1">
                                                <span class="px-3 py-1 bg-orange-500 text-white rounded-full text-xs font-bold">Jatuh Tempo Hari Ini</span>
                                                <span class="px-3 py-1 bg-fuchsia-100 text-fuchsia-700 rounded-full text-xs font-semibold">{{ $pinjam->barang->kategori->nama_kategori ?? 'Lainnya' }}</span>
                                            </div>
                                            <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $pinjam->barang->nama_barang }}</h3>
                                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-sm">
                                                <div>
                                                    <p class="text-gray-500 text-xs">Tanggal Pinjam</p>
                                                    <p class="font-semibold text-gray-900">
                                                        @if($pinjam->tipe_pinjam == 'hari')
                                                            {{ \Carbon\Carbon::parse($pinjam->tanggal_pinjam)->format('d M Y') }}
                                                        @else
                                                            {{ \Carbon\Carbon::parse($pinjam->tanggal_pinjam_jam)->format('d M Y') }} {{ $pinjam->jam_pinjam }}
                                                        @endif
                                                    </p>
                                                </div>
                                                <div>
                                                    <p class="text-gray-500 text-xs">Tanggal Kembali</p>
                                                    <p class="font-semibold text-orange-900">
                                                        @if($pinjam->tipe_pinjam == 'hari')
                                                            {{ \Carbon\Carbon::parse($pinjam->tanggal_kembali)->format('d M Y') }}
                                                        @else
                                                            {{ \Carbon\Carbon::parse($pinjam->tanggal_pinjam_jam)->format('d M Y') }} {{ $pinjam->jam_kembali }}
                                                        @endif
                                                    </p>
                                                </div>
                                                <div>
                                                    <p class="text-gray-500 text-xs">Durasi</p>
                                                    <p class="font-semibold text-gray-900">
                                                        @if($pinjam->tipe_pinjam == 'hari')
                                                            {{ \Carbon\Carbon::parse($pinjam->tanggal_pinjam)->diffInDays($pinjam->tanggal_kembali) + 1 }} hari
                                                        @else
                                                            {{ \Carbon\Carbon::parse($pinjam->jam_pinjam)->diffInHours($pinjam->jam_kembali) }} jam
                                                        @endif
                                                    </p>
                                                </div>
                                                <div>
                                                    <p class="text-gray-500 text-xs">Status</p>
                                                    <p class="font-semibold text-orange-600">Jatuh Tempo</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex flex-col space-y-2 lg:w-48">
                                        <button onclick="openReturnModal({{ $pinjam->id }})" class="px-4 py-2.5 bg-gradient-to-r from-orange-600 to-amber-500 text-white rounded-xl font-semibold hover:shadow-lg hover:shadow-orange-300 transition-all text-sm">
                                            Kembalikan Sekarang
                                        </button>
                                        <button onclick="showDetail({{ $pinjam->id }})" class="px-4 py-2.5 bg-white border-2 border-gray-200 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition-all text-sm">
                                            Lihat Detail
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="w-24 h-24 bg-gradient-to-br from-orange-500 to-amber-400 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg shadow-orange-200">
                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Tidak Ada Jatuh Tempo Hari Ini</h3>
                        <p class="text-gray-600">Semua peminjaman Anda masih dalam batas waktu.</p>
                    </div>
                @endif
            </div>

            <!-- Tab Content: Overdue -->
            <div id="content-overdue" class="tab-content hidden p-6">
                @if($peminjamanTerlambat->count() > 0)
                    <div class="space-y-4">
                        @foreach($peminjamanTerlambat as $pinjam)
                            @php
                                $imagePath = $pinjam->barang->gambar 
                                    ? Storage::url($pinjam->barang->gambar) 
                                    : 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=150';
                                
                                if ($pinjam->tipe_pinjam == 'hari') {
                                    // 🔥 PERBAIKAN: Gunakan today() untuk hitung hari terlambat
                                    $tanggalKembali = \Carbon\Carbon::parse($pinjam->tanggal_kembali)->startOfDay();
                                    $hariIni = \Carbon\Carbon::today();
                                    $hariTerlambat = $tanggalKembali->diffInDays($hariIni);
                                    $denda = $hariTerlambat * 5000;
                                    $keterlambatan = $hariTerlambat . ' hari';
                                } else {
                                // Parse tanggal dari tanggal_pinjam_jam
                                $tanggalPinjam = \Carbon\Carbon::parse($pinjam->tanggal_pinjam_jam);
                                
                                // Set jam kembali ke tanggal yang sama
                                $jamKembali = $tanggalPinjam->copy()->setTimeFromTimeString($pinjam->jam_kembali);
                                
                                // Hitung keterlambatan
                                $jamTerlambat = $jamKembali->diffInHours(now());
                                $denda = $jamTerlambat * 2000;
                                $keterlambatan = $jamTerlambat . ' jam';
                            }
                            @endphp
                            
                            <div class="bg-gradient-to-r from-red-50 to-rose-50 border-2 border-red-300 rounded-2xl p-6 hover:shadow-md transition-all">
                                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                                    <div class="flex items-start space-x-4 flex-1">
                                        <img src="{{ $imagePath }}" alt="{{ $pinjam->barang->nama_barang }}" class="w-20 h-20 object-cover rounded-xl shadow-md flex-shrink-0">
                                        <div class="flex-1">
                                            <div class="flex items-center space-x-2 mb-2 flex-wrap gap-1">
                                                <span class="px-3 py-1 bg-red-500 text-white rounded-full text-xs font-bold">Terlambat {{ $keterlambatan }}</span>
                                                <span class="px-3 py-1 bg-fuchsia-100 text-fuchsia-700 rounded-full text-xs font-semibold">{{ $pinjam->barang->kategori->nama_kategori ?? 'Lainnya' }}</span>
                                            </div>
                                            <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $pinjam->barang->nama_barang }}</h3>
                                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-sm">
                                                <div>
                                                    <p class="text-gray-500 text-xs">Tanggal Pinjam</p>
                                                    <p class="font-semibold text-gray-900">
                                                        @if($pinjam->tipe_pinjam == 'hari')
                                                            {{ \Carbon\Carbon::parse($pinjam->tanggal_pinjam)->format('d M Y') }}
                                                        @else
                                                            {{ \Carbon\Carbon::parse($pinjam->tanggal_pinjam_jam)->format('d M Y') }}
                                                        @endif
                                                    </p>
                                                </div>
                                                <div>
                                                    <p class="text-gray-500 text-xs">Tanggal Kembali</p>
                                                    <p class="font-semibold text-red-900">
                                                        @if($pinjam->tipe_pinjam == 'hari')
                                                            {{ \Carbon\Carbon::parse($pinjam->tanggal_kembali)->format('d M Y') }}
                                                        @else
                                                            {{ \Carbon\Carbon::parse($pinjam->tanggal_pinjam_jam)->format('d M Y') }} {{ $pinjam->jam_kembali }}
                                                        @endif
                                                    </p>
                                                </div>
                                                <div>
                                                    <p class="text-gray-500 text-xs">Denda</p>
                                                    <p class="font-semibold text-red-600">Rp {{ number_format($denda, 0, ',', '.') }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-gray-500 text-xs">Status</p>
                                                    <p class="font-semibold text-red-600">Terlambat</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex flex-col space-y-2 lg:w-48">
                                        <button onclick="openReturnModal({{ $pinjam->id }})" class="px-4 py-2.5 bg-gradient-to-r from-red-600 to-rose-500 text-white rounded-xl font-semibold hover:shadow-lg hover:shadow-red-300 transition-all text-sm">
                                            Kembalikan Sekarang
                                        </button>
                                        <button onclick="showDetail({{ $pinjam->id }})" class="px-4 py-2.5 bg-white border-2 border-gray-200 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition-all text-sm">
                                            Lihat Detail
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="w-24 h-24 bg-gradient-to-br from-emerald-500 to-green-400 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg shadow-emerald-200">
                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Tidak Ada Keterlambatan!</h3>
                        <p class="text-gray-600">Pertahankan! Anda selalu mengembalikan item tepat waktu.</p>
                    </div>
                @endif
            </div>

            <!-- Tab Content: History -->
            <div id="content-history" class="tab-content hidden p-6">
                <div class="mb-6 flex items-center justify-between">
                    <div>
                        <h3 class="font-bold text-gray-900 text-lg">Riwayat Peminjaman</h3>
                        <p class="text-sm text-gray-600">Total {{ $totalPeminjaman }} peminjaman</p>
                    </div>
                    <select id="filterHistory" class="px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-fuchsia-500">
                        <option value="all">Semua Waktu</option>
                        <option value="month">Bulan Ini</option>
                        <option value="3months">3 Bulan Terakhir</option>
                        <option value="6months">6 Bulan Terakhir</option>
                    </select>
                </div>

                @if($riwayatPeminjaman->count() > 0)
                    <div class="space-y-4">
                        @foreach($riwayatPeminjaman as $pinjam)
                            @php
                                $imagePath = $pinjam->barang->gambar 
                                    ? Storage::url($pinjam->barang->gambar) 
                                    : 'https://images.unsplash.com/photo-1530124566582-a618bc2615dc?w=150';
                                
                                $statusClass = $pinjam->status == 'dikembalikan' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700';
                                $statusIcon = $pinjam->status == 'dikembalikan' 
                                    ? '<svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>'
                                    : '<svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
                                
                                $statusLabel = $pinjam->status == 'dikembalikan' ? 'Selesai' : 'Ditolak';
                            @endphp
                            
                            <div class="bg-white border border-gray-200 rounded-2xl p-6 hover:shadow-md transition-all">
                                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                                    <div class="flex items-start space-x-4 flex-1">
                                        <img src="{{ $imagePath }}" alt="{{ $pinjam->barang->nama_barang }}" class="w-20 h-20 object-cover rounded-xl shadow-md flex-shrink-0">
                                        <div class="flex-1">
                                            <div class="flex items-center space-x-2 mb-2 flex-wrap gap-1">
                                                <span class="px-3 py-1 {{ $statusClass }} rounded-full text-xs font-bold">{!! $statusIcon !!} {{ $statusLabel }}</span>
                                                <span class="px-3 py-1 bg-fuchsia-100 text-fuchsia-700 rounded-full text-xs font-semibold">{{ $pinjam->barang->kategori->nama_kategori ?? 'Lainnya' }}</span>
                                                @if($pinjam->denda > 0)
                                                    <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold">Denda: Rp {{ number_format($pinjam->denda, 0, ',', '.') }}</span>
                                                @endif
                                            </div>
                                            <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $pinjam->barang->nama_barang }}</h3>
                                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-sm">
                                                <div>
                                                    <p class="text-gray-500 text-xs">Tanggal Pinjam</p>
                                                    <p class="font-semibold text-gray-900">
                                                        @if($pinjam->tipe_pinjam == 'hari')
                                                            {{ \Carbon\Carbon::parse($pinjam->tanggal_pinjam)->format('d M Y') }}
                                                        @else
                                                            {{ \Carbon\Carbon::parse($pinjam->tanggal_pinjam_jam)->format('d M Y') }}
                                                        @endif
                                                    </p>
                                                </div>
                                                <div>
                                                    <p class="text-gray-500 text-xs">Tanggal Kembali</p>
                                                    <p class="font-semibold text-gray-900">
                                                        @if($pinjam->status == 'dikembalikan')
                                                            {{ $pinjam->updated_at->format('d M Y') }}
                                                        @else
                                                            -
                                                        @endif
                                                    </p>
                                                </div>
                                                <div>
                                                    <p class="text-gray-500 text-xs">Durasi</p>
                                                    <p class="font-semibold text-gray-900">
                                                        @if($pinjam->tipe_pinjam == 'hari')
                                                            {{ \Carbon\Carbon::parse($pinjam->tanggal_pinjam)->diffInDays($pinjam->tanggal_kembali) + 1 }} hari
                                                        @else
                                                            {{ \Carbon\Carbon::parse($pinjam->jam_pinjam)->diffInHours($pinjam->jam_kembali) }} jam
                                                        @endif
                                                    </p>
                                                </div>
                                                <div>
                                                    <p class="text-gray-500 text-xs">Status</p>
                                                    <p class="font-semibold {{ $pinjam->status == 'dikembalikan' ? 'text-green-600' : 'text-red-600' }}">{{ $statusLabel }}</p>
                                                </div>
                                            </div>
                                            @if($pinjam->denda > 0 || $pinjam->kondisi_saat_kembali)
                                                <div class="mt-4 rounded-2xl bg-red-50 border border-red-100 p-4 text-sm text-gray-700">
                                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                                        <div><span class="font-semibold">Total Denda:</span> Rp {{ number_format($pinjam->denda, 0, ',', '.') }}</div>
                                                        <div><span class="font-semibold">Kondisi:</span> {{ $pinjam->kondisi_saat_kembali ?? 'Baik' }}</div>
                                                    </div>
                                                    @if($pinjam->denda_terlambat > 0)
                                                        <p class="mt-2"><span class="font-semibold">Denda Keterlambatan:</span> Rp {{ number_format($pinjam->denda_terlambat, 0, ',', '.') }}</p>
                                                    @endif
                                                    @if($pinjam->denda_kondisi > 0)
                                                        <p><span class="font-semibold">Denda Kondisi:</span> Rp {{ number_format($pinjam->denda_kondisi, 0, ',', '.') }}</p>
                                                    @endif
                                                    @if($pinjam->catatan_pengembalian)
                                                        <p class="mt-2"><span class="font-semibold">Catatan:</span> {{ $pinjam->catatan_pengembalian }}</p>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex flex-col space-y-2 lg:w-48">
                                        @if($pinjam->status == 'dikembalikan')
                                            <a href="{{ route('peminjam.beranda') }}?barang={{ $pinjam->barang_id }}" class="px-4 py-2.5 bg-gradient-to-r from-fuchsia-600 to-pink-500 text-white rounded-xl font-semibold hover:shadow-lg hover:shadow-fuchsia-300 transition-all text-sm text-center">
                                                Pinjam Lagi
                                            </a>
                                        @endif
                                        <button onclick="showDetail({{ $pinjam->id }})" class="px-4 py-2.5 bg-white border-2 border-gray-200 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition-all text-sm">
                                            Lihat Detail
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $riwayatPeminjaman->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="w-24 h-24 bg-gradient-to-br from-fuchsia-600 to-pink-500 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg shadow-fuchsia-200">
                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Riwayat</h3>
                        <p class="text-gray-600">Anda belum melakukan peminjaman apapun.</p>
                    </div>
                @endif
            </div>
        </div>
    </main>

    <!-- Return Confirmation Modal -->
    <div id="returnModal" class="modal hidden" style="display: none;" onclick="if(event.target === this) closeReturnModal()">
        <div class="bg-white rounded-2xl max-w-md w-full p-6">
            <div class="text-center">
                <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Konfirmasi Pengembalian</h3>
                <p class="text-gray-600 mb-6">Apakah Anda yakin ingin mengembalikan item ini? Petugas akan memverifikasi kondisi barang.</p>
                
                <input type="hidden" id="returnPeminjamanId">
                
                <div class="space-y-3">
                    <button onclick="confirmReturn()" class="w-full py-3 bg-gradient-to-r from-emerald-600 to-green-500 text-white rounded-xl font-semibold hover:shadow-lg hover:shadow-emerald-300 transition-all">
                        Ya, Kembalikan
                    </button>
                    <button onclick="closeReturnModal()" class="w-full py-3 bg-white border-2 border-gray-200 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition-all">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Kode Peminjaman Modal -->
    <div id="kodeModal" class="modal hidden" style="display: none;" onclick="if(event.target === this) closeKodeModal()">
        <div class="bg-white rounded-2xl max-w-md w-full p-6">
            <div class="text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-fuchsia-600 to-pink-500 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg shadow-fuchsia-200">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Kode Peminjaman</h3>
                <p class="text-gray-600 mb-2">Tunjukkan kode ini ke petugas untuk mengambil barang</p>
                
                <div id="kodeDisplay" class="bg-gray-100 rounded-xl p-6 mb-6">
                    <p class="text-4xl font-bold tracking-wider text-fuchsia-600" id="kodeValue"></p>
                </div>
                
                <div class="space-y-3">
                    <button onclick="copyKode()" class="w-full py-3 bg-gradient-to-r from-fuchsia-600 to-pink-500 text-white rounded-xl font-semibold hover:shadow-lg hover:shadow-fuchsia-300 transition-all flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                        <span>Salin Kode</span>
                    </button>
                    <button onclick="closeKodeModal()" class="w-full py-3 bg-white border-2 border-gray-200 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition-all">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Modal -->
    <div id="detailModal" class="modal hidden" style="display: none;" onclick="if(event.target === this) closeDetailModal()">
        <div class="bg-white rounded-2xl max-w-3xl w-full max-h-[90vh] overflow-y-auto p-6">
            <div class="flex justify-between items-start mb-6">
                <h3 class="text-xl font-bold text-gray-900">Detail Peminjaman</h3>
                <button onclick="closeDetailModal()" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div id="detailContent">
                <!-- Detail akan diisi via JavaScript -->
            </div>
        </div>
    </div>

    <script>
        // Switch tab function
        function switchTab(tab) {
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });
            
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('active');
                button.classList.add('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200');
            });
            
            document.getElementById(`content-${tab}`).classList.remove('hidden');
            
            const activeTab = document.getElementById(`tab-${tab}`);
            activeTab.classList.remove('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200');
            activeTab.classList.add('active');
        }

        // Return modal functions
        let currentReturnId = null;
        
        function openReturnModal(id) {
            currentReturnId = id;
            document.getElementById('returnPeminjamanId').value = id;
            const returnModal = document.getElementById('returnModal');
            returnModal.classList.remove('hidden');
            returnModal.style.display = 'flex';
        }

        function closeReturnModal() {
            const returnModal = document.getElementById('returnModal');
            returnModal.classList.add('hidden');
            returnModal.style.display = 'none';
            currentReturnId = null;
        }

        function confirmReturn() {
            const id = document.getElementById('returnPeminjamanId').value;
            alert('Permintaan pengembalian berhasil! Silakan datang ke ruang SarPras untuk verifikasi.');
            closeReturnModal();
        }

        // Kode modal functions
        function showKodePeminjaman(kode) {
            const kodeModal = document.getElementById('kodeModal');
            document.getElementById('kodeValue').innerText = kode;
            kodeModal.classList.remove('hidden');
            kodeModal.style.display = 'flex';
        }

        function closeKodeModal() {
            const kodeModal = document.getElementById('kodeModal');
            kodeModal.classList.add('hidden');
            kodeModal.style.display = 'none';
        }

        function copyKode() {
            const kode = document.getElementById('kodeValue').innerText;
            navigator.clipboard.writeText(kode).then(() => {
                alert('Kode berhasil disalin!');
            });
        }

        // Detail modal - DIPERBAIKI
function showDetail(id) {
    // Tampilkan loading
    document.getElementById('detailContent').innerHTML = `
        <div class="text-center py-12">
            <div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-fuchsia-600 border-t-transparent"></div>
            <p class="mt-4 text-gray-600">Memuat detail peminjaman...</p>
        </div>
    `;
    const detailModal = document.getElementById('detailModal');
    detailModal.classList.remove('hidden');
    detailModal.style.display = 'flex';
    
    // 🔥 PERBAIKAN: Gunakan URL yang benar
    const url = `/peminjam/aktivitas-saya/${id}`;
    console.log('Fetching URL:', url);
    
    fetch(url, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(response => {
        console.log('Response status:', response.status);
        if (!response.ok) {
            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        if (data.success) {
            renderDetailPeminjaman(data.data);
        } else {
            throw new Error(data.message || 'Gagal memuat detail');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('detailContent').innerHTML = `
            <div class="text-center py-12 text-red-600">
                <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-lg font-semibold mb-2">Gagal memuat detail</p>
                <p class="text-sm text-gray-600">${error.message}</p>
                <button onclick="showDetail(${id})" class="mt-4 px-4 py-2 bg-fuchsia-600 text-white rounded-lg hover:bg-fuchsia-700 transition-colors">
                    Coba Lagi
                </button>
            </div>
        `;
    });
}

function renderDetailPeminjaman(pinjam) {
    // Format tanggal
    const formatDate = (date) => {
        return new Date(date).toLocaleDateString('id-ID', {
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        });
    };

    const formatDateTime = (date) => {
        return new Date(date).toLocaleDateString('id-ID', {
            day: 'numeric',
            month: 'long',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    };

    // Status badge
    const getStatusBadge = (status) => {
        const badges = {
            'menunggu': { bg: 'bg-yellow-100', text: 'text-yellow-800', label: 'Menunggu Persetujuan', icon: '⏳' },
            'disetujui': { bg: 'bg-blue-100', text: 'text-blue-800', label: 'Disetujui', icon: '✅' },
            'dipinjam': { bg: 'bg-green-100', text: 'text-green-800', label: 'Sedang Dipinjam', icon: '📦' },
            'dikembalikan': { bg: 'bg-gray-100', text: 'text-gray-800', label: 'Selesai', icon: '↩️' },
            'ditolak': { bg: 'bg-red-100', text: 'text-red-800', label: 'Ditolak', icon: '❌' },
            'terlambat': { bg: 'bg-red-100', text: 'text-red-800', label: 'Terlambat', icon: '⚠️' }
        };
        return badges[status] || badges['menunggu'];
    };

    const status = getStatusBadge(pinjam.status);
    const imagePath = pinjam.barang.gambar 
        ? `/storage/${pinjam.barang.gambar}`
        : 'https://images.unsplash.com/photo-1593642632823-8f785ba67e45?w=400';

    // Hitung durasi
    let durasi = '';
    if (pinjam.tipe_pinjam == 'hari') {
        const tglPinjam = new Date(pinjam.tanggal_pinjam);
        const tglKembali = new Date(pinjam.tanggal_kembali);
        const selisihHari = Math.ceil((tglKembali - tglPinjam) / (1000 * 60 * 60 * 24)) + 1;
        durasi = `${selisihHari} hari`;
    } else {
        const jamPinjam = pinjam.jam_pinjam.split(':');
        const jamKembali = pinjam.jam_kembali.split(':');
        const selisihJam = parseInt(jamKembali[0]) - parseInt(jamPinjam[0]);
        durasi = `${selisihJam} jam`;
    }

    // Hitung sisa waktu atau denda
    let sisaWaktu = '';
    let sisaWarna = '';
    
    if (pinjam.status == 'dipinjam' || pinjam.status == 'disetujui') {
        const hariIni = new Date();
        hariIni.setHours(0, 0, 0, 0);
        
        if (pinjam.tipe_pinjam == 'hari') {
            const tglKembali = new Date(pinjam.tanggal_kembali);
            tglKembali.setHours(0, 0, 0, 0);
            
            if (hariIni < tglKembali) {
                const selisih = Math.ceil((tglKembali - hariIni) / (1000 * 60 * 60 * 24));
                sisaWaktu = `${selisih} hari lagi`;
                sisaWarna = 'text-emerald-600';
            } else if (hariIni.getTime() === tglKembali.getTime()) {
                sisaWaktu = 'Jatuh tempo hari ini';
                sisaWarna = 'text-orange-600';
            } else {
                const selisih = Math.ceil((hariIni - tglKembali) / (1000 * 60 * 60 * 24));
                sisaWaktu = `${selisih} hari terlambat`;
                sisaWarna = 'text-red-600';
            }
        } else {
            const tglJamKembali = new Date(pinjam.tanggal_pinjam_jam + 'T' + pinjam.jam_kembali);
            if (hariIni < tglJamKembali) {
                const selisihJam = Math.ceil((tglJamKembali - new Date()) / (1000 * 60 * 60));
                sisaWaktu = `${selisihJam} jam lagi`;
                sisaWarna = 'text-emerald-600';
            } else if (hariIni.toDateString() === tglJamKembali.toDateString() && new Date() < tglJamKembali) {
                sisaWaktu = 'Hari ini';
                sisaWarna = 'text-orange-600';
            } else {
                sisaWaktu = 'Terlambat';
                sisaWarna = 'text-red-600';
            }
        }
    }

    const detailHTML = `
        <div class="space-y-6">
            <!-- Header dengan status -->
            <div class="flex items-center justify-between p-4 ${status.bg} rounded-xl">
                <div class="flex items-center space-x-3">
                    <span class="text-2xl">${status.icon}</span>
                    <div>
                        <p class="font-semibold ${status.text}">Status: ${status.label}</p>
                        <p class="text-sm ${status.text} opacity-75">Kode: ${pinjam.kode_peminjaman || '-'}</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-sm ${status.text}">ID: #${pinjam.id}</p>
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
                            <span class="px-3 py-1 bg-fuchsia-100 text-fuchsia-700 rounded-full text-xs font-semibold">
                                ${pinjam.barang.kategori?.nama_kategori || 'Lainnya'}
                            </span>
                            <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-semibold">
                                Jumlah: ${pinjam.jumlah} unit
                            </span>
                            <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">
                                Tipe: ${pinjam.tipe_pinjam == 'hari' ? 'Per Hari' : 'Per Jam'}
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
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

            <!-- Timeline / Detail Waktu -->
            <div class="border-t border-gray-200 pt-6">
                <h4 class="font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-fuchsia-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Timeline Peminjaman
                </h4>
                
                <div class="space-y-4">
                    ${pinjam.tipe_pinjam == 'hari' ? `
                    <!-- Per Hari -->
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
                        <div class="flex-shrink-0 w-8 h-8 ${sisaWarna.replace('text', 'bg').replace('600', '100')} rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 ${sisaWarna}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold text-gray-900">Tanggal Kembali</p>
                            <p class="text-sm text-gray-600">${formatDate(pinjam.tanggal_kembali)}</p>
                            ${sisaWaktu ? `<p class="text-xs ${sisaWarna} mt-1 font-semibold">${sisaWaktu}</p>` : ''}
                        </div>
                    </div>
                    ` : `
                    <!-- Per Jam -->
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
                        <div class="flex-shrink-0 w-8 h-8 ${sisaWarna.replace('text', 'bg').replace('600', '100')} rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 ${sisaWarna}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold text-gray-900">Tanggal & Jam Kembali</p>
                            <p class="text-sm text-gray-600">${formatDate(pinjam.tanggal_pinjam_jam)} ${pinjam.jam_kembali}</p>
                            ${sisaWaktu ? `<p class="text-xs ${sisaWarna} mt-1 font-semibold">${sisaWaktu}</p>` : ''}
                        </div>
                    </div>
                    `}

                    <!-- Durasi -->
                    <div class="mt-4 p-4 bg-gradient-to-r from-fuchsia-50 to-pink-50 rounded-xl">
                        <div class="flex justify-between items-center">
                            <span class="font-semibold text-fuchsia-900">Durasi Peminjaman:</span>
                            <span class="text-xl font-bold text-fuchsia-700">${durasi}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informasi Tambahan -->
            <div class="border-t border-gray-200 pt-6">
                <h4 class="font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-fuchsia-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Informasi Lainnya
                </h4>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    ${pinjam.denda > 0 ? `
                    <div class="bg-red-50 p-3 rounded-lg">
                        <p class="text-xs text-red-600 mb-1">Denda</p>
                        <p class="font-semibold text-red-700">Rp ${new Intl.NumberFormat('id-ID').format(pinjam.denda)}</p>
                    </div>
                    ` : ''}
                </div>
            </div>

            <!-- Catatan (jika ada) -->
            ${pinjam.alasan ? `
            <div class="border-t border-gray-200 pt-6">
                <h4 class="font-bold text-gray-900 mb-2">Alasan</h4>
                <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4">
                    <p class="text-sm text-gray-700">${pinjam.alasan}</p>
                </div>
            </div>
            ` : ''}
        </div>
    `;

    document.getElementById('detailContent').innerHTML = detailHTML;
}

function closeDetailModal() {
    const detailModal = document.getElementById('detailModal');
    detailModal.classList.add('hidden');
    detailModal.style.display = 'none';
}

        // Filter history
        document.getElementById('filterHistory')?.addEventListener('change', function() {
            // TODO: Filter history berdasarkan waktu
            const value = this.value;
            alert('Filter ' + value + ' akan segera hadir!');
        });

        // Close modals when clicking outside
        window.addEventListener('click', function(e) {
            const returnModal = document.getElementById('returnModal');
            const kodeModal = document.getElementById('kodeModal');
            const detailModal = document.getElementById('detailModal');
            
            if (e.target === returnModal) closeReturnModal();
            if (e.target === kodeModal) closeKodeModal();
            if (e.target === detailModal) closeDetailModal();
        });
    </script>
</body>
</html>