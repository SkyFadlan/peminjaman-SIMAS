<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa - SarPras</title>
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
                            <h1 class="text-2xl font-bold text-gray-900">Data Siswa</h1>
                            <p class="text-sm text-gray-500 mt-0.5">Kelola data siswa</p>
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
                                    const notif = document.getElementById('success-notification');
                                    if (notif) notif.remove();
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
            <main class="p-4 sm:p-6 lg:px-8">
                <!-- Action Bar -->
                <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="flex flex-wrap items-center gap-3">
                        <!-- Tombol Tambah Siswa -->
                        <button id="tambahPenggunaBtn" class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-cyan-500 text-white rounded-xl font-semibold hover:shadow-lg hover:shadow-blue-300 transition-all flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span>Tambah Siswa</span>
                        </button>

                        <!-- Tombol Import Siswa -->
                        <a href="{{ route('admin.pengguna.import.form') }}" 
                           class="px-5 py-2.5 bg-gradient-to-r from-emerald-600 to-teal-500 text-white rounded-xl font-semibold hover:shadow-lg hover:shadow-emerald-300 transition-all flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                            </svg>
                            <span>Import Siswa</span>
                        </a>

                        <!-- Dropdown Export -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="px-5 py-2.5 bg-white border border-gray-200 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition-all flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                                <span>Export</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="open" @click.away="open = false" class="absolute left-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-200 z-50 py-2">
                                <div class="px-4 py-2 text-xs font-semibold text-gray-500 border-b border-gray-100">EXPORT DATA</div>
                                <a href="{{ route('admin.pengguna.export.excel') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center">
                                    <svg class="w-4 h-4 mr-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Excel - Semua Siswa
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Alpine.js untuk dropdown -->
                <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-gray-600 text-sm font-medium mb-1">Total Siswa</h3>
                        <p class="text-3xl font-bold text-gray-900">{{ $totalSiswa }}</p>
                    </div>
                    
                </div>

                <!-- Table Siswa -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <!-- Filter Bar -->
                    <div class="border-b border-gray-200 px-6 py-4">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div class="flex items-center space-x-3">
                                <div class="relative">
                                    <input type="text" id="searchInput" placeholder="Cari siswa..." class="pl-10 pr-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 w-full md:w-64">
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
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">NISN</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kelas</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($siswa as $user)
                                <tr class="hover:bg-gray-50 user-row" data-name="{{ strtolower($user->name) }}">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-teal-400 rounded-full flex items-center justify-center text-white font-semibold mr-3">
                                                {{ strtoupper(substr($user->name, 0, 2)) }}
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-gray-900">{{ $user->name }}</p>
                                                <p class="text-xs text-gray-500">Siswa</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $user->nisn ?? '-' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $user->kelas ?? '-' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $user->email }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-2">
                                            <button onclick="viewUser({{ json_encode($user) }})" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Detail">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </button>
                                            <button onclick="editUser({{ $user->id }})" class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors" title="Edit">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </button>
                                            <form action="{{ route('admin.pengguna.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus siswa ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
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
                                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                        Belum ada data siswa
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    @if($siswa->hasPages())
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                        <div class="flex flex-col items-center space-y-2">
                            <div class="text-sm text-gray-700">
                                Menampilkan {{ $siswa->firstItem() }} - {{ $siswa->lastItem() }} 
                                dari {{ $siswa->total() }} data
                            </div>
                            <div class="flex items-center space-x-1">
                                @if($siswa->onFirstPage())
                                    <span class="px-3 py-1 text-gray-400 bg-gray-100 rounded cursor-not-allowed">Previous</span>
                                @else
                                    <a href="{{ $siswa->previousPageUrl() }}" class="px-3 py-1 text-blue-600 bg-blue-50 rounded hover:bg-blue-100">Previous</a>
                                @endif

                                @foreach($siswa->getUrlRange(1, $siswa->lastPage()) as $page => $url)
                                    @if($page == $siswa->currentPage())
                                        <span class="px-3 py-1 text-white bg-blue-600 rounded">{{ $page }}</span>
                                    @else
                                        <a href="{{ $url }}" class="px-3 py-1 text-gray-600 bg-gray-100 rounded hover:bg-gray-200">{{ $page }}</a>
                                    @endif
                                @endforeach

                                @if($siswa->hasMorePages())
                                    <a href="{{ $siswa->nextPageUrl() }}" class="px-3 py-1 text-blue-600 bg-blue-50 rounded hover:bg-blue-100">Next</a>
                                @else
                                    <span class="px-3 py-1 text-gray-400 bg-gray-100 rounded cursor-not-allowed">Next</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </main>
        </div>
    </div>

    <!-- MODAL TAMBAH SISWA -->
    <div id="addUserModal" class="modal-overlay hidden">
        <div class="modal-content">
            <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between rounded-t-2xl">
                <h3 class="text-xl font-bold text-gray-900">Tambah Siswa Baru</h3>
                <button type="button" id="closeAddModal" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="p-6">
                <form id="addUserForm" action="{{ route('admin.pengguna.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="role" value="siswa">
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="name" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Nama lengkap siswa" required />
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">NISN <span class="text-red-500">*</span></label>
                        <input type="number" name="nisn" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Contoh: 00567890" required />
                        <p class="text-xs text-gray-500 mt-1">NISN akan digunakan sebagai email login (nisn@siswa.com)</p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Kelas <span class="text-red-500">*</span></label>
                        <input type="text" name="kelas" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Contoh: XII RPL 1" required />
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Password <span class="text-red-500">*</span></label>
                        <input type="password" name="password" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Minimal 8 karakter" required />
                    </div>

                    <div class="flex justify-end space-x-3 pt-4">
                        <button type="button" id="cancelAddBtn" class="px-5 py-2.5 border border-gray-200 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition-all">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-cyan-500 text-white rounded-xl font-semibold hover:shadow-lg hover:shadow-blue-300 transition-all">
                            Simpan Siswa
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL DETAIL SISWA -->
    <div id="viewUserModal" class="modal-overlay hidden">
        <div class="modal-content max-w-2xl">
            <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between rounded-t-2xl">
                <h3 class="text-xl font-bold text-gray-900">Detail Siswa</h3>
                <button type="button" id="closeViewModal" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="p-6">
                <div id="userDetailContent">
                    <!-- Konten akan diisi oleh JavaScript -->
                </div>
                <div class="mt-6 flex justify-end">
                    <button type="button" id="closeViewBtn" class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-cyan-500 text-white rounded-xl font-semibold hover:shadow-lg hover:shadow-blue-300 transition-all">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

        <!-- SCRIPT -->
    <script>
        // Debug
        console.log('Script Data Siswa loaded successfully');
        
        let sidebarElement;
        
        // Fungsi modal
        function showAddUserModal() {
            const modal = document.getElementById('addUserModal');
            if (modal) modal.classList.remove('hidden');
        }
        
        function hideAddUserModal() {
            const modal = document.getElementById('addUserModal');
            if (modal) {
                modal.classList.add('hidden');
                const form = document.getElementById('addUserForm');
                if (form) form.reset();
            }
        }
        
        function viewUser(userData) {
            const modal = document.getElementById('viewUserModal');
            const contentDiv = document.getElementById('userDetailContent');
            
            // Debug: lihat data yang diterima
            console.log('User Data:', userData);
            console.log('NISN:', userData.nisn);
            console.log('Kelas:', userData.kelas);
            
            // Pastikan data ada, jika tidak kasih nilai default
            const nisnValue = userData.nisn || '-';
            const kelasValue = userData.kelas || '-';
            const emailValue = userData.email || '-';
            const createdAt = userData.created_at ? new Date(userData.created_at).toLocaleDateString('id-ID') : '-';
            
            contentDiv.innerHTML = `
                <div class="flex items-center mb-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-teal-400 rounded-full flex items-center justify-center text-white font-semibold text-xl mr-4">
                        ${userData.name ? userData.name.substring(0, 2).toUpperCase() : '??'}
                    </div>
                    <div>
                        <h4 class="text-lg font-bold text-gray-900">${userData.name || '-'}</h4>
                        <p class="text-sm text-gray-600">Siswa</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">NISN</label>
                        <p class="text-gray-900">${nisnValue}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Kelas</label>
                        <p class="text-gray-900">${kelasValue}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                        <p class="text-gray-900">${emailValue}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Dibuat</label>
                        <p class="text-gray-900">${createdAt}</p>
                    </div>
                </div>
            `;
            
            if (modal) modal.classList.remove('hidden');
        }
        
        function hideViewUserModal() {
            const modal = document.getElementById('viewUserModal');
            if (modal) modal.classList.add('hidden');
        }
        
        function editUser(userId) {
            window.location.href = `/admin/pengguna/${userId}/edit`;
        }
        
        function filterUsers() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const rows = document.querySelectorAll('.user-row');
            
            rows.forEach(row => {
                const name = row.getAttribute('data-name');
                const matchesSearch = name ? name.includes(searchTerm) : false;
                
                if (matchesSearch) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
        
        // Inisialisasi
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded - Initializing...');
            
            // Tombol tambah
            const tambahBtn = document.getElementById('tambahPenggunaBtn');
            if (tambahBtn) {
                tambahBtn.addEventListener('click', showAddUserModal);
                console.log('Tombol tambah ditemukan');
            } else {
                console.error('Tombol tambah tidak ditemukan');
            }
            
            // Tombol close modal
            const closeAddBtn = document.getElementById('closeAddModal');
            const cancelAddBtn = document.getElementById('cancelAddBtn');
            if (closeAddBtn) closeAddBtn.addEventListener('click', hideAddUserModal);
            if (cancelAddBtn) cancelAddBtn.addEventListener('click', hideAddUserModal);
            
            // Tombol close view modal
            const closeViewBtn = document.getElementById('closeViewBtn');
            const closeViewModal = document.getElementById('closeViewModal');
            if (closeViewBtn) closeViewBtn.addEventListener('click', hideViewUserModal);
            if (closeViewModal) closeViewModal.addEventListener('click', hideViewUserModal);
            
            // Filter
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                searchInput.addEventListener('input', filterUsers);
                console.log('Search input ditemukan');
            }
            
            // Mobile menu
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            sidebarElement = document.querySelector('aside');
            if (mobileMenuButton && sidebarElement) {
                mobileMenuButton.addEventListener('click', () => {
                    sidebarElement.classList.toggle('-translate-x-full');
                });
            }
            
            // Close dengan ESC
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    hideAddUserModal();
                    hideViewUserModal();
                }
            });
            
            // Close klik di luar modal
            document.addEventListener('click', function(e) {
                const addModal = document.getElementById('addUserModal');
                const viewModal = document.getElementById('viewUserModal');
                
                if (addModal && !addModal.classList.contains('hidden') && e.target === addModal) {
                    hideAddUserModal();
                }
                if (viewModal && !viewModal.classList.contains('hidden') && e.target === viewModal) {
                    hideViewUserModal();
                }
            });
            
            console.log('Initialization complete');
        });
        
        // Export ke global
        window.showAddUserModal = showAddUserModal;
        window.hideAddUserModal = hideAddUserModal;
        window.viewUser = viewUser;
        window.hideViewUserModal = hideViewUserModal;
        window.editUser = editUser;
        window.filterUsers = filterUsers;
    </script>
</body>
</html>