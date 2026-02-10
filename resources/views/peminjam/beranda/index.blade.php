<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda - SarPras Siswa</title>
    @vite('resources/css/app.css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .category-pill.active {
            background: linear-gradient(to right, #c026d3, #ec4899);
            color: white;
            box-shadow: 0 4px 14px 0 rgba(192, 38, 211, 0.39);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-fuchsia-50 via-pink-50 to-purple-50 min-h-screen">
    
    <!-- Navbar Component -->
    @include('components.navbar_peminjam')

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Hero Section -->
        <div class="bg-gradient-to-r from-fuchsia-600 to-pink-500 rounded-2xl p-8 mb-8 text-white shadow-xl shadow-fuchsia-200">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <h1 class="text-3xl sm:text-4xl font-bold mb-3">Selamat Datang, Andi! 👋</h1>
                    <p class="text-fuchsia-100 text-lg mb-6">Temukan dan pinjam peralatan sekolah dengan mudah</p>
                    <div class="flex flex-wrap gap-3">
                        <div class="bg-white/20 backdrop-blur-sm rounded-lg px-4 py-2 flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="font-semibold">3 Item Dipinjam</span>
                        </div>
                        <div class="bg-white/20 backdrop-blur-sm rounded-lg px-4 py-2 flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="font-semibold">2 Jatuh Tempo</span>
                        </div>
                    </div>
                </div>
                <div class="hidden lg:block">
                    <svg class="w-48 h-48 text-white/20" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Category Pills -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-900">Kategori</h2>
                <button class="text-sm font-semibold text-fuchsia-600 hover:text-fuchsia-700">
                    Lihat Semua →
                </button>
            </div>
            <div class="flex overflow-x-auto pb-4 space-x-3 scrollbar-hide">
                <button onclick="filterCategory('all')" class="category-pill active px-6 py-3 bg-white rounded-xl font-semibold text-sm whitespace-nowrap shadow-sm hover:shadow-md transition-all flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                    <span>Semua</span>
                    <span class="bg-fuchsia-100 text-fuchsia-700 px-2 py-0.5 rounded-full text-xs font-bold">342</span>
                </button>
                <button onclick="filterCategory('elektronik')" class="category-pill px-6 py-3 bg-white rounded-xl font-semibold text-sm text-gray-700 whitespace-nowrap shadow-sm hover:shadow-md transition-all flex items-center space-x-2">
                    <span>📱</span>
                    <span>Elektronik</span>
                    <span class="bg-gray-100 text-gray-700 px-2 py-0.5 rounded-full text-xs font-bold">52</span>
                </button>
                <button onclick="filterCategory('buku')" class="category-pill px-6 py-3 bg-white rounded-xl font-semibold text-sm text-gray-700 whitespace-nowrap shadow-sm hover:shadow-md transition-all flex items-center space-x-2">
                    <span>📚</span>
                    <span>Buku & Literatur</span>
                    <span class="bg-gray-100 text-gray-700 px-2 py-0.5 rounded-full text-xs font-bold">128</span>
                </button>
                <button onclick="filterCategory('lab')" class="category-pill px-6 py-3 bg-white rounded-xl font-semibold text-sm text-gray-700 whitespace-nowrap shadow-sm hover:shadow-md transition-all flex items-center space-x-2">
                    <span>🔬</span>
                    <span>Laboratorium</span>
                    <span class="bg-gray-100 text-gray-700 px-2 py-0.5 rounded-full text-xs font-bold">34</span>
                </button>
                <button onclick="filterCategory('olahraga')" class="category-pill px-6 py-3 bg-white rounded-xl font-semibold text-sm text-gray-700 whitespace-nowrap shadow-sm hover:shadow-md transition-all flex items-center space-x-2">
                    <span>⚽</span>
                    <span>Olahraga</span>
                    <span class="bg-gray-100 text-gray-700 px-2 py-0.5 rounded-full text-xs font-bold">45</span>
                </button>
                <button onclick="filterCategory('multimedia')" class="category-pill px-6 py-3 bg-white rounded-xl font-semibold text-sm text-gray-700 whitespace-nowrap shadow-sm hover:shadow-md transition-all flex items-center space-x-2">
                    <span>📷</span>
                    <span>Multimedia</span>
                    <span class="bg-gray-100 text-gray-700 px-2 py-0.5 rounded-full text-xs font-bold">18</span>
                </button>
            </div>
        </div>

        <!-- Filters & Sort -->
        <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center space-x-3">
                <select class="px-4 py-2.5 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-fuchsia-500 focus:border-transparent shadow-sm">
                    <option>Urutkan: Terbaru</option>
                    <option>Nama A-Z</option>
                    <option>Nama Z-A</option>
                    <option>Stok Terbanyak</option>
                    <option>Paling Populer</option>
                </select>
                <select class="px-4 py-2.5 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-fuchsia-500 focus:border-transparent shadow-sm">
                    <option>Semua Kondisi</option>
                    <option>Baik</option>
                    <option>Rusak Ringan</option>
                </select>
                <button class="px-4 py-2.5 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                    </svg>
                </button>
            </div>
            <div class="flex items-center space-x-2">
                <button onclick="changeView('grid')" id="gridViewBtn" class="p-2.5 bg-gradient-to-r from-fuchsia-600 to-pink-500 text-white rounded-lg shadow-lg shadow-fuchsia-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                </button>
                <button onclick="changeView('list')" id="listViewBtn" class="p-2.5 bg-white text-gray-600 rounded-lg hover:bg-gray-100 transition-colors shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Item Grid -->
        <div id="itemGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <!-- Item Card 1 - Available -->
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 group">
                <div class="relative overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1593642632823-8f785ba67e45?w=400" alt="Laptop" class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-300">
                    <div class="absolute top-3 right-3">
                        <button class="w-10 h-10 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center shadow-lg hover:bg-fuchsia-600 hover:text-white transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="absolute top-3 left-3">
                        <span class="px-3 py-1 bg-green-500 text-white rounded-full text-xs font-bold shadow-lg">Tersedia</span>
                    </div>
                </div>
                <div class="p-5">
                    <div class="flex items-center space-x-2 mb-2">
                        <span class="px-2 py-1 bg-fuchsia-100 text-fuchsia-700 rounded-md text-xs font-semibold">Elektronik</span>
                        <span class="text-xs text-gray-500">ELK-001</span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2">Laptop ASUS VivoBook 14</h3>
                    <p class="text-sm text-gray-600 mb-3 line-clamp-2">Intel Core i5, RAM 8GB, SSD 512GB, Layar 14 inch FHD</p>
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            <span class="text-sm font-semibold text-gray-700">Stok: <span class="text-fuchsia-600">5 unit</span></span>
                        </div>
                        <div class="flex items-center space-x-1">
                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <span class="text-xs font-semibold text-gray-600">4.8 (24)</span>
                        </div>
                    </div>
                    <button onclick="openDetail('laptop-1')" class="w-full py-3 bg-gradient-to-r from-fuchsia-600 to-pink-500 text-white rounded-xl font-semibold hover:shadow-lg hover:shadow-fuchsia-300 transition-all">
                        Lihat Detail
                    </button>
                </div>
            </div>

            <!-- Item Card 2 - Popular -->
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 group">
                <div class="relative overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=400" alt="Proyektor" class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-300">
                    <div class="absolute top-3 right-3">
                        <button class="w-10 h-10 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center shadow-lg hover:bg-fuchsia-600 hover:text-white transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="absolute top-3 left-3 flex flex-col space-y-2">
                        <span class="px-3 py-1 bg-green-500 text-white rounded-full text-xs font-bold shadow-lg">Tersedia</span>
                        <span class="px-3 py-1 bg-orange-500 text-white rounded-full text-xs font-bold shadow-lg">🔥 Populer</span>
                    </div>
                </div>
                <div class="p-5">
                    <div class="flex items-center space-x-2 mb-2">
                        <span class="px-2 py-1 bg-fuchsia-100 text-fuchsia-700 rounded-md text-xs font-semibold">Elektronik</span>
                        <span class="text-xs text-gray-500">ELK-002</span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2">Proyektor LCD Epson EB-X41</h3>
                    <p class="text-sm text-gray-600 mb-3 line-clamp-2">3300 lumens, XGA resolution, HDMI & VGA support</p>
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            <span class="text-sm font-semibold text-gray-700">Stok: <span class="text-fuchsia-600">3 unit</span></span>
                        </div>
                        <div class="flex items-center space-x-1">
                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <span class="text-xs font-semibold text-gray-600">5.0 (42)</span>
                        </div>
                    </div>
                    <button onclick="openDetail('proyektor-1')" class="w-full py-3 bg-gradient-to-r from-fuchsia-600 to-pink-500 text-white rounded-xl font-semibold hover:shadow-lg hover:shadow-fuchsia-300 transition-all">
                        Lihat Detail
                    </button>
                </div>
            </div>

            <!-- Item Card 3 - Limited Stock -->
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 group">
                <div class="relative overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1530124566582-a618bc2615dc?w=400" alt="Kamera" class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-300">
                    <div class="absolute top-3 right-3">
                        <button class="w-10 h-10 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center shadow-lg hover:bg-fuchsia-600 hover:text-white transition-all">
                            <svg class="w-5 h-5 fill-fuchsia-600" viewBox="0 0 24 24">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                            </svg>
                        </button>
                    </div>
                    <div class="absolute top-3 left-3">
                        <span class="px-3 py-1 bg-yellow-500 text-white rounded-full text-xs font-bold shadow-lg">Stok Terbatas</span>
                    </div>
                </div>
                <div class="p-5">
                    <div class="flex items-center space-x-2 mb-2">
                        <span class="px-2 py-1 bg-purple-100 text-purple-700 rounded-md text-xs font-semibold">Multimedia</span>
                        <span class="text-xs text-gray-500">MLT-001</span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2">Kamera DSLR Canon EOS 80D</h3>
                    <p class="text-sm text-gray-600 mb-3 line-clamp-2">24.2 MP, Full HD video, WiFi enabled</p>
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            <span class="text-sm font-semibold text-gray-700">Stok: <span class="text-yellow-600">1 unit</span></span>
                        </div>
                        <div class="flex items-center space-x-1">
                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <span class="text-xs font-semibold text-gray-600">4.9 (18)</span>
                        </div>
                    </div>
                    <button onclick="openDetail('kamera-1')" class="w-full py-3 bg-gradient-to-r from-fuchsia-600 to-pink-500 text-white rounded-xl font-semibold hover:shadow-lg hover:shadow-fuchsia-300 transition-all">
                        Lihat Detail
                    </button>
                </div>
            </div>

            <!-- Item Card 4 - Not Available -->
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 group opacity-75">
                <div class="relative overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1583394838336-acd977736f90?w=400" alt="Mikroskop" class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-300 grayscale">
                    <div class="absolute top-3 right-3">
                        <button class="w-10 h-10 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center shadow-lg hover:bg-fuchsia-600 hover:text-white transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="absolute top-3 left-3">
                        <span class="px-3 py-1 bg-red-500 text-white rounded-full text-xs font-bold shadow-lg">Tidak Tersedia</span>
                    </div>
                </div>
                <div class="p-5">
                    <div class="flex items-center space-x-2 mb-2">
                        <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-md text-xs font-semibold">Laboratorium</span>
                        <span class="text-xs text-gray-500">LAB-012</span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2">Mikroskop Digital Olympus</h3>
                    <p class="text-sm text-gray-600 mb-3 line-clamp-2">1000x magnification, USB connectivity, LED illumination</p>
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            <span class="text-sm font-semibold text-gray-700">Stok: <span class="text-red-600">0 unit</span></span>
                        </div>
                        <div class="flex items-center space-x-1">
                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <span class="text-xs font-semibold text-gray-600">4.7 (32)</span>
                        </div>
                    </div>
                    <button disabled class="w-full py-3 bg-gray-300 text-gray-500 rounded-xl font-semibold cursor-not-allowed">
                        Tidak Tersedia
                    </button>
                </div>
            </div>
        </div>

        <!-- Load More -->
        <div class="mt-12 text-center">
            <button class="px-8 py-3 bg-white border-2 border-fuchsia-200 text-fuchsia-600 rounded-xl font-semibold hover:bg-fuchsia-50 transition-all shadow-sm">
                Muat Lebih Banyak
            </button>
        </div>
    </main>

    <!-- Detail Modal -->
    <div id="detailModal" class="modal hidden fixed inset-0 bg-black bg-opacity-50 z-50 overflow-y-auto">
        <div class="min-h-screen px-4 flex items-center justify-center">
            <div class="bg-white rounded-2xl max-w-4xl w-full my-8 overflow-hidden shadow-2xl">
                <!-- Modal Header -->
                <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between z-10">
                    <h3 class="text-xl font-bold text-gray-900">Detail Item</h3>
                    <button onclick="closeModal()" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Left: Image Gallery -->
                        <div>
                            <div class="mb-4">
                                <img src="https://images.unsplash.com/photo-1593642632823-8f785ba67e45?w=600" alt="Laptop" class="w-full h-80 object-cover rounded-xl">
                            </div>
                            <div class="grid grid-cols-4 gap-2">
                                <img src="https://images.unsplash.com/photo-1593642632823-8f785ba67e45?w=150" class="w-full h-20 object-cover rounded-lg cursor-pointer border-2 border-fuchsia-500">
                                <img src="https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=150" class="w-full h-20 object-cover rounded-lg cursor-pointer opacity-50 hover:opacity-100">
                                <img src="https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=150" class="w-full h-20 object-cover rounded-lg cursor-pointer opacity-50 hover:opacity-100">
                                <img src="https://images.unsplash.com/photo-1525547719571-a2d4ac8945e2?w=150" class="w-full h-20 object-cover rounded-lg cursor-pointer opacity-50 hover:opacity-100">
                            </div>
                        </div>

                        <!-- Right: Details -->
                        <div>
                            <div class="flex items-center space-x-2 mb-3">
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-bold">Tersedia</span>
                                <span class="px-3 py-1 bg-fuchsia-100 text-fuchsia-700 rounded-full text-sm font-semibold">Elektronik</span>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900 mb-2">Laptop ASUS VivoBook 14</h2>
                            <p class="text-gray-600 mb-4">Kode: ELK-001</p>
                            
                            <div class="flex items-center space-x-4 mb-6">
                                <div class="flex items-center space-x-1">
                                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                    <span class="font-bold text-gray-900">4.8</span>
                                    <span class="text-gray-600">(24 review)</span>
                                </div>
                                <div class="border-l border-gray-300 pl-4">
                                    <span class="text-gray-600">Dipinjam: <span class="font-bold text-fuchsia-600">142x</span></span>
                                </div>
                            </div>

                            <!-- Specs -->
                            <div class="bg-gray-50 rounded-xl p-4 mb-6">
                                <h3 class="font-bold text-gray-900 mb-3">Spesifikasi:</h3>
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Processor:</span>
                                        <span class="font-semibold text-gray-900">Intel Core i5-1135G7</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">RAM:</span>
                                        <span class="font-semibold text-gray-900">8GB DDR4</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Storage:</span>
                                        <span class="font-semibold text-gray-900">512GB SSD NVMe</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Display:</span>
                                        <span class="font-semibold text-gray-900">14" FHD (1920x1080)</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Kondisi:</span>
                                        <span class="font-semibold text-green-600">Baik</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Stock Info -->
                            <div class="bg-fuchsia-50 border border-fuchsia-200 rounded-xl p-4 mb-6">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-5 h-5 text-fuchsia-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                        </svg>
                                        <span class="font-semibold text-fuchsia-900">Stok Tersedia:</span>
                                    </div>
                                    <span class="text-2xl font-bold text-fuchsia-600">5 unit</span>
                                </div>
                            </div>

                            <!-- Durasi Peminjaman -->
                            <div class="mb-6">
                                <label class="block text-sm font-bold text-gray-900 mb-3">Durasi Peminjaman:</label>
                                <div class="grid grid-cols-3 gap-3">
                                    <button onclick="selectDuration(this, 1)" class="duration-btn px-4 py-3 border-2 border-gray-200 rounded-xl font-semibold text-gray-700 hover:border-fuchsia-500 hover:bg-fuchsia-50 transition-all">
                                        1 Hari
                                    </button>
                                    <button onclick="selectDuration(this, 3)" class="duration-btn px-4 py-3 border-2 border-gray-200 rounded-xl font-semibold text-gray-700 hover:border-fuchsia-500 hover:bg-fuchsia-50 transition-all">
                                        3 Hari
                                    </button>
                                    <button onclick="selectDuration(this, 7)" class="duration-btn active px-4 py-3 border-2 border-fuchsia-500 bg-fuchsia-50 rounded-xl font-semibold text-fuchsia-700 transition-all">
                                        7 Hari
                                    </button>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="space-y-3">
                                <button onclick="submitRequest()" class="w-full py-4 bg-gradient-to-r from-fuchsia-600 to-pink-500 text-white rounded-xl font-bold text-lg hover:shadow-lg hover:shadow-fuchsia-300 transition-all">
                                    Ajukan Peminjaman
                                </button>
                                <button class="w-full py-3 bg-white border-2 border-gray-200 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition-all flex items-center justify-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                    <span>Tambah ke Favorit</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Description & Terms -->
                    <div class="mt-8 border-t border-gray-200 pt-8">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <div>
                                <h3 class="font-bold text-gray-900 mb-3">Deskripsi:</h3>
                                <p class="text-gray-600 text-sm leading-relaxed">
                                    Laptop ASUS VivoBook 14 dengan performa powerful untuk kebutuhan pembelajaran dan project. Dilengkapi dengan processor Intel Core i5 generasi 11, RAM 8GB, dan SSD 512GB yang cepat. Cocok untuk tugas multimedia, coding, dan presentasi.
                                </p>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 mb-3">Syarat & Ketentuan:</h3>
                                <ul class="space-y-2 text-sm text-gray-600">
                                    <li class="flex items-start space-x-2">
                                        <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span>Wajib menyertakan Kartu Pelajar</span>
                                    </li>
                                    <li class="flex items-start space-x-2">
                                        <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span>Maksimal peminjaman 7 hari</span>
                                    </li>
                                    <li class="flex items-start space-x-2">
                                        <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span>Tidak boleh dipinjamkan ke pihak lain</span>
                                    </li>
                                    <li class="flex items-start space-x-2">
                                        <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span>Bertanggung jawab atas kerusakan</span>
                                    </li>
                                    <li class="flex items-start space-x-2">
                                        <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span>Denda keterlambatan Rp 5.000/hari</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function filterCategory(category) {
            // Remove active class from all pills
            document.querySelectorAll('.category-pill').forEach(pill => {
                pill.classList.remove('active');
                pill.classList.add('text-gray-700');
            });
            // Add active class to clicked pill
            event.target.classList.add('active');
            event.target.classList.remove('text-gray-700');
            
            console.log('Filtering by:', category);
            // Here you would filter the items
        }

        function changeView(view) {
            const gridBtn = document.getElementById('gridViewBtn');
            const listBtn = document.getElementById('listViewBtn');
            
            if (view === 'grid') {
                gridBtn.classList.add('bg-gradient-to-r', 'from-fuchsia-600', 'to-pink-500', 'text-white', 'shadow-lg', 'shadow-fuchsia-200');
                gridBtn.classList.remove('bg-white', 'text-gray-600');
                listBtn.classList.add('bg-white', 'text-gray-600');
                listBtn.classList.remove('bg-gradient-to-r', 'from-fuchsia-600', 'to-pink-500', 'text-white', 'shadow-lg', 'shadow-fuchsia-200');
            } else {
                listBtn.classList.add('bg-gradient-to-r', 'from-fuchsia-600', 'to-pink-500', 'text-white', 'shadow-lg', 'shadow-fuchsia-200');
                listBtn.classList.remove('bg-white', 'text-gray-600');
                gridBtn.classList.add('bg-white', 'text-gray-600');
                gridBtn.classList.remove('bg-gradient-to-r', 'from-fuchsia-600', 'to-pink-500', 'text-white', 'shadow-lg', 'shadow-fuchsia-200');
            }
        }

        function openDetail(itemId) {
            document.getElementById('detailModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            document.getElementById('detailModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function selectDuration(btn, days) {
            document.querySelectorAll('.duration-btn').forEach(b => {
                b.classList.remove('active', 'border-fuchsia-500', 'bg-fuchsia-50', 'text-fuchsia-700');
                b.classList.add('border-gray-200', 'text-gray-700');
            });
            btn.classList.add('active', 'border-fuchsia-500', 'bg-fuchsia-50', 'text-fuchsia-700');
            btn.classList.remove('border-gray-200', 'text-gray-700');
        }

        function submitRequest() {
            alert('Permintaan peminjaman berhasil diajukan! Silakan tunggu persetujuan dari petugas.');
            closeModal();
        }

        // Close modal when clicking outside
        window.addEventListener('click', function(e) {
            const modal = document.getElementById('detailModal');
            if (e.target === modal) {
                closeModal();
            }
        });
    </script>
</body>
</html>