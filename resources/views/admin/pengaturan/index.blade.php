<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Sistem - SarPras</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .toggle-checkbox:checked {
            background-color: #0ea5e9;
            border-color: #0ea5e9;
        }
        .toggle-checkbox:checked + .toggle-label {
            left: 1.25rem;
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
                            <h1 class="text-2xl font-bold text-gray-900">Pengaturan Sistem</h1>
                            <p class="text-sm text-gray-500 mt-0.5">Konfigurasi dan kelola sistem SarPras</p>
                        </div>

                        <!-- Right Side Actions -->
                        <div class="flex items-center space-x-3">
                            <button class="p-2 text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </button>
                            <button class="relative p-2 text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                </svg>
                                <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                            </button>
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
                <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                    <!-- Settings Menu Sidebar -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 sticky top-24">
                            <h3 class="text-sm font-bold text-gray-900 mb-3 px-3">Menu Pengaturan</h3>
                            <nav class="space-y-1">
                                <button onclick="showSection('general')" class="settings-menu-item active w-full flex items-center space-x-3 px-3 py-2.5 rounded-lg text-left transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span class="font-medium">Umum</span>
                                </button>
                                <button onclick="showSection('notifications')" class="settings-menu-item w-full flex items-center space-x-3 px-3 py-2.5 rounded-lg text-left transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                    </svg>
                                    <span class="font-medium">Notifikasi</span>
                                </button>
                                <button onclick="showSection('borrowing')" class="settings-menu-item w-full flex items-center space-x-3 px-3 py-2.5 rounded-lg text-left transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                    <span class="font-medium">Peminjaman</span>
                                </button>
                                <button onclick="showSection('security')" class="settings-menu-item w-full flex items-center space-x-3 px-3 py-2.5 rounded-lg text-left transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                    <span class="font-medium">Keamanan</span>
                                </button>
                                <button onclick="showSection('backup')" class="settings-menu-item w-full flex items-center space-x-3 px-3 py-2.5 rounded-lg text-left transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                                    </svg>
                                    <span class="font-medium">Backup & Restore</span>
                                </button>
                                <button onclick="showSection('email')" class="settings-menu-item w-full flex items-center space-x-3 px-3 py-2.5 rounded-lg text-left transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="font-medium">Email</span>
                                </button>
                                <button onclick="showSection('appearance')" class="settings-menu-item w-full flex items-center space-x-3 px-3 py-2.5 rounded-lg text-left transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                                    </svg>
                                    <span class="font-medium">Tampilan</span>
                                </button>
                                <button onclick="showSection('about')" class="settings-menu-item w-full flex items-center space-x-3 px-3 py-2.5 rounded-lg text-left transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="font-medium">Tentang</span>
                                </button>
                            </nav>
                        </div>
                    </div>

                    <!-- Settings Content -->
                    <div class="lg:col-span-3">
                        <!-- General Settings -->
                        <div id="general-section" class="settings-section">
                            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                                <h2 class="text-xl font-bold text-gray-900 mb-6">Pengaturan Umum</h2>
                                
                                <div class="space-y-6">
                                    <!-- School Info -->
                                    <div>
                                        <h3 class="text-sm font-bold text-gray-900 mb-4">Informasi Sekolah</h3>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Sekolah *</label>
                                                <input type="text" value="SMA Negeri 1 Jakarta" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 mb-2">NPSN</label>
                                                <input type="text" value="20100001" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 mb-2">Email Sekolah</label>
                                                <input type="email" value="info@sman1jakarta.sch.id" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 mb-2">No. Telepon</label>
                                                <input type="tel" value="(021) 1234-5678" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            </div>
                                        </div>
                                        <div class="mt-4">
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat Lengkap</label>
                                            <textarea rows="3" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">Jl. Pendidikan No. 1, Jakarta Pusat, DKI Jakarta 10110</textarea>
                                        </div>
                                    </div>

                                    <!-- Working Hours -->
                                    <div class="pt-6 border-t border-gray-200">
                                        <h3 class="text-sm font-bold text-gray-900 mb-4">Jam Operasional</h3>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 mb-2">Jam Buka</label>
                                                <input type="time" value="07:00" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 mb-2">Jam Tutup</label>
                                                <input type="time" value="16:00" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            </div>
                                        </div>
                                        <div class="mt-4">
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">Hari Kerja</label>
                                            <div class="flex flex-wrap gap-2">
                                                <label class="flex items-center px-4 py-2 border-2 border-blue-500 bg-blue-50 rounded-lg cursor-pointer">
                                                    <input type="checkbox" checked class="mr-2">
                                                    <span class="text-sm font-medium text-blue-700">Senin</span>
                                                </label>
                                                <label class="flex items-center px-4 py-2 border-2 border-blue-500 bg-blue-50 rounded-lg cursor-pointer">
                                                    <input type="checkbox" checked class="mr-2">
                                                    <span class="text-sm font-medium text-blue-700">Selasa</span>
                                                </label>
                                                <label class="flex items-center px-4 py-2 border-2 border-blue-500 bg-blue-50 rounded-lg cursor-pointer">
                                                    <input type="checkbox" checked class="mr-2">
                                                    <span class="text-sm font-medium text-blue-700">Rabu</span>
                                                </label>
                                                <label class="flex items-center px-4 py-2 border-2 border-blue-500 bg-blue-50 rounded-lg cursor-pointer">
                                                    <input type="checkbox" checked class="mr-2">
                                                    <span class="text-sm font-medium text-blue-700">Kamis</span>
                                                </label>
                                                <label class="flex items-center px-4 py-2 border-2 border-blue-500 bg-blue-50 rounded-lg cursor-pointer">
                                                    <input type="checkbox" checked class="mr-2">
                                                    <span class="text-sm font-medium text-blue-700">Jumat</span>
                                                </label>
                                                <label class="flex items-center px-4 py-2 border-2 border-gray-200 rounded-lg cursor-pointer">
                                                    <input type="checkbox" class="mr-2">
                                                    <span class="text-sm font-medium text-gray-700">Sabtu</span>
                                                </label>
                                                <label class="flex items-center px-4 py-2 border-2 border-gray-200 rounded-lg cursor-pointer">
                                                    <input type="checkbox" class="mr-2">
                                                    <span class="text-sm font-medium text-gray-700">Minggu</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- System Timezone -->
                                    <div class="pt-6 border-t border-gray-200">
                                        <h3 class="text-sm font-bold text-gray-900 mb-4">Zona Waktu & Bahasa</h3>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 mb-2">Zona Waktu</label>
                                                <select class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                    <option>WIB (GMT+7)</option>
                                                    <option>WITA (GMT+8)</option>
                                                    <option>WIT (GMT+9)</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 mb-2">Bahasa</label>
                                                <select class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                    <option>Bahasa Indonesia</option>
                                                    <option>English</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Save Button -->
                                    <div class="flex justify-end pt-6 border-t border-gray-200">
                                        <button class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-cyan-500 text-white rounded-xl font-semibold hover:shadow-lg hover:shadow-blue-300 transition-all">
                                            Simpan Perubahan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Notifications Settings -->
                        <div id="notifications-section" class="settings-section hidden">
                            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                                <h2 class="text-xl font-bold text-gray-900 mb-6">Pengaturan Notifikasi</h2>
                                
                                <div class="space-y-6">
                                    <!-- Email Notifications -->
                                    <div>
                                        <h3 class="text-sm font-bold text-gray-900 mb-4">Notifikasi Email</h3>
                                        <div class="space-y-4">
                                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                                <div class="flex-1">
                                                    <p class="font-semibold text-gray-900">Peminjaman Baru</p>
                                                    <p class="text-sm text-gray-600">Kirim email saat ada pengajuan peminjaman baru</p>
                                                </div>
                                                <label class="relative inline-flex items-center cursor-pointer">
                                                    <input type="checkbox" checked class="sr-only toggle-checkbox">
                                                    <div class="w-11 h-6 bg-gray-200 rounded-full relative">
                                                        <div class="toggle-label absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition-all"></div>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                                <div class="flex-1">
                                                    <p class="font-semibold text-gray-900">Pengingat Pengembalian</p>
                                                    <p class="text-sm text-gray-600">Email pengingat H-1 sebelum batas pengembalian</p>
                                                </div>
                                                <label class="relative inline-flex items-center cursor-pointer">
                                                    <input type="checkbox" checked class="sr-only toggle-checkbox">
                                                    <div class="w-11 h-6 bg-gray-200 rounded-full relative">
                                                        <div class="toggle-label absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition-all"></div>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                                <div class="flex-1">
                                                    <p class="font-semibold text-gray-900">Keterlambatan</p>
                                                    <p class="text-sm text-gray-600">Notifikasi saat terjadi keterlambatan pengembalian</p>
                                                </div>
                                                <label class="relative inline-flex items-center cursor-pointer">
                                                    <input type="checkbox" checked class="sr-only toggle-checkbox">
                                                    <div class="w-11 h-6 bg-gray-200 rounded-full relative">
                                                        <div class="toggle-label absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition-all"></div>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- System Notifications -->
                                    <div class="pt-6 border-t border-gray-200">
                                        <h3 class="text-sm font-bold text-gray-900 mb-4">Notifikasi Sistem</h3>
                                        <div class="space-y-4">
                                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                                <div class="flex-1">
                                                    <p class="font-semibold text-gray-900">Laporan Bulanan</p>
                                                    <p class="text-sm text-gray-600">Kirim laporan statistik setiap akhir bulan</p>
                                                </div>
                                                <label class="relative inline-flex items-center cursor-pointer">
                                                    <input type="checkbox" checked class="sr-only toggle-checkbox">
                                                    <div class="w-11 h-6 bg-gray-200 rounded-full relative">
                                                        <div class="toggle-label absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition-all"></div>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                                <div class="flex-1">
                                                    <p class="font-semibold text-gray-900">Update Sistem</p>
                                                    <p class="text-sm text-gray-600">Notifikasi saat ada update sistem tersedia</p>
                                                </div>
                                                <label class="relative inline-flex items-center cursor-pointer">
                                                    <input type="checkbox" class="sr-only toggle-checkbox">
                                                    <div class="w-11 h-6 bg-gray-200 rounded-full relative">
                                                        <div class="toggle-label absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition-all"></div>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Save Button -->
                                    <div class="flex justify-end pt-6 border-t border-gray-200">
                                        <button class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-cyan-500 text-white rounded-xl font-semibold hover:shadow-lg hover:shadow-blue-300 transition-all">
                                            Simpan Perubahan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Borrowing Settings -->
                        <div id="borrowing-section" class="settings-section hidden">
                            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                                <h2 class="text-xl font-bold text-gray-900 mb-6">Pengaturan Peminjaman</h2>
                                
                                <div class="space-y-6">
                                    <!-- Borrowing Rules -->
                                    <div>
                                        <h3 class="text-sm font-bold text-gray-900 mb-4">Aturan Peminjaman</h3>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 mb-2">Durasi Peminjaman Default (Hari)</label>
                                                <input type="number" value="7" min="1" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 mb-2">Maksimal Item per Peminjaman</label>
                                                <input type="number" value="3" min="1" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 mb-2">Maksimal Peminjaman Aktif per User</label>
                                                <input type="number" value="5" min="1" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 mb-2">Denda Keterlambatan per Hari (Rp)</label>
                                                <input type="number" value="5000" min="0" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Auto Approval -->
                                    <div class="pt-6 border-t border-gray-200">
                                        <h3 class="text-sm font-bold text-gray-900 mb-4">Persetujuan Otomatis</h3>
                                        <div class="space-y-4">
                                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                                <div class="flex-1">
                                                    <p class="font-semibold text-gray-900">Auto-Approve untuk Guru</p>
                                                    <p class="text-sm text-gray-600">Setujui otomatis peminjaman dari guru tanpa review</p>
                                                </div>
                                                <label class="relative inline-flex items-center cursor-pointer">
                                                    <input type="checkbox" checked class="sr-only toggle-checkbox">
                                                    <div class="w-11 h-6 bg-gray-200 rounded-full relative">
                                                        <div class="toggle-label absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition-all"></div>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                                <div class="flex-1">
                                                    <p class="font-semibold text-gray-900">Perpanjangan Otomatis</p>
                                                    <p class="text-sm text-gray-600">Izinkan perpanjangan otomatis jika tidak ada booking</p>
                                                </div>
                                                <label class="relative inline-flex items-center cursor-pointer">
                                                    <input type="checkbox" class="sr-only toggle-checkbox">
                                                    <div class="w-11 h-6 bg-gray-200 rounded-full relative">
                                                        <div class="toggle-label absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition-all"></div>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Save Button -->
                                    <div class="flex justify-end pt-6 border-t border-gray-200">
                                        <button class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-cyan-500 text-white rounded-xl font-semibold hover:shadow-lg hover:shadow-blue-300 transition-all">
                                            Simpan Perubahan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Security Settings -->
                        <div id="security-section" class="settings-section hidden">
                            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                                <h2 class="text-xl font-bold text-gray-900 mb-6">Pengaturan Keamanan</h2>
                                
                                <div class="space-y-6">
                                    <!-- Password Policy -->
                                    <div>
                                        <h3 class="text-sm font-bold text-gray-900 mb-4">Kebijakan Password</h3>
                                        <div class="space-y-4">
                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 mb-2">Minimum Panjang Password</label>
                                                <input type="number" value="8" min="6" max="20" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            </div>
                                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                                <div class="flex-1">
                                                    <p class="font-semibold text-gray-900">Wajib Huruf Besar & Kecil</p>
                                                    <p class="text-sm text-gray-600">Password harus mengandung huruf besar dan kecil</p>
                                                </div>
                                                <label class="relative inline-flex items-center cursor-pointer">
                                                    <input type="checkbox" checked class="sr-only toggle-checkbox">
                                                    <div class="w-11 h-6 bg-gray-200 rounded-full relative">
                                                        <div class="toggle-label absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition-all"></div>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                                <div class="flex-1">
                                                    <p class="font-semibold text-gray-900">Wajib Angka</p>
                                                    <p class="text-sm text-gray-600">Password harus mengandung minimal 1 angka</p>
                                                </div>
                                                <label class="relative inline-flex items-center cursor-pointer">
                                                    <input type="checkbox" checked class="sr-only toggle-checkbox">
                                                    <div class="w-11 h-6 bg-gray-200 rounded-full relative">
                                                        <div class="toggle-label absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition-all"></div>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                                <div class="flex-1">
                                                    <p class="font-semibold text-gray-900">Wajib Karakter Spesial</p>
                                                    <p class="text-sm text-gray-600">Password harus mengandung karakter spesial (!@#$%)</p>
                                                </div>
                                                <label class="relative inline-flex items-center cursor-pointer">
                                                    <input type="checkbox" class="sr-only toggle-checkbox">
                                                    <div class="w-11 h-6 bg-gray-200 rounded-full relative">
                                                        <div class="toggle-label absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition-all"></div>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Session Settings -->
                                    <div class="pt-6 border-t border-gray-200">
                                        <h3 class="text-sm font-bold text-gray-900 mb-4">Pengaturan Sesi</h3>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 mb-2">Timeout Sesi (Menit)</label>
                                                <input type="number" value="30" min="5" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 mb-2">Maksimal Login Gagal</label>
                                                <input type="number" value="5" min="3" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Save Button -->
                                    <div class="flex justify-end pt-6 border-t border-gray-200">
                                        <button class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-cyan-500 text-white rounded-xl font-semibold hover:shadow-lg hover:shadow-blue-300 transition-all">
                                            Simpan Perubahan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Backup & Restore -->
                        <div id="backup-section" class="settings-section hidden">
                            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                                <h2 class="text-xl font-bold text-gray-900 mb-6">Backup & Restore</h2>
                                
                                <div class="space-y-6">
                                    <!-- Auto Backup -->
                                    <div>
                                        <h3 class="text-sm font-bold text-gray-900 mb-4">Backup Otomatis</h3>
                                        <div class="space-y-4">
                                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                                <div class="flex-1">
                                                    <p class="font-semibold text-gray-900">Aktifkan Backup Otomatis</p>
                                                    <p class="text-sm text-gray-600">Backup database secara otomatis setiap hari</p>
                                                </div>
                                                <label class="relative inline-flex items-center cursor-pointer">
                                                    <input type="checkbox" checked class="sr-only toggle-checkbox">
                                                    <div class="w-11 h-6 bg-gray-200 rounded-full relative">
                                                        <div class="toggle-label absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition-all"></div>
                                                    </div>
                                                </label>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 mb-2">Waktu Backup</label>
                                                <input type="time" value="02:00" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Manual Backup -->
                                    <div class="pt-6 border-t border-gray-200">
                                        <h3 class="text-sm font-bold text-gray-900 mb-4">Backup Manual</h3>
                                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                                            <p class="text-sm text-blue-700">Backup terakhir: <span class="font-semibold">06 Feb 2024, 02:00 WIB</span></p>
                                            <p class="text-sm text-blue-700 mt-1">Ukuran: <span class="font-semibold">125 MB</span></p>
                                        </div>
                                        <div class="flex gap-3">
                                            <button class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-cyan-500 text-white rounded-xl font-semibold hover:shadow-lg hover:shadow-blue-300 transition-all flex items-center space-x-2">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                                </svg>
                                                <span>Backup Sekarang</span>
                                            </button>
                                            <button class="px-6 py-2.5 bg-white border border-gray-200 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition-all flex items-center space-x-2">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                                </svg>
                                                <span>Download Backup</span>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Restore -->
                                    <div class="pt-6 border-t border-gray-200">
                                        <h3 class="text-sm font-bold text-gray-900 mb-4">Restore Database</h3>
                                        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
                                            <div class="flex items-start">
                                                <svg class="w-5 h-5 text-red-600 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                                </svg>
                                                <div>
                                                    <p class="text-sm font-semibold text-red-800">Peringatan!</p>
                                                    <p class="text-sm text-red-700">Restore akan mengganti semua data yang ada dengan data dari backup. Pastikan Anda yakin sebelum melanjutkan.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
                                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                            </svg>
                                            <p class="text-sm text-gray-600 mb-1">Upload file backup (.sql atau .zip)</p>
                                            <p class="text-xs text-gray-500">Maksimal 500MB</p>
                                            <button class="mt-4 px-6 py-2.5 bg-white border border-gray-200 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition-all">
                                                Pilih File
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Email Settings -->
                        <div id="email-section" class="settings-section hidden">
                            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                                <h2 class="text-xl font-bold text-gray-900 mb-6">Pengaturan Email</h2>
                                
                                <div class="space-y-6">
                                    <div>
                                        <h3 class="text-sm font-bold text-gray-900 mb-4">Konfigurasi SMTP</h3>
                                        <div class="grid grid-cols-1 gap-4">
                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 mb-2">SMTP Host</label>
                                                <input type="text" value="smtp.gmail.com" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            </div>
                                            <div class="grid grid-cols-2 gap-4">
                                                <div>
                                                    <label class="block text-sm font-semibold text-gray-700 mb-2">SMTP Port</label>
                                                    <input type="number" value="587" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Enkripsi</label>
                                                    <select class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                        <option>TLS</option>
                                                        <option>SSL</option>
                                                        <option>None</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 mb-2">Username/Email</label>
                                                <input type="email" value="sarpras@sekolah.sch.id" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                                                <input type="password" value="••••••••" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="pt-6 border-t border-gray-200">
                                        <h3 class="text-sm font-bold text-gray-900 mb-4">Test Email</h3>
                                        <div class="flex gap-3">
                                            <input type="email" placeholder="Masukkan email tujuan test" class="flex-1 px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <button class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-cyan-500 text-white rounded-xl font-semibold hover:shadow-lg hover:shadow-blue-300 transition-all">
                                                Kirim Test Email
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Save Button -->
                                    <div class="flex justify-end pt-6 border-t border-gray-200">
                                        <button class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-cyan-500 text-white rounded-xl font-semibold hover:shadow-lg hover:shadow-blue-300 transition-all">
                                            Simpan Perubahan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Appearance Settings -->
                        <div id="appearance-section" class="settings-section hidden">
                            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                                <h2 class="text-xl font-bold text-gray-900 mb-6">Pengaturan Tampilan</h2>
                                
                                <div class="space-y-6">
                                    <div>
                                        <h3 class="text-sm font-bold text-gray-900 mb-4">Logo & Branding</h3>
                                        <div class="space-y-4">
                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 mb-2">Logo Sekolah</label>
                                                <div class="flex items-center space-x-4">
                                                    <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-cyan-400 rounded-lg flex items-center justify-center">
                                                        <span class="text-white font-bold text-2xl">S</span>
                                                    </div>
                                                    <button class="px-4 py-2 bg-white border border-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-50 transition-all">
                                                        Upload Logo
                                                    </button>
                                                </div>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Aplikasi</label>
                                                <input type="text" value="SarPras - Sistem Peminjaman" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="pt-6 border-t border-gray-200">
                                        <h3 class="text-sm font-bold text-gray-900 mb-4">Tema Warna</h3>
                                        <div class="grid grid-cols-3 gap-4">
                                            <div class="border-2 border-blue-500 rounded-lg p-4 cursor-pointer bg-blue-50">
                                                <div class="flex space-x-2 mb-2">
                                                    <div class="w-8 h-8 bg-blue-500 rounded"></div>
                                                    <div class="w-8 h-8 bg-cyan-400 rounded"></div>
                                                </div>
                                                <p class="text-sm font-semibold text-blue-700">Biru (Default)</p>
                                            </div>
                                            <div class="border-2 border-gray-200 rounded-lg p-4 cursor-pointer hover:border-green-500">
                                                <div class="flex space-x-2 mb-2">
                                                    <div class="w-8 h-8 bg-green-500 rounded"></div>
                                                    <div class="w-8 h-8 bg-emerald-400 rounded"></div>
                                                </div>
                                                <p class="text-sm font-semibold text-gray-700">Hijau</p>
                                            </div>
                                            <div class="border-2 border-gray-200 rounded-lg p-4 cursor-pointer hover:border-purple-500">
                                                <div class="flex space-x-2 mb-2">
                                                    <div class="w-8 h-8 bg-purple-500 rounded"></div>
                                                    <div class="w-8 h-8 bg-pink-400 rounded"></div>
                                                </div>
                                                <p class="text-sm font-semibold text-gray-700">Ungu</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Save Button -->
                                    <div class="flex justify-end pt-6 border-t border-gray-200">
                                        <button class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-cyan-500 text-white rounded-xl font-semibold hover:shadow-lg hover:shadow-blue-300 transition-all">
                                            Simpan Perubahan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- About Section -->
                        <div id="about-section" class="settings-section hidden">
                            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                                <h2 class="text-xl font-bold text-gray-900 mb-6">Tentang Sistem</h2>
                                
                                <div class="text-center py-8">
                                    <div class="w-24 h-24 bg-gradient-to-br from-blue-500 to-cyan-400 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg">
                                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-2xl font-bold text-gray-900 mb-2">SarPras v2.0.1</h3>
                                    <p class="text-gray-600 mb-8">Sistem Peminjaman Sarana Prasarana Sekolah</p>
                                    
                                    <div class="max-w-md mx-auto space-y-3 text-left">
                                        <div class="flex justify-between py-3 border-b border-gray-100">
                                            <span class="text-gray-600">Versi</span>
                                            <span class="font-semibold text-gray-900">2.0.1</span>
                                        </div>
                                        <div class="flex justify-between py-3 border-b border-gray-100">
                                            <span class="text-gray-600">Build Date</span>
                                            <span class="font-semibold text-gray-900">01 Februari 2024</span>
                                        </div>
                                        <div class="flex justify-between py-3 border-b border-gray-100">
                                            <span class="text-gray-600">Framework</span>
                                            <span class="font-semibold text-gray-900">Laravel 12</span>
                                        </div>
                                        <div class="flex justify-between py-3 border-b border-gray-100">
                                            <span class="text-gray-600">Database</span>
                                            <span class="font-semibold text-gray-900">MySQL 8.0</span>
                                        </div>
                                        <div class="flex justify-between py-3">
                                            <span class="text-gray-600">License</span>
                                            <span class="font-semibold text-gray-900">MIT License</span>
                                        </div>
                                    </div>

                                    <div class="mt-8 pt-8 border-t border-gray-200">
                                        <p class="text-sm text-gray-600">© 2024 SarPras. All rights reserved.</p>
                                        <p class="text-sm text-gray-500 mt-2">Developed with ❤️ for Indonesian Schools</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        // Settings menu navigation
        function showSection(sectionName) {
            // Hide all sections
            document.querySelectorAll('.settings-section').forEach(section => {
                section.classList.add('hidden');
            });
            
            // Remove active class from all menu items
            document.querySelectorAll('.settings-menu-item').forEach(item => {
                item.classList.remove('active', 'bg-gradient-to-r', 'from-blue-600', 'to-cyan-500', 'text-white', 'shadow-lg', 'shadow-blue-200');
                item.classList.add('text-gray-700', 'hover:bg-gray-100');
            });
            
            // Show selected section
            document.getElementById(sectionName + '-section').classList.remove('hidden');
            
            // Add active class to clicked menu item
            event.target.closest('.settings-menu-item').classList.remove('text-gray-700', 'hover:bg-gray-100');
            event.target.closest('.settings-menu-item').classList.add('active', 'bg-gradient-to-r', 'from-blue-600', 'to-cyan-500', 'text-white', 'shadow-lg', 'shadow-blue-200');
        }

        // Mobile menu toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const sidebar = document.querySelector('aside');
        
        if (mobileMenuButton && sidebar) {
            mobileMenuButton.addEventListener('click', () => {
                sidebar.classList.toggle('-translate-x-full');
            });
        }
    </script>
</body>
</html>