<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan - SarPras Petugas</title>
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
<body class="bg-slate-50">
    
    <div class="flex min-h-screen">
        @include('components.sidebar_petugas')

        <div class="flex-1 lg:ml-64">
            <nav class="bg-white border-b border-gray-200 sticky top-0 z-40">
                <div class="px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between h-16">
                        <button id="mobile-menu-button" class="lg:hidden p-2 rounded-lg text-gray-600 hover:bg-gray-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                        <div class="flex-1">
                            <h1 class="text-2xl font-bold text-gray-900">Laporan & Statistik</h1>
                            <p class="text-sm text-gray-500 mt-0.5">Generate dan analisa laporan peminjaman</p>
                        </div>
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
                                    <p class="text-sm font-semibold text-gray-900">Petugas SarPras</p>
                                    <p class="text-xs text-gray-500">Staff</p>
                                </div>
                                <button class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-600 to-violet-500 flex items-center justify-center text-white font-semibold">
                                    P
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <main class="p-4 sm:p-6 lg:p-8">
                <!-- Report Generator Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Generate Laporan</h2>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Report Type -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Jenis Laporan</label>
                            <div class="space-y-2">
                                <label class="flex items-center p-3 border-2 border-indigo-500 bg-indigo-50 rounded-lg cursor-pointer">
                                    <input type="radio" name="reportType" value="transaction" checked class="w-4 h-4 text-indigo-600 mr-3">
                                    <span class="text-sm font-medium text-indigo-700">Transaksi Peminjaman</span>
                                </label>
                                <label class="flex items-center p-3 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-indigo-300">
                                    <input type="radio" name="reportType" value="asset" class="w-4 h-4 text-indigo-600 mr-3">
                                    <span class="text-sm font-medium text-gray-700">Penggunaan Aset</span>
                                </label>
                                <label class="flex items-center p-3 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-indigo-300">
                                    <input type="radio" name="reportType" value="user" class="w-4 h-4 text-indigo-600 mr-3">
                                    <span class="text-sm font-medium text-gray-700">Aktivitas Pengguna</span>
                                </label>
                                <label class="flex items-center p-3 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-indigo-300">
                                    <input type="radio" name="reportType" value="overdue" class="w-4 h-4 text-indigo-600 mr-3">
                                    <span class="text-sm font-medium text-gray-700">Keterlambatan</span>
                                </label>
                            </div>
                        </div>

                        <!-- Period Selection -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Periode</label>
                            <div class="space-y-3">
                                <select class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 font-medium">
                                    <option>Hari Ini</option>
                                    <option>Minggu Ini</option>
                                    <option selected>Bulan Ini</option>
                                    <option>Tahun Ini</option>
                                    <option>Custom Range</option>
                                </select>
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">Dari Tanggal</label>
                                    <input type="date" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">Sampai Tanggal</label>
                                    <input type="date" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Export Format</label>
                            <div class="space-y-3">
                                <button onclick="generateReport('pdf')" class="w-full px-5 py-3 bg-gradient-to-r from-indigo-600 to-violet-500 text-white rounded-xl font-semibold hover:shadow-lg hover:shadow-indigo-300 transition-all flex items-center justify-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                    <span>Generate PDF</span>
                                </button>
                                <button onclick="generateReport('excel')" class="w-full px-5 py-3 bg-white border border-gray-200 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition-all flex items-center justify-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <span>Export Excel</span>
                                </button>
                                <button onclick="printReport()" class="w-full px-5 py-3 bg-white border border-gray-200 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition-all flex items-center justify-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                    </svg>
                                    <span>Cetak Laporan</span>
                                </button>
                                <button class="w-full px-5 py-3 bg-white border border-gray-200 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition-all flex items-center justify-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                    <span>Email Laporan</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="bg-gradient-to-br from-indigo-600 to-violet-500 rounded-xl p-6 text-white">
                        <div class="flex items-center justify-between mb-4">
                            <svg class="w-12 h-12 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-white/80 text-sm font-medium mb-1">Total Transaksi</h3>
                        <p class="text-4xl font-bold">1,234</p>
                        <p class="text-sm text-white/70 mt-2">Bulan ini: +128</p>
                    </div>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-gray-600 text-sm font-medium mb-1">Tepat Waktu</h3>
                        <p class="text-3xl font-bold text-gray-900">93.7%</p>
                        <p class="text-xs text-green-600 mt-2 font-medium">+2.3% dari bulan lalu</p>
                    </div>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-gray-600 text-sm font-medium mb-1">Rata-rata Durasi</h3>
                        <p class="text-3xl font-bold text-gray-900">4.2</p>
                        <p class="text-xs text-gray-500 mt-2">hari per peminjaman</p>
                    </div>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-gray-600 text-sm font-medium mb-1">Total Denda</h3>
                        <p class="text-3xl font-bold text-gray-900">Rp 450K</p>
                        <p class="text-xs text-gray-500 mt-2">Dari 78 keterlambatan</p>
                    </div>
                </div>

                <!-- Charts & Detailed Reports -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                    <!-- Trend Chart -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Trend Peminjaman (7 Hari Terakhir)</h3>
                        <div class="h-64 flex items-end justify-between space-x-2">
                            <div class="flex-1 flex flex-col justify-end items-center">
                                <div class="w-full bg-gradient-to-t from-indigo-600 to-violet-500 rounded-t-lg" style="height: 70%"></div>
                                <span class="text-xs text-gray-600 mt-2">Sen</span>
                            </div>
                            <div class="flex-1 flex flex-col justify-end items-center">
                                <div class="w-full bg-gradient-to-t from-indigo-600 to-violet-500 rounded-t-lg" style="height: 50%"></div>
                                <span class="text-xs text-gray-600 mt-2">Sel</span>
                            </div>
                            <div class="flex-1 flex flex-col justify-end items-center">
                                <div class="w-full bg-gradient-to-t from-indigo-600 to-violet-500 rounded-t-lg" style="height: 85%"></div>
                                <span class="text-xs text-gray-600 mt-2">Rab</span>
                            </div>
                            <div class="flex-1 flex flex-col justify-end items-center">
                                <div class="w-full bg-gradient-to-t from-indigo-600 to-violet-500 rounded-t-lg" style="height: 60%"></div>
                                <span class="text-xs text-gray-600 mt-2">Kam</span>
                            </div>
                            <div class="flex-1 flex flex-col justify-end items-center">
                                <div class="w-full bg-gradient-to-t from-indigo-600 to-violet-500 rounded-t-lg" style="height: 95%"></div>
                                <span class="text-xs text-gray-600 mt-2">Jum</span>
                            </div>
                            <div class="flex-1 flex flex-col justify-end items-center">
                                <div class="w-full bg-gradient-to-t from-indigo-600 to-violet-500 rounded-t-lg" style="height: 40%"></div>
                                <span class="text-xs text-gray-600 mt-2">Sab</span>
                            </div>
                            <div class="flex-1 flex flex-col justify-end items-center">
                                <div class="w-full bg-gradient-to-t from-indigo-600 to-violet-500 rounded-t-lg" style="height: 30%"></div>
                                <span class="text-xs text-gray-600 mt-2">Min</span>
                            </div>
                        </div>
                    </div>

                    <!-- Category Distribution -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Top Kategori Dipinjam</h3>
                        <div class="space-y-4">
                            <div>
                                <div class="flex justify-between text-sm mb-2">
                                    <span class="font-medium text-gray-900">Elektronik</span>
                                    <span class="font-semibold text-indigo-600">45%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-3">
                                    <div class="bg-gradient-to-r from-indigo-600 to-violet-500 h-3 rounded-full" style="width: 45%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-sm mb-2">
                                    <span class="font-medium text-gray-900">Buku & Literatur</span>
                                    <span class="font-semibold text-green-600">30%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-3">
                                    <div class="bg-gradient-to-r from-green-500 to-emerald-400 h-3 rounded-full" style="width: 30%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-sm mb-2">
                                    <span class="font-medium text-gray-900">Laboratorium</span>
                                    <span class="font-semibold text-blue-600">15%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-3">
                                    <div class="bg-gradient-to-r from-blue-500 to-cyan-400 h-3 rounded-full" style="width: 15%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-sm mb-2">
                                    <span class="font-medium text-gray-900">Olahraga</span>
                                    <span class="font-semibold text-orange-600">10%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-3">
                                    <div class="bg-gradient-to-r from-orange-500 to-amber-400 h-3 rounded-full" style="width: 10%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Reports Table -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-lg font-bold text-gray-900">Riwayat Laporan</h2>
                                <p class="text-sm text-gray-500 mt-1">Laporan yang pernah dibuat</p>
                            </div>
                            <button class="text-sm font-semibold text-indigo-600 hover:text-indigo-700">
                                Lihat Semua →
                            </button>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b border-gray-100">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama Laporan</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Periode</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Dibuat</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Oleh</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center mr-3">
                                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-gray-900">Laporan Transaksi Januari 2024</p>
                                                <p class="text-xs text-gray-500">PDF • 2.3 MB</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">01-31 Jan 2024</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">01 Feb 2024</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">Petugas SarPras</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-2">
                                            <button class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Download">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                                </svg>
                                            </button>
                                            <button class="p-2 text-gray-600 hover:bg-gray-50 rounded-lg transition-colors" title="Preview">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        function generateReport(format) {
            alert(`Generating ${format.toUpperCase()} report...`);
        }

        function printReport() {
            window.print();
        }

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