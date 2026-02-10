<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pengguna - SarPras</title>
    @vite('resources/css/app.css')
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
        
        .tab-active {
            background: linear-gradient(135deg, #2563eb 0%, #06b6d4 100%);
            color: white;
            box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.2);
        }
        
        .tab-inactive {
            background-color: #f3f4f6;
            color: #374151;
        }
        
        .tab-inactive:hover {
            background-color: #e5e7eb;
        }
        
        /* Badge status */
        .badge-aktif {
            background-color: #dcfce7;
            color: #166534;
        }
        
        .badge-nonaktif {
            background-color: #fee2e2;
            color: #991b1b;
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
                            <h1 class="text-2xl font-bold text-gray-900">Data Pengguna</h1>
                            <p class="text-sm text-gray-500 mt-0.5">Kelola data petugas dan siswa</p>
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
                                    document.getElementById('success-notification').remove();
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
                    <div class="flex items-center space-x-3">
                        <!-- Tombol tambah dengan style yang sama -->
                        <button id="tambahPenggunaBtn" class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-cyan-500 text-white rounded-xl font-semibold hover:shadow-lg hover:shadow-blue-300 transition-all flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span>Tambah Pengguna</span>
                        </button>
                    </div>
                </div>

                <!-- Stats Cards (Data Dinamis dari Controller) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-gray-600 text-sm font-medium mb-1">Total Pengguna</h3>
                        <p class="text-3xl font-bold text-gray-900">{{ $totalPengguna }}</p>
                    </div>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-cyan-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-gray-600 text-sm font-medium mb-1">Petugas</h3>
                        <p class="text-3xl font-bold text-gray-900">{{ $totalPetugas }}</p>
                    </div>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-gray-600 text-sm font-medium mb-1">Siswa</h3>
                        <p class="text-3xl font-bold text-gray-900">{{ $totalSiswa }}</p>
                    </div>
                </div>

                <!-- Tabs & Table -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <!-- Tabs Header -->
                    <div class="border-b border-gray-200">
                        <div class="px-6 py-4">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">
                                <div class="flex space-x-2">
                                    <button id="tab-petugas" class="tab-button px-6 py-2.5 tab-active rounded-lg font-semibold transition-all">
                                        Petugas ({{ $totalPetugas }})
                                    </button>
                                    <button id="tab-siswa" class="tab-button px-6 py-2.5 tab-inactive rounded-lg font-semibold transition-all">
                                        Siswa ({{ $totalSiswa }})
                                    </button>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <div class="relative">
                                        <input type="text" id="searchInput" placeholder="Cari pengguna..." class="pl-10 pr-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 w-full md:w-64">
                                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Table Petugas -->
                    <div id="content-petugas" class="tab-content">
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50 border-b border-gray-100">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama</th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">NIP</th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Jabatan</th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Email</th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @forelse($petugas as $user)
                                    <tr class="hover:bg-gray-50 user-row" data-name="{{ strtolower($user->name) }}" data-status="{{ $user->status }}">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-cyan-400 rounded-full flex items-center justify-center text-white font-semibold mr-3">
                                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                                </div>
                                                <div>
                                                    <p class="text-sm font-semibold text-gray-900">{{ $user->name }}</p>
                                                    <p class="text-xs text-gray-500">Petugas</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">{{ $user->nip ?? '-' }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-900">{{ $user->jabatan ?? 'Petugas' }}</td>
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
                                                <form action="{{ route('admin.pengguna.destroy', $user->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onclick="return confirm('Yakin hapus pengguna ini?')" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
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
                                            Belum ada data petugas
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination Petugas -->
                        @if($petugas->hasPages())
                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                            {{ $petugas->appends(['petugas_page' => $petugas->currentPage()])->links('vendor.pagination.tailwind') }}
                        </div>
                        @endif
                    </div>

                    <!-- Table Siswa -->
                    <div id="content-siswa" class="tab-content hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50 border-b border-gray-100">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama</th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">NISN</th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kelas</th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Email</th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @forelse($siswa as $user)
                                    <tr class="hover:bg-gray-50 user-row" data-name="{{ strtolower($user->name) }}" data-status="{{ $user->status }}">
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
                                                <form action="{{ route('admin.pengguna.destroy', $user->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onclick="return confirm('Yakin hapus pengguna ini?')" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
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
                        
                        <!-- Pagination Siswa -->
                        @if($siswa->hasPages())
                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                            {{ $siswa->appends(['siswa_page' => $siswa->currentPage()])->links('vendor.pagination.tailwind') }}
                        </div>
                        @endif
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- MODAL TAMBAH PENGGUNA -->
    <div id="addUserModal" class="modal-overlay hidden">
        <div class="modal-content">
            <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between rounded-t-2xl">
                <h3 class="text-xl font-bold text-gray-900">Tambah Pengguna Baru</h3>
                <button type="button" id="closeAddModal" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="p-6">
                <form id="addUserForm" action="{{ route('admin.pengguna.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Role Pengguna <span class="text-red-500">*</span></label>
                        <select id="roleSelect" name="role" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            <option value="">-- Pilih Role --</option>
                            <option value="petugas">Petugas</option>
                            <option value="siswa">Siswa</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="name" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Nama lengkap pengguna" required />
                    </div>

                    <!-- Untuk Petugas: Email -->
                    <div id="emailContainer">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Email Login <span class="text-red-500">*</span></label>
                        <input type="email" name="email" id="emailInput" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="email@sekolah.sch.id" />
                        <p class="text-xs text-gray-500 mt-1">Email wajib diisi untuk Petugas.</p>
                    </div>

                    <!-- Untuk Siswa: NISN dan Kelas -->
                    <div id="siswaContainer" class="hidden bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <p class="text-sm font-semibold text-blue-600 mb-3">Data Khusus Siswa</p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">NISN (Untuk Login) <span class="text-red-500">*</span></label>
                                <input type="number" name="nisn" id="nisnInput" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Contoh: 00567890" />
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Kelas <span class="text-red-500">*</span></label>
                                <input type="text" name="kelas" id="kelasInput" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Contoh: XII RPL 1" />
                            </div>
                        </div>
                    </div>

                    <!-- Untuk Petugas: NIP dan Jabatan -->
                    <div id="petugasContainer" class="hidden bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <p class="text-sm font-semibold text-blue-600 mb-3">Data Khusus Petugas</p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">NIP (Opsional)</label>
                                <input type="text" name="nip" id="nipInput" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Contoh: 198501012010012001" />
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Jabatan (Opsional)</label>
                                <input type="text" name="jabatan" id="jabatanInput" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Contoh: Guru Matematika" />
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Password <span class="text-red-500">*</span></label>
                        <input type="password" name="password" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Minimal 6 karakter" required />
                    </div>

                    <div class="flex justify-end space-x-3 pt-4">
                        <button type="button" id="cancelAddBtn" class="px-5 py-2.5 border border-gray-200 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition-all">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-cyan-500 text-white rounded-xl font-semibold hover:shadow-lg hover:shadow-blue-300 transition-all">
                            Simpan Pengguna
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL DETAIL PENGGUNA -->
    <div id="viewUserModal" class="modal-overlay hidden">
        <div class="modal-content max-w-2xl">
            <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between rounded-t-2xl">
                <h3 class="text-xl font-bold text-gray-900">Detail Pengguna</h3>
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
        // Debug - Pastikan script berjalan
        console.log('Script Data Pengguna loaded successfully');
        
        // Deklarasi variabel
        let sidebarElement;
        
        // Fungsi untuk modal
        function showAddUserModal() {
            console.log('showAddUserModal called');
            const modal = document.getElementById('addUserModal');
            if (modal) {
                modal.classList.remove('hidden');
                console.log('Modal should be visible now');
            } else {
                console.error('Add user modal not found!');
            }
        }
        
        function hideAddUserModal() {
            const modal = document.getElementById('addUserModal');
            if (modal) {
                modal.classList.add('hidden');
                // Reset form
                const form = document.getElementById('addUserForm');
                if (form) form.reset();
                // Reset tampilan
                document.getElementById('siswaContainer').classList.add('hidden');
                document.getElementById('petugasContainer').classList.add('hidden');
                document.getElementById('emailContainer').classList.remove('hidden');
                document.getElementById('emailInput').setAttribute('required', 'required');
            }
        }
        
        function viewUser(userData) {
            const modal = document.getElementById('viewUserModal');
            const contentDiv = document.getElementById('userDetailContent');
            
            // Tentukan warna avatar berdasarkan role
            const avatarColor = userData.role === 'siswa' 
                ? 'from-green-500 to-teal-400' 
                : 'from-blue-500 to-cyan-400';
            
            // Tentukan label NIP/NISN
            const idLabel = userData.role === 'siswa' ? 'NISN' : 'NIP';
            const idValue = userData.role === 'siswa' ? (userData.nisn || '-') : (userData.nip || '-');
            
            // Tentukan label kelas/jabatan
            const detailLabel = userData.role === 'siswa' ? 'Kelas' : 'Jabatan';
            const detailValue = userData.role === 'siswa' ? (userData.kelas || '-') : (userData.jabatan || '-');
            
            // Buat konten detail
            contentDiv.innerHTML = `
                <div class="flex items-center mb-6">
                    <div class="w-16 h-16 bg-gradient-to-br ${avatarColor} rounded-full flex items-center justify-center text-white font-semibold text-xl mr-4">
                        ${userData.name.substring(0, 2).toUpperCase()}
                    </div>
                    <div>
                        <h4 class="text-lg font-bold text-gray-900">${userData.name}</h4>
                        <p class="text-sm text-gray-600 capitalize">${userData.role}</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">${idLabel}</label>
                        <p class="text-gray-900">${idValue}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">${detailLabel}</label>
                        <p class="text-gray-900">${detailValue}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                        <p class="text-gray-900">${userData.email}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Role</label>
                        <p class="text-gray-900 capitalize">${userData.role}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Dibuat</label>
                        <p class="text-gray-900">${new Date(userData.created_at).toLocaleDateString('id-ID')}</p>
                    </div>
                </div>
            `;
            
            if (modal) {
                modal.classList.remove('hidden');
            }
        }
        
        function hideViewUserModal() {
            const modal = document.getElementById('viewUserModal');
            if (modal) {
                modal.classList.add('hidden');
            }
        }
        
        function editUser(userId) {
            // Redirect ke halaman edit
            window.location.href = `/admin/pengguna/${userId}/edit`;
        }
        
        function confirmDelete() {
            return confirm('Apakah Anda yakin ingin menghapus pengguna ini?');
        }
        
        // Tab switching function
        function switchTab(tab) {
            // Hide all content
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });
            
            // Remove active state from all tabs
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('tab-active');
                button.classList.add('tab-inactive');
            });
            
            // Show selected content
            document.getElementById(`content-${tab}`).classList.remove('hidden');
            
            // Add active state to selected tab
            const activeTab = document.getElementById(`tab-${tab}`);
            activeTab.classList.remove('tab-inactive');
            activeTab.classList.add('tab-active');
        }
        
        // Fungsi untuk filter pencarian
        function filterUsers() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const statusFilter = document.getElementById('statusFilter').value;
            const currentTab = document.querySelector('.tab-active').id.replace('tab-', '');
            
            // Ambil semua baris di tab aktif
            const rows = document.querySelectorAll(`#content-${currentTab} .user-row`);
            
            rows.forEach(row => {
                const name = row.getAttribute('data-name');
                const status = row.getAttribute('data-status');
                
                const matchesSearch = name.includes(searchTerm);
                const matchesStatus = !statusFilter || status === statusFilter;
                
                if (matchesSearch && matchesStatus) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
        
        // Inisialisasi event listeners setelah DOM siap
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM fully loaded - Data Pengguna');
            
            // Setup untuk tombol tambah pengguna
            const tambahBtn = document.getElementById('tambahPenggunaBtn');
            if (tambahBtn) {
                tambahBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    showAddUserModal();
                });
            }
            
            // Setup untuk tombol close modal tambah
            const closeAddBtn = document.getElementById('closeAddModal');
            const cancelAddBtn = document.getElementById('cancelAddBtn');
            if (closeAddBtn) closeAddBtn.addEventListener('click', hideAddUserModal);
            if (cancelAddBtn) cancelAddBtn.addEventListener('click', hideAddUserModal);
            
            // Setup untuk tombol close modal view
            const closeViewBtn = document.getElementById('closeViewBtn');
            const closeViewModal = document.getElementById('closeViewModal');
            if (closeViewBtn) closeViewBtn.addEventListener('click', hideViewUserModal);
            if (closeViewModal) closeViewModal.addEventListener('click', hideViewUserModal);
            
            // Setup untuk tab switching
            const tabPetugas = document.getElementById('tab-petugas');
            const tabSiswa = document.getElementById('tab-siswa');
            if (tabPetugas) tabPetugas.addEventListener('click', () => switchTab('petugas'));
            if (tabSiswa) tabSiswa.addEventListener('click', () => switchTab('siswa'));
            
            // Setup untuk form role selection
            const roleSelect = document.getElementById('roleSelect');
            const emailContainer = document.getElementById('emailContainer');
            const emailInput = document.getElementById('emailInput');
            const siswaContainer = document.getElementById('siswaContainer');
            const petugasContainer = document.getElementById('petugasContainer');
            const nisnInput = document.getElementById('nisnInput');
            const kelasInput = document.getElementById('kelasInput');
            const nipInput = document.getElementById('nipInput');
            const jabatanInput = document.getElementById('jabatanInput');
            
            if (roleSelect) {
                roleSelect.addEventListener('change', function() {
                    if (this.value === 'siswa') {
                        // Kondisi: SISWA DIPILIH
                        emailContainer.classList.add('hidden');
                        siswaContainer.classList.remove('hidden');
                        petugasContainer.classList.add('hidden');
                        
                        emailInput.removeAttribute('required');
                        emailInput.value = '';
                        
                        nisnInput.setAttribute('required', 'required');
                        kelasInput.setAttribute('required', 'required');
                        nipInput.removeAttribute('required');
                        jabatanInput.removeAttribute('required');
                    } else if (this.value === 'petugas') {
                        // Kondisi: PETUGAS DIPILIH
                        emailContainer.classList.remove('hidden');
                        siswaContainer.classList.add('hidden');
                        petugasContainer.classList.remove('hidden');
                        
                        emailInput.setAttribute('required', 'required');
                        
                        nisnInput.removeAttribute('required');
                        kelasInput.removeAttribute('required');
                        nipInput.removeAttribute('required');
                        jabatanInput.removeAttribute('required');
                    } else {
                        // Reset
                        emailContainer.classList.remove('hidden');
                        siswaContainer.classList.add('hidden');
                        petugasContainer.classList.add('hidden');
                    }
                });
            }
            
            // Setup untuk filter pencarian
            const searchInput = document.getElementById('searchInput');
            const statusFilter = document.getElementById('statusFilter');
            if (searchInput) searchInput.addEventListener('input', filterUsers);
            if (statusFilter) statusFilter.addEventListener('change', filterUsers);
            
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
                    hideAddUserModal();
                    hideViewUserModal();
                }
            });
            
            // Close modal dengan klik di luar
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
        });
        
        // Export fungsi ke global scope
        window.showAddUserModal = showAddUserModal;
        window.hideAddUserModal = hideAddUserModal;
        window.viewUser = viewUser;
        window.hideViewUserModal = hideViewUserModal;
        window.editUser = editUser;
        window.switchTab = switchTab;
    </script>
</body>
</html>