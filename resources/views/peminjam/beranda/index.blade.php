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
        .item-card {
            transition: all 0.3s ease;
        }
        .item-card:hover {
            transform: translateY(-5px);
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
<body class="bg-gradient-to-br from-fuchsia-50 via-pink-50 to-purple-50 min-h-screen">
    
    <!-- Navbar Component -->
    @include('components.navbar_peminjam')

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Hero Section -->
        <div class="bg-gradient-to-r from-fuchsia-600 to-pink-500 rounded-2xl p-8 mb-8 text-white shadow-xl shadow-fuchsia-200">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <h1 class="text-3xl sm:text-4xl font-bold mb-3">Selamat Datang, {{ Auth::user()->name ?? 'Siswa' }}! 👋</h1>
                    <p class="text-fuchsia-100 text-lg mb-6">Temukan dan pinjam peralatan sekolah dengan mudah</p>
                    <div class="flex flex-wrap gap-3">
                        <div class="bg-white/20 backdrop-blur-sm rounded-lg px-4 py-2 flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="font-semibold">{{ $totalDipinjam ?? 0 }} Item Dipinjam</span>
                        </div>
                        <div class="bg-white/20 backdrop-blur-sm rounded-lg px-4 py-2 flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0114 0z"></path>
                            </svg>
                            <span class="font-semibold">{{ $jatuhTempo ?? 0 }} Jatuh Tempo</span>
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
                <button class="text-sm font-semibold text-fuchsia-600 hover:text-fuchsia-700" onclick="showAllCategories()">
                    Lihat Semua →
                </button>
            </div>
            <div class="flex overflow-x-auto pb-4 space-x-3 scrollbar-hide" id="categoryContainer">
                <!-- Kategori akan diisi dengan data dari database -->
                <button onclick="filterCategory('all')" id="category-all" class="category-pill active px-6 py-3 bg-white rounded-xl font-semibold text-sm whitespace-nowrap shadow-sm hover:shadow-md transition-all flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                    <span>Semua</span>
                    <span class="bg-fuchsia-100 text-fuchsia-700 px-2 py-0.5 rounded-full text-xs font-bold" id="total-all">{{ $totalBarang ?? 0 }}</span>
                </button>
                
                @foreach($kategoris ?? [] as $kategori)
                <button onclick="filterCategory({{ $kategori->id }})" id="category-{{ $kategori->id }}" class="category-pill px-6 py-3 bg-white rounded-xl font-semibold text-sm text-gray-700 whitespace-nowrap shadow-sm hover:shadow-md transition-all flex items-center space-x-2">
                    @php
                        // Emoji berdasarkan kategori
                        $emoji = match(strtolower($kategori->nama_kategori)) {
                            'elektronik', 'komputer', 'laptop' => '💻',
                            'buku', 'literatur', 'referensi' => '📚',
                            'laboratorium', 'kimia', 'biologi' => '🔬',
                            'olahraga', 'sport', 'bola' => '⚽',
                            'multimedia', 'kamera', 'video' => '📷',
                            'alat tulis', 'stationery' => '✏️',
                            'musik', 'instrumen' => '🎵',
                            'kesenian', 'seni' => '🎨',
                            default => '📦'
                        };
                    @endphp
                    <span>{{ $emoji }}</span>
                    <span>{{ $kategori->nama_kategori }}</span>
                    <span class="bg-gray-100 text-gray-700 px-2 py-0.5 rounded-full text-xs font-bold" id="count-{{ $kategori->id }}">{{ $kategori->barang_count ?? 0 }}</span>
                </button>
                @endforeach
            </div>
        </div>

        <!-- Filters & Sort -->
        <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center space-x-3">
                <select id="sortSelect" class="px-4 py-2.5 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-fuchsia-500 focus:border-transparent shadow-sm">
                    <option value="latest">Urutkan: Terbaru</option>
                    <option value="name_asc">Nama A-Z</option>
                    <option value="name_desc">Nama Z-A</option>
                    <option value="stock_desc">Stok Terbanyak</option>
                    <option value="popular">Paling Populer</option>
                </select>
                <select id="stockFilter" class="px-4 py-2.5 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-fuchsia-500 focus:border-transparent shadow-sm">
                    <option value="all">Semua Stok</option>
                    <option value="available">Tersedia</option>
                    <option value="low">Stok Sedikit</option>
                    <option value="out">Habis</option>
                </select>
                <button id="clearFilters" class="px-4 py-2.5 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
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
            <!-- Data barang akan diisi dengan data dari database -->
            @forelse($barangs as $barang)
            @php
                // Tentukan status stok
                $statusClass = '';
                $statusText = '';
                $stockClass = '';
                
                if ($barang->jumlah > 5) {
                    $statusClass = 'bg-green-100 text-green-700';
                    $statusText = 'Tersedia';
                    $stockClass = 'text-fuchsia-600';
                } elseif ($barang->jumlah > 0 && $barang->jumlah <= 5) {
                    $statusClass = 'bg-yellow-100 text-yellow-700';
                    $statusText = 'Stok Terbatas';
                    $stockClass = 'text-yellow-600';
                } else {
                    $statusClass = 'bg-red-100 text-red-700';
                    $statusText = 'Tidak Tersedia';
                    $stockClass = 'text-red-600';
                }
                
                // Warna badge kategori
                $categoryColors = [
                    'Elektronik' => ['bg' => 'bg-fuchsia-100', 'text' => 'text-fuchsia-700'],
                    'Buku' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-700'],
                    'Laboratorium' => ['bg' => 'bg-purple-100', 'text' => 'text-purple-700'],
                    'Olahraga' => ['bg' => 'bg-orange-100', 'text' => 'text-orange-700'],
                    'Multimedia' => ['bg' => 'bg-pink-100', 'text' => 'text-pink-700'],
                    'default' => ['bg' => 'bg-gray-100', 'text' => 'text-gray-700']
                ];
                
                $categoryName = $barang->kategori->nama_kategori ?? 'Lainnya';
                $categoryColor = $categoryColors[$categoryName] ?? $categoryColors['default'];
                
                // Path gambar
                $imagePath = $barang->gambar ? Storage::url($barang->gambar) : 'https://images.unsplash.com/photo-1593642632823-8f785ba67e45?w=400';
            @endphp
            
            <div class="item-card bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 group" 
                 data-category="{{ $barang->kategori_id }}" 
                 data-stock="{{ $barang->jumlah }}"
                 data-name="{{ strtolower($barang->nama_barang) }}">
                <div class="relative overflow-hidden">
                    <img src="{{ $imagePath }}" alt="{{ $barang->nama_barang }}" class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-300">
                    <div class="absolute top-3 right-3">
                        <button onclick="toggleFavorite({{ $barang->id }})" class="w-10 h-10 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center shadow-lg hover:bg-fuchsia-600 hover:text-white transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="absolute top-3 left-3">
                        <span class="px-3 py-1 {{ $statusClass }} rounded-full text-xs font-bold shadow-lg">{{ $statusText }}</span>
                    </div>
                </div>
                <div class="p-5">
                    <div class="flex items-center space-x-2 mb-2">
                        <span class="px-2 py-1 {{ $categoryColor['bg'] }} {{ $categoryColor['text'] }} rounded-md text-xs font-semibold">
                            {{ $categoryName }}
                        </span>
                        <span class="text-xs text-gray-500">BRG-{{ str_pad($barang->id, 3, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2">{{ $barang->nama_barang }}</h3>
                    <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $barang->deskripsi ?? 'Tanpa deskripsi' }}</p>
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            <span class="text-sm font-semibold text-gray-700">Stok: <span class="{{ $stockClass }}">{{ $barang->jumlah }} unit</span></span>
                        </div>
                        <div class="flex items-center space-x-1">
                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <span class="text-xs font-semibold text-gray-600">4.5 ({{ rand(10, 50) }})</span>
                        </div>
                    </div>
                    <button onclick="openDetail({{ $barang->id }})" {{ $barang->jumlah == 0 ? 'disabled' : '' }} 
                        class="w-full py-3 {{ $barang->jumlah > 0 ? 'bg-gradient-to-r from-fuchsia-600 to-pink-500 text-white hover:shadow-lg hover:shadow-fuchsia-300' : 'bg-gray-300 text-gray-500 cursor-not-allowed' }} rounded-xl font-semibold transition-all">
                        {{ $barang->jumlah > 0 ? 'Lihat Detail' : 'Tidak Tersedia' }}
                    </button>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <div class="w-24 h-24 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Belum ada barang tersedia</h3>
                <p class="text-gray-600">Silakan hubungi admin untuk informasi lebih lanjut.</p>
            </div>
            @endforelse
        </div>

        <!-- Load More -->
        @if($barangs->hasPages())
        <div class="mt-12 text-center">
            <button id="loadMoreBtn" class="px-8 py-3 bg-white border-2 border-fuchsia-200 text-fuchsia-600 rounded-xl font-semibold hover:bg-fuchsia-50 transition-all shadow-sm">
                Muat Lebih Banyak
            </button>
        </div>
        @endif
    </main>

    <!-- Detail Modal -->
    <div id="detailModal" class="modal hidden fixed inset-0 bg-black bg-opacity-50 z-50 overflow-y-auto">
        <div class="min-h-screen px-4 flex items-center justify-center">
            <div class="bg-white rounded-2xl max-w-4xl w-full my-8 overflow-hidden shadow-2xl" id="modalContent">
                <!-- Konten akan diisi oleh JavaScript -->
            </div>
        </div>
    </div>

    <script>
        // Data barang dari server
        let allBarangs = @json($barangs->items() ?? []);
        let currentCategory = 'all';
        let currentSort = 'latest';
        let currentStockFilter = 'all';
        let currentPage = 1;
        let hasMorePages = {{ $barangs->hasMorePages() ? 'true' : 'false' }};

        // Filter berdasarkan kategori
        function filterCategory(categoryId) {
            currentCategory = categoryId;
            
            // Update active pill
            document.querySelectorAll('.category-pill').forEach(pill => {
                pill.classList.remove('active', 'text-white');
                pill.classList.add('text-gray-700');
            });
            
            const pill = document.getElementById(`category-${categoryId}`);
            if (pill) {
                pill.classList.add('active');
                pill.classList.remove('text-gray-700');
            }
            
            applyFilters();
        }

        // Apply all filters
        function applyFilters() {
            const items = document.querySelectorAll('.item-card');
            let visibleCount = 0;
            
            items.forEach(item => {
                const category = item.getAttribute('data-category');
                const stock = parseInt(item.getAttribute('data-stock'));
                const name = item.getAttribute('data-name');
                
                let visible = true;
                
                // Filter kategori
                if (currentCategory !== 'all' && category !== currentCategory.toString()) {
                    visible = false;
                }
                
                // Filter stok
                if (currentStockFilter === 'available' && stock === 0) {
                    visible = false;
                } else if (currentStockFilter === 'low' && (stock > 5 || stock === 0)) {
                    visible = false;
                } else if (currentStockFilter === 'out' && stock > 0) {
                    visible = false;
                }
                
                // Sorting (sederhana untuk demo)
                if (visible) {
                    item.style.display = '';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });
            
            // Update counter
            document.getElementById('total-all').textContent = visibleCount;
        }

        // Show all categories
        function showAllCategories() {
            document.getElementById('categoryContainer').scrollTo({
                left: 0,
                behavior: 'smooth'
            });
        }

        // Change view (grid/list)
        function changeView(view) {
            const gridBtn = document.getElementById('gridViewBtn');
            const listBtn = document.getElementById('listViewBtn');
            const itemGrid = document.getElementById('itemGrid');
            
            if (view === 'grid') {
                gridBtn.classList.add('bg-gradient-to-r', 'from-fuchsia-600', 'to-pink-500', 'text-white', 'shadow-lg', 'shadow-fuchsia-200');
                gridBtn.classList.remove('bg-white', 'text-gray-600');
                listBtn.classList.add('bg-white', 'text-gray-600');
                listBtn.classList.remove('bg-gradient-to-r', 'from-fuchsia-600', 'to-pink-500', 'text-white', 'shadow-lg', 'shadow-fuchsia-200');
                itemGrid.classList.remove('grid-cols-1');
                itemGrid.classList.add('grid-cols-1', 'sm:grid-cols-2', 'lg:grid-cols-3', 'xl:grid-cols-4');
            } else {
                listBtn.classList.add('bg-gradient-to-r', 'from-fuchsia-600', 'to-pink-500', 'text-white', 'shadow-lg', 'shadow-fuchsia-200');
                listBtn.classList.remove('bg-white', 'text-gray-600');
                gridBtn.classList.add('bg-white', 'text-gray-600');
                gridBtn.classList.remove('bg-gradient-to-r', 'from-fuchsia-600', 'to-pink-500', 'text-white', 'shadow-lg', 'shadow-fuchsia-200');
                itemGrid.classList.remove('grid-cols-1', 'sm:grid-cols-2', 'lg:grid-cols-3', 'xl:grid-cols-4');
                itemGrid.classList.add('grid-cols-1');
            }
        }

        // Open detail modal
        function openDetail(barangId) {
            const barang = allBarangs.find(b => b.id === barangId);
            if (!barang) return;
            
            // Tentukan status stok
            let statusClass, statusText, stockClass;
            if (barang.jumlah > 5) {
                statusClass = 'bg-green-100 text-green-700';
                statusText = 'Tersedia';
                stockClass = 'text-fuchsia-600';
            } else if (barang.jumlah > 0 && barang.jumlah <= 5) {
                statusClass = 'bg-yellow-100 text-yellow-700';
                statusText = 'Stok Terbatas';
                stockClass = 'text-yellow-600';
            } else {
                statusClass = 'bg-red-100 text-red-700';
                statusText = 'Tidak Tersedia';
                stockClass = 'text-red-600';
            }
            
            // Path gambar
            const imagePath = barang.gambar ? `{{ Storage::url('') }}${barang.gambar}` : 'https://images.unsplash.com/photo-1593642632823-8f785ba67e45?w=600';
            
            // Warna kategori
            const categoryColors = {
                'Elektronik': ['bg-fuchsia-100', 'text-fuchsia-700'],
                'Buku': ['bg-blue-100', 'text-blue-700'],
                'Laboratorium': ['bg-purple-100', 'text-purple-700'],
                'Olahraga': ['bg-orange-100', 'text-orange-700'],
                'Multimedia': ['bg-pink-100', 'text-pink-700'],
                'default': ['bg-gray-100', 'text-gray-700']
            };
            
            const categoryName = barang.kategori?.nama_kategori || 'Lainnya';
            const categoryColor = categoryColors[categoryName] || categoryColors['default'];
            
            // Buat konten modal
            const modalContent = `
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
                        <!-- Left: Image -->
                        <div>
                            <div class="mb-4">
                                <img src="${imagePath}" alt="${barang.nama_barang}" class="w-full h-80 object-cover rounded-xl">
                            </div>
                        </div>

                        <!-- Right: Details -->
                        <div>
                            <div class="flex items-center space-x-2 mb-3">
                                <span class="px-3 py-1 ${statusClass} rounded-full text-sm font-bold">${statusText}</span>
                                <span class="px-3 py-1 ${categoryColor[0]} ${categoryColor[1]} rounded-full text-sm font-semibold">${categoryName}</span>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900 mb-2">${barang.nama_barang}</h2>
                            <p class="text-gray-600 mb-4">Kode: BRG-${String(barang.id).padStart(3, '0')}</p>
                            
                            <div class="flex items-center space-x-4 mb-6">
                                <div class="flex items-center space-x-1">
                                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                    <span class="font-bold text-gray-900">4.5</span>
                                    <span class="text-gray-600">(${Math.floor(Math.random() * 50) + 10} review)</span>
                                </div>
                            </div>

                            <!-- Deskripsi -->
                            <div class="bg-gray-50 rounded-xl p-4 mb-6">
                                <h3 class="font-bold text-gray-900 mb-3">Deskripsi:</h3>
                                <p class="text-sm text-gray-600 leading-relaxed">${barang.deskripsi || 'Tidak ada deskripsi yang tersedia.'}</p>
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
                                    <span class="text-2xl font-bold ${stockClass}">${barang.jumlah} unit</span>
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
                                <button onclick="submitRequest(${barang.id})" ${barang.jumlah === 0 ? 'disabled' : ''} class="w-full py-4 ${barang.jumlah > 0 ? 'bg-gradient-to-r from-fuchsia-600 to-pink-500 text-white hover:shadow-lg hover:shadow-fuchsia-300' : 'bg-gray-300 text-gray-500 cursor-not-allowed'} rounded-xl font-bold text-lg transition-all">
                                    ${barang.jumlah > 0 ? 'Ajukan Peminjaman' : 'Tidak Tersedia'}
                                </button>
                                <button onclick="toggleFavorite(${barang.id})" class="w-full py-3 bg-white border-2 border-gray-200 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition-all flex items-center justify-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                    <span>Tambah ke Favorit</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Syarat & Ketentuan -->
                    <div class="mt-8 border-t border-gray-200 pt-8">
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
            `;
            
            document.getElementById('modalContent').innerHTML = modalContent;
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

        function submitRequest(barangId) {
            alert('Permintaan peminjaman berhasil diajukan! Silakan tunggu persetujuan dari petugas.');
            closeModal();
        }

        function toggleFavorite(barangId) {
            const btn = event.currentTarget;
            btn.classList.toggle('bg-fuchsia-600');
            btn.classList.toggle('text-white');
            
            if (btn.classList.contains('bg-fuchsia-600')) {
                alert('Barang telah ditambahkan ke favorit!');
            }
        }

        // Event listeners
        document.addEventListener('DOMContentLoaded', function() {
            // Filter events
            document.getElementById('sortSelect').addEventListener('change', function(e) {
                currentSort = e.target.value;
                applyFilters();
            });
            
            document.getElementById('stockFilter').addEventListener('change', function(e) {
                currentStockFilter = e.target.value;
                applyFilters();
            });
            
            document.getElementById('clearFilters').addEventListener('click', function() {
                currentCategory = 'all';
                currentSort = 'latest';
                currentStockFilter = 'all';
                
                document.getElementById('sortSelect').value = 'latest';
                document.getElementById('stockFilter').value = 'all';
                
                document.querySelectorAll('.category-pill').forEach(pill => {
                    pill.classList.remove('active', 'text-white');
                    pill.classList.add('text-gray-700');
                });
                
                document.getElementById('category-all').classList.add('active');
                document.getElementById('category-all').classList.remove('text-gray-700');
                
                applyFilters();
            });
            
            // Load more
            document.getElementById('loadMoreBtn')?.addEventListener('click', function() {
                // Implementasi load more
                alert('Fitur load more akan diimplementasi nanti!');
            });
            
            // Close modal when clicking outside
            window.addEventListener('click', function(e) {
                const modal = document.getElementById('detailModal');
                if (e.target === modal) {
                    closeModal();
                }
            });
            
            // Initialize filters
            applyFilters();
        });
    </script>
</body>
</html>