<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permintaan Peminjaman - SarPras</title>
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
        .status-menunggu { background: #fef3c7; color: #92400e; }
        .status-disetujui { background: #dbeafe; color: #1e40af; }
        .status-ditolak { background: #fee2e2; color: #991b1b; }
        
        /* Loading spinner */
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
                            <h1 class="text-2xl font-bold text-gray-900">Permintaan Peminjaman</h1>
                            <p class="text-sm text-gray-500 mt-0.5">Kelola dan proses permintaan peminjaman</p>
                        </div>

                        <div class="flex items-center space-x-3">
                            <div class="relative">
                                <input type="text" id="searchInput" placeholder="Cari peminjam/barang..." value="{{ request('search') }}" class="pl-10 pr-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 w-64">
                                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <div class="flex items-center space-x-3 pl-3 border-l border-gray-200">
                                <div class="hidden sm:block text-right">
                                    <p class="text-sm font-semibold text-gray-900">{{ Auth::user()->name ?? 'Admin' }}</p>
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
                <!-- Action Bar -->
                <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="flex flex-wrap items-center gap-3">
                        <button onclick="approveSelected()" class="px-5 py-2.5 bg-gradient-to-r from-green-600 to-emerald-500 text-white rounded-xl font-semibold hover:shadow-lg hover:shadow-green-300 transition-all flex items-center space-x-2 disabled:opacity-50 disabled:cursor-not-allowed" id="approveSelectedBtn">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Setujui Dipilih</span>
                        </button>
                        <button onclick="rejectSelected()" class="px-5 py-2.5 bg-white border border-gray-200 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition-all flex items-center space-x-2 disabled:opacity-50 disabled:cursor-not-allowed" id="rejectSelectedBtn">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            <span>Tolak Dipilih</span>
                        </button>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-gray-600 text-sm font-medium mb-1">Total Pending</h3>
                        <p class="text-3xl font-bold text-gray-900">{{ $totalPending }}</p>
                        <p class="text-xs text-gray-500 mt-2">Menunggu approval</p>
                    </div>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-gray-600 text-sm font-medium mb-1">Hari Ini</h3>
                        <p class="text-3xl font-bold text-gray-900">{{ $hariIni }}</p>
                        <p class="text-xs text-gray-500 mt-2">Permintaan baru</p>
                    </div>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-violet-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-gray-600 text-sm font-medium mb-1">Dari Siswa</h3>
                        <p class="text-3xl font-bold text-gray-900">{{ $dariSiswa }}</p>
                        <p class="text-xs text-gray-500 mt-2">{{ $totalPending > 0 ? round(($dariSiswa/$totalPending)*100) : 0 }}% total</p>
                    </div>
                </div>

                <!-- Filters & Table -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <!-- Filters -->
                    <div class="p-6 border-b border-gray-100">
                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                            <div class="flex flex-wrap items-center gap-3">
                                <select id="filterKategori" class="px-4 py-2 border border-gray-200 rounded-lg text-sm font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                    <option value="">Semua Kategori</option>
                                    @foreach($kategoris as $kategori)
                                        <option value="{{ $kategori->id }}" {{ request('kategori') == $kategori->id ? 'selected' : '' }}>
                                            {{ $kategori->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                                <button onclick="resetFilters()" class="px-4 py-2 text-sm text-indigo-600 hover:text-indigo-700 font-medium">
                                    Reset Filter
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gradient-to-r from-indigo-50 to-violet-50 border-b border-gray-100">
                                <tr>
                                    <th class="px-6 py-4 text-left">
                                        <input type="checkbox" id="selectAll" class="w-4 h-4 text-indigo-600 rounded border-gray-300 focus:ring-indigo-500">
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Peminjam</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Item</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Durasi</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Waktu</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Alasan</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($peminjamans as $pinjam)
                                    @php
                                        $inisial = strtoupper(substr($pinjam->user->name, 0, 2));
                                        $warna = ['from-indigo-500 to-violet-400', 'from-pink-500 to-purple-400', 'from-green-500 to-teal-400', 'from-orange-500 to-amber-400', 'from-blue-500 to-cyan-400'][$loop->index % 5];
                                        
                                        $durasi = '';
                                        if ($pinjam->tipe_pinjam == 'hari') {
                                            $durasi = \Carbon\Carbon::parse($pinjam->tanggal_pinjam)->diffInDays($pinjam->tanggal_kembali) + 1 . ' hari';
                                            $tanggal = \Carbon\Carbon::parse($pinjam->tanggal_pinjam)->format('d M') . ' - ' . \Carbon\Carbon::parse($pinjam->tanggal_kembali)->format('d M Y');
                                        } else {
                                            $durasi = \Carbon\Carbon::parse($pinjam->jam_pinjam)->diffInHours($pinjam->jam_kembali) . ' jam';
                                            $tanggal = \Carbon\Carbon::parse($pinjam->tanggal_pinjam_jam)->format('d M Y') . ' ' . $pinjam->jam_pinjam . ' - ' . $pinjam->jam_kembali;
                                        }
                                    @endphp
                                    <tr class="hover:bg-indigo-50/50 transition-colors">
                                        <td class="px-6 py-4">
                                            <input type="checkbox" class="item-checkbox w-4 h-4 text-indigo-600 rounded border-gray-300 focus:ring-indigo-500" value="{{ $pinjam->id }}">
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="text-sm font-semibold text-gray-900">#REQ-{{ str_pad($pinjam->id, 4, '0', STR_PAD_LEFT) }}</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <div class="w-10 h-10 bg-gradient-to-br {{ $warna }} rounded-full flex items-center justify-center text-white font-semibold mr-3 uppercase">
                                                    {{ $inisial }}
                                                </div>
                                                <div>
                                                    <p class="text-sm font-semibold text-gray-900">{{ $pinjam->user->name }}</p>
                                                    <p class="text-xs text-gray-500">
                                                        @if($pinjam->user->role == 'siswa')
                                                            {{ $pinjam->user->profile->kelas->nama_kelas ?? 'Siswa' }}
                                                        @else
                                                            {{ $pinjam->user->role == 'guru' ? 'Guru' : 'Staff' }}
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div>
                                                <p class="text-sm font-semibold text-gray-900">{{ $pinjam->barang->nama_barang }}</p>
                                                <p class="text-xs text-gray-500">{{ $pinjam->barang->kategori->nama_kategori ?? 'Lainnya' }}</p>
                                                <p class="text-xs text-gray-400 mt-1">Jumlah: {{ $pinjam->jumlah }} unit</p>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            {{ $tanggal }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="text-sm font-semibold text-gray-900">{{ $durasi }}</span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            {{ $pinjam->created_at->diffForHumans() }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="text-xs text-gray-600 max-w-xs block truncate" title="{{ $pinjam->alasan }}">
                                                {{ Str::limit($pinjam->alasan, 30) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center space-x-2">
                                                <button onclick="approveItem({{ $pinjam->id }})" class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors" title="Setujui">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                </button>
                                                <button onclick="openRejectModal({{ $pinjam->id }})" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Tolak">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
                                                <button onclick="showDetail({{ $pinjam->id }})" class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors" title="Detail">
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
                                        <td colspan="9" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center">
                                                <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                                <h3 class="text-lg font-semibold text-gray-900 mb-1">Tidak Ada Permintaan</h3>
                                                <p class="text-gray-600">Belum ada pengajuan peminjaman yang perlu diproses.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <p class="text-sm text-gray-600">
                            Menampilkan <span class="font-semibold">{{ $peminjamans->firstItem() ?? 0 }}-{{ $peminjamans->lastItem() ?? 0 }}</span> 
                            dari <span class="font-semibold">{{ $peminjamans->total() }}</span> permintaan
                        </p>
                        <div class="flex items-center space-x-2">
                            {{ $peminjamans->links() }}
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Approve Modal -->
    <div id="approveModal" class="modal hidden">
        <div class="bg-white rounded-2xl max-w-md w-full">
            <div class="p-6">
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 text-center mb-2">Setujui Permintaan?</h3>
                <p class="text-gray-600 text-center mb-6" id="approveModalMessage">Apakah Anda yakin ingin menyetujui permintaan peminjaman ini?</p>
                
                <input type="hidden" id="approveId">
                
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Catatan (Opsional)</label>
                        <textarea id="approveNote" rows="3" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="Tambahkan catatan jika diperlukan..."></textarea>
                    </div>
                </div>

                <div class="flex space-x-3 mt-6">
                    <button onclick="closeModal('approveModal')" class="flex-1 px-4 py-2.5 border border-gray-200 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition-all">
                        Batal
                    </button>
                    <button onclick="confirmApprove()" class="flex-1 px-4 py-2.5 bg-gradient-to-r from-green-600 to-emerald-500 text-white rounded-xl font-semibold hover:shadow-lg transition-all">
                        Setujui
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal" class="modal hidden">
        <div class="bg-white rounded-2xl max-w-md w-full">
            <div class="p-6">
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 text-center mb-2">Tolak Permintaan?</h3>
                <p class="text-gray-600 text-center mb-4" id="rejectModalMessage">Berikan alasan penolakan kepada peminjam.</p>
                
                <input type="hidden" id="rejectId">
                <input type="hidden" id="rejectMode" value="single">
                
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Alasan Penolakan <span class="text-red-500">*</span></label>
                        <textarea id="rejectReason" rows="3" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500" placeholder="Jelaskan alasan penolakan..." required></textarea>
                    </div>
                </div>

                <div class="flex space-x-3 mt-6">
                    <button onclick="closeModal('rejectModal')" class="flex-1 px-4 py-2.5 border border-gray-200 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition-all">
                        Batal
                    </button>
                    <button onclick="confirmReject()" class="flex-1 px-4 py-2.5 bg-gradient-to-r from-red-600 to-rose-500 text-white rounded-xl font-semibold hover:shadow-lg transition-all">
                        Tolak Permintaan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div id="successModal" class="modal hidden">
        <div class="bg-white rounded-2xl max-w-md w-full">
            <div class="p-6 text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2" id="successTitle">Berhasil!</h3>
                <p class="text-gray-600 mb-6" id="successMessage"></p>
                
                <div id="kodeContainer" class="bg-gray-100 rounded-xl p-4 mb-6 hidden">
                    <p class="text-sm text-gray-600 mb-1">Kode Peminjaman:</p>
                    <p class="text-3xl font-bold tracking-wider text-indigo-600" id="kodePeminjaman"></p>
                </div>
                
                <button onclick="closeModal('successModal')" class="w-full px-4 py-3 bg-gradient-to-r from-indigo-600 to-violet-500 text-white rounded-xl font-semibold hover:shadow-lg transition-all">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- Detail Modal -->
    <div id="detailModal" class="modal hidden">
        <div class="bg-white rounded-2xl max-w-3xl w-full max-h-[90vh] overflow-y-auto p-6">
            <div class="flex justify-between items-start mb-6">
                <h3 class="text-xl font-bold text-gray-900">Detail Peminjaman</h3>
                <button onclick="closeModal('detailModal')" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
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
    // CSRF Token
    const csrfToken = '{{ csrf_token() }}';

    // ================ CEK APAKAH SUDAH ADA SEBELUMNYA ================
    if (typeof window.appFunctions === 'undefined') {
        window.appFunctions = {};
    }

    // ================ SELECT ALL CHECKBOX ================
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize setelah DOM siap
        const selectAll = document.getElementById('selectAll');
        if (selectAll) {
            selectAll.addEventListener('change', function() {
                const checkboxes = document.querySelectorAll('.item-checkbox');
                checkboxes.forEach(cb => cb.checked = this.checked);
                updateSelectedButtons();
            });
        }

        // Add event listeners to checkboxes
        document.querySelectorAll('.item-checkbox').forEach(cb => {
            cb.addEventListener('change', function() {
                const selectAll = document.getElementById('selectAll');
                if (selectAll) {
                    const allCheckboxes = document.querySelectorAll('.item-checkbox');
                    const checkedCheckboxes = document.querySelectorAll('.item-checkbox:checked');
                    selectAll.checked = allCheckboxes.length === checkedCheckboxes.length;
                }
                updateSelectedButtons();
            });
        });

        // Event listeners for filters
        document.getElementById('filterStatus')?.addEventListener('change', applyFilters);
        document.getElementById('filterTipe')?.addEventListener('change', applyFilters);
        document.getElementById('filterKategori')?.addEventListener('change', applyFilters);
        
        // Search with debounce
        let searchTimeout;
        document.getElementById('searchInput')?.addEventListener('keyup', function(e) {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                applyFilters();
            }, 500);
        });

        // Initialize selected buttons state
        updateSelectedButtons();
    });

    // Update selected buttons state
    function updateSelectedButtons() {
        const checkboxes = document.querySelectorAll('.item-checkbox:checked');
        const hasSelected = checkboxes.length > 0;
        const approveBtn = document.getElementById('approveSelectedBtn');
        const rejectBtn = document.getElementById('rejectSelectedBtn');
        if (approveBtn) approveBtn.disabled = !hasSelected;
        if (rejectBtn) rejectBtn.disabled = !hasSelected;
    }

    // ================ FILTER FUNCTIONS ================
    function applyFilters() {
        const url = new URL(window.location.href);
        
        const status = document.getElementById('filterStatus')?.value;
        const tipe = document.getElementById('filterTipe')?.value;
        const kategori = document.getElementById('filterKategori')?.value;
        const search = document.getElementById('searchInput')?.value;
        
        if (status) url.searchParams.set('status', status);
        else url.searchParams.delete('status');
        
        if (tipe) url.searchParams.set('tipe', tipe);
        else url.searchParams.delete('tipe');
        
        if (kategori) url.searchParams.set('kategori', kategori);
        else url.searchParams.delete('kategori');
        
        if (search) url.searchParams.set('search', search);
        else url.searchParams.delete('search');
        
        window.location.href = url.toString();
    }

    function resetFilters() {
        window.location.href = '{{ route("admin.permintaan.index") }}';
    }

    // ================ MODAL FUNCTIONS ================
    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) modal.classList.remove('hidden');
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) modal.classList.add('hidden');
    }

    // ================ APPROVE FUNCTIONS ================
    window.approveItem = function(id) {
        document.getElementById('approveId').value = id;
        document.getElementById('approveModalMessage').innerHTML = 'Apakah Anda yakin ingin menyetujui permintaan peminjaman ini?';
        document.getElementById('approveNote').value = '';
        openModal('approveModal');
    }

    window.confirmApprove = function() {
        const id = document.getElementById('approveId').value;
        const note = document.getElementById('approveNote').value;
        
        const btn = event.currentTarget;
        const originalText = btn.innerHTML;
        btn.innerHTML = '<svg class="animate-spin inline-block w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Menyetujui...';
        btn.disabled = true;
        
        const url = '{{ route("admin.permintaan.approve", ":id") }}'.replace(':id', id);
        console.log('Approve URL:', url);
        
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ note: note })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                closeModal('approveModal');
                
                document.getElementById('successTitle').innerHTML = '✅ Permintaan Disetujui!';
                document.getElementById('successMessage').innerHTML = data.message;
                
                if (data.kode_peminjaman) {
                    document.getElementById('kodePeminjaman').innerHTML = data.kode_peminjaman;
                    document.getElementById('kodeContainer').classList.remove('hidden');
                } else {
                    document.getElementById('kodeContainer').classList.add('hidden');
                }
                
                openModal('successModal');
                
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            } else {
                alert('❌ Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Fetch Error:', error);
            alert('❌ Gagal menyetujui: ' + error.message);
        })
        .finally(() => {
            btn.innerHTML = originalText;
            btn.disabled = false;
        });
    }

    window.approveSelected = function() {
        const checkboxes = document.querySelectorAll('.item-checkbox:checked');
        if (checkboxes.length === 0) {
            alert('Pilih minimal satu permintaan!');
            return;
        }
        
        const ids = Array.from(checkboxes).map(cb => cb.value);
        
        if (!confirm(`✅ Setujui ${ids.length} permintaan yang dipilih?`)) {
            return;
        }
        
        const url = '{{ route("admin.permintaan.approve-selected") }}';
        console.log('Approve Selected URL:', url);
        
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ ids: ids })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('✅ ' + data.message);
                window.location.reload();
            } else {
                alert('❌ Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('❌ Gagal menyetujui: ' + error.message);
        });
    }

    // ================ REJECT FUNCTIONS ================
    window.openRejectModal = function(id) {
        document.getElementById('rejectId').value = id;
        document.getElementById('rejectMode').value = 'single';
        document.getElementById('rejectModalMessage').innerHTML = 'Berikan alasan penolakan kepada peminjam.';
        document.getElementById('rejectReason').value = '';
        openModal('rejectModal');
    }

    window.rejectSelected = function() {
        const checkboxes = document.querySelectorAll('.item-checkbox:checked');
        if (checkboxes.length === 0) {
            alert('Pilih minimal satu permintaan!');
            return;
        }
        
        const ids = Array.from(checkboxes).map(cb => cb.value);
        
        document.getElementById('rejectId').value = ids.join(',');
        document.getElementById('rejectMode').value = 'multiple';
        document.getElementById('rejectModalMessage').innerHTML = `❌ Tolak ${ids.length} permintaan yang dipilih?`;
        document.getElementById('rejectReason').value = '';
        openModal('rejectModal');
    }

    window.confirmReject = function() {
        const id = document.getElementById('rejectId').value;
        const mode = document.getElementById('rejectMode').value;
        const reason = document.getElementById('rejectReason').value.trim();
        
        if (!reason) {
            alert('❌ Alasan penolakan wajib diisi!');
            return;
        }
        
        if (reason.length < 5) {
            alert('❌ Alasan penolakan minimal 5 karakter!');
            return;
        }
        
        const btn = event.currentTarget;
        const originalText = btn.innerHTML;
        btn.innerHTML = '<svg class="animate-spin inline-block w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Menolak...';
        btn.disabled = true;
        
        let url, body;
        
        if (mode === 'single') {
            url = '{{ route("admin.permintaan.reject", ":id") }}'.replace(':id', id);
            body = { alasan_penolakan: reason };
        } else {
            url = '{{ route("admin.permintaan.reject-selected") }}';
            body = { 
                ids: id.split(','),
                alasan_penolakan: reason 
            };
        }
        
        console.log('Reject URL:', url);
        
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify(body)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                closeModal('rejectModal');
                alert('✅ ' + data.message);
                window.location.reload();
            } else {
                alert('❌ Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('❌ Gagal menolak: ' + error.message);
        })
        .finally(() => {
            btn.innerHTML = originalText;
            btn.disabled = false;
        });
    }

    // ================ DETAIL FUNCTIONS ================
    window.showDetail = function(id) {
        const url = '{{ route("admin.permintaan.show", ":id") }}'.replace(':id', id);
        console.log('Detail URL:', url);
        
        fetch(url, {
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => response.json())
        .then(data => {
            const detailContent = document.getElementById('detailContent');
            
            const tipe = data.tipe_pinjam === 'hari' ? 'Per Hari' : 'Per Jam';
            
            let tanggalPinjam, tanggalKembali;
            
            if (data.tipe_pinjam === 'hari') {
                tanggalPinjam = new Date(data.tanggal_pinjam).toLocaleDateString('id-ID', { 
                    day: 'numeric', 
                    month: 'long', 
                    year: 'numeric' 
                });
                tanggalKembali = new Date(data.tanggal_kembali).toLocaleDateString('id-ID', { 
                    day: 'numeric', 
                    month: 'long', 
                    year: 'numeric' 
                });
            } else {
                tanggalPinjam = new Date(data.tanggal_pinjam_jam).toLocaleDateString('id-ID', { 
                    day: 'numeric', 
                    month: 'long', 
                    year: 'numeric' 
                }) + ' ' + data.jam_pinjam;
                tanggalKembali = new Date(data.tanggal_pinjam_jam).toLocaleDateString('id-ID', { 
                    day: 'numeric', 
                    month: 'long', 
                    year: 'numeric' 
                }) + ' ' + data.jam_kembali;
            }
            
            const imagePath = data.barang.gambar 
                ? `/storage/${data.barang.gambar}`
                : 'https://images.unsplash.com/photo-1593642632823-8f785ba67e45?w=400';
            
            detailContent.innerHTML = `
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div>
                        <img src="${imagePath}" alt="${data.barang.nama_barang}" class="w-full h-64 object-cover rounded-xl">
                    </div>
                    <div>
                        <div class="mb-4">
                            <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-bold">Menunggu Persetujuan</span>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">${data.barang.nama_barang}</h2>
                        <p class="text-gray-600 mb-4">Kode: BRG-${String(data.barang.id).padStart(3, '0')}</p>
                        
                        <div class="bg-gray-50 rounded-xl p-4 mb-4">
                            <h3 class="font-bold text-gray-900 mb-2">Informasi Peminjam</h3>
                            <div class="space-y-2 text-sm">
                                <p><span class="font-medium">Nama:</span> ${data.user.name}</p>
                                <p><span class="font-medium">Role:</span> ${data.user.role || 'Siswa'}</p>
                                <p><span class="font-medium">Email:</span> ${data.user.email || '-'}</p>
                            </div>
                        </div>
                        
                        <div class="bg-gray-50 rounded-xl p-4 mb-4">
                            <h3 class="font-bold text-gray-900 mb-2">Detail Peminjaman</h3>
                            <div class="space-y-2 text-sm">
                                <p><span class="font-medium">Tipe:</span> ${tipe}</p>
                                <p><span class="font-medium">Tanggal Pinjam:</span> ${tanggalPinjam}</p>
                                <p><span class="font-medium">Tanggal Kembali:</span> ${tanggalKembali}</p>
                                <p><span class="font-medium">Jumlah:</span> ${data.jumlah} unit</p>
                                <p><span class="font-medium">Stok Tersedia:</span> ${data.barang.jumlah} unit</p>
                            </div>
                        </div>
                        
                        <div class="bg-gray-50 rounded-xl p-4">
                            <h3 class="font-bold text-gray-900 mb-2">Alasan Peminjaman</h3>
                            <p class="text-sm text-gray-700">${data.alasan || '-'}</p>
                        </div>
                    </div>
                </div>
            `;
            
            openModal('detailModal');
        })
        .catch(error => {
            console.error('Error:', error);
            alert('❌ Gagal mengambil detail peminjaman: ' + error.message);
        });
    }

    // ================ MOBILE MENU ================
    // Hapus deklarasi variable sidebar di sini, pindahkan ke dalam event listener
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const sidebar = document.querySelector('aside');
        
        if (mobileMenuButton && sidebar) {
            // Hapus event listener lama dengan clone node
            const newButton = mobileMenuButton.cloneNode(true);
            mobileMenuButton.parentNode.replaceChild(newButton, mobileMenuButton);
            
            newButton.addEventListener('click', function() {
                sidebar.classList.toggle('-translate-x-full');
            });
        }
    });

    // ================ CLOSE MODAL OUTSIDE ================
    window.addEventListener('click', function(e) {
        if (e.target.classList.contains('modal')) {
            e.target.classList.add('hidden');
        }
    });

    // Hapus semua deklarasi variable global yang tidak perlu
    // Hapus: currentApproveId, searchTimeout, dll yang double
</script>
</body>
</html>