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
                    <button type="button" onclick="showNotificationDetail(this)" data-id="{{ $notification->id }}" data-title="{{ e($notification->data['title'] ?? 'Pemberitahuan') }}" data-message="{{ e($notification->data['message'] ?? '') }}" class="notification-card w-full text-left rounded-3xl border px-6 py-5 shadow-sm transition-all {{ $isRead ? 'bg-white border-gray-200' : 'bg-purple-50 border-purple-200' }} hover:shadow-md">
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

    <div id="notificationDetailModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4">
        <div class="w-full max-w-2xl rounded-3xl bg-white dark:bg-slate-950 shadow-2xl border border-gray-200 dark:border-slate-800 overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-slate-800">
                <div>
                    <h2 id="notificationModalTitle" class="text-xl font-semibold text-gray-900 dark:text-slate-100">Detail Notifikasi</h2>
                    <p id="notificationModalSubtitle" class="text-sm text-gray-500 dark:text-gray-400 mt-1">Informasi lengkap mengenai pemberitahuan.</p>
                </div>
                <button type="button" onclick="closeNotificationModal()" class="text-gray-400 hover:text-gray-700 dark:hover:text-gray-200">
                    <span class="sr-only">Tutup</span>
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="px-6 py-6 space-y-4">
                <p id="notificationModalMessage" class="text-sm leading-relaxed text-gray-600 dark:text-gray-300"></p>
                <div class="rounded-2xl bg-purple-50 dark:bg-slate-900 border border-purple-100 dark:border-slate-800 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-purple-600 dark:text-purple-300">Status</p>
                    <p id="notificationModalStatus" class="mt-2 text-sm text-gray-700 dark:text-gray-200">Belum dibaca</p>
                </div>
            </div>
            <div class="px-6 py-4 bg-gray-50 dark:bg-slate-900 flex justify-end gap-3">
                <button type="button" onclick="closeNotificationModal()" class="inline-flex items-center justify-center rounded-3xl border border-gray-200 bg-white px-5 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-100 transition-all dark:border-slate-800 dark:bg-slate-950 dark:text-slate-100 dark:hover:bg-slate-900">Tutup</button>
            </div>
        </div>
    </div>

    <script>
        const notificationPageCsrfToken = '{{ csrf_token() }}';

        function showNotificationDetail(button) {
            const notificationId = button.dataset.id;
            const notificationTitle = button.dataset.title || 'Pemberitahuan';
            const notificationMessage = button.dataset.message || 'Tidak ada detail tambahan.';

            document.getElementById('notificationModalTitle').textContent = notificationTitle;
            document.getElementById('notificationModalMessage').textContent = notificationMessage;
            document.getElementById('notificationModalStatus').textContent = 'Sudah dibaca';

            if (notificationId) {
                fetch(`/peminjam/notifications/${notificationId}/read`, {
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
                        button.classList.remove('bg-purple-50', 'border-purple-200');
                        button.classList.add('bg-white', 'border-gray-200');
                        const unreadCount = document.getElementById('notificationUnreadCount');
                        const current = Number(unreadCount?.textContent || 0);
                        const next = Math.max(current - 1, 0);
                        if (unreadCount) unreadCount.textContent = next;
                        document.getElementById('notificationModalStatus').textContent = 'Sudah dibaca';
                    }
                });
            }

            document.getElementById('notificationDetailModal').classList.remove('hidden');
        }

        function closeNotificationModal() {
            document.getElementById('notificationDetailModal').classList.add('hidden');
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
    </script>
</body>
</html>
