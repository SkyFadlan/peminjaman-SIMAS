<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>LIBRARYFLOW - Sistem Peminjaman Buku Digital</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        html {
            scroll-behavior: smooth;
        }
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
        .gradient-border {
            background: linear-gradient(135deg, #8B5CF6, #D946EF, #F59E0B);
            padding: 2px;
            border-radius: 1.5rem;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        .hover-lift {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .hover-lift:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -12px rgba(0, 0, 0, 0.1);
        }
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-amber-50 via-orange-50/40 to-rose-50 min-h-screen antialiased">

    <!-- Modern Navbar dengan efek glassmorphism -->
    <nav class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 bg-white/75 backdrop-blur-xl border-b border-amber-100/60 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16 md:h-20">
                <!-- Logo + Brand -->
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-600 via-purple-600 to-amber-500 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-200/50">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <span class="text-xl md:text-2xl font-extrabold bg-gradient-to-r from-indigo-700 via-purple-700 to-amber-600 bg-clip-text text-transparent tracking-tight">LIBRARYFLOW</span>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#beranda" class="text-gray-700 hover:text-indigo-600 font-semibold transition-all duration-200 relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:bg-indigo-500 after:transition-all hover:after:w-full">Beranda</a>
                    <a href="#fitur" class="text-gray-700 hover:text-indigo-600 font-semibold transition-all duration-200">Fitur</a>
                    <a href="#koleksi" class="text-gray-700 hover:text-indigo-600 font-semibold transition-all duration-200">Koleksi</a>
                    <a href="#tentang" class="text-gray-700 hover:text-indigo-600 font-semibold transition-all duration-200">Tentang</a>
                    <a href="#kontak" class="text-gray-700 hover:text-indigo-600 font-semibold transition-all duration-200">Kontak</a>
                </div>

                <!-- CTA Buttons -->
                <div class="flex items-center gap-3">
                    <a href="/login" class="hidden sm:block px-5 py-2 text-indigo-600 font-bold hover:text-indigo-800 transition">Masuk</a>
                    <a href="/register/siswa" class="px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold rounded-xl shadow-md shadow-indigo-200 hover:shadow-lg hover:scale-105 transition-all duration-300">Daftar</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section dengan ilustrasi buku modern -->
    <section id="beranda" class="pt-28 md:pt-36 pb-20 px-4 sm:px-6 lg:px-8 overflow-hidden">
        <div class="max-w-7xl mx-auto">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Left Content -->
                <div class="space-y-6 animate-fade-in">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-100/80 rounded-full border border-indigo-200">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                        </span>
                        <span class="text-indigo-800 text-sm font-bold">📚 Platform Peminjaman Buku Digital</span>
                    </div>
                    
                    <h1 class="text-5xl lg:text-7xl font-extrabold leading-tight tracking-tight">
                        Pinjam Buku
                        <span class="bg-gradient-to-r from-indigo-600 via-purple-600 to-amber-500 bg-clip-text text-transparent"> Tanpa Ribet,</span>
                        Kembali Tepat Waktu
                    </h1>
                    
                    <p class="text-lg md:text-xl text-gray-600 leading-relaxed max-w-lg">
                        Kelola peminjaman buku perpustakaan sekolah secara modern, transparan, dan efisien. Tersedia untuk siswa, guru, dan staf.
                    </p>
                    
                    <div class="flex flex-wrap gap-4 pt-4">
                        <a href="/register" class="px-8 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold rounded-2xl shadow-xl shadow-indigo-300/40 hover:shadow-2xl hover:scale-[1.02] transition-all duration-300 flex items-center gap-2">
                            Mulai Pinjam
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                        <a href="#koleksi" class="px-8 py-4 bg-white border-2 border-indigo-200 text-indigo-700 font-bold rounded-2xl hover:bg-indigo-50 transition-all duration-300">Lihat Koleksi</a>
                    </div>
                    
                    <!-- Stats -->
                    <div class="flex gap-6 pt-6">
                        <div><span class="text-2xl font-black text-gray-900">5.000+</span><p class="text-sm text-gray-500">Judul Buku</p></div>
                        <div><span class="text-2xl font-black text-gray-900">1.200+</span><p class="text-sm text-gray-500">Anggota Aktif</p></div>
                        <div><span class="text-2xl font-black text-gray-900">98%</span><p class="text-sm text-gray-500">Tepat Waktu</p></div>
                    </div>
                </div>

                <!-- Right Illustration / Mockup Buku -->
                <div class="relative">
                    <div class="relative z-10 bg-white/70 backdrop-blur-sm rounded-3xl shadow-2xl shadow-indigo-200/40 border border-white/50 p-6">
                        <!-- Stacked Books Mockup -->
                        <div class="space-y-5">
                            <div class="flex items-center justify-between pb-3 border-b border-indigo-100">
                                <h3 class="font-black text-xl text-gray-800">🔥 Peminjaman Populer</h3>
                                <span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-full text-xs font-bold">Hari Ini</span>
                            </div>
                            <!-- Book Card 1 -->
                            <div class="group p-4 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-2xl border border-indigo-100 transition-all hover:shadow-md">
                                <div class="flex gap-4">
                                    <div class="w-14 h-14 bg-indigo-500 rounded-xl flex items-center justify-center shadow-md">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-bold text-gray-800">Filosofi Teras</h4>
                                        <p class="text-xs text-gray-500 mt-1">Henry Manampiring</p>
                                        <div class="flex items-center gap-2 mt-2">
                                            <span class="text-[10px] font-bold bg-green-100 text-green-700 px-2 py-0.5 rounded-full">Tersedia</span>
                                            <span class="text-xs text-gray-400">Kembali: 28 Feb 2025</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Book Card 2 -->
                            <div class="group p-4 bg-gradient-to-r from-amber-50 to-orange-50 rounded-2xl border border-amber-100">
                                <div class="flex gap-4">
                                    <div class="w-14 h-14 bg-amber-500 rounded-xl flex items-center justify-center shadow-md">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-bold text-gray-800">Atomic Habits</h4>
                                        <p class="text-xs text-gray-500">James Clear</p>
                                        <div class="flex items-center gap-2 mt-2">
                                            <span class="text-[10px] font-bold bg-amber-100 text-amber-700 px-2 py-0.5 rounded-full">Dipinjam</span>
                                            <span class="text-xs text-gray-400">Kembali: 02 Mar 2025</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Book Card 3 -->
                            <div class="group p-4 bg-gradient-to-r from-purple-50 to-pink-50 rounded-2xl border border-purple-100">
                                <div class="flex gap-4">
                                    <div class="w-14 h-14 bg-purple-500 rounded-xl flex items-center justify-center shadow-md">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-bold text-gray-800">Laut Bercerita</h4>
                                        <p class="text-xs text-gray-500">Leila S. Chudori</p>
                                        <div class="flex items-center gap-2 mt-2">
                                            <span class="text-[10px] font-bold bg-green-100 text-green-700 px-2 py-0.5 rounded-full">Tersedia</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Floating Decoration -->
                    <div class="absolute -top-10 -right-8 w-44 h-44 bg-gradient-to-br from-indigo-300 to-purple-300 rounded-full opacity-30 blur-3xl animate-float"></div>
                    <div class="absolute -bottom-8 -left-10 w-56 h-56 bg-gradient-to-tr from-amber-200 to-rose-200 rounded-full opacity-30 blur-2xl"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section (Modern Grid) -->
    <section id="fitur" class="py-24 px-4 sm:px-6 lg:px-8 bg-white/40 backdrop-blur-sm">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <span class="px-5 py-2 bg-gradient-to-r from-indigo-100 to-purple-100 text-indigo-700 rounded-full text-sm font-extrabold tracking-wide">✨ Superpower Features</span>
                <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mt-6">Pengalaman Peminjaman<br><span class="bg-gradient-to-r from-indigo-600 via-purple-600 to-amber-500 bg-clip-text text-transparent">Tanpa Batas</span></h2>
                <p class="text-lg text-gray-600 mt-4 max-w-2xl mx-auto">Dibangun dengan teknologi modern untuk kemudahan akses dan kenyamanan membaca.</p>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="group p-7 bg-white rounded-2xl border border-indigo-100 shadow-sm hover:shadow-2xl hover:shadow-indigo-100 transition-all duration-500 hover:-translate-y-2">
                    <div class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-2xl flex items-center justify-center mb-5 group-hover:scale-110 transition-transform"><svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg></div>
                    <h3 class="text-xl font-extrabold text-gray-900 mb-2">Katalog Digital</h3>
                    <p class="text-gray-600">Jelajahi ribuan koleksi buku dengan filter genre, penulis, dan ketersediaan secara realtime.</p>
                </div>
                <!-- Feature 2 -->
                <div class="group p-7 bg-white rounded-2xl border border-purple-100 shadow-sm hover:shadow-2xl hover:shadow-purple-100 transition-all duration-500 hover:-translate-y-2">
                    <div class="w-14 h-14 bg-gradient-to-br from-amber-500 to-orange-500 rounded-2xl flex items-center justify-center mb-5 group-hover:scale-110 transition-transform"><svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg></div>
                    <h3 class="text-xl font-extrabold text-gray-900 mb-2">Notifikasi Otomatis</h3>
                    <p class="text-gray-600">Pengingat tenggat pengembalian via email & WhatsApp, bebas denda keterlambatan.</p>
                </div>
                <!-- Feature 3 -->
                <div class="group p-7 bg-white rounded-2xl border border-indigo-100 shadow-sm hover:shadow-2xl hover:shadow-indigo-100 transition-all duration-500 hover:-translate-y-2">
                    <div class="w-14 h-14 bg-gradient-to-br from-rose-500 to-pink-500 rounded-2xl flex items-center justify-center mb-5 group-hover:scale-110 transition-transform"><svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg></div>
                    <h3 class="text-xl font-extrabold text-gray-900 mb-2">Riwayat & Statistik</h3>
                    <p class="text-gray-600">Pantau histori peminjaman, buku favorit, dan rekomendasi bacaan berbasis AI.</p>
                </div>
                <!-- Feature 4 -->
                <div class="group p-7 bg-white rounded-2xl border border-amber-100 shadow-sm hover:shadow-2xl hover:shadow-amber-100 transition-all duration-500 hover:-translate-y-2">
                    <div class="w-14 h-14 bg-gradient-to-br from-teal-500 to-emerald-500 rounded-2xl flex items-center justify-center mb-5 group-hover:scale-110 transition-transform"><svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg></div>
                    <h3 class="text-xl font-extrabold text-gray-900 mb-2">Mobile Responsive</h3>
                    <p class="text-gray-600">Akses perpustakaan dari smartphone, tablet, atau laptop dengan pengalaman optimal.</p>
                </div>
                <!-- Feature 5 -->
                <div class="group p-7 bg-white rounded-2xl border border-purple-100 shadow-sm hover:shadow-2xl hover:shadow-purple-100 transition-all duration-500 hover:-translate-y-2">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-2xl flex items-center justify-center mb-5 group-hover:scale-110 transition-transform"><svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg></div>
                    <h3 class="text-xl font-extrabold text-gray-900 mb-2">Multi-Role Akses</h3>
                    <p class="text-gray-600">Siswa, guru, pustakawan dengan dashboard dan hak akses berbeda sesuai kebutuhan.</p>
                </div>
                <!-- Feature 6 -->
                <div class="group p-7 bg-white rounded-2xl border border-indigo-100 shadow-sm hover:shadow-2xl hover:shadow-indigo-100 transition-all duration-500 hover:-translate-y-2">
                    <div class="w-14 h-14 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-2xl flex items-center justify-center mb-5 group-hover:scale-110 transition-transform"><svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg></div>
                    <h3 class="text-xl font-extrabold text-gray-900 mb-2">Laporan Real-time</h3>
                    <p class="text-gray-600">Grafik peminjaman terbanyak, buku favorit, dan analisa tren perpustakaan.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Koleksi Unggulan Section -->
    <section id="koleksi" class="py-24 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12">
                <span class="px-5 py-2 bg-amber-100 text-amber-700 rounded-full text-sm font-bold">📖 Koleksi Terpopuler</span>
                <h2 class="text-4xl font-extrabold mt-5">Rekomendasi <span class="text-indigo-600">Buku Terlaris</span> Bulan Ini</h2>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-7">
                <!-- Book item 1 -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all group border border-gray-100">
                    <div class="h-48 bg-gradient-to-br from-indigo-200 to-purple-200 flex items-center justify-center"><svg class="w-16 h-16 text-indigo-500 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg></div>
                    <div class="p-5"><h3 class="font-bold text-xl">Atomic Habits</h3><p class="text-gray-500 text-sm">James Clear</p><div class="mt-3 flex justify-between items-center"><span class="text-indigo-600 font-bold">Tersedia 12</span><button class="text-indigo-500 font-semibold text-sm">Pinjam →</button></div></div>
                </div>
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all group border border-gray-100"><div class="h-48 bg-gradient-to-br from-amber-200 to-orange-200 flex items-center justify-center"><svg class="w-16 h-16 text-amber-600 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg></div><div class="p-5"><h3 class="font-bold text-xl">Filosofi Teras</h3><p class="text-gray-500 text-sm">Henry Manampiring</p><div class="mt-3 flex justify-between items-center"><span class="text-green-600 font-bold">Tersedia 8</span><button class="text-indigo-500 font-semibold text-sm">Pinjam →</button></div></div></div>
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all group border border-gray-100"><div class="h-48 bg-gradient-to-br from-rose-200 to-pink-200 flex items-center justify-center"><svg class="w-16 h-16 text-rose-500 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg></div><div class="p-5"><h3 class="font-bold text-xl">Laut Bercerita</h3><p class="text-gray-500 text-sm">Leila S. Chudori</p><div class="mt-3 flex justify-between items-center"><span class="text-indigo-600 font-bold">Tersedia 5</span><button class="text-indigo-500 font-semibold text-sm">Pinjam →</button></div></div></div>
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all group border border-gray-100"><div class="h-48 bg-gradient-to-br from-teal-200 to-cyan-200 flex items-center justify-center"><svg class="w-16 h-16 text-teal-600 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div><div class="p-5"><h3 class="font-bold text-xl">Bumi Manusia</h3><p class="text-gray-500 text-sm">Pramoedya Ananta Toer</p><div class="mt-3 flex justify-between items-center"><span class="text-amber-600 font-bold">Tersedia 3</span><button class="text-indigo-500 font-semibold text-sm">Pinjam →</button></div></div></div>
            </div>
        </div>
    </section>

    <!-- CTA Banner Modern -->
    <section class="py-20 px-4">
        <div class="max-w-5xl mx-auto">
            <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-indigo-600 via-purple-600 to-amber-500 p-10 md:p-14 text-center shadow-2xl">
                <div class="relative z-10"><h2 class="text-3xl md:text-5xl font-extrabold text-white">Siap Memulai Petualangan Membaca?</h2><p class="text-indigo-100 text-lg mt-4 max-w-xl mx-auto">Bergabung dengan ribuan pembaca lain dan nikmati kemudahan pinjam buku digital.</p><a href="/register" class="inline-block mt-8 px-8 py-3 bg-white text-indigo-700 font-bold rounded-full shadow-lg hover:shadow-xl transition-all">Daftar Sekarang →</a></div>
                <div class="absolute -top-24 -right-24 w-64 h-64 bg-white opacity-10 rounded-full blur-3xl"></div>
            </div>
        </div>
    </section>

    <!-- Footer Modern -->
    <footer id="kontak" class="bg-gray-900 text-gray-300 pt-16 pb-8 px-4">
        <div class="max-w-7xl mx-auto grid md:grid-cols-4 gap-10 border-b border-gray-800 pb-12">
            <div class="col-span-2"><div class="flex items-center gap-3 mb-4"><div class="w-10 h-10 bg-indigo-500 rounded-xl flex items-center justify-center"><svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg></div><span class="text-xl font-bold text-white">LIBRARYFLOW</span></div><p class="text-gray-400">Ekosistem peminjaman buku masa depan untuk sekolah modern. Transparan, cepat, dan nyaman.</p></div>
            <div><h3 class="font-bold text-white mb-4">Jelajahi</h3><ul class="space-y-2"><li><a href="#beranda" class="hover:text-indigo-400">Beranda</a></li><li><a href="#fitur" class="hover:text-indigo-400">Fitur</a></li><li><a href="#koleksi" class="hover:text-indigo-400">Koleksi</a></li></ul></div>
            <div><h3 class="font-bold text-white mb-4">Kontak</h3><ul><li class="flex gap-2"><svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg><span>hello@libraryflow.id</span></li><li class="flex gap-2 mt-2"><svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg><span>+62 812 3456 7890</span></li></ul></div>
        </div>
        <div class="text-center text-gray-500 text-sm pt-8">© 2025 LIBRARYFLOW — Semua hak cipta dilindungi. | Perpustakaan Digital Sekolah</div>
    </footer>
</body>
</html>