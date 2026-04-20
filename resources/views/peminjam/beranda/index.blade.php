<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Beranda - SarPras Siswa</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite('resources/js/cart.js')
    <style>
        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        
        /* Reset dan perbaikan CSS untuk menghindari konflik dengan navbar */
        body {
            background: linear-gradient(to bottom right, #fdf4ff, #fff0f7, #faf5ff);
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }
        
        main {
            max-width: 1280px;
            margin-left: auto;
            margin-right: auto;
            padding: 2rem 1rem;
        }
        
        @media (min-width: 640px) {
            main {
                padding-left: 1.5rem;
                padding-right: 1.5rem;
            }
        }
        
        @media (min-width: 1024px) {
            main {
                padding-left: 2rem;
                padding-right: 2rem;
            }
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
        
        /* Scrollbar hide */
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        
        /* Line clamp */
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        /* Custom datepicker styling */
        .custom-datepicker {
            border: 1px solid #e5e7eb;
            border-radius: 0.75rem;
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
            width: 100%;
            transition: all 0.2s;
        }
        
        .custom-datepicker:focus {
            outline: none;
            border-color: #c026d3;
            box-shadow: 0 0 0 2px rgba(192, 38, 211, 0.1);
        }
        
        .custom-datepicker:read-only {
            background-color: #f9fafb;
            cursor: not-allowed;
        }
        
        /* Animations */
        .fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Reason textarea styling */
        .reason-textarea {
            border: 1px solid #e5e7eb;
            border-radius: 0.75rem;
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
            width: 100%;
            transition: all 0.2s;
            resize: vertical;
            min-height: 100px;
        }
        
        .reason-textarea:focus {
            outline: none;
            border-color: #c026d3;
            box-shadow: 0 0 0 2px rgba(192, 38, 211, 0.1);
        }
        
        /* Time input styling */
        .time-input {
            border: 1px solid #e5e7eb;
            border-radius: 0.75rem;
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
            width: 100%;
            transition: all 0.2s;
        }
        
        .time-input:focus {
            outline: none;
            border-color: #c026d3;
            box-shadow: 0 0 0 2px rgba(192, 38, 211, 0.1);
        }

        /* Info box styling */
        .info-box {
            background-color: #f0f9ff;
            border: 1px solid #bae6fd;
            border-radius: 0.75rem;
            padding: 0.75rem 1rem;
            color: #0369a1;
            font-size: 0.875rem;
        }

        /* Loading spinner */
@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.animate-spin {
    animation: spin 1s linear infinite;
}

/* Notification toast */
.notification-toast {
    max-width: 400px;
    min-width: 300px;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    animation: slideIn 0.3s ease-out;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateX(100%);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}
    </style>
</head>
<body>
    
    <!-- Navbar Component -->
    @include('components.navbar_peminjam')

    <!-- Main Content -->
    <main>
        <!-- Hero Section -->
        <div class="bg-gradient-to-r from-fuchsia-600 to-pink-500 rounded-2xl p-6 sm:p-8 mb-8 text-white shadow-xl shadow-fuchsia-200/50 fade-in">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold mb-3">Selamat Datang, {{ Auth::user()->name ?? 'Siswa' }}! 👋</h1>
                    <p class="text-fuchsia-100 text-base sm:text-lg mb-6">Temukan dan pinjam peralatan sekolah dengan mudah</p>
                    <div class="flex flex-wrap gap-3">
                        <div class="bg-white/20 backdrop-blur-sm rounded-lg px-4 py-2 flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="font-semibold text-sm sm:text-base">{{ $totalDipinjam ?? 0 }} Item Dipinjam</span>
                        </div>
                        <div class="bg-white/20 backdrop-blur-sm rounded-lg px-4 py-2 flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0114 0z"></path>
                            </svg>
                            <span class="font-semibold text-sm sm:text-base">{{ $jatuhTempo ?? 0 }} Jatuh Tempo</span>
                            <span class="inline-flex items-center rounded-full bg-red-100 text-red-700 px-2.5 py-1 text-xs font-semibold">{{ $terlambat ?? 0 }} Telat</span>
                        </div>
                    </div>
                </div>
                <div class="hidden lg:block">
                    <svg class="w-36 h-36 lg:w-48 lg:h-48 text-white/20" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Category Pills -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-900">Kategori</h2>
            </div>
            <div class="flex overflow-x-auto pb-4 space-x-3 scrollbar-hide" id="categoryContainer">
                <button onclick="filterCategory('all')" id="category-all" class="category-pill active px-5 py-2.5 bg-white rounded-xl font-semibold text-sm whitespace-nowrap shadow-sm hover:shadow-md transition-all flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                    <span>Semua</span>
                    <span class="bg-fuchsia-100 text-fuchsia-700 px-2 py-0.5 rounded-full text-xs font-bold" id="total-all">{{ $totalBarang ?? 0 }}</span>
                </button>
                
                @foreach($kategoris ?? [] as $kategori)
                <button onclick="filterCategory({{ $kategori->id }})" id="category-{{ $kategori->id }}" class="category-pill px-5 py-2.5 bg-white rounded-xl font-semibold text-sm text-gray-700 whitespace-nowrap shadow-sm hover:shadow-md transition-all flex items-center space-x-2">
                    @php
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
            <div class="flex flex-wrap items-center gap-2">
                <select id="sortSelect" class="px-4 py-2.5 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-fuchsia-500 focus:border-transparent shadow-sm">
                    <option value="latest">Urutkan: Terbaru</option>
                    <option value="name_asc">Nama A-Z</option>
                    <option value="name_desc">Nama Z-A</option>
                    <option value="stock_desc">Stok Terbanyak</option>
                </select>
                <select id="stockFilter" class="px-4 py-2.5 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-fuchsia-500 focus:border-transparent shadow-sm">
                    <option value="all">Semua Stok</option>
                    <option value="available">Tersedia</option>
                    <option value="low">Stok Sedikit</option>
                    <option value="out">Habis</option>
                </select>
                <button id="clearFilters" class="p-2.5 bg-white border border-gray-200 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="flex items-center space-x-2">
                <button onclick="changeView('grid')" id="gridViewBtn" class="p-2.5 bg-gradient-to-r from-fuchsia-600 to-pink-500 text-white rounded-lg shadow-lg shadow-fuchsia-200 transition-all">
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
        <div id="itemGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5 lg:gap-6">
            @forelse($barangs as $barang)
            @php
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
                $imagePath = $barang->gambar ? Storage::url($barang->gambar) : 'https://images.unsplash.com/photo-1593642632823-8f785ba67e45?w=400';
            @endphp
            
            <div class="item-card bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 group fade-in" 
                 data-category="{{ $barang->kategori_id }}" 
                 data-stock="{{ $barang->jumlah }}"
                 data-name="{{ strtolower($barang->nama_barang) }}">
                <div class="relative overflow-hidden">
                    <img src="{{ $imagePath }}" alt="{{ $barang->nama_barang }}" class="w-full h-44 sm:h-48 object-cover group-hover:scale-110 transition-transform duration-300">
                    <div class="absolute top-3 left-3">
                        <span class="px-3 py-1 {{ $statusClass }} rounded-full text-xs font-bold shadow-lg">{{ $statusText }}</span>
                    </div>
                </div>
                <div class="p-4 sm:p-5">
                    <div class="flex items-center space-x-2 mb-2">
                        <span class="px-2 py-1 {{ $categoryColor['bg'] }} {{ $categoryColor['text'] }} rounded-md text-xs font-semibold">
                            {{ $categoryName }}
                        </span>
                        <span class="text-xs text-gray-500">BRG-{{ str_pad($barang->id, 3, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    <h3 class="text-base sm:text-lg font-bold text-gray-900 mb-2 line-clamp-2">{{ $barang->nama_barang }}</h3>
                    <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $barang->deskripsi ?? 'Tanpa deskripsi' }}</p>
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            <span class="text-sm font-semibold text-gray-700">Stok: <span class="{{ $stockClass }}">{{ $barang->jumlah }} unit</span></span>
                        </div>
                    </div>
                    <button onclick="openDetail({{ $barang->id }})" {{ $barang->jumlah == 0 ? 'disabled' : '' }} 
                        class="w-full py-2.5 sm:py-3 {{ $barang->jumlah > 0 ? 'bg-gradient-to-r from-fuchsia-600 to-pink-500 text-white hover:shadow-lg hover:shadow-fuchsia-300' : 'bg-gray-300 text-gray-500 cursor-not-allowed' }} rounded-xl font-semibold transition-all text-sm sm:text-base">
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
    <div id="detailModal" class="modal hidden fade-in" style="display: none;" onclick="if(event.target === this) closeModal()">
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

        // Format tanggal ke YYYY-MM-DD
        function formatDate(date) {
            const d = new Date(date);
            const year = d.getFullYear();
            const month = String(d.getMonth() + 1).padStart(2, '0');
            const day = String(d.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        // Dapatkan tanggal hari ini
        function getTodayDate() {
            const today = new Date();
            return formatDate(today);
        }

        // Dapatkan tanggal besok
        function getTomorrowDate() {
            const tomorrow = new Date();
            tomorrow.setDate(tomorrow.getDate() + 1);
            return formatDate(tomorrow);
        }

        // Dapatkan waktu sekarang (HH:MM)
        function getCurrentTime() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            return `${hours}:${minutes}`;
        }

        // Filter berdasarkan kategori
        function filterCategory(categoryId) {
            currentCategory = categoryId;
            
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
                
                let visible = true;
                
                if (currentCategory !== 'all' && category !== currentCategory.toString()) {
                    visible = false;
                }
                
                if (currentStockFilter === 'available' && stock === 0) {
                    visible = false;
                } else if (currentStockFilter === 'low' && (stock > 5 || stock === 0)) {
                    visible = false;
                } else if (currentStockFilter === 'out' && stock > 0) {
                    visible = false;
                }
                
                if (visible) {
                    item.style.display = '';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });
            
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
                itemGrid.classList.add('grid-cols-1', 'sm:grid-cols-2', 'lg:grid-cols-3', 'xl:grid-cols-4');
                itemGrid.classList.remove('grid-cols-1');
            } else {
                listBtn.classList.add('bg-gradient-to-r', 'from-fuchsia-600', 'to-pink-500', 'text-white', 'shadow-lg', 'shadow-fuchsia-200');
                listBtn.classList.remove('bg-white', 'text-gray-600');
                gridBtn.classList.add('bg-white', 'text-gray-600');
                gridBtn.classList.remove('bg-gradient-to-r', 'from-fuchsia-600', 'to-pink-500', 'text-white', 'shadow-lg', 'shadow-fuchsia-200');
                itemGrid.classList.remove('sm:grid-cols-2', 'lg:grid-cols-3', 'xl:grid-cols-4');
                itemGrid.classList.add('grid-cols-1');
            }
        }

        // Set tipe peminjaman
        function setLoanType(type) {
            const hariBtn = document.getElementById('loanTypeHari');
            const jamBtn = document.getElementById('loanTypeJam');
            const durationHari = document.getElementById('durationHari');
            const durationJam = document.getElementById('durationJam');
            
            if (type === 'hari') {
                hariBtn.classList.add('active', 'border-fuchsia-500', 'bg-fuchsia-50', 'text-fuchsia-700');
                hariBtn.classList.remove('border-gray-200', 'text-gray-700');
                jamBtn.classList.add('border-gray-200', 'text-gray-700');
                jamBtn.classList.remove('active', 'border-fuchsia-500', 'bg-fuchsia-50', 'text-fuchsia-700');
                
                durationHari.classList.remove('hidden');
                durationJam.classList.add('hidden');
            } else {
                jamBtn.classList.add('active', 'border-fuchsia-500', 'bg-fuchsia-50', 'text-fuchsia-700');
                jamBtn.classList.remove('border-gray-200', 'text-gray-700');
                hariBtn.classList.add('border-gray-200', 'text-gray-700');
                hariBtn.classList.remove('active', 'border-fuchsia-500', 'bg-fuchsia-50', 'text-fuchsia-700');
                
                durationJam.classList.remove('hidden');
                durationHari.classList.add('hidden');
                
                // Update tanggal kembali otomatis sama dengan tanggal ambil
                updateReturnDateJam();
            }
        }

        // Update tanggal kembali untuk peminjaman per jam (otomatis sama dengan tanggal ambil)
        function updateReturnDateJam() {
            const pickupDate = document.getElementById('pickupDateJam').value;
            const returnDateInput = document.getElementById('returnDateJam');
            if (pickupDate && returnDateInput) {
                returnDateInput.value = pickupDate;
            }
        }

        // Validasi tanggal kembali tidak boleh kurang dari tanggal ambil
        function validateReturnDate() {
            const pickupDate = document.getElementById('pickupDateHari').value;
            const returnDate = document.getElementById('returnDateHari').value;
            
            if (returnDate < pickupDate) {
                alert('Tanggal kembali tidak boleh kurang dari tanggal ambil!');
                document.getElementById('returnDateHari').value = pickupDate;
            }
        }

        // Validasi jam kembali tidak boleh kurang dari jam ambil (karena tanggal sama)
        function validateReturnTime() {
            const pickupTime = document.getElementById('pickupTime').value;
            const returnTime = document.getElementById('returnTime').value;
            
            if (returnTime < pickupTime) {
                alert('Jam kembali tidak boleh kurang dari jam ambil!');
                document.getElementById('returnTime').value = pickupTime;
            }
        }

        // Open detail modal
        // Open detail modal
function openDetail(barangId) {
    const barang = allBarangs.find(b => b.id === barangId);
    if (!barang) return;
    
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
    
    const imagePath = barang.gambar ? `{{ Storage::url('') }}${barang.gambar}` : 'https://images.unsplash.com/photo-1593642632823-8f785ba67e45?w=600';
    
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
    
    const today = getTodayDate();
    const tomorrow = getTomorrowDate();
    const currentTime = getCurrentTime();
    
    const modalContent = `
        <!-- Modal Header -->
        <div class="sticky top-0 bg-white border-b border-gray-200 px-5 sm:px-6 py-4 flex items-center justify-between z-10">
            <h3 class="text-lg sm:text-xl font-bold text-gray-900">Detail Item</h3>
            <button onclick="closeModal()" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="p-5 sm:p-6 max-h-[calc(100vh-120px)] overflow-y-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">
                <!-- Left: Image -->
                <div>
                    <div class="mb-4">
                        <img src="${imagePath}" alt="${barang.nama_barang}" class="w-full h-60 sm:h-72 lg:h-80 object-cover rounded-xl">
                    </div>
                </div>

                <!-- Right: Details -->
                <div>
                    <div class="flex flex-wrap items-center gap-2 mb-3">
                        <span class="px-3 py-1 ${statusClass} rounded-full text-xs sm:text-sm font-bold">${statusText}</span>
                        <span class="px-3 py-1 ${categoryColor[0]} ${categoryColor[1]} rounded-full text-xs sm:text-sm font-semibold">${categoryName}</span>
                    </div>
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-2">${barang.nama_barang}</h2>
                    <p class="text-sm sm:text-base text-gray-600 mb-4">Kode: BRG-${String(barang.id).padStart(3, '0')}</p>
                    
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
                            <span class="text-xl sm:text-2xl font-bold ${stockClass}">${barang.jumlah} unit</span>
                        </div>
                    </div>

                    <!-- QUANTITY SELECTOR - INI YANG DITAMBAHKAN -->
                    <div class="mb-6 p-4 bg-gradient-to-r from-fuchsia-50 to-pink-50 rounded-xl border border-fuchsia-200">
                        <label class="block text-sm font-bold text-gray-900 mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-fuchsia-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            Jumlah yang Ingin Dipinjam
                        </label>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <button onclick="decrementJumlah('jumlahPinjam', ${barang.jumlah})" class="w-10 h-10 bg-white rounded-lg border border-fuchsia-200 hover:bg-fuchsia-100 transition-colors flex items-center justify-center text-xl font-bold text-fuchsia-700 shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                    </svg>
                                </button>
                                <input type="number" id="jumlahPinjam" value="1" min="1" max="${barang.jumlah}" 
                                    onchange="validateJumlah(this, ${barang.jumlah})"
                                    class="w-16 text-center px-2 py-2 border border-fuchsia-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-fuchsia-500 font-semibold text-fuchsia-700">
                                <button onclick="incrementJumlah('jumlahPinjam', ${barang.jumlah})" class="w-10 h-10 bg-white rounded-lg border border-fuchsia-200 hover:bg-fuchsia-100 transition-colors flex items-center justify-center text-xl font-bold text-fuchsia-700 shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="text-sm text-gray-600">
                                <span class="font-medium">Maksimal:</span> ${barang.jumlah} unit
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 mt-3 flex items-center">
                            <svg class="w-4 h-4 mr-1 text-fuchsia-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Jumlah yang dipinjam akan mengurangi stok barang
                        </p>
                    </div>

                    <!-- Tipe Peminjaman -->
                    <div class="mb-6">
                        <label class="block text-sm font-bold text-gray-900 mb-3">⏰ Tipe Peminjaman:</label>
                        <div class="grid grid-cols-2 gap-3">
                            <button onclick="setLoanType('hari')" id="loanTypeHari" class="px-4 py-3 border-2 border-fuchsia-500 bg-fuchsia-50 rounded-xl font-semibold text-fuchsia-700 transition-all active">
                                📅 Per Hari
                            </button>
                            <button onclick="setLoanType('jam')" id="loanTypeJam" class="px-4 py-3 border-2 border-gray-200 rounded-xl font-semibold text-gray-700 hover:border-fuchsia-500 hover:bg-fuchsia-50 transition-all">
                                ⏰ Per Jam
                            </button>
                        </div>
                    </div>

                    <!-- Form Peminjaman - Per Hari -->
                    <div id="durationHari" class="mb-6">
                        <label class="block text-sm font-bold text-gray-900 mb-3">📅 Detail Peminjaman Per Hari:</label>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Ambil</label>
                                <input type="date" id="pickupDateHari" value="${today}" min="${today}" class="custom-datepicker">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Kembali</label>
                                <input type="date" id="returnDateHari" value="${tomorrow}" min="${today}" onchange="validateReturnDate()" class="custom-datepicker">
                            </div>
                        </div>
                    </div>

                    <!-- Form Peminjaman - Per Jam -->
                    <div id="durationJam" class="mb-6 hidden">
                        <label class="block text-sm font-bold text-gray-900 mb-3">⏰ Detail Peminjaman Per Jam:</label>
                        
                        <!-- Info Box -->
                        <div class="info-box mb-4 flex items-start space-x-2">
                            <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-xs sm:text-sm">Peminjaman per jam hanya berlaku di hari yang sama. Tanggal kembali otomatis mengikuti tanggal ambil.</span>
                        </div>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Ambil</label>
                                <input type="date" id="pickupDateJam" value="${today}" min="${today}" onchange="updateReturnDateJam()" class="custom-datepicker">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Jam Ambil</label>
                                <input type="time" id="pickupTime" value="${currentTime}" class="time-input">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Kembali</label>
                                <input type="date" id="returnDateJam" value="${today}" class="custom-datepicker" readonly>
                                <p class="text-xs text-gray-500 mt-1">* Otomatis mengikuti tanggal ambil</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Jam Kembali</label>
                                <input type="time" id="returnTime" value="${currentTime}" onchange="validateReturnTime()" class="time-input">
                                <p class="text-xs text-gray-500 mt-1">* Minimal 1 jam setelah jam ambil</p>
                            </div>
                        </div>
                    </div>

                    <!-- TOTAL YANG DIPINJAM SUMMARY -->
                    <div class="mb-6 p-4 bg-gradient-to-r from-fuchsia-600 to-pink-500 rounded-xl text-white shadow-lg">
                        <div class="flex justify-between items-center">
                            <span class="font-semibold">Total yang dipinjam:</span>
                            <span class="text-2xl font-bold" id="totalYangDipinjam">1</span>
                            <span class="text-sm opacity-90">unit</span>
                        </div>
                    </div>

                    <!-- Alasan Peminjaman -->
                    <div class="mb-6">
                        <label class="block text-sm font-bold text-gray-900 mb-3">📝 Alasan Peminjaman</label>
                        <textarea id="reason" class="reason-textarea" placeholder="Tuliskan alasan Anda meminjam barang ini... (contoh: untuk praktikum, tugas kelompok, dll)"></textarea>
                        <p class="text-xs text-gray-500 mt-2">* Alasan wajib diisi dan akan dipertimbangkan oleh petugas</p>
                    </div>

                    <!-- Actions -->
                    <div class="space-y-3">
                        <button onclick="submitRequest(${barang.id})" ${barang.jumlah === 0 ? 'disabled' : ''} 
                            class="w-full py-3 sm:py-4 ${barang.jumlah > 0 ? 'bg-gradient-to-r from-fuchsia-600 to-pink-500 text-white hover:shadow-lg hover:shadow-fuchsia-300' : 'bg-gray-300 text-gray-500 cursor-not-allowed'} rounded-xl font-bold text-base sm:text-lg transition-all">
                            ${barang.jumlah > 0 ? 'Ajukan Peminjaman Langsung' : 'Tidak Tersedia'}
                        </button>
                        <button onclick="addToCartFromModal(${barang.id}, '${barang.nama_barang}', '${imagePath}', ${barang.kategori_id}, '${categoryName}', ${barang.jumlah})" ${barang.jumlah === 0 ? 'disabled' : ''} 
                            class="w-full py-3 sm:py-4 ${barang.jumlah > 0 ? 'bg-white text-fuchsia-600 border-2 border-fuchsia-600 hover:bg-fuchsia-50' : 'bg-gray-300 text-gray-500 cursor-not-allowed'} rounded-xl font-bold text-base sm:text-lg transition-all flex items-center justify-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <span>${barang.jumlah > 0 ? 'Tambah ke Keranjang' : 'Tidak Tersedia'}</span>
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
                        <span>Wajib menyertakan Kartu Pelajar saat mengambil barang</span>
                    </li>
                    <li class="flex items-start space-x-2">
                        <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Maksimal peminjaman: <span class="font-semibold">7 hari</span> (per hari) atau <span class="font-semibold">8 jam</span> (per jam)</span>
                    </li>
                    <li class="flex items-start space-x-2">
                        <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Peminjaman per jam hanya berlaku di hari yang sama</span>
                    </li>
                    <li class="flex items-start space-x-2">
                        <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Tidak boleh meminjamkan ke pihak lain</span>
                    </li>
                    <li class="flex items-start space-x-2">
                        <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Bertanggung jawab penuh atas kerusakan/kehilangan</span>
                    </li>
                    <li class="flex items-start space-x-2">
                        <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Denda keterlambatan: <span class="font-semibold">Rp 5.000/hari</span> atau <span class="font-semibold">Rp 2.000/jam</span></span>
                    </li>
                </ul>
            </div>
        </div>
    `;
    
    const detailModal = document.getElementById('detailModal');
    document.getElementById('modalContent').innerHTML = modalContent;
    detailModal.classList.remove('hidden');
    detailModal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

// Fungsi untuk increment jumlah
function incrementJumlah(inputId, maxStock) {
    const input = document.getElementById(inputId);
    if (!input) return;
    
    let value = parseInt(input.value) || 1;
    if (value < maxStock) {
        value++;
        input.value = value;
        validateJumlah(input, maxStock);
    }
}

// Fungsi untuk decrement jumlah
function decrementJumlah(inputId, maxStock) {
    const input = document.getElementById(inputId);
    if (!input) return;
    
    let value = parseInt(input.value) || 1;
    if (value > 1) {
        value--;
        input.value = value;
        validateJumlah(input, maxStock);
    }
}

// Fungsi untuk validasi jumlah
function validateJumlah(input, maxStock) {
    let value = parseInt(input.value) || 1;
    
    if (value < 1) value = 1;
    if (value > maxStock) value = maxStock;
    
    input.value = value;
    
    // Update total display
    const totalDisplay = document.getElementById('totalYangDipinjam');
    if (totalDisplay) {
        totalDisplay.textContent = value;
    }
}

        // Close modal
        function closeModal() {
            const detailModal = document.getElementById('detailModal');
            detailModal.classList.add('hidden');
            detailModal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        // Submit request - Kirim ke database
// Submit request - Kirim ke database
function submitRequest(barangId) {
    const barang = allBarangs.find(b => b.id === barangId);
    const loanType = document.getElementById('loanTypeHari').classList.contains('active') ? 'hari' : 'jam';
    const reason = document.getElementById('reason').value.trim();
    
    // AMBIL JUMLAH DARI INPUT
    const jumlahInput = document.getElementById('jumlahPinjam');
    const jumlah = jumlahInput ? parseInt(jumlahInput.value) || 1 : 1;
    
    // Validasi alasan
    if (!reason) {
        alert('Harap isi alasan peminjaman!');
        return;
    }
    
    if (reason.length < 5) {
        alert('Alasan peminjaman minimal 5 karakter!');
        return;
    }
    
    // Validasi jumlah
    if (jumlah < 1 || jumlah > barang.jumlah) {
        alert('Jumlah yang dipinjam tidak valid!');
        return;
    }
    
    // Siapkan FormData
    let formData = new FormData();
    formData.append('_token', '{{ csrf_token() }}');
    formData.append('barang_id', barangId);
    formData.append('tipe_pinjam', loanType);
    formData.append('jumlah', jumlah);
    formData.append('alasan', reason);
    
    // Validasi dan ambil data berdasarkan tipe
    if (loanType === 'hari') {
        const pickupDate = document.getElementById('pickupDateHari').value;
        const returnDate = document.getElementById('returnDateHari').value;
        
        if (!pickupDate) {
            alert('Harap pilih tanggal ambil!');
            return;
        }
        
        if (!returnDate) {
            alert('Harap pilih tanggal kembali!');
            return;
        }
        
        if (returnDate < pickupDate) {
            alert('Tanggal kembali tidak boleh kurang dari tanggal ambil!');
            return;
        }
        
        formData.append('tanggal_pinjam', pickupDate);
        formData.append('tanggal_kembali', returnDate);
        
    } else {
        const pickupDate = document.getElementById('pickupDateJam').value;
        const pickupTime = document.getElementById('pickupTime').value;
        const returnTime = document.getElementById('returnTime').value;
        
        if (!pickupDate) {
            alert('Harap pilih tanggal ambil!');
            return;
        }
        
        if (!pickupTime) {
            alert('Harap pilih jam ambil!');
            return;
        }
        
        if (!returnTime) {
            alert('Harap pilih jam kembali!');
            return;
        }
        
        if (returnTime <= pickupTime) {
            alert('Jam kembali harus lebih dari jam ambil!');
            return;
        }
        
        // Hitung selisih jam
        const pickupHour = parseInt(pickupTime.split(':')[0]);
        const returnHour = parseInt(returnTime.split(':')[0]);
        const selisihJam = returnHour - pickupHour;
        
        if (selisihJam > 8) {
            alert('Maksimal peminjaman per jam adalah 8 jam!');
            return;
        }
        
        formData.append('tanggal_pinjam_jam', pickupDate);
        formData.append('jam_pinjam', pickupTime);
        formData.append('jam_kembali', returnTime);
    }
    
    // Tampilkan loading state
    const submitBtn = event.currentTarget;
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<svg class="animate-spin inline-block w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Mengirim...';
    submitBtn.disabled = true;
    
    // Kirim ke server
    fetch('{{ route("peminjam.peminjaman.store") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => { throw err; });
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Tampilkan notifikasi sukses
            showNotification('success', data.message);
            
            // Tampilkan detail peminjaman di console (untuk debugging)
            console.log('Peminjaman berhasil:', data.data);
            
            // Tutup modal
            closeModal();
            
            // Reset form
            document.getElementById('reason').value = '';
            
            // Optional: Redirect ke halaman aktivitas setelah 2 detik
            setTimeout(() => {
                if (confirm('Lihat status peminjaman Anda di menu Aktivitas Saya?')) {
                    window.location.href = '{{ route("peminjam.aktivitasSaya") }}';
                }
            }, 2000);
            
        } else {
            showNotification('error', data.message || 'Gagal mengajukan peminjaman');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        
        let errorMessage = 'Terjadi kesalahan saat mengajukan peminjaman';
        
        if (error.errors) {
            // Tampilkan error validasi
            const firstError = Object.values(error.errors)[0];
            errorMessage = Array.isArray(firstError) ? firstError[0] : firstError;
        } else if (error.message) {
            errorMessage = error.message;
        }
        
        showNotification('error', errorMessage);
    })
    .finally(() => {
        // Kembalikan tombol ke keadaan semula
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
}

// Fungsi untuk menampilkan notifikasi
function showNotification(type, message) {
    // Hapus notifikasi yang sudah ada
    const existingNotif = document.querySelector('.notification-toast');
    if (existingNotif) {
        existingNotif.remove();
    }
    
    // Buat elemen notifikasi
    const notification = document.createElement('div');
    notification.className = `notification-toast fixed top-20 right-4 z-[10000] px-6 py-4 rounded-xl shadow-2xl transform transition-all duration-500 fade-in ${
        type === 'success' 
            ? 'bg-gradient-to-r from-green-500 to-emerald-500 text-white' 
            : 'bg-gradient-to-r from-red-500 to-pink-500 text-white'
    }`;
    
    notification.innerHTML = `
        <div class="flex items-center space-x-3">
            <div class="flex-shrink-0">
                ${type === 'success' 
                    ? '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'
                    : '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'
                }
            </div>
            <div class="flex-1">
                <p class="font-semibold">${type === 'success' ? 'Berhasil!' : 'Gagal!'}</p>
                <p class="text-sm opacity-90">${message}</p>
            </div>
            <button onclick="this.parentElement.parentElement.remove()" class="flex-shrink-0 ml-4 hover:opacity-75">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Auto hide setelah 5 detik
    setTimeout(() => {
        notification.style.opacity = '0';
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => notification.remove(), 500);
    }, 5000);
}

// Function to validate return date for daily loans
function validateReturnDate() {
    const pickupDate = new Date(document.getElementById('pickupDateHari').value);
    const returnDate = new Date(document.getElementById('returnDateHari').value);
    
    // Hitung selisih hari
    const diffTime = Math.abs(returnDate - pickupDate);
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 

    if (returnDate < pickupDate) {
        alert('Tanggal kembali tidak boleh kurang dari tanggal ambil!');
        document.getElementById('returnDateHari').value = document.getElementById('pickupDateHari').value;
    } else if (diffDays > 7) {
        alert('Maaf, maksimal peminjaman adalah 7 hari!');
        // Reset ke maksimal 7 hari dari tanggal pinjam
        const maxDate = new Date(pickupDate);
        maxDate.setDate(maxDate.getDate() + 7);
        document.getElementById('returnDateHari').value = formatDate(maxDate);
    }
}

// Function to validate return time for hourly loans
function validateReturnTime() {
    const pickupTime = document.getElementById('pickupTime').value;
    const returnTime = document.getElementById('returnTime').value;
    
    if (returnTime < pickupTime) {
        alert('Jam kembali tidak boleh kurang dari jam ambil!');
        document.getElementById('returnTime').value = pickupTime;
        return;
    }

    // Hitung selisih jam
    const start = pickupTime.split(':');
    const end = returnTime.split(':');
    const startDate = new Date(0, 0, 0, start[0], start[1], 0);
    const endDate = new Date(0, 0, 0, end[0], end[1], 0);
    const diffInHours = (endDate - startDate) / 1000 / 60 / 60;

    if (diffInHours > 8) {
        alert('Maaf, maksimal peminjaman adalah 8 jam!');
        // Set ke jam maksimal (tambah 8 jam dari waktu mulai)
        let maxHour = parseInt(start[0]) + 8;
        if (maxHour > 23) maxHour = 23; // Batas akhir hari
        const formattedMax = String(maxHour).padStart(2, '0') + ':' + start[1];
        document.getElementById('returnTime').value = formattedMax;
    }
}

// Tambahkan validasi jam kembali minimal 1 jam setelah jam ambil
document.addEventListener('DOMContentLoaded', function() {
    // ... existing code ...
    
    // Validasi untuk jam kembali
    const pickupTimeInput = document.getElementById('pickupTime');
    const returnTimeInput = document.getElementById('returnTime');
    
    if (pickupTimeInput && returnTimeInput) {
        pickupTimeInput.addEventListener('change', function() {
            const pickupTime = this.value;
            if (pickupTime) {
                const [hours, minutes] = pickupTime.split(':');
                let returnHours = parseInt(hours) + 1;
                if (returnHours > 23) returnHours = 23;
                const returnTime = `${String(returnHours).padStart(2, '0')}:${minutes}`;
                returnTimeInput.value = returnTime;
                returnTimeInput.min = returnTime;
            }
        });
    }
});

// Validasi maksimal peminjaman 7 hari untuk tipe hari
document.addEventListener('DOMContentLoaded', function() {
    const pickupDateHari = document.getElementById('pickupDateHari');
    const returnDateHari = document.getElementById('returnDateHari');
    
    if (pickupDateHari && returnDateHari) {
        pickupDateHari.addEventListener('change', function() {
            const pickupDate = this.value;
            if (pickupDate) {
                const maxReturnDate = new Date(pickupDate);
                maxReturnDate.setDate(maxReturnDate.getDate() + 7);
                const maxReturnDateStr = formatDate(maxReturnDate);
                returnDateHari.max = maxReturnDateStr;
                
                // Jika tanggal kembali melebihi 7 hari, reset
                if (returnDateHari.value > maxReturnDateStr) {
                    returnDateHari.value = maxReturnDateStr;
                    alert('Maksimal peminjaman adalah 7 hari');
                }
            }
        });
    }
});

        // Event listeners
        document.addEventListener('DOMContentLoaded', function() {
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
            
            document.getElementById('loadMoreBtn')?.addEventListener('click', function() {
                alert('Fitur load more akan diimplementasi nanti!');
            });
            
            window.addEventListener('click', function(e) {
                const modal = document.getElementById('detailModal');
                if (e.target === modal) {
                    closeModal();
                }
            });
            
            applyFilters();
        });

        // Add to cart from modal
        function addToCartFromModal(barangId, barangNama, gambar, kategoriId, kategoriNama, stokTersedia) {
            const jumlahInput = document.getElementById('jumlahPinjam');
            const jumlah = jumlahInput ? parseInt(jumlahInput.value) || 1 : 1;

            try {
                cart.addItem(barangId, barangNama, gambar, kategoriId, kategoriNama, jumlah, stokTersedia);
                showNotification('success', `${barangNama} ditambahkan ke keranjang (${jumlah} unit)`);
                
                // Update badge
                cart.updateBadge();
                
                // Close modal after 1 second
                setTimeout(() => {
                    closeModal();
                }, 1000);
            } catch (error) {
                showNotification('error', error.message);
            }
        }
    </script>
</body>
</html>