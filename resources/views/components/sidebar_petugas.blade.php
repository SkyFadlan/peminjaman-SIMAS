<!-- Sidebar Component untuk Petugas -->
<aside class="fixed inset-y-0 left-0 z-50 w-64 bg-white dark:bg-slate-950 border-r border-gray-200 dark:border-slate-800 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out flex flex-col">
    <!-- Logo Section -->
    <div class="h-16 flex-shrink-0 flex items-center justify-between px-6 border-b border-gray-200 dark:border-slate-800">
    <div class="flex items-center space-x-3">
        <div class="w-10 h-10 bg-gradient-to-br from-indigo-600 to-violet-500 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-200">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
            </svg>
        </div>
        
        <div class="flex flex-col leading-tight">
            <span class="text-xl font-bold bg-gradient-to-r from-indigo-600 to-violet-500 bg-clip-text text-transparent">SIMAS</span>
            <p class="text-[10px] md:text-xs text-gray-500 dark:text-slate-400 font-medium">Sistem Manajemen Sekolah</p>
        </div>
    </div>
    </div>

    <!-- Navigation Menu - Scrollable Area -->
    <div class="flex-1 overflow-y-auto">
        <nav class="py-6 px-4">
            <div class="space-y-1">
                <!-- Dashboard -->
                <a href="{{ url('petugas/dashboard') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl {{ Request::is('petugas/dashboard*') ? 'bg-gradient-to-r from-indigo-600 to-violet-500 text-white shadow-lg shadow-indigo-200' : 'text-gray-700 dark:text-slate-300 hover:bg-indigo-50 dark:hover:bg-slate-800 hover:text-indigo-600 dark:hover:text-indigo-300' }} transition-all group">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span class="font-semibold">Dashboard</span>
                </a>

                <!-- Main Menu Section -->
                <div class="pt-6">
                    <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Menu Utama</h3>
                    <div class="space-y-1">
                        <!-- Permintaan Peminjaman -->
                        <a href="{{ url('petugas/permintaan') }}" 
                           class="flex items-center justify-between px-4 py-3 rounded-xl {{ Request::is('petugas/permintaan*') ? 'bg-gradient-to-r from-indigo-600 to-violet-500 text-white shadow-lg shadow-indigo-200' : 'text-gray-700 dark:text-slate-300 hover:bg-indigo-50 dark:hover:bg-slate-800 hover:text-indigo-600 dark:hover:text-indigo-300' }} transition-all group">
                            <div class="flex items-center space-x-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                <span class="font-medium">Permintaan</span>
                            </div>

                        <!-- Pengembalian -->
                        <a href="{{ url('petugas/pengembalian') }}" 
                           class="flex items-center justify-between px-4 py-3 rounded-xl {{ Request::is('petugas/pengembalian*') ? 'bg-gradient-to-r from-indigo-600 to-violet-500 text-white shadow-lg shadow-indigo-200' : 'text-gray-700 dark:text-slate-300 hover:bg-indigo-50 dark:hover:bg-slate-800 hover:text-indigo-600 dark:hover:text-indigo-300' }} transition-all group">
                            <div class="flex items-center space-x-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="font-medium">Pengembalian</span>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Data & Laporan Section -->
                <div class="pt-6">
                    <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Data & Laporan</h3>
                    <div class="space-y-1">
                        <!-- Laporan -->
                        <a href="{{ url('petugas/laporan') }}" 
                           class="flex items-center space-x-3 px-4 py-3 rounded-xl {{ Request::is('petugas/laporan*') ? 'bg-gradient-to-r from-indigo-600 to-violet-500 text-white shadow-lg shadow-indigo-200' : 'text-gray-700 dark:text-slate-300 hover:bg-indigo-50 dark:hover:bg-slate-800 hover:text-indigo-600 dark:hover:text-indigo-300' }} transition-all group">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            <span class="font-medium">Laporan</span>
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </div>

    <!-- Bottom Profile Section dengan Logout -->
    <div class="border-t border-gray-200 p-4 flex-shrink-0 space-y-3">
        <!-- Profil User -->
        <div class="flex items-center justify-between p-3 rounded-xl hover:bg-indigo-50 dark:hover:bg-slate-800 transition-colors cursor-pointer group">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-600 to-violet-500 flex items-center justify-center text-white font-semibold shadow-lg">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                </div>
            </div>
            <div class="relative">
                <button onclick="togglePetugasDropdown()" class="p-1.5 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                    </svg>
                </button>
                
                <!-- Dropdown Menu -->
                <div id="petugas-dropdown" class="hidden absolute bottom-full right-0 mb-2 w-48 bg-white dark:bg-slate-900 rounded-xl shadow-xl border border-gray-100 dark:border-slate-800 py-2 z-50">
                    <a href="{{ route('profile.edit') }}" class="flex items-center space-x-3 px-4 py-2.5 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span class="text-sm font-medium">Profil Saya</span>
                    </a>
                    <div class="border-t border-gray-100 my-2"></div>
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button type="submit" class="flex items-center space-x-3 px-4 py-2.5 text-red-600 hover:bg-red-50 w-full text-left transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            <span class="text-sm font-medium">Keluar</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Tombol Dark Mode -->
        <button type="button" onclick="toggleDarkMode()" data-theme-toggle class="theme-toggle-button flex items-center justify-center gap-2 w-full px-4 py-3 bg-slate-900/5 dark:bg-slate-700/70 text-slate-700 dark:text-slate-100 rounded-xl hover:bg-slate-900/10 dark:hover:bg-slate-600 transition-all">
            <span class="inline-flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M17.293 13.293A8 8 0 116.707 2.707a7 7 0 1010.586 10.586z" clip-rule="evenodd"/></svg>
                <span>Dark Mode</span>
            </span>
        </button>

        <!-- Tombol Logout Utama -->
        <form method="POST" action="{{ route('logout') }}" class="w-full">
            @csrf
            <button type="submit" 
                    class="flex items-center justify-center space-x-2 w-full px-4 py-3 bg-gradient-to-r from-indigo-600 to-violet-500 text-white rounded-xl hover:from-indigo-700 hover:to-violet-600 transition-all shadow-lg hover:shadow-xl active:scale-95 transform font-semibold group">
                <svg class="w-5 h-5 group-hover:rotate-180 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                <span>Keluar dari Akun</span>
            </button>
        </form>
    </div>
</aside>

<!-- Overlay untuk mobile -->
<div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden" onclick="toggleSidebar()"></div>

<!-- JavaScript untuk interaksi -->
<script>
    // Toggle sidebar mobile
    function toggleSidebar() {
        const sidebar = document.querySelector('aside');
        const overlay = document.getElementById('sidebar-overlay');
        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
    }

    // Toggle dropdown profile petugas
    function togglePetugasDropdown() {
        const dropdown = document.getElementById('petugas-dropdown');
        dropdown.classList.toggle('hidden');
    }

    // Tutup dropdown ketika klik di luar
    document.addEventListener('click', function(event) {
        const dropdown = document.getElementById('petugas-dropdown');
        const dropdownBtn = document.querySelector('[onclick="togglePetugasDropdown()"]');
        
        if (dropdown && dropdownBtn) {
            if (!dropdown.contains(event.target) && !dropdownBtn.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        }
    });

    // Auto-hide dropdown jika mobile sidebar ditutup
    const sidebar = document.querySelector('aside');
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.attributeName === 'class') {
                const dropdown = document.getElementById('petugas-dropdown');
                if (dropdown) {
                    dropdown.classList.add('hidden');
                }
            }
        });
    });
    
    if (sidebar) {
        observer.observe(sidebar, { attributes: true });
    }

    // Animasi untuk tombol logout
    const logoutBtn = document.querySelector('form[action="{{ route("logout") }}"] button');
    if (logoutBtn) {
        logoutBtn.addEventListener('mouseenter', function() {
            this.querySelector('svg').style.transform = 'rotate(180deg)';
        });
        
        logoutBtn.addEventListener('mouseleave', function() {
            this.querySelector('svg').style.transform = 'rotate(0deg)';
        });
    }
</script>

<style>
    /* Custom scrollbar untuk sidebar petugas */
    .overflow-y-auto::-webkit-scrollbar {
        width: 5px;
    }
    
    .overflow-y-auto::-webkit-scrollbar-track {
        background: #f8fafc;
        border-radius: 10px;
    }
    
    .overflow-y-auto::-webkit-scrollbar-thumb {
        background: linear-gradient(to bottom, #6366f1, #8b5cf6);
        border-radius: 10px;
    }
    
    .overflow-y-auto::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(to bottom, #4f46e5, #7c3aed);
    }
    
    /* Smooth transitions */
    .transition-all {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .transform {
        transition: transform 0.2s ease;
    }
    
    /* Animasi dropdown */
    #petugas-dropdown {
        animation: fadeIn 0.2s ease-out;
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Hover effect untuk menu item */
    .group:hover .group-hover\:text-indigo-600 {
        color: #4f46e5;
    }
    
    .group:hover .group-hover\:bg-indigo-50 {
        background-color: #eef2ff;
    }
</style>