{{-- Navbar Component untuk Siswa/Peminjam --}}
@php
    $notificationCount = auth()->check() ? auth()->user()->unreadNotifications()->count() : 0;
    $notifications = auth()->check() ? auth()->user()->unreadNotifications()->latest()->take(3)->get() : collect();
@endphp

<nav class="navbar-main bg-white/95 dark:bg-slate-950/95 border-b border-purple-100 dark:border-slate-800 sticky top-0 z-50 backdrop-blur-md">
    <div class="max-w-7xl mx-auto px-3 sm:px-5 lg:px-8">
        <div class="flex items-center justify-between h-14 sm:h-16">

            {{-- ===== LOGO ===== --}}
            <a href="{{ route('peminjam.beranda') }}" class="flex items-center gap-2 sm:gap-3 flex-shrink-0">
                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-br from-purple-600 to-pink-500 rounded-xl flex items-center justify-center shadow-md shadow-purple-200 dark:shadow-purple-900/30">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <div class="hidden xs:block">
                    <h1 class="text-base sm:text-lg font-extrabold bg-gradient-to-r from-purple-600 to-pink-500 bg-clip-text text-transparent leading-none">SIMAS</h1>
                    <p class="text-[10px] sm:text-xs text-gray-400 dark:text-slate-500 leading-none mt-0.5">Manajemen Sekolah</p>
                </div>
            </a>

            {{-- ===== DESKTOP NAV ===== --}}
            <div class="hidden md:flex items-center gap-1">
                <a href="{{ route('peminjam.beranda') }}"
                   class="nav-link px-3 py-2 rounded-lg text-sm font-semibold flex items-center gap-2 transition-all
                   {{ Request::is('peminjam/beranda*') ? 'bg-gradient-to-r from-purple-600 to-pink-500 text-white shadow-md shadow-purple-200 dark:shadow-purple-900/40' : 'text-gray-600 dark:text-slate-300 hover:bg-purple-50 dark:hover:bg-slate-800 hover:text-purple-600 dark:hover:text-purple-300' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Beranda
                </a>
                <a href="{{ route('peminjam.aktivitasSaya') }}"
                   class="nav-link px-3 py-2 rounded-lg text-sm font-semibold flex items-center gap-2 transition-all
                   {{ Request::is('peminjam/aktivitas*') ? 'bg-gradient-to-r from-purple-600 to-pink-500 text-white shadow-md shadow-purple-200 dark:shadow-purple-900/40' : 'text-gray-600 dark:text-slate-300 hover:bg-purple-50 dark:hover:bg-slate-800 hover:text-purple-600 dark:hover:text-purple-300' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Aktivitas Saya
                </a>
            </div>

            {{-- ===== RIGHT SIDE DESKTOP ===== --}}
            <div class="hidden md:flex items-center gap-1 sm:gap-2">
                {{-- Dark Mode Toggle --}}
                <button type="button" onclick="toggleDarkMode()" data-theme-toggle
                    class="theme-toggle-button p-2 items-center justify-center rounded-lg bg-gray-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-purple-100 dark:hover:bg-slate-700 transition-all"
                    title="Toggle Dark Mode">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 dark:hidden" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M17.293 13.293A8 8 0 116.707 2.707a7 7 0 1010.586 10.586z" clip-rule="evenodd"/></svg>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 hidden dark:block" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"/></svg>
                </button>

                {{-- Cart --}}
                <a href="{{ route('peminjam.keranjang') }}" class="relative p-2 text-gray-500 dark:text-slate-400 hover:bg-purple-50 dark:hover:bg-slate-800 rounded-lg transition-colors group">
                    <svg class="w-5 h-5 group-hover:text-purple-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span id="cartBadgeDesktop" class="cart-badge absolute -top-0.5 -right-0.5 min-w-[18px] h-[18px] bg-gradient-to-r from-purple-600 to-pink-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center px-1 hidden">0</span>
                </a>

                {{-- Notifications --}}
                <div class="relative">
                    <button id="notificationButton" type="button" onclick="toggleNotificationDropdown(event)"
                        class="relative p-2 text-gray-500 dark:text-slate-400 hover:bg-purple-50 dark:hover:bg-slate-800 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        @if($notificationCount > 0)
                            <span id="notificationBadge" class="absolute top-0.5 right-0.5 min-w-[16px] h-[16px] bg-red-500 text-white text-[9px] font-bold rounded-full flex items-center justify-center px-0.5 border border-white dark:border-slate-950">{{ $notificationCount }}</span>
                        @endif
                    </button>

                    <div id="notificationDropdown" class="notif-dropdown hidden absolute right-0 mt-2 w-80 sm:w-96 bg-white dark:bg-slate-950 rounded-2xl shadow-xl border border-gray-100 dark:border-slate-800 z-50 overflow-hidden">
                        <div class="px-4 py-3 border-b border-gray-100 dark:border-slate-800 flex items-center justify-between gap-2">
                            <div>
                                <h3 class="text-sm font-bold text-gray-900 dark:text-slate-100">Pemberitahuan</h3>
                                <p id="notificationCountLabel" class="text-xs text-gray-500 dark:text-slate-400">{{ $notificationCount }} belum dibaca</p>
                            </div>
                            @if($notificationCount > 0)
                                <button id="notificationMarkAllButton" type="button" onclick="markAllNotificationsRead()"
                                    class="text-xs font-semibold text-purple-600 hover:text-purple-700 dark:text-purple-400 dark:hover:text-purple-300 px-2 py-1 rounded-lg hover:bg-purple-50 dark:hover:bg-slate-800 transition-colors">
                                    Tandai semua
                                </button>
                            @endif
                        </div>
                        <div id="notificationItemsContainer" class="max-h-64 overflow-y-auto p-2">
                            @if($notifications->isNotEmpty())
                                @foreach($notifications as $notification)
                                    <button type="button" onclick="showNotificationDetail(this)"
                                        data-id="{{ $notification->id }}"
                                        data-url="{{ e($notification->data['url'] ?? '#') }}"
                                        data-title="{{ e($notification->data['title'] ?? 'Pemberitahuan') }}"
                                        data-message="{{ e($notification->data['message'] ?? '') }}"
                                        class="notification-item notification-item--accent w-full text-left px-3 py-3 mb-1.5 rounded-xl border border-purple-100/60 bg-gradient-to-br from-purple-50 to-pink-50 dark:from-slate-900 dark:to-slate-800 dark:border-slate-700 hover:from-purple-100 hover:to-pink-100 dark:hover:from-slate-800 dark:hover:to-slate-700 transition-all">
                                        <div class="text-xs font-bold text-slate-900 dark:text-slate-100">{{ $notification->data['title'] ?? 'Pemberitahuan' }}</div>
                                        <div class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 line-clamp-2">{{ $notification->data['message'] ?? '' }}</div>
                                        <div class="text-[10px] font-semibold text-pink-500 dark:text-pink-400 mt-1">Tap untuk detail →</div>
                                    </button>
                                @endforeach
                                @if($notificationCount > 3)
                                    <div class="px-3 py-2 rounded-xl bg-gray-50 dark:bg-slate-900 text-xs text-gray-500 dark:text-slate-400 border border-gray-100 dark:border-slate-800">
                                        Menampilkan 3 terbaru dari {{ $notificationCount }} notifikasi.
                                    </div>
                                @endif
                            @else
                                <div class="px-3 py-8 text-center">
                                    <svg class="w-12 h-12 text-gray-300 dark:text-slate-700 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                                    <p class="text-sm text-gray-400 dark:text-slate-500">Tidak ada pemberitahuan</p>
                                </div>
                            @endif
                        </div>
                        <div class="px-3 py-2.5 border-t border-gray-100 dark:border-slate-800">
                            <a href="{{ route('peminjam.notifications.index') }}" class="w-full flex items-center justify-center gap-1.5 py-2 text-xs font-semibold text-purple-600 dark:text-purple-400 hover:bg-purple-50 dark:hover:bg-slate-800 rounded-lg transition-colors">
                                Lihat semua notifikasi
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Profile Dropdown --}}
                <div class="relative">
                    <button onclick="toggleDropdown()" class="flex items-center gap-2 p-1 hover:bg-gray-100 dark:hover:bg-slate-800 rounded-lg transition-colors">
                        <div class="hidden sm:block text-right">
                            <p class="text-xs font-bold text-gray-900 dark:text-slate-100 leading-none">{{ auth()->user()->name }}</p>
                            <p class="text-[10px] text-gray-400 dark:text-slate-500 leading-none mt-0.5">{{ auth()->user()->kelas ?? 'Siswa' }}</p>
                        </div>
                        <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-gradient-to-br from-purple-600 to-pink-500 flex items-center justify-center text-white text-xs font-bold shadow-md shadow-purple-200 dark:shadow-purple-900/30 flex-shrink-0">
                            {{ substr(auth()->user()->name, 0, 2) }}
                        </div>
                    </button>

                    <div id="profileDropdown" class="hidden absolute right-0 mt-2 w-52 bg-white dark:bg-slate-900 rounded-xl shadow-lg border border-gray-100 dark:border-slate-700 py-1.5 z-50">
                        <div class="px-3 py-2.5 border-b border-gray-100 dark:border-slate-700">
                            <p class="text-sm font-bold text-gray-900 dark:text-slate-100">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-400 dark:text-slate-500 truncate">{{ auth()->user()->email ?? auth()->user()->nisn }}</p>
                        </div>
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-2.5 px-3 py-2.5 hover:bg-purple-50 dark:hover:bg-slate-800 transition-colors group">
                            <div class="w-7 h-7 rounded-lg bg-purple-100 dark:bg-slate-700 flex items-center justify-center group-hover:bg-purple-200 dark:group-hover:bg-slate-600 transition-colors">
                                <svg class="w-4 h-4 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <span class="text-sm font-medium text-gray-700 dark:text-slate-200">Profil Saya</span>
                        </a>
                        <div class="border-t border-gray-100 dark:border-slate-700 mt-1 pt-1">
                            <form method="POST" action="{{ route('logout') }}" class="w-full">
                                @csrf
                                <button type="submit" class="flex items-center gap-2.5 px-3 py-2.5 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors w-full text-left group">
                                    <div class="w-7 h-7 rounded-lg bg-red-100 dark:bg-red-900/30 flex items-center justify-center group-hover:bg-red-200 dark:group-hover:bg-red-900/50 transition-colors">
                                        <svg class="w-4 h-4 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                    </div>
                                    <span class="text-sm font-medium text-red-600 dark:text-red-400">Keluar</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Hanya icon cart dan notif di mobile, tanpa hamburger --}}
            <div class="flex md:hidden items-center gap-2">
                {{-- Cart Mobile --}}
                <a href="{{ route('peminjam.keranjang') }}" class="relative p-2 text-gray-500 dark:text-slate-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span id="cartBadgeMobile" class="absolute -top-0.5 -right-0.5 min-w-[16px] h-[16px] bg-gradient-to-r from-purple-600 to-pink-500 text-white text-[9px] font-bold rounded-full flex items-center justify-center px-0.5 hidden">0</span>
                </a>

                {{-- Notifications Mobile --}}
                <div class="relative">
                    <button id="notificationButtonMobile" type="button" onclick="toggleNotificationDropdownMobile(event)"
                        class="relative p-2 text-gray-500 dark:text-slate-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        @if($notificationCount > 0)
                            <span id="notificationBadgeMobile" class="absolute top-0.5 right-0.5 min-w-[16px] h-[16px] bg-red-500 text-white text-[9px] font-bold rounded-full flex items-center justify-center px-0.5 border border-white dark:border-slate-950">{{ $notificationCount }}</span>
                        @endif
                    </button>

                    <div id="notificationDropdownMobile" class="notif-dropdown hidden absolute right-0 mt-2 w-80 bg-white dark:bg-slate-950 rounded-2xl shadow-xl border border-gray-100 dark:border-slate-800 z-50 overflow-hidden">
                        <div class="px-4 py-3 border-b border-gray-100 dark:border-slate-800 flex items-center justify-between gap-2">
                            <div>
                                <h3 class="text-sm font-bold text-gray-900 dark:text-slate-100">Pemberitahuan</h3>
                                <p id="notificationCountLabelMobile" class="text-xs text-gray-500 dark:text-slate-400">{{ $notificationCount }} belum dibaca</p>
                            </div>
                            @if($notificationCount > 0)
                                <button id="notificationMarkAllButtonMobile" type="button" onclick="markAllNotificationsReadMobile()"
                                    class="text-xs font-semibold text-purple-600 hover:text-purple-700 dark:text-purple-400 dark:hover:text-purple-300 px-2 py-1 rounded-lg hover:bg-purple-50 dark:hover:bg-slate-800 transition-colors">
                                    Tandai semua
                                </button>
                            @endif
                        </div>
                        <div id="notificationItemsContainerMobile" class="max-h-64 overflow-y-auto p-2">
                            @if($notifications->isNotEmpty())
                                @foreach($notifications as $notification)
                                    <button type="button" onclick="showNotificationDetailMobile(this)"
                                        data-id="{{ $notification->id }}"
                                        data-url="{{ e($notification->data['url'] ?? '#') }}"
                                        data-title="{{ e($notification->data['title'] ?? 'Pemberitahuan') }}"
                                        data-message="{{ e($notification->data['message'] ?? '') }}"
                                        class="notification-item notification-item--accent w-full text-left px-3 py-3 mb-1.5 rounded-xl border border-purple-100/60 bg-gradient-to-br from-purple-50 to-pink-50 dark:from-slate-900 dark:to-slate-800 dark:border-slate-700 hover:from-purple-100 hover:to-pink-100 dark:hover:from-slate-800 dark:hover:to-slate-700 transition-all">
                                        <div class="text-xs font-bold text-slate-900 dark:text-slate-100">{{ $notification->data['title'] ?? 'Pemberitahuan' }}</div>
                                        <div class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 line-clamp-2">{{ $notification->data['message'] ?? '' }}</div>
                                        <div class="text-[10px] font-semibold text-pink-500 dark:text-pink-400 mt-1">Tap untuk detail →</div>
                                    </button>
                                @endforeach
                                @if($notificationCount > 3)
                                    <div class="px-3 py-2 rounded-xl bg-gray-50 dark:bg-slate-900 text-xs text-gray-500 dark:text-slate-400 border border-gray-100 dark:border-slate-800">
                                        Menampilkan 3 terbaru dari {{ $notificationCount }} notifikasi.
                                    </div>
                                @endif
                            @else
                                <div class="px-3 py-8 text-center">
                                    <svg class="w-12 h-12 text-gray-300 dark:text-slate-700 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                                    <p class="text-sm text-gray-400 dark:text-slate-500">Tidak ada pemberitahuan</p>
                                </div>
                            @endif
                        </div>
                        <div class="px-3 py-2.5 border-t border-gray-100 dark:border-slate-800">
                            <a href="{{ route('peminjam.notifications.index') }}" class="w-full flex items-center justify-center gap-1.5 py-2 text-xs font-semibold text-purple-600 dark:text-purple-400 hover:bg-purple-50 dark:hover:bg-slate-800 rounded-lg transition-colors">
                                Lihat semua notifikasi
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Profile Avatar Mobile --}}
                <a href="{{ route('profile.edit') }}" class="flex items-center">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-purple-600 to-pink-500 flex items-center justify-center text-white text-xs font-bold shadow-md shadow-purple-200 dark:shadow-purple-900/30">
                        {{ substr(auth()->user()->name, 0, 2) }}
                    </div>
                </a>
            </div>
        </div>
    </div>
</nav>

{{-- BOTTOM NAVIGATION BAR UNTUK MOBILE --}}
<div class="md:hidden fixed bottom-0 left-0 right-0 bg-white/95 dark:bg-slate-950/95 border-t border-purple-100 dark:border-slate-800 z-50 backdrop-blur-md pb-safe">
    <div class="flex items-center justify-around py-2">
        <!-- Beranda -->
        <a href="{{ route('peminjam.beranda') }}" 
           class="flex flex-col items-center gap-1 px-4 py-1 rounded-lg transition-all
           {{ Request::is('peminjam/beranda*') ? 'text-purple-600 dark:text-purple-400' : 'text-gray-500 dark:text-slate-400' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
            <span class="text-[10px] font-medium">Beranda</span>
        </a>

        <!-- Aktivitas -->
        <a href="{{ route('peminjam.aktivitasSaya') }}" 
           class="flex flex-col items-center gap-1 px-4 py-1 rounded-lg transition-all
           {{ Request::is('peminjam/aktivitas*') ? 'text-purple-600 dark:text-purple-400' : 'text-gray-500 dark:text-slate-400' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <span class="text-[10px] font-medium">Aktivitas</span>
        </a>

        <!-- Cart Bottom -->
        <a href="{{ route('peminjam.keranjang') }}" 
           class="flex flex-col items-center gap-1 px-4 py-1 rounded-lg transition-all relative
           {{ Request::is('peminjam/keranjang*') ? 'text-purple-600 dark:text-purple-400' : 'text-gray-500 dark:text-slate-400' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
            <span class="text-[10px] font-medium">Keranjang</span>
            <span id="cartBadgeBottomNav" class="absolute -top-1 right-3 min-w-[16px] h-[16px] bg-gradient-to-r from-purple-600 to-pink-500 text-white text-[9px] font-bold rounded-full flex items-center justify-center px-0.5 hidden">0</span>
        </a>

        <!-- Profil -->
        <a href="{{ route('profile.edit') }}" 
           class="flex flex-col items-center gap-1 px-4 py-1 rounded-lg transition-all
           {{ Request::is('profile*') ? 'text-purple-600 dark:text-purple-400' : 'text-gray-500 dark:text-slate-400' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
            <span class="text-[10px] font-medium">Profil</span>
        </a>
    </div>
</div>

<style>
    .navbar-main {
        box-shadow: 0 1px 20px rgba(139, 92, 246, 0.06);
    }

    /* xs breakpoint */
    @media (min-width: 400px) {
        .xs\:block { display: block; }
    }

    /* Dropdown animations */
    #profileDropdown, .notif-dropdown {
        animation: dropFade 0.18s ease-out;
        transform-origin: top right;
    }

    @keyframes dropFade {
        from { opacity: 0; transform: translateY(-8px) scale(0.97); }
        to   { opacity: 1; transform: translateY(0) scale(1); }
    }

    .notification-item--accent {
        background: linear-gradient(135deg, rgba(236, 72, 153, 0.08), rgba(168, 85, 247, 0.05));
        border-color: rgba(168, 85, 247, 0.2);
    }

    .cart-badge {
        transition: transform 0.2s;
    }

    a:hover .cart-badge {
        transform: scale(1.1);
    }

    /* Safe area untuk bottom navigation di iPhone */
    .pb-safe {
        padding-bottom: env(safe-area-inset-bottom, 0px);
    }
</style>

<script>
    const notificationCsrfToken = '{{ csrf_token() }}';

    function toggleDropdown() {
        const dd = document.getElementById('profileDropdown');
        const notifDd = document.getElementById('notificationDropdown');
        if (notifDd) notifDd.classList.add('hidden');
        if (dd) dd.classList.toggle('hidden');
    }

    function toggleNotificationDropdown(event) {
        event.stopPropagation();
        const dd = document.getElementById('notificationDropdown');
        const profileDd = document.getElementById('profileDropdown');
        if (profileDd) profileDd.classList.add('hidden');
        if (dd) dd.classList.toggle('hidden');
    }

    function toggleNotificationDropdownMobile(event) {
        event.stopPropagation();
        const dd = document.getElementById('notificationDropdownMobile');
        const profileDd = document.getElementById('profileDropdown');
        if (profileDd) profileDd.classList.add('hidden');
        if (dd) dd.classList.toggle('hidden');
    }

    function updateNotificationBadge(count) {
        // Update desktop badge
        const badge = document.getElementById('notificationBadge');
        const label = document.getElementById('notificationCountLabel');
        if (label) label.textContent = `${count} belum dibaca`;
        if (badge) {
            if (count <= 0) {
                badge.remove();
            } else {
                badge.textContent = count;
            }
        }
        
        // Update mobile badge
        const badgeMobile = document.getElementById('notificationBadgeMobile');
        if (badgeMobile) {
            if (count <= 0) {
                badgeMobile.remove();
            } else {
                badgeMobile.textContent = count;
            }
        }
        
        // Update label mobile
        const labelMobile = document.getElementById('notificationCountLabelMobile');
        if (labelMobile) labelMobile.textContent = `${count} belum dibaca`;
        
        // Hapus tombol mark all jika count 0
        const markAllBtn = document.getElementById('notificationMarkAllButton');
        if (markAllBtn && count <= 0) markAllBtn.remove();
        const markAllBtnMobile = document.getElementById('notificationMarkAllButtonMobile');
        if (markAllBtnMobile && count <= 0) markAllBtnMobile.remove();
        
        // Update container kosong
        if (count <= 0) {
            const container = document.getElementById('notificationItemsContainer');
            if (container) {
                container.innerHTML = '<div class="px-3 py-8 text-center"><svg class="w-12 h-12 text-gray-300 dark:text-slate-700 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg><p class="text-sm text-gray-400 dark:text-slate-500">Tidak ada pemberitahuan</p></div>';
            }
            const containerMobile = document.getElementById('notificationItemsContainerMobile');
            if (containerMobile) {
                containerMobile.innerHTML = '<div class="px-3 py-8 text-center"><svg class="w-12 h-12 text-gray-300 dark:text-slate-700 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg><p class="text-sm text-gray-400 dark:text-slate-500">Tidak ada pemberitahuan</p></div>';
            }
        }
    }

    function showNotificationDetail(button) {
        const notifId = button.dataset.id;
        const notifUrl = button.dataset.url || '#';
        const notifTitle = button.dataset.title || 'Pemberitahuan';
        const notifMessage = button.dataset.message || 'Tidak ada detail.';

        document.getElementById('notificationModalTitle').textContent = notifTitle;
        document.getElementById('notificationModalMessage').innerHTML = notifMessage;
        document.getElementById('notificationModalStatus').textContent = 'Belum dibaca';

        const openBtn = document.getElementById('notificationModalOpenButton');
        openBtn.dataset.url = notifUrl;
        openBtn.style.display = (notifUrl && notifUrl !== '#') ? 'inline-flex' : 'none';

        const dropdown = document.getElementById('notificationDropdown');
        if (dropdown) dropdown.classList.add('hidden');
        
        const modal = document.getElementById('notificationDetailModal');
        modal.classList.remove('hidden');

        if (notifId) {
            fetch(`/peminjam/notifications/${notifId}/read`, {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json', 
                    'X-CSRF-TOKEN': notificationCsrfToken, 
                    'Accept': 'application/json' 
                },
                body: JSON.stringify({})
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('notificationModalStatus').textContent = 'Sudah dibaca';
                    const current = Number(document.getElementById('notificationBadge')?.textContent || 0);
                    updateNotificationBadge(Math.max(current - 1, 0));
                    
                    button.classList.remove('from-purple-50', 'to-pink-50', 'border-purple-100/60');
                    button.classList.add('bg-white', 'dark:bg-slate-800');
                }
            })
            .catch(() => {});
        }
    }

    function showNotificationDetailMobile(button) {
        const notifId = button.dataset.id;
        const notifUrl = button.dataset.url || '#';
        const notifTitle = button.dataset.title || 'Pemberitahuan';
        const notifMessage = button.dataset.message || 'Tidak ada detail.';

        document.getElementById('notificationModalTitle').textContent = notifTitle;
        document.getElementById('notificationModalMessage').innerHTML = notifMessage;
        document.getElementById('notificationModalStatus').textContent = 'Belum dibaca';

        const openBtn = document.getElementById('notificationModalOpenButton');
        openBtn.dataset.url = notifUrl;
        openBtn.style.display = (notifUrl && notifUrl !== '#') ? 'inline-flex' : 'none';

        const dropdown = document.getElementById('notificationDropdownMobile');
        if (dropdown) dropdown.classList.add('hidden');
        
        const modal = document.getElementById('notificationDetailModal');
        modal.classList.remove('hidden');

        if (notifId) {
            fetch(`/peminjam/notifications/${notifId}/read`, {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json', 
                    'X-CSRF-TOKEN': notificationCsrfToken, 
                    'Accept': 'application/json' 
                },
                body: JSON.stringify({})
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('notificationModalStatus').textContent = 'Sudah dibaca';
                    const current = Number(document.getElementById('notificationBadgeMobile')?.textContent || 0);
                    updateNotificationBadge(Math.max(current - 1, 0));
                    
                    button.classList.remove('from-purple-50', 'to-pink-50', 'border-purple-100/60');
                    button.classList.add('bg-white', 'dark:bg-slate-800');
                }
            })
            .catch(() => {});
        }
    }

    function closeNotificationModal() {
        const modal = document.getElementById('notificationDetailModal');
        if (modal) modal.classList.add('hidden');
    }

    function openNotificationUrl() {
        const url = document.getElementById('notificationModalOpenButton').dataset.url;
        if (url && url !== '#') {
            window.location.href = url;
        }
    }

    function markAllNotificationsRead() {
        fetch('/peminjam/notifications/read-all', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': notificationCsrfToken, 'Accept': 'application/json' },
            body: JSON.stringify({})
        }).then(r => r.json()).then(data => {
            if (data.success) updateNotificationBadge(0);
        }).catch(() => {});
    }

    function markAllNotificationsReadMobile() {
        fetch('/peminjam/notifications/read-all', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': notificationCsrfToken, 'Accept': 'application/json' },
            body: JSON.stringify({})
        }).then(r => r.json()).then(data => {
            if (data.success) updateNotificationBadge(0);
        }).catch(() => {});
    }

    function updateCartBadge() {
        const cartCount = localStorage.getItem('cartCount') || 0;
        
        const cartBadgeDesktop = document.getElementById('cartBadgeDesktop');
        if (cartBadgeDesktop) {
            cartBadgeDesktop.textContent = cartCount;
            if (cartCount == 0) cartBadgeDesktop.classList.add('hidden');
            else cartBadgeDesktop.classList.remove('hidden');
        }
        
        const cartBadgeMobile = document.getElementById('cartBadgeMobile');
        if (cartBadgeMobile) {
            cartBadgeMobile.textContent = cartCount;
            if (cartCount == 0) cartBadgeMobile.classList.add('hidden');
            else cartBadgeMobile.classList.remove('hidden');
        }
        
        const cartBadgeBottomNav = document.getElementById('cartBadgeBottomNav');
        if (cartBadgeBottomNav) {
            cartBadgeBottomNav.textContent = cartCount;
            if (cartCount == 0) cartBadgeBottomNav.classList.add('hidden');
            else cartBadgeBottomNav.classList.remove('hidden');
        }
    }

    // Close all dropdowns on outside click
    document.addEventListener('click', function(e) {
        const profileDd = document.getElementById('profileDropdown');
        const profileBtn = document.querySelector('[onclick="toggleDropdown()"]');
        if (profileDd && profileBtn && !profileDd.contains(e.target) && !profileBtn.contains(e.target)) {
            profileDd.classList.add('hidden');
        }

        const notifDd = document.getElementById('notificationDropdown');
        const notifBtn = document.getElementById('notificationButton');
        if (notifDd && notifBtn && !notifDd.contains(e.target) && !notifBtn.contains(e.target)) {
            notifDd.classList.add('hidden');
        }
        
        const notifDdMobile = document.getElementById('notificationDropdownMobile');
        const notifBtnMobile = document.getElementById('notificationButtonMobile');
        if (notifDdMobile && notifBtnMobile && !notifDdMobile.contains(e.target) && !notifBtnMobile.contains(e.target)) {
            notifDdMobile.classList.add('hidden');
        }
    });

    // Close modal on backdrop click
    const modal = document.getElementById('notificationDetailModal');
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === this) closeNotificationModal();
        });
    }
    
    // Jalankan saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
        updateCartBadge();
        
        // Update cart badge saat localStorage berubah
        window.addEventListener('storage', updateCartBadge);
        
        // Custom event untuk cart update
        window.addEventListener('cartUpdated', updateCartBadge);
    });
    
    // Dark mode toggle
    function toggleDarkMode() {
        if (document.documentElement.classList.contains('dark')) {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('theme', 'light');
        } else {
            document.documentElement.classList.add('dark');
            localStorage.setItem('theme', 'dark');
        }
    }
    
    // Cek theme saat load
    if (localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
</script>