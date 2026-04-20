<!-- Navbar Component untuk Siswa/Peminjam -->
@php
    $notificationCount = auth()->check() ? auth()->user()->unreadNotifications()->count() : 0;
    $notifications = auth()->check() ? auth()->user()->unreadNotifications()->latest()->take(3)->get() : collect();
@endphp
<nav class="bg-white dark:bg-slate-950 border-b border-gray-200 dark:border-slate-800 sticky top-0 z-50 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Logo & Brand -->
            <div class="flex items-center space-x-3">
                <a href="{{ route('peminjam.beranda') }}" class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-purple-600 to-pink-500 rounded-xl flex items-center justify-center shadow-lg shadow-purple-200">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <div class="block">
                        <h1 class="text-xl font-bold bg-gradient-to-r from-purple-600 to-pink-500 bg-clip-text text-transparent">SIMAS</h1>
                        <p class="text-xs text-gray-500">Sistem Manajemen Sekolah</p>
                    </div>
                </a>
            </div>

            <!-- Main Navigation - Desktop -->
            <div class="hidden sm:flex items-center space-x-1">
                <a href="{{ route('peminjam.beranda') }}" class="px-4 py-2 rounded-lg font-semibold text-sm transition-all flex items-center space-x-2 text-gray-600 hover:bg-pink-50 hover:text-pink-500 {{ Request::is('peminjam/beranda*') ? 'bg-gradient-to-r from-purple-600 to-pink-500 text-white shadow-lg shadow-purple-200' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span>Beranda</span>
                </a>
                <a href="{{ route('peminjam.aktivitasSaya') }}" class="px-4 py-2 rounded-lg font-semibold text-sm transition-all flex items-center space-x-2 text-gray-600 hover:bg-pink-50 hover:text-pink-500 {{ Request::is('peminjam/aktivitas*') ? 'bg-gradient-to-r from-purple-600 to-pink-500 text-white shadow-lg shadow-purple-200' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span>Aktivitas Saya</span>
                </a>
            </div>

            <!-- Right Side Actions -->
            <div class="flex items-center space-x-2 sm:space-x-3">
                <!-- Search Bar - Desktop -->
                <div class="hidden sm:block relative">
                    <input type="text" placeholder="Cari barang..." class="pl-10 pr-4 py-2 border border-gray-200 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-900 text-sm text-gray-700 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent w-full sm:w-64 transition-all">
                    <svg class="w-5 h-5 text-gray-400 dark:text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>

                <!-- Dark Mode Button -->
                <button type="button" onclick="toggleDarkMode()" data-theme-toggle class="theme-toggle-button inline-flex items-center gap-2 px-3 py-2 bg-slate-900/5 dark:bg-slate-700/70 text-slate-700 dark:text-slate-100 rounded-lg hover:bg-slate-900/10 dark:hover:bg-slate-600 transition-all">
                    <span class="inline-flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M17.293 13.293A8 8 0 116.707 2.707a7 7 0 1010.586 10.586z" clip-rule="evenodd"/></svg>
                        <span>Dark Mode</span>
                    </span>
                </button>

                <!-- Shopping Cart Button -->
                <a href="{{ route('peminjam.keranjang') }}" class="relative p-2 text-gray-600 hover:bg-pink-50 rounded-lg transition-colors group">
                    <svg class="w-6 h-6 group-hover:text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span id="cartBadge" class="absolute -top-1 -right-1 w-5 h-5 bg-gradient-to-r from-purple-600 to-pink-500 text-white text-xs font-bold rounded-full flex items-center justify-center group-hover:shadow-lg group-hover:shadow-purple-200 transition-all">0</span>
                </a>

                <!-- Notifications -->
                <div class="relative">
                    <button id="notificationButton" type="button" onclick="toggleNotificationDropdown(event)" class="relative p-2 text-gray-600 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-800 rounded-lg transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        @if($notificationCount > 0)
                            <span id="notificationBadge" class="absolute top-0 right-0 w-5 h-5 bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center border-2 border-white dark:border-slate-950">{{ $notificationCount }}</span>
                        @endif
                    </button>
                    <div id="notificationDropdown" class="hidden absolute right-0 mt-2 w-80 bg-white dark:bg-slate-950 rounded-xl shadow-lg border border-gray-100 dark:border-slate-800 z-50 overflow-hidden">
                        <div class="px-4 py-3 border-b border-gray-100 dark:border-slate-800 flex items-start justify-between gap-3">
                            <div>
                                <h3 class="text-sm font-semibold text-gray-900 dark:text-slate-100">Pemberitahuan</h3>
                                <p id="notificationCountLabel" class="text-xs text-gray-500 dark:text-slate-400">{{ $notificationCount }} belum dibaca</p>
                            </div>
                            @if($notificationCount > 0)
                                <button id="notificationMarkAllButton" type="button" onclick="markAllNotificationsRead()" class="text-xs font-semibold text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-300">Tandai semua</button>
                            @endif
                        </div>
                        <div id="notificationItemsContainer" class="max-h-72 overflow-y-auto px-2 py-2">
                            @if($notifications->isNotEmpty())
                                @foreach($notifications as $notification)
                                    <button type="button" onclick="showNotificationDetail(this)" data-id="{{ $notification->id }}" data-url="{{ e($notification->data['url'] ?? '#') }}" data-title="{{ e($notification->data['title'] ?? 'Pemberitahuan') }}" data-message="{{ e($notification->data['message'] ?? '') }}" class="notification-item notification-item--accent w-full text-left px-4 py-4 mb-3 rounded-[1.75rem] border border-purple-200/40 bg-gradient-to-br from-purple-50 via-fuchsia-50 to-pink-50 text-slate-800 dark:bg-slate-900 dark:text-slate-100 dark:border-slate-800 hover:from-purple-100 hover:via-fuchsia-100 hover:to-pink-100 dark:hover:bg-slate-800 transition-all shadow-sm shadow-purple-200/10">
                                        <div class="text-sm font-semibold text-slate-900 dark:text-slate-100">{{ $notification->data['title'] ?? 'Pemberitahuan' }}</div>
                                        <div class="text-xs text-slate-500 dark:text-slate-400 mt-1">{{ $notification->data['message'] ?? '' }}</div>
                                        <div class="text-[11px] font-semibold text-pink-600 dark:text-pink-300 mt-2">Klik untuk lihat detail</div>
                                    </button>
                                @endforeach
                                @if($notificationCount > 3)
                                    <div class="px-4 py-3 rounded-2xl bg-gray-50 dark:bg-slate-900 text-xs text-gray-500 dark:text-slate-400 border border-gray-100 dark:border-slate-800">
                                        Menampilkan 3 notifikasi terbaru. Lihat semua untuk melihat sisanya.
                                    </div>
                                @endif
                            @else
                                <div class="px-4 py-4 text-sm text-gray-500 dark:text-slate-400">Tidak ada pemberitahuan baru.</div>
                            @endif
                        </div>
                        <div class="px-4 py-3 border-t border-gray-100 dark:border-slate-800">
                            <a href="{{ route('peminjam.notifications.index') }}" class="w-full inline-flex justify-center px-4 py-2 text-sm font-semibold text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300">Lihat semua notifikasi</a>
                        </div>
                    </div>
                </div>

<div id="notificationDetailModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4 transition-opacity duration-200">
                        <div class="relative w-full max-w-xl overflow-hidden rounded-[2rem] border border-slate-200/20 bg-white text-slate-900 shadow-2xl dark:border-slate-800 dark:bg-slate-950 dark:text-slate-100">
                            <div class="bg-gradient-to-r from-purple-600 via-pink-500 to-orange-400 px-6 py-5">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-white/85">Pemberitahuan</p>
                                        <h2 id="notificationModalTitle" class="mt-2 text-2xl font-semibold text-white">Detail Notifikasi</h2>
                                    </div>
                                    <button type="button" onclick="closeNotificationModal()" class="inline-flex h-11 w-11 items-center justify-center rounded-full bg-white/15 text-white transition hover:bg-white/25">
                                        <span class="sr-only">Tutup</span>
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="px-6 py-6 space-y-5">
                                <div class="rounded-[1.5rem] border border-purple-200/80 bg-white/90 p-5 shadow-sm shadow-purple-200/20 dark:border-purple-500/20 dark:bg-slate-900/95">
                                    <p class="text-[11px] font-semibold uppercase tracking-[0.24em] text-purple-600 dark:text-purple-300">Pesan Utama</p>
                                    <p id="notificationModalMessage" class="mt-3 text-base font-semibold leading-8 text-slate-900 dark:text-white"></p>
                                </div>
                                <div class="grid gap-3 sm:grid-cols-[1fr_auto] items-center">
                                    <div class="rounded-[1.5rem] border border-purple-200/50 bg-purple-50/80 p-4 dark:border-purple-500/20 dark:bg-slate-900/80">
                                        <p class="text-[11px] font-semibold uppercase tracking-[0.24em] text-purple-700 dark:text-purple-300">Status</p>
                                        <p id="notificationModalStatus" class="mt-2 text-sm font-semibold text-slate-900 dark:text-white">Belum dibaca</p>
                                    </div>
                                    <button id="notificationModalOpenButton" type="button" onclick="openNotificationUrl()" data-url="#" style="display:none" class="inline-flex h-12 items-center justify-center rounded-full bg-gradient-to-r from-purple-600 to-pink-500 px-6 text-sm font-semibold text-white shadow-lg shadow-pink-500/20 transition hover:scale-[1.02]">Buka halaman</button>
                                </div>
                                <button type="button" onclick="closeNotificationModal()" class="w-full rounded-3xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-900 transition hover:bg-slate-100 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100 dark:hover:bg-slate-800">Tutup</button>
                            </div>
                        </div>
                    </div>

                <!-- Profile Dropdown -->
                <div class="relative">
                    <button onclick="toggleDropdown()" class="flex items-center space-x-2 sm:space-x-3 p-1.5 hover:bg-gray-100 dark:hover:bg-slate-800 rounded-lg transition-colors">
                        <div class="hidden sm:block text-right">
                            <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-500">
                                @if(auth()->user()->profile && auth()->user()->profile->kelas)
                                    {{ auth()->user()->profile->kelas->nama_kelas ?? 'Siswa' }}
                                @else
                                    Siswa
                                @endif
                            </p>
                        </div>
                        <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-gradient-to-br from-purple-600 to-pink-500 flex items-center justify-center text-white font-bold shadow-lg shadow-purple-200">
                            {{ substr(auth()->user()->name, 0, 2) }}
                        </div>
                    </button>

                    <!-- Dropdown Menu -->
                    <div id="profileDropdown" class="hidden absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-100 py-2 z-50">
                        <div class="px-4 py-3 border-b border-gray-100">
                            <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-500">{{ auth()->user()->email ?? auth()->user()->nisn }}</p>
                        </div>
                        <a href="{{ route('profile.edit') }}" class="flex items-center space-x-3 px-4 py-2.5 hover:bg-pink-50 transition-colors">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span class="text-sm font-medium text-gray-700">Profil Saya</span>
                        </a>
                        <a href="/siswa/pengaturan" class="flex items-center space-x-3 px-4 py-2.5 hover:bg-pink-50 transition-colors">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="text-sm font-medium text-gray-700">Pengaturan</span>
                        </a>
                        <a href="/siswa/bantuan" class="flex items-center space-x-3 px-4 py-2.5 hover:bg-pink-50 transition-colors">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-sm font-medium text-gray-700">Bantuan</span>
                        </a>
                        <div class="border-t border-gray-100 mt-2 pt-2">
                            <form method="POST" action="{{ route('logout') }}" class="w-full">
                                @csrf
                                <button type="submit" class="flex items-center space-x-3 px-4 py-2.5 hover:bg-red-50 transition-colors w-full text-left">
                                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    <span class="text-sm font-medium text-red-600">Keluar</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Mobile Menu Button -->
                <button id="mobile-menu-button" class="md:hidden p-2 text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation -->
        <div id="mobile-menu" class="hidden md:hidden border-t border-gray-100 dark:border-slate-800 bg-white dark:bg-slate-950 py-3">
            <div class="px-4 pb-3 border-b border-gray-100 dark:border-slate-800">
                <button type="button" onclick="toggleDarkMode()" data-theme-toggle class="theme-toggle-button w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-slate-900/5 dark:bg-slate-700/70 text-slate-700 dark:text-slate-100 rounded-xl hover:bg-slate-900/10 dark:hover:bg-slate-600 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M17.293 13.293A8 8 0 116.707 2.707a7 7 0 1010.586 10.586z" clip-rule="evenodd"/></svg>
                    <span>Dark Mode</span>
                </button>
            </div>
            <div class="space-y-1">
                <a href="{{ route('peminjam.beranda') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg font-semibold text-sm transition-all text-gray-600 dark:text-slate-200 hover:bg-pink-50 dark:hover:bg-slate-800 hover:text-pink-500 dark:hover:text-pink-300 {{ Request::is('peminjam/beranda*') ? 'bg-gradient-to-r from-purple-600 to-pink-500 text-white' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span>Beranda</span>
                </a>
                <a href="{{ route('peminjam.aktivitasSaya') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg font-semibold text-sm transition-all text-gray-600 dark:text-slate-200 hover:bg-pink-50 dark:hover:bg-slate-800 hover:text-pink-500 dark:hover:text-pink-300 {{ Request::is('peminjam/aktivitas*') ? 'bg-gradient-to-r from-purple-600 to-pink-500 text-white' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span>Aktivitas Saya</span>
                </a>
                <a href="/siswa/riwayat" class="flex items-center space-x-3 px-4 py-3 rounded-lg font-semibold text-sm transition-all text-gray-600 dark:text-slate-200 hover:bg-pink-50 dark:hover:bg-slate-800 hover:text-pink-500 dark:hover:text-pink-300 {{ Request::is('siswa/riwayat*') ? 'bg-gradient-to-r from-purple-600 to-pink-500 text-white' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Riwayat</span>
                </a>
                <a href="/siswa/favorit" class="flex items-center space-x-3 px-4 py-3 rounded-lg font-semibold text-sm transition-all text-gray-600 dark:text-slate-200 hover:bg-pink-50 dark:hover:bg-slate-800 hover:text-pink-500 dark:hover:text-pink-300 {{ Request::is('siswa/favorit*') ? 'bg-gradient-to-r from-purple-600 to-pink-500 text-white' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                    <span>Favorit</span>
                </a>
            </div>
            
            <!-- Mobile Search -->
            <div class="mt-3 px-4">
                <div class="relative">
                    <input type="text" placeholder="Cari barang..." class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>
            
            <!-- Mobile Logout Button -->
            <div class="mt-4 px-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center justify-center space-x-2 w-full px-4 py-3 bg-gradient-to-r from-purple-600 to-pink-500 text-white rounded-xl hover:from-purple-700 hover:to-pink-600 transition-all shadow-lg hover:shadow-xl font-semibold group">
                        <svg class="w-5 h-5 group-hover:rotate-180 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>

<style>
    /* Animation untuk dropdown */
    #profileDropdown {
        animation: dropdownFade 0.2s ease-out;
    }

    @keyframes dropdownFade {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    #notificationDetailModal {
        backdrop-filter: blur(10px);
    }

    .notification-item--accent {
        background: linear-gradient(135deg, rgba(236, 72, 153, 0.12), rgba(168, 85, 247, 0.06));
        border-color: rgba(168, 85, 247, 0.25);
    }
</style>

<script>
    // Toggle profile dropdown
    function toggleDropdown() {
        const dropdown = document.getElementById('profileDropdown');
        dropdown.classList.toggle('hidden');
    }

    const notificationCsrfToken = '{{ csrf_token() }}';

    // Toggle notification dropdown
    function toggleNotificationDropdown(event) {
        event.stopPropagation();
        const dropdown = document.getElementById('notificationDropdown');
        const profileDropdown = document.getElementById('profileDropdown');

        if (profileDropdown && !profileDropdown.classList.contains('hidden')) {
            profileDropdown.classList.add('hidden');
        }

        dropdown.classList.toggle('hidden');
    }

    function updateNotificationBadge(count) {
        const badge = document.getElementById('notificationBadge');
        const label = document.getElementById('notificationCountLabel');

        if (label) {
            label.textContent = `${count} belum dibaca`;
        }

        if (!badge) {
            return;
        }

        if (count <= 0) {
            badge.remove();
            const markAllButton = document.getElementById('notificationMarkAllButton');
            if (markAllButton) {
                markAllButton.remove();
            }
            const itemsContainer = document.getElementById('notificationItemsContainer');
            if (itemsContainer) {
                itemsContainer.innerHTML = '<div class="px-4 py-4 text-sm text-gray-500 dark:text-slate-400">Tidak ada pemberitahuan baru.</div>';
            }
            return;
        }

        badge.textContent = count;
    }

    function showNotificationDetail(button) {
        const notificationId = button.dataset.id;
        const notificationUrl = button.dataset.url || '#';
        const notificationTitle = button.dataset.title || 'Pemberitahuan';
        const notificationMessage = button.dataset.message || 'Tidak ada detail tambahan.';

        document.getElementById('notificationModalTitle').textContent = notificationTitle;
        document.getElementById('notificationModalMessage').textContent = notificationMessage;
        document.getElementById('notificationModalStatus').textContent = 'Belum dibaca';
        const openButton = document.getElementById('notificationModalOpenButton');
        openButton.dataset.url = notificationUrl;
        openButton.style.display = notificationUrl && notificationUrl !== '#' ? 'inline-flex' : 'none';

        if (notificationId) {
            fetch(`/peminjam/notifications/${notificationId}/read`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': notificationCsrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    button.classList.remove('bg-purple-50', 'dark:bg-slate-900', 'border-purple-100');
                    button.classList.add('bg-white', 'dark:bg-slate-950', 'border-gray-100');
                    const currentCount = Number(document.getElementById('notificationBadge')?.textContent || 0);
                    updateNotificationBadge(Math.max(currentCount - 1, 0));
                    document.getElementById('notificationModalStatus').textContent = 'Sudah dibaca';
                }
            })
            .catch(() => {
                // ignore network errors
            });
        }

        document.getElementById('notificationDetailModal').classList.remove('hidden');
    }

    function openNotificationUrl() {
        const openButton = document.getElementById('notificationModalOpenButton');
        const notificationUrl = openButton.dataset.url || '#';

        if (notificationUrl && notificationUrl !== '#') {
            window.location.href = notificationUrl;
        }
    }

    function closeNotificationModal() {
        document.getElementById('notificationDetailModal').classList.add('hidden');
    }

    function markAllNotificationsRead() {
        fetch('/peminjam/notifications/read-all', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': notificationCsrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({})
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateNotificationBadge(0);
            }
        })
        .catch(() => {
            // ignore errors
        });
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        const dropdown = document.getElementById('profileDropdown');
        const dropdownBtn = document.querySelector('[onclick="toggleDropdown()"]');
        
        if (dropdown && dropdownBtn) {
            if (!dropdown.contains(event.target) && !dropdownBtn.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        }
    });

    // Mobile menu toggle
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    
    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
            
            // Toggle icon
            const icon = mobileMenuButton.querySelector('svg');
            if (mobileMenu.classList.contains('hidden')) {
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>';
            } else {
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>';
            }
        });
    }

    // Close mobile menu when clicking outside
    document.addEventListener('click', function(event) {
        const mobileMenu = document.getElementById('mobile-menu');
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const notificationDropdown = document.getElementById('notificationDropdown');
        const notificationButton = document.getElementById('notificationButton');
        
        if (mobileMenu && mobileMenuButton) {
            if (!mobileMenu.contains(event.target) && !mobileMenuButton.contains(event.target)) {
                mobileMenu.classList.add('hidden');
                const icon = mobileMenuButton.querySelector('svg');
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>';
            }
        }

        if (notificationDropdown && notificationButton) {
            if (!notificationDropdown.contains(event.target) && !notificationButton.contains(event.target)) {
                notificationDropdown.classList.add('hidden');
            }
        }
    });

    // Animasi untuk tombol logout
    const logoutButtons = document.querySelectorAll('form[action="{{ route("logout") }}"] button');
    logoutButtons.forEach(button => {
        button.addEventListener('mouseenter', function() {
            const icon = this.querySelector('svg');
            if (icon) {
                icon.style.transform = 'rotate(180deg)';
            }
        });
        
        button.addEventListener('mouseleave', function() {
            const icon = this.querySelector('svg');
            if (icon) {
                icon.style.transform = 'rotate(0deg)';
            }
        });
    });

</script>