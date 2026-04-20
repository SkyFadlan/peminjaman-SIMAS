<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi - SarPras Petugas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50">
    
    <div class="flex min-h-screen">
        @include('components.sidebar_petugas')

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
                            <h1 class="text-2xl font-bold text-gray-900">Laporan Transaksi</h1>
                            <p class="text-sm text-gray-500 mt-0.5">Generate laporan peminjaman</p>
                        </div>
                        
                        <div class="flex items-center space-x-3">
                            <div class="flex items-center space-x-3 pl-3 border-l border-gray-200">
                                <div class="hidden sm:block text-right">
                                    <p class="text-sm font-semibold text-gray-900">{{ Auth::user()->name ?? 'Petugas' }}</p>
                                    <p class="text-xs text-gray-500">{{ ucfirst(Auth::user()->role ?? 'Staff') }}</p>
                                </div>
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-600 to-violet-500 flex items-center justify-center text-white font-semibold uppercase">
                                    {{ substr(Auth::user()->name ?? 'P', 0, 1) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <main class="p-4 sm:p-6 lg:p-8">
                <!-- Statistik Hari Ini -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
                    <div class="bg-gradient-to-br from-indigo-600 to-violet-500 rounded-xl p-6 text-white">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-white/80 text-sm font-medium mb-1">Transaksi Hari Ini</h3>
                        <p class="text-3xl font-bold">{{ $totalTransaksiHariIni }}</p>
                    </div>
                    
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-gray-600 text-sm font-medium mb-1">Dikembalikan Hari Ini</h3>
                        <p class="text-3xl font-bold text-gray-900">{{ $dikembalikanHariIni }}</p>
                    </div>
                    
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-gray-600 text-sm font-medium mb-1">Total Denda Hari Ini</h3>
                        <p class="text-3xl font-bold text-gray-900">Rp {{ number_format($totalDendaHariIni, 0, ',', '.') }}</p>
                    </div>
                </div>

                <!-- Form Generate Laporan -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
                    <h2 class="text-lg font-bold text-gray-900 mb-6">Generate Laporan Transaksi</h2>
                    
                    <form action="{{ route('petugas.laporan.generate') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Tanggal Mulai -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Tanggal Mulai <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <input type="date" 
                                           name="start_date" 
                                           id="start_date"
                                           value="{{ now()->startOfMonth()->format('Y-m-d') }}"
                                           class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                           required>
                                </div>
                            </div>
                            
                            <!-- Tanggal Selesai -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Tanggal Selesai <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <input type="date" 
                                           name="end_date" 
                                           id="end_date"
                                           value="{{ now()->format('Y-m-d') }}"
                                           class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                           required>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Quick Range Buttons -->
                        <div class="flex flex-wrap gap-2">
                            <button type="button" onclick="setRange('today')" 
                                    class="px-4 py-2 text-sm bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                                Hari Ini
                            </button>
                            <button type="button" onclick="setRange('yesterday')" 
                                    class="px-4 py-2 text-sm bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                                Kemarin
                            </button>
                            <button type="button" onclick="setRange('thisWeek')" 
                                    class="px-4 py-2 text-sm bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                                Minggu Ini
                            </button>
                            <button type="button" onclick="setRange('thisMonth')" 
                                    class="px-4 py-2 text-sm bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                                Bulan Ini
                            </button>
                            <button type="button" onclick="setRange('lastMonth')" 
                                    class="px-4 py-2 text-sm bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                                Bulan Lalu
                            </button>
                            <button type="button" onclick="setRange('thisYear')" 
                                    class="px-4 py-2 text-sm bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                                Tahun Ini
                            </button>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="flex flex-wrap gap-3 pt-4 border-t border-gray-200">
                            <button type="submit" name="format" value="pdf" 
                                    class="px-6 py-3 bg-gradient-to-r from-red-600 to-red-500 text-white rounded-lg font-semibold hover:shadow-lg hover:shadow-red-300 transition-all flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>
                                <span>Export PDF</span>
                            </button>
                            
                            <button type="submit" name="format" value="excel" 
                                    class="px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-500 text-white rounded-lg font-semibold hover:shadow-lg hover:shadow-green-300 transition-all flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <span>Export Excel</span>
                            </button>
                            
                            <button type="submit" name="format" value="print" 
                                    class="px-6 py-3 bg-white border border-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-50 transition-all flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                </svg>
                                <span>Cetak / Print</span>
                            </button>
                            
                            <button type="button" onclick="resetForm()" 
                                    class="px-6 py-3 bg-white border border-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-50 transition-all">
                                Reset
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Informasi -->
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-sm font-semibold text-blue-800 mb-1">Informasi Laporan</h3>
                            <p class="text-xs text-blue-700">
                                Laporan akan menampilkan semua data transaksi peminjaman berdasarkan rentang tanggal yang dipilih.
                                Format tanggal menggunakan DD/MM/YYYY. Data dapat diekspor ke PDF, Excel, atau dicetak langsung.
                            </p>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        // Set range tanggal
        function setRange(range) {
            const today = new Date();
            const startDate = document.getElementById('start_date');
            const endDate = document.getElementById('end_date');
            
            switch(range) {
                case 'today':
                    startDate.value = formatDate(today);
                    endDate.value = formatDate(today);
                    break;
                    
                case 'yesterday':
                    const yesterday = new Date(today);
                    yesterday.setDate(yesterday.getDate() - 1);
                    startDate.value = formatDate(yesterday);
                    endDate.value = formatDate(yesterday);
                    break;
                    
                case 'thisWeek':
                    const firstDay = new Date(today);
                    firstDay.setDate(today.getDate() - today.getDay() + 1);
                    startDate.value = formatDate(firstDay);
                    endDate.value = formatDate(today);
                    break;
                    
                case 'thisMonth':
                    const firstDayMonth = new Date(today.getFullYear(), today.getMonth(), 1);
                    startDate.value = formatDate(firstDayMonth);
                    endDate.value = formatDate(today);
                    break;
                    
                case 'lastMonth':
                    const lastMonth = new Date(today.getFullYear(), today.getMonth() - 1, 1);
                    const lastMonthEnd = new Date(today.getFullYear(), today.getMonth(), 0);
                    startDate.value = formatDate(lastMonth);
                    endDate.value = formatDate(lastMonthEnd);
                    break;
                    
                case 'thisYear':
                    const firstDayYear = new Date(today.getFullYear(), 0, 1);
                    startDate.value = formatDate(firstDayYear);
                    endDate.value = formatDate(today);
                    break;
            }
        }

        // Format date ke YYYY-MM-DD
        function formatDate(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        // Reset form ke bulan ini
        function resetForm() {
            const today = new Date();
            const firstDayMonth = new Date(today.getFullYear(), today.getMonth(), 1);
            document.getElementById('start_date').value = formatDate(firstDayMonth);
            document.getElementById('end_date').value = formatDate(today);
        }

        // Validasi tanggal
        document.getElementById('start_date').addEventListener('change', function() {
            const endDate = document.getElementById('end_date');
            if (this.value > endDate.value) {
                endDate.value = this.value;
            }
        });

        document.getElementById('end_date').addEventListener('change', function() {
            const startDate = document.getElementById('start_date');
            if (this.value < startDate.value) {
                startDate.value = this.value;
            }
        });

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