<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SarPras - Sistem Peminjaman Sekolah</title>
    @vite('resources/css/app.css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 via-blue-50 to-cyan-50 min-h-screen">
    
    <!-- Navbar -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/80 backdrop-blur-lg border-b border-blue-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-cyan-400 rounded-xl flex items-center justify-center shadow-lg shadow-blue-200">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <span class="text-xl font-bold bg-gradient-to-r from-blue-600 to-cyan-500 bg-clip-text text-transparent">SarPras</span>
                </div>

                <!-- Navigation Links -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#beranda" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">Beranda</a>
                    <a href="#fitur" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">Fitur</a>
                    <a href="#tentang" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">Tentang</a>
                    <a href="#kontak" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">Kontak</a>
                </div>

                <!-- CTA Button -->
                <div class="flex items-center space-x-4">
                    <a href="/login" class="hidden sm:block px-4 py-2 text-blue-600 hover:text-blue-700 font-semibold transition-colors">Masuk</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="beranda" class="pt-32 pb-20 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Left Content -->
                <div class="space-y-8 animate-fade-in">
                    <div class="inline-block">
                        <span class="px-4 py-2 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold">
                            ✨ Sistem Peminjaman Modern
                        </span>
                    </div>
                    
                    <h1 class="text-5xl lg:text-6xl font-bold text-gray-900 leading-tight">
                        Kelola Peminjaman
                        <span class="bg-gradient-to-r from-blue-600 to-cyan-500 bg-clip-text text-transparent"> Sarana Prasarana </span>
                        dengan Mudah
                    </h1>
                    
                    <p class="text-xl text-gray-600 leading-relaxed">
                        Platform digital yang memudahkan siswa dan guru dalam meminjam dan mengelola sarana prasarana sekolah secara efisien dan transparan.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="/register" class="px-8 py-4 bg-gradient-to-r from-blue-600 to-cyan-500 text-white rounded-xl font-bold text-lg hover:shadow-xl hover:shadow-blue-300 transition-all duration-300 transform hover:-translate-y-1 text-center">
                            Mulai Sekarang
                        </a>
                        <a href="#fitur" class="px-8 py-4 bg-white text-blue-600 rounded-xl font-bold text-lg border-2 border-blue-200 hover:border-blue-400 hover:shadow-lg transition-all duration-300 text-center">
                            Pelajari Lebih Lanjut
                        </a>
                    </div>

                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-6 pt-8 border-t border-blue-100">
                        <div>
                            <div class="text-3xl font-bold text-blue-600">500+</div>
                            <div class="text-sm text-gray-600 mt-1">Pengguna Aktif</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-cyan-600">1000+</div>
                            <div class="text-sm text-gray-600 mt-1">Item Tersedia</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-blue-600">98%</div>
                            <div class="text-sm text-gray-600 mt-1">Kepuasan</div>
                        </div>
                    </div>
                </div>

                <!-- Right Illustration -->
                <div class="relative">
                    <div class="relative z-10 bg-white rounded-3xl shadow-2xl shadow-blue-200/50 p-8 border border-blue-100">
                        <!-- Mockup Card -->
                        <div class="space-y-4">
                            <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                                <h3 class="font-bold text-lg text-gray-900">Peminjaman Aktif</h3>
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">3 Item</span>
                            </div>
                            
                            <!-- Item Card 1 -->
                            <div class="p-4 bg-gradient-to-br from-blue-50 to-cyan-50 rounded-xl border border-blue-100">
                                <div class="flex items-start space-x-4">
                                    <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-gray-900">Buku Paket Matematika</h4>
                                        <p class="text-sm text-gray-600 mt-1">Kembali: 15 Feb 2024</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Item Card 2 -->
                            <div class="p-4 bg-gradient-to-br from-cyan-50 to-blue-50 rounded-xl border border-cyan-100">
                                <div class="flex items-start space-x-4">
                                    <div class="w-12 h-12 bg-cyan-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-gray-900">Proyektor LCD</h4>
                                        <p class="text-sm text-gray-600 mt-1">Kembali: 10 Feb 2024</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Item Card 3 -->
                            <div class="p-4 bg-gradient-to-br from-blue-50 to-cyan-50 rounded-xl border border-blue-100">
                                <div class="flex items-start space-x-4">
                                    <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-gray-900">Alat Tulis Kantor</h4>
                                        <p class="text-sm text-gray-600 mt-1">Kembali: 12 Feb 2024</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Decorative Elements -->
                    <div class="absolute -top-6 -right-6 w-32 h-32 bg-gradient-to-br from-blue-400 to-cyan-300 rounded-full opacity-20 blur-2xl"></div>
                    <div class="absolute -bottom-6 -left-6 w-40 h-40 bg-gradient-to-br from-cyan-400 to-blue-300 rounded-full opacity-20 blur-2xl"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="fitur" class="py-20 px-4 sm:px-6 lg:px-8 bg-white/50">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <span class="px-4 py-2 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold">
                    Fitur Unggulan
                </span>
                <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mt-6">
                    Kenapa Memilih <span class="bg-gradient-to-r from-blue-600 to-cyan-500 bg-clip-text text-transparent">SarPras?</span>
                </h2>
                <p class="text-xl text-gray-600 mt-4 max-w-2xl mx-auto">
                    Platform lengkap dengan berbagai fitur yang memudahkan proses peminjaman
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="group p-8 bg-white rounded-2xl border border-blue-100 hover:shadow-xl hover:shadow-blue-100 transition-all duration-300 hover:-translate-y-2">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-cyan-400 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Cepat & Mudah</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Proses peminjaman yang simpel dan cepat, hanya dalam beberapa klik saja
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="group p-8 bg-white rounded-2xl border border-cyan-100 hover:shadow-xl hover:shadow-cyan-100 transition-all duration-300 hover:-translate-y-2">
                    <div class="w-14 h-14 bg-gradient-to-br from-cyan-500 to-blue-400 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Aman & Terpercaya</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Data peminjaman tersimpan dengan aman dan dapat dilacak kapan saja
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="group p-8 bg-white rounded-2xl border border-blue-100 hover:shadow-xl hover:shadow-blue-100 transition-all duration-300 hover:-translate-y-2">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-cyan-400 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Notifikasi Real-time</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Dapatkan pengingat otomatis untuk tanggal pengembalian barang
                    </p>
                </div>

                <!-- Feature 4 -->
                <div class="group p-8 bg-white rounded-2xl border border-cyan-100 hover:shadow-xl hover:shadow-cyan-100 transition-all duration-300 hover:-translate-y-2">
                    <div class="w-14 h-14 bg-gradient-to-br from-cyan-500 to-blue-400 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Laporan Lengkap</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Statistik dan laporan detail untuk monitoring peminjaman
                    </p>
                </div>

                <!-- Feature 5 -->
                <div class="group p-8 bg-white rounded-2xl border border-blue-100 hover:shadow-xl hover:shadow-blue-100 transition-all duration-300 hover:-translate-y-2">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-cyan-400 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Responsif</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Akses dari mana saja, kapan saja melalui smartphone atau komputer
                    </p>
                </div>

                <!-- Feature 6 -->
                <div class="group p-8 bg-white rounded-2xl border border-cyan-100 hover:shadow-xl hover:shadow-cyan-100 transition-all duration-300 hover:-translate-y-2">
                    <div class="w-14 h-14 bg-gradient-to-br from-cyan-500 to-blue-400 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Multi-User</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Mendukung berbagai peran: siswa, guru, dan admin dengan hak akses berbeda
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="py-20 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <span class="px-4 py-2 bg-cyan-100 text-cyan-700 rounded-full text-sm font-semibold">
                    Cara Kerja
                </span>
                <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mt-6">
                    Mudah dalam <span class="bg-gradient-to-r from-blue-600 to-cyan-500 bg-clip-text text-transparent">3 Langkah</span>
                </h2>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Step 1 -->
                <div class="relative">
                    <div class="text-center">
                        <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-cyan-400 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg shadow-blue-200">
                            <span class="text-3xl font-bold text-white">1</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Pilih Barang</h3>
                        <p class="text-gray-600">
                            Cari dan pilih sarana prasarana yang ingin dipinjam dari katalog
                        </p>
                    </div>
                    <!-- Arrow -->
                    <div class="hidden md:block absolute top-10 -right-4 text-blue-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="relative">
                    <div class="text-center">
                        <div class="w-20 h-20 bg-gradient-to-br from-cyan-500 to-blue-400 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg shadow-cyan-200">
                            <span class="text-3xl font-bold text-white">2</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Ajukan Peminjaman</h3>
                        <p class="text-gray-600">
                            Isi formulir peminjaman dan tunggu persetujuan dari admin
                        </p>
                    </div>
                    <!-- Arrow -->
                    <div class="hidden md:block absolute top-10 -right-4 text-cyan-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="text-center">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-cyan-400 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg shadow-blue-200">
                        <span class="text-3xl font-bold text-white">3</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Ambil & Kembalikan</h3>
                    <p class="text-gray-600">
                        Ambil barang sesuai jadwal dan kembalikan tepat waktu
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto">
            <div class="bg-gradient-to-br from-blue-600 via-blue-500 to-cyan-500 rounded-3xl p-12 lg:p-16 shadow-2xl shadow-blue-300 relative overflow-hidden">
                <!-- Decorative circles -->
                <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/10 rounded-full translate-y-1/2 -translate-x-1/2"></div>
                
                <div class="relative z-10 text-center text-white">
                    <h2 class="text-4xl lg:text-5xl font-bold mb-6">
                        Siap Memulai Peminjaman Digital?
                    </h2>
                    <p class="text-xl mb-8 text-blue-50 max-w-2xl mx-auto">
                        Bergabunglah dengan ratusan pengguna lain yang sudah merasakan kemudahan sistem peminjaman modern
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="/register" class="px-8 py-4 bg-white text-blue-600 rounded-xl font-bold text-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                            Daftar Gratis
                        </a>
                        <a href="#kontak" class="px-8 py-4 bg-blue-700 text-white rounded-xl font-bold text-lg border-2 border-white/30 hover:bg-blue-800 transition-all duration-300">
                            Hubungi Kami
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="kontak" class="bg-gray-900 text-gray-300 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                <!-- Brand -->
                <div class="col-span-2">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-cyan-400 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                        <span class="text-xl font-bold text-white">SarPras</span>
                    </div>
                    <p class="text-gray-400 mb-4">
                        Platform digital untuk memudahkan peminjaman sarana prasarana sekolah secara efisien dan transparan.
                    </p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="font-bold text-white mb-4">Navigasi</h3>
                    <ul class="space-y-2">
                        <li><a href="#beranda" class="hover:text-blue-400 transition-colors">Beranda</a></li>
                        <li><a href="#fitur" class="hover:text-blue-400 transition-colors">Fitur</a></li>
                        <li><a href="#tentang" class="hover:text-blue-400 transition-colors">Tentang</a></li>
                        <li><a href="/login" class="hover:text-blue-400 transition-colors">Masuk</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h3 class="font-bold text-white mb-4">Kontak</h3>
                    <ul class="space-y-2">
                        <li class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <span>info@sarpras.sch.id</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            <span>(021) 123-4567</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 pt-8 text-center text-gray-500">
                <p>&copy; 2024 SarPras. Semua hak cipta dilindungi.</p>
            </div>
        </div>
    </footer>

</body>
</html>