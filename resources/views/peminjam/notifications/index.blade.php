<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi - SarPras Siswa</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        body {
            background: linear-gradient(to bottom right, #f8fafc, #eef2ff, #fdf4ff);
            min-height: 100vh;
            margin: 0;
        }
        .notification-card {
            transition: all 0.25s ease;
        }
        .notification-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 18px 40px -24px rgba(99, 102, 241, 0.8);
        }
        .badge-unread {
            background: #e9d5ff;
            color: #6b21a8;
        }
        
        /* Modal styling - CENTERED */
        .modal-notif {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 99999;
            padding: 20px;
        }
        
        .modal-notif-content {
            background: white;
            border-radius: 24px;
            width: 100%;
            max-width: 500px;
            max-height: 80vh;
            overflow-y: auto;
            position: relative;
            margin: auto;
        }
        
        .hidden {
            display: none !important;
        }
        
        /* Dark mode support */
        .dark .modal-notif-content {
            background: #0f172a;
            border: 1px solid #1e293b;
        }
    </style>
</head>
<body>
    @include('components.navbar_peminjam')

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="mb-8">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Notifikasi Saya</h1>
                    <p class="text-gray-600 mt-2">Lihat semua pemberitahuan dari petugas dan sistem.</p>
                </div>
                <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                    <div class="rounded-3xl bg-white border border-gray-200 px-5 py-4 shadow-sm">
                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-gray-500">Belum dibaca</p>
                        <p id="notificationUnreadCount" class="text-3xl font-bold text-gray-900">{{ $unreadCount }}</p>
                    </div>
                    <button type="button" onclick="markAllNotificationsReadPage()" class="inline-flex items-center justify-center rounded-3xl bg-gradient-to-r from-purple-600 to-pink-500 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-purple-200 hover:from-purple-700 hover:to-pink-600 transition-all">
                        Tandai semua dibaca
                    </button>
                </div>
            </div>
        </div>

        <div class="grid gap-4">
            @if($notifications->isEmpty())
                <div class="rounded-3xl border border-dashed border-gray-300 bg-white/80 p-8 text-center text-gray-500 shadow-sm">
                    <p class="text-lg font-semibold">Belum ada notifikasi.</p>
                    <p class="mt-2">Semua notifikasi baru akan muncul di sini.</p>
                </div>
            @else
                @foreach($notifications as $notification)
                    @php
                        $isRead = !empty($notification->read_at);
                    @endphp
                    <button type="button" onclick="showNotificationDetailPage(this)" data-id="{{ $notification->id }}" data-title="{{ e($notification->data['title'] ?? 'Pemberitahuan') }}" data-message="{{ e($notification->data['message'] ?? '') }}" data-url="{{ e($notification->data['url'] ?? '#') }}" class="notification-card w-full text-left rounded-3xl border px-6 py-5 shadow-sm transition-all {{ $isRead ? 'bg-white border-gray-200' : 'bg-purple-50 border-purple-200' }} hover:shadow-md">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div>
                                <p class="text-sm font-semibold text-gray-900">{{ $notification->data['title'] ?? 'Pemberitahuan' }}</p>
                                <p class="mt-1 text-sm text-gray-500">{{ $notification->data['message'] ?? '' }}</p>
                            </div>
                            <div class="flex items-center gap-2">
                                @if(!$isRead)
                                    <span class="badge-unread rounded-full px-3 py-1 text-xs font-semibold">Belum dibaca</span>
                                @else
                                    <span class="rounded-full border border-gray-200 bg-white px-3 py-1 text-xs text-gray-500">Sudah dibaca</span>
                                @endif
                                <span class="text-xs text-gray-400">{{ $notification->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </button>
                @endforeach
            @endif
        </div>
    </main>

    <!-- Modal Detail Notifikasi - PERFECT CENTERED -->
    <div id="notificationDetailModalPage" class="modal-notif hidden">
        <div class="modal-notif-content">
            <div class="sticky top-0 bg-white dark:bg-slate-950 flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-slate-800 rounded-t-2xl">
                <div>
                    <h2 id="notificationModalTitlePage" class="text-xl font-semibold text-gray-900 dark:text-slate-100">Detail Notifikasi</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Informasi lengkap mengenai pemberitahuan.</p>
                </div>
                <button type="button" onclick="closeNotificationModalPage()" class="text-gray-400 hover:text-gray-700 dark:hover:text-gray-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="px-6 py-6 space-y-4">
                <p id="notificationModalMessagePage" class="text-sm leading-relaxed text-gray-600 dark:text-gray-300"></p>
                <div class="rounded-2xl bg-purple-50 dark:bg-slate-900 border border-purple-100 dark:border-slate-800 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-purple-600 dark:text-purple-300">Status</p>
                    <p id="notificationModalStatusPage" class="mt-2 text-sm text-gray-700 dark:text-gray-200">Belum dibaca</p>
                </div>
                <div class="flex gap-3">
                    <button id="notificationModalOpenButtonPage" onclick="openNotificationUrlPage()" data-url="#" style="display:none" class="flex-1 inline-flex items-center justify-center rounded-2xl bg-gradient-to-r from-purple-600 to-pink-500 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-purple-200 hover:from-purple-700 hover:to-pink-600 transition-all">
                        Buka Halaman
                    </button>
                    <button type="button" onclick="closeNotificationModalPage()" class="flex-1 inline-flex items-center justify-center rounded-2xl border border-gray-200 bg-white px-5 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-100 transition-all dark:border-slate-800 dark:bg-slate-950 dark:text-slate-100 dark:hover:bg-slate-900">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const notificationPageCsrfToken = '{{ csrf_token() }}';

        function showNotificationDetailPage(button) {
            const notifId = button.dataset.id;
            const notifUrl = button.dataset.url || '#';
            const notifTitle = button.dataset.title || 'Pemberitahuan';
            const notifMessage = button.dataset.message || 'Tidak ada detail.';

            document.getElementById('notificationModalTitlePage').textContent = notifTitle;
            document.getElementById('notificationModalMessagePage').innerHTML = notifMessage;
            document.getElementById('notificationModalStatusPage').textContent = 'Belum dibaca';

            const openBtn = document.getElementById('notificationModalOpenButtonPage');
            openBtn.dataset.url = notifUrl;
            openBtn.style.display = (notifUrl && notifUrl !== '#') ? 'flex' : 'none';

            const modal = document.getElementById('notificationDetailModalPage');
            modal.classList.remove('hidden');

            if (notifId) {
                fetch(`/peminjam/notifications/${notifId}/read`, {
                    method: 'POST',
                    headers: { 
                        'Content-Type': 'application/json', 
                        'X-CSRF-TOKEN': notificationPageCsrfToken, 
                        'Accept': 'application/json' 
                    },
                    body: JSON.stringify({})
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('notificationModalStatusPage').textContent = 'Sudah dibaca';
                        button.classList.remove('bg-purple-50', 'border-purple-200');
                        button.classList.add('bg-white', 'border-gray-200');
                        
                        // Update badge di navbar
                        const badge = document.getElementById('notificationBadge');
                        if (badge) {
                            let currentCount = parseInt(badge.textContent) || 0;
                            if (currentCount > 0) {
                                currentCount--;
                                if (currentCount === 0) {
                                    badge.remove();
                                } else {
                                    badge.textContent = currentCount;
                                }
                            }
                        }
                        
                        // Update count di halaman
                        const unreadCountEl = document.getElementById('notificationUnreadCount');
                        if (unreadCountEl) {
                            let current = parseInt(unreadCountEl.textContent) || 0;
                            unreadCountEl.textContent = Math.max(current - 1, 0);
                        }
                    }
                })
                .catch(() => {});
            }
        }

        function closeNotificationModalPage() {
            const modal = document.getElementById('notificationDetailModalPage');
            modal.classList.add('hidden');
        }

        function openNotificationUrlPage() {
            const url = document.getElementById('notificationModalOpenButtonPage').dataset.url;
            if (url && url !== '#') {
                window.location.href = url;
            }
        }

        function markAllNotificationsReadPage() {
            fetch('{{ route('peminjam.notifications.readAll') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': notificationPageCsrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                }
            });
        }

        // Close modal dengan ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeNotificationModalPage();
            }
        });
    </script>
</body>
</html>