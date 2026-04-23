<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Peminjaman - SarPras</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
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
                            <h1 class="text-2xl font-bold text-gray-900">Riwayat Peminjaman</h1>
                            <p class="text-sm text-gray-500 mt-0.5">Histori transaksi yang telah selesai</p>
                        </div>

                        <!-- Right Side Actions -->
                        <div class="flex items-center space-x-3">
                            <button onclick="window.location.reload()" class="p-2 text-gray-600 hover:bg-gray-100 rounded-lg transition-colors" title="Refresh">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                            </button>
                            <div class="flex items-center space-x-3 pl-3 border-l border-gray-200">
                                <div class="hidden sm:block text-right">
                                    <p class="text-sm font-semibold text-gray-900">{{ Auth::user()->name ?? 'Admin User' }}</p>
                                    <p class="text-xs text-gray-500">Administrator</p>
                                </div>
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-cyan-400 flex items-center justify-center text-white font-semibold uppercase">
                                    {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="p-4 sm:p-6 lg:p-8">
                <!-- Stats Cards Sederhana -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-gray-600 text-sm font-medium mb-1">Total Transaksi</h3>
                        <p class="text-3xl font-bold text-gray-900">{{ number_format($totalTransaksi) }}</p>
                    </div>
                    
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-gray-600 text-sm font-medium mb-1">Tepat Waktu</h3>
                        <p class="text-3xl font-bold text-gray-900">{{ number_format($tepatWaktu) }}</p>
                    </div>
                    
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-gray-600 text-sm font-medium mb-1">Terlambat / Ditolak</h3>
                        <p class="text-3xl font-bold text-gray-900">{{ number_format($terlambat) }}</p>
                    </div>
                </div>

                <!-- Filter Form Sederhana -->
<form id="filterForm" method="GET" action="{{ route('admin.riwayat.index') }}" class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
    <div class="p-6 border-b border-gray-100">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div class="flex flex-wrap items-center gap-3">
                <!-- Date Range -->
                <div class="relative">
                    <input type="date" 
                           name="start_date" 
                           id="start_date"
                           value="{{ request('start_date') }}"
                           class="px-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <span class="text-gray-500">-</span>
                <div class="relative">
                    <input type="date" 
                           name="end_date" 
                           id="end_date"
                           value="{{ request('end_date') }}"
                           class="px-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                
                <!-- Filter Status -->
                <select name="status" class="px-4 py-2 border border-gray-200 rounded-lg text-sm font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Status</option>
                    <option value="tepat_waktu" {{ request('status') == 'tepat_waktu' ? 'selected' : '' }}>Tepat Waktu</option>
                    <option value="terlambat" {{ request('status') == 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
                
                <!-- Filter Kategori -->
                <select name="kategori" class="px-4 py-2 border border-gray-200 rounded-lg text-sm font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" {{ request('kategori') == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="flex items-center gap-3">
                <!-- Search -->
                <div class="relative">
                    <input type="text" 
                           name="search" 
                           id="search"
                           value="{{ request('search') }}"
                           placeholder="Cari peminjam/barang/kode..." 
                           class="pl-10 pr-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 w-64">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                
                <!-- Buttons -->
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700 transition-colors">
                    Filter
                </button>
                
                <!-- 🔥 TOMBOL EXPORT EXCEL 🔥 -->
                <a href="{{ route('admin.riwayat.export', request()->query()) }}" 
                class="px-4 py-2 bg-gradient-to-r from-emerald-600 to-teal-500 text-white rounded-lg text-sm font-semibold hover:shadow-lg transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    Export Excel
                </a>
                
                <a href="{{ route('admin.riwayat.index') }}" 
                   class="px-4 py-2 border border-gray-200 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                    Reset
                </a>
            </div>
        </div>
    </div>
</form>

                <!-- Transaction Table -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b border-gray-100">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID Transaksi</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Peminjam</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Item</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tgl Pinjam</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tgl Kembali</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($transaksi as $item)
                                    @php
                                        // Format ID Transaksi
                                        $transaksiId = 'TRX-' . str_pad($item->id, 6, '0', STR_PAD_LEFT);
                                        
                                        // Inisial peminjam
                                        $inisial = strtoupper(substr($item->user->name, 0, 2));
                                        
                                        // Warna background berdasarkan role
                                        $bgColor = $item->user->role == 'siswa' 
                                            ? 'from-blue-500 to-cyan-400' 
                                            : 'from-purple-500 to-pink-400';
                                        
                                        // Tanggal
                                        $tglPinjam = $item->tipe_pinjam == 'hari'
                                            ? Carbon\Carbon::parse($item->tanggal_pinjam)->format('d/m/Y')
                                            : Carbon\Carbon::parse($item->tanggal_pinjam_jam)->format('d/m/Y');
                                        
                                        $tglKembali = $item->status == 'dikembalikan'
                                            ? $item->updated_at->format('d/m/Y')
                                            : ($item->tipe_pinjam == 'hari'
                                                ? Carbon\Carbon::parse($item->tanggal_kembali)->format('d/m/Y')
                                                : Carbon\Carbon::parse($item->tanggal_pinjam_jam)->format('d/m/Y'));
                                        
                                        // Status
                                        $statusClass = '';
                                        $statusText = '';
                                        
                                        if ($item->status == 'dikembalikan' && $item->denda == 0) {
                                            $statusClass = 'bg-green-100 text-green-700';
                                            $statusText = 'Tepat Waktu';
                                        } elseif ($item->status == 'dikembalikan' && $item->denda > 0) {
                                            $statusClass = 'bg-orange-100 text-orange-700';
                                            $statusText = 'Terlambat';
                                        } elseif ($item->status == 'terlambat') {
                                            $statusClass = 'bg-red-100 text-red-700';
                                            $statusText = 'Terlambat';
                                        } elseif ($item->status == 'ditolak') {
                                            $statusClass = 'bg-gray-100 text-gray-700';
                                            $statusText = 'Ditolak';
                                        }
                                    @endphp
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center space-x-2">
                                                <div class="w-8 h-8 bg-blue-100 rounded flex items-center justify-center">
                                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    </svg>
                                                </div>
                                                <span class="text-sm font-semibold text-gray-900">{{ $transaksiId }}</span>
                                            </div>
                                            @if($item->kode_peminjaman)
                                                <span class="text-xs text-purple-600 font-mono block mt-1">Kode: {{ $item->kode_peminjaman }}</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <div class="w-10 h-10 bg-gradient-to-br {{ $bgColor }} rounded-full flex items-center justify-center text-white font-semibold mr-3 uppercase">
                                                    {{ $inisial }}
                                                </div>
                                                <div>
                                                    <p class="text-sm font-semibold text-gray-900">{{ $item->user->name }}</p>
                                                    <p class="text-xs text-gray-500">{{ $item->user->role == 'siswa' ? 'Siswa' : 'Petugas' }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <p class="text-sm font-semibold text-gray-900">{{ $item->barang->nama_barang }}</p>
                                            <p class="text-xs text-gray-500">{{ $item->barang->kategori->nama_kategori ?? '-' }}</p>
                                            @if($item->denda > 0)
                                                <p class="text-xs text-red-600 font-medium mt-1">Denda: Rp {{ number_format($item->denda, 0, ',', '.') }}</p>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">{{ $tglPinjam }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-900">{{ $tglKembali }}</td>
                                        <td class="px-6 py-4">
                                            <span class="px-3 py-1 {{ $statusClass }} rounded-full text-xs font-medium flex items-center w-fit">
                                                {{ $statusText }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <button onclick="showDetail({{ $item->id }})" 
                                                    class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" 
                                                    title="Detail">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center">
                                                <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                                <h3 class="text-base font-semibold text-gray-900 mb-1">Tidak Ada Riwayat</h3>
                                                <p class="text-sm text-gray-600">Belum ada transaksi peminjaman yang selesai.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($transaksi->hasPages())
                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <p class="text-sm text-gray-600">
                                Menampilkan <span class="font-semibold">{{ $transaksi->firstItem() ?? 0 }}-{{ $transaksi->lastItem() ?? 0 }}</span> 
                                dari <span class="font-semibold">{{ number_format($transaksi->total()) }}</span> transaksi
                            </p>
                            <div class="flex items-center space-x-2">
                                {{ $transaksi->links() }}
                            </div>
                        </div>
                    @endif
                </div>
            </main>
        </div>
    </div>

    <!-- Detail Transaction Modal -->
    <div id="detailModal" class="modal hidden">
        <div class="bg-white rounded-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between rounded-t-2xl">
                <h3 class="text-xl font-bold text-gray-900" id="modalTitle">Detail Transaksi</h3>
                <button onclick="closeModal('detailModal')" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="p-6" id="modalContent">
                <!-- Content akan diisi oleh JavaScript -->
            </div>
        </div>
    </div>

    <script>
        const csrfToken = '{{ csrf_token() }}';

        // ================ MODAL FUNCTIONS ================
        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // ================ DETAIL FUNCTIONS ================
        function showDetail(id) {
            fetch(`/admin/riwayat/${id}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => response.json())
            .then(data => {
                const modalContent = document.getElementById('modalContent');
                const modalTitle = document.getElementById('modalTitle');
                
                modalTitle.innerText = `Detail Transaksi #TRX-${String(data.id).padStart(6, '0')}`;
                
                // Format tanggal
                const tglPinjam = data.tipe_pinjam === 'hari'
                    ? new Date(data.tanggal_pinjam).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' })
                    : new Date(data.tanggal_pinjam_jam).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }) + ' ' + data.jam_pinjam;
                
                const tglKembali = data.tipe_pinjam === 'hari'
                    ? new Date(data.tanggal_kembali).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' })
                    : new Date(data.tanggal_pinjam_jam).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }) + ' ' + data.jam_kembali;
                
                // Status
                let statusClass = '';
                let statusText = '';
                
                if (data.status === 'dikembalikan' && data.denda === 0) {
                    statusClass = 'bg-green-100 text-green-700';
                    statusText = 'Dikembalikan Tepat Waktu';
                } else if (data.status === 'dikembalikan' && data.denda > 0) {
                    statusClass = 'bg-orange-100 text-orange-700';
                    statusText = `Dikembalikan Terlambat (Denda: Rp ${data.denda.toLocaleString('id-ID')})`;
                } else if (data.status === 'terlambat') {
                    statusClass = 'bg-red-100 text-red-700';
                    statusText = 'Belum Dikembalikan';
                } else if (data.status === 'ditolak') {
                    statusClass = 'bg-gray-100 text-gray-700';
                    statusText = 'Ditolak';
                }
                
                modalContent.innerHTML = `
                    <div class="space-y-6">
                        <!-- Status -->
                        <div class="flex items-center justify-center">
                            <span class="px-6 py-3 ${statusClass} rounded-xl text-sm font-bold">
                                ${statusText}
                            </span>
                        </div>

                        <!-- Informasi Peminjam -->
                        <div class="bg-gray-50 rounded-xl p-4">
                            <h4 class="text-sm font-bold text-gray-900 mb-3">Informasi Peminjam</h4>
                            <div class="flex items-center">
                                <div class="w-16 h-16 bg-gradient-to-br ${data.user.role === 'siswa' ? 'from-blue-500 to-cyan-400' : 'from-purple-500 to-pink-400'} rounded-full flex items-center justify-center text-white font-bold text-xl mr-4 uppercase">
                                    ${data.user.name.substr(0, 2)}
                                </div>
                                <div>
                                    <p class="text-base font-bold text-gray-900">${data.user.name}</p>
                                    <p class="text-sm text-gray-600">${data.user.role === 'siswa' ? 'Siswa' : 'Petugas'}</p>
                                    <p class="text-sm text-gray-600">NISN/NIP: ${data.user.nisn || data.user.nip || '-'}</p>
                                    <p class="text-sm text-gray-600">Email: ${data.user.email || '-'}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Informasi Item -->
                        <div class="bg-blue-50 rounded-xl p-4">
                            <h4 class="text-sm font-bold text-gray-900 mb-3">Informasi Item</h4>
                            <div class="flex items-start">
                                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-400 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-base font-bold text-gray-900">${data.barang.nama_barang}</p>
                                    <p class="text-sm text-gray-600">Kode: BRG-${String(data.barang.id).padStart(3, '0')}</p>
                                    <p class="text-sm text-gray-600">Kategori: ${data.barang.kategori?.nama_kategori || '-'}</p>
                                    <p class="text-sm text-gray-600">Tanggal Pinjam: ${tglPinjam}</p>
                                    <p class="text-sm text-gray-600">Tanggal Kembali: ${tglKembali}</p>
                                    ${data.kode_peminjaman ? `<p class="text-sm text-gray-600">Kode Pinjam: <span class="font-mono bg-purple-100 text-purple-800 px-2 py-0.5 rounded">${data.kode_peminjaman}</span></p>` : ''}
                                </div>
                            </div>
                        </div>

                        <!-- Catatan -->
                        <div class="bg-gray-50 rounded-xl p-4">
                            <h4 class="text-sm font-bold text-gray-900 mb-3">Catatan</h4>
                            <p class="text-sm text-gray-600">${data.alasan || data.alasan_penolakan || data.catatan_pengembalian || '-'}</p>
                        </div>
                    </div>
                    
                    <div class="flex justify-end pt-6 border-t border-gray-200 mt-6">
                        <button onclick="closeModal('detailModal')" 
                                class="px-5 py-2.5 border border-gray-200 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition-all">
                            Tutup
                        </button>
                    </div>
                `;
                
                openModal('detailModal');
            })
            .catch(error => {
                console.error('Error:', error);
                alert('❌ Gagal mengambil detail transaksi');
            });
        }

        // ================ VALIDASI TANGGAL ================
        document.getElementById('start_date')?.addEventListener('change', function() {
            const endDate = document.getElementById('end_date');
            if (this.value && endDate.value && this.value > endDate.value) {
                endDate.value = this.value;
            }
        });

        document.getElementById('end_date')?.addEventListener('change', function() {
            const startDate = document.getElementById('start_date');
            if (this.value && startDate.value && this.value < startDate.value) {
                startDate.value = this.value;
            }
        });

        // ================ MOBILE MENU ================
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const sidebar = document.querySelector('aside');
        
        if (mobileMenuButton && sidebar) {
            mobileMenuButton.addEventListener('click', () => {
                sidebar.classList.toggle('-translate-x-full');
            });
        }

        // ================ CLOSE MODAL OUTSIDE ================
        window.addEventListener('click', function(e) {
            if (e.target.classList.contains('modal')) {
                e.target.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        });
    </script>
</body>
</html>