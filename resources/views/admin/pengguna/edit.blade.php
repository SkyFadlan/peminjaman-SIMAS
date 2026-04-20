<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengguna - SarPras</title>
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
        
        .badge-aktif {
            background-color: #dcfce7;
            color: #166534;
        }
        
        .badge-nonaktif {
            background-color: #fee2e2;
            color: #991b1b;
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
                            <h1 class="text-2xl font-bold text-gray-900">Edit Pengguna</h1>
                            <p class="text-sm text-gray-500 mt-0.5">Ubah data pengguna</p>
                        </div>

                        <!-- Right Side Actions -->
                        <div class="flex items-center space-x-3">
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
                <!-- Breadcrumb -->
                <div class="mb-6">
                    <nav class="flex" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-3">
                            <li class="inline-flex items-center">
                                <a href="{{ route('admin.pengguna.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
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
                                    <a href="{{ route('admin.pengguna.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">Data Pengguna</a>
                                </div>
                            </li>
                            <li aria-current="page">
                                <div class="flex items-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Edit Pengguna</span>
                                </div>
                            </li>
                        </ol>
                    </nav>
                </div>

                <!-- Form Edit Pengguna -->
                <div class="max-w-3xl mx-auto">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <!-- Header Form -->
                        <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-cyan-50 border-b border-gray-200">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-400 rounded-full flex items-center justify-center text-white font-semibold text-lg mr-4">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </div>
                                <div>
                                    <h2 class="text-xl font-bold text-gray-900">Edit Data Pengguna</h2>
                                    <p class="text-sm text-gray-600">ID Pengguna: #{{ $user->id }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Form Body -->
                        <form action="{{ route('admin.pengguna.update', $user->id) }}" method="POST" class="p-6">
                            @csrf
                            @method('PUT')
                            
                            <!-- Role Info (Read-only) -->
                            <div class="form-group bg-gray-50 p-4 rounded-lg border border-gray-200 mb-6">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-semibold text-gray-700">Role Pengguna:</span>
                                    <span class="px-3 py-1 {{ $user->role == 'siswa' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }} rounded-full text-sm font-semibold">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </div>
                                <input type="hidden" name="role" value="{{ $user->role }}">
                                <p class="text-xs text-gray-500 mt-2">Role tidak dapat diubah</p>
                            </div>
                            
                            <!-- Nama Lengkap -->
                            <div class="form-group">
                                <label for="name" class="form-label">Nama Lengkap <span class="text-red-500">*</span></label>
                                <input type="text" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $user->name) }}" 
                                       class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror"
                                       placeholder="Masukkan nama lengkap"
                                       required>
                                @error('name')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Conditional Fields based on Role -->
                            @if($user->role === 'siswa')
                                <!-- Fields untuk Siswa -->
                                <div class="bg-blue-50 p-4 rounded-lg border border-blue-200 mb-4">
                                    <h3 class="text-sm font-semibold text-blue-700 mb-3 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"></path>
                                        </svg>
                                        Data Khusus Siswa
                                    </h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label for="nisn" class="block text-sm font-semibold text-gray-700 mb-2">NISN <span class="text-red-500">*</span></label>
                                            <input type="number" 
                                                   id="nisn" 
                                                   name="nisn" 
                                                   value="{{ old('nisn', $user->nisn) }}" 
                                                   class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nisn') border-red-500 @enderror"
                                                   placeholder="Contoh: 00567890"
                                                   required>
                                            @error('nisn')
                                                <p class="error-message">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="kelas" class="block text-sm font-semibold text-gray-700 mb-2">Kelas <span class="text-red-500">*</span></label>
                                            <input type="text" 
                                                   id="kelas" 
                                                   name="kelas" 
                                                   value="{{ old('kelas', $user->kelas) }}" 
                                                   class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('kelas') border-red-500 @enderror"
                                                   placeholder="Contoh: XII RPL 1"
                                                   required>
                                            @error('kelas')
                                                <p class="error-message">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            @else
                                <!-- Fields untuk Petugas -->
                                <div class="bg-cyan-50 p-4 rounded-lg border border-cyan-200 mb-4">
                                    <h3 class="text-sm font-semibold text-cyan-700 mb-3 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                                            <path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z"></path>
                                        </svg>
                                        Data Khusus Petugas
                                    </h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
                                            <input type="email" 
                                                   id="email" 
                                                   name="email" 
                                                   value="{{ old('email', $user->email) }}" 
                                                   class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror"
                                                   placeholder="email@sekolah.sch.id"
                                                   required>
                                            @error('email')
                                                <p class="error-message">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="nip" class="block text-sm font-semibold text-gray-700 mb-2">NIP (Opsional)</label>
                                            <input type="text" 
                                                   id="nip" 
                                                   name="nip" 
                                                   value="{{ old('nip', $user->nip) }}" 
                                                   class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                   placeholder="Contoh: 198501012010012001">
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <label for="jabatan" class="block text-sm font-semibold text-gray-700 mb-2">Jabatan (Opsional)</label>
                                        <input type="text" 
                                               id="jabatan" 
                                               name="jabatan" 
                                               value="{{ old('jabatan', $user->jabatan) }}" 
                                               class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                               placeholder="Contoh: Guru Matematika">
                                    </div>
                                </div>
                            @endif

                            <!-- Status -->
                            <div class="form-group">
                                <label for="status" class="form-label">Status Akun</label>
                                <select id="status" name="status" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="aktif" {{ $user->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="nonaktif" {{ $user->status == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                </select>
                                <p class="text-xs text-gray-500 mt-1">Status nonaktif akan mencegah user login</p>
                            </div>

                            <!-- Info Tambahan -->
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 mb-4">
                                <h3 class="text-sm font-semibold text-gray-700 mb-2">Informasi Akun</h3>
                                <div class="grid grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <span class="text-gray-500">ID Pengguna:</span>
                                        <span class="font-semibold ml-2">#{{ $user->id }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-500">Dibuat pada:</span>
                                        <span class="font-semibold ml-2">{{ $user->created_at->format('d/m/Y H:i') }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-500">Terakhir diupdate:</span>
                                        <span class="font-semibold ml-2">{{ $user->updated_at->format('d/m/Y H:i') }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                                <a href="{{ route('admin.pengguna.index') }}" 
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
                                    Update Pengguna
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
                                    <span class="font-semibold">Tips:</span> Jika ingin mengubah password, gunakan fitur reset password atau edit melalui halaman terpisah.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- SCRIPT -->
    <script>
        // Debug - Pastikan script berjalan
        console.log('Script Edit Pengguna loaded successfully');
        
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
        });

        // Confirm before leaving with unsaved changes
        let formChanged = false;
        const form = document.querySelector('form');
        if (form) {
            const inputs = form.querySelectorAll('input, select, textarea');
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