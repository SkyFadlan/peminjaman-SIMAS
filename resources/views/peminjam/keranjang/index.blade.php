<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Keranjang - SarPras Siswa</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite('resources/js/cart.js')
    <style>
        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        
        body {
            background: linear-gradient(to bottom right, #fdf4ff, #fff0f7, #faf5ff);
            min-height: 100vh;
        }
    </style>
</head>
<body>
    <!-- Navbar Component -->
    @include('components.navbar_peminjam')

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center space-x-3 mb-4">
                <a href="{{ route('peminjam.beranda') }}" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 flex items-center space-x-2">
                        <span>🛒 Keranjang Saya</span>
                    </h1>
                    <p class="text-gray-600 mt-1">Kelola dan checkout barang yang ingin Anda pinjam</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Items Section -->
            <div class="lg:col-span-2">
                <div id="cartItemsContainer" class="space-y-4">
                    <!-- Items akan di-load oleh JavaScript -->
                </div>
            </div>

            <!-- Summary Section -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-lg p-6 sticky top-20 border border-gray-100">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Ringkasan Pesanan</h2>
                    
                    <div class="space-y-4 mb-6 pb-6 border-b border-gray-200">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Total Item:</span>
                            <span class="font-bold text-lg" id="summaryItems">0</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Total Unit:</span>
                            <span class="font-bold text-lg text-pink-500" id="summaryUnits">0 unit</span>
                        </div>
                    </div>

                    <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl p-4 mb-6 border border-purple-200">
                        <p class="text-sm text-gray-600 mb-2">Status Keranjang</p>
                        <p class="text-2xl font-bold text-pink-500" id="cartStatus">Kosong</p>
                    </div>

                    <div class="space-y-3">
                        <button id="clearCartBtn" onclick="if(confirm('Hapus semua? Tindakan ini tidak bisa dibatalkan.')) { cart.clearCart(); loadCartItems(); }" class="w-full px-4 py-2.5 bg-red-100 text-red-600 rounded-lg font-semibold hover:bg-red-200 transition-colors hidden">
                            🗑️ Kosongkan Keranjang
                        </button>
                        <button id="checkoutBtn" onclick="checkoutAllItems()" class="w-full px-4 py-3 bg-gradient-to-r from-purple-600 to-pink-500 text-white rounded-xl font-bold text-lg hover:shadow-lg hover:shadow-purple-200 transition-all hidden">
                            Checkout (0)
                        </button>
                        <a href="{{ route('peminjam.beranda') }}" class="w-full px-4 py-2.5 bg-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-300 transition-colors text-center block">
                            Lanjut Memilih Buku
                        </a>
                    </div>

                    <!-- Info Box -->
                    <div class="mt-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                        <p class="text-xs text-blue-700 flex items-start space-x-2">
                            <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Atur detail peminjaman untuk setiap item sebelum checkout</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal untuk Edit Detail Item -->
    <div id="editItemModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4 overflow-y-auto">
        <div class="bg-white rounded-2xl max-w-2xl w-full shadow-2xl p-6 my-8">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-bold text-gray-900" id="editModalTitle">Edit Detail Peminjaman</h3>
                <button onclick="closeEditModal()" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div class="space-y-6 max-h-[calc(100vh-200px)] overflow-y-auto">
                <!-- Tipe Peminjaman -->
                <div>
                    <label class="block text-sm font-bold text-gray-900 mb-3">⏰ Tipe Peminjaman:</label>
                    <div class="grid grid-cols-2 gap-3">
                        <button onclick="setEditLoanType('hari')" id="editLoanTypeHari" class="px-4 py-3 border-2 border-pink-500 bg-pink-50 text-pink-700 rounded-xl font-semibold transition-all active">
                            📅 Per Hari
                        </button>
                        <button onclick="setEditLoanType('jam')" id="editLoanTypeJam" class="px-4 py-3 border-2 border-gray-200 text-gray-700 rounded-xl font-semibold hover:border-pink-500 transition-all">
                            ⏰ Per Jam
                        </button>
                    </div>
                </div>

                <!-- Form Per Hari -->
                <div id="editFormHari" class="">
                    <label class="block text-sm font-bold text-gray-900 mb-3">📅 Detail Peminjaman Per Hari:</label>
                    <p class="text-xs text-gray-500 mb-3">Maksimal 7 hari. Tanggal kembali tidak boleh lebih dari 7 hari setelah tanggal ambil.</p>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Ambil</label>
                            <input type="date" id="editPickupDateHari" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Kembali</label>
                            <input type="date" id="editReturnDateHari" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500">
                        </div>
                    </div>
                </div>

                <!-- Form Per Jam -->
                <div id="editFormJam" class="hidden">
                    <label class="block text-sm font-bold text-gray-900 mb-3">⏰ Detail Peminjaman Per Jam:</label>
                    <p class="text-xs text-gray-500 mb-3">Maksimal 8 jam. Jam kembali harus dalam 8 jam setelah jam ambil pada hari yang sama.</p>
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-4">
                        <p class="text-xs text-blue-700 flex items-start space-x-2">
                            <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Peminjaman per jam hanya berlaku di hari yang sama</span>
                        </p>
                    </div>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                            <input type="date" id="editPickupDateJam" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jam Ambil</label>
                            <input type="time" id="editJamPinjam" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jam Kembali</label>
                            <input type="time" id="editJamKembali" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500">
                        </div>
                    </div>
                </div>

                <!-- Alasan Peminjaman -->
                <div>
                    <label class="block text-sm font-bold text-gray-900 mb-2">📝 Alasan Peminjaman:</label>
                    <textarea id="editReason" placeholder="Tuliskan alasan Anda..." rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500"></textarea>
                    <p class="text-xs text-gray-500 mt-2">* Minimal 5 karakter, wajib diisi</p>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex gap-3 mt-8">
                <button onclick="closeEditModal()" class="flex-1 px-4 py-2.5 bg-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-300 transition-colors">
                    Batal
                </button>
                <button onclick="saveEditedItem()" class="flex-1 px-4 py-2.5 bg-gradient-to-r from-purple-600 to-pink-500 text-white rounded-lg font-semibold hover:shadow-lg transition-all">
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </div>

    <script>
        let currentEditingItemId = null;

        function formatDate(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        function setupEditModalValidation() {
            const pickupDateHari = document.getElementById('editPickupDateHari');
            const returnDateHari = document.getElementById('editReturnDateHari');
            const pickupDateJam = document.getElementById('editPickupDateJam');
            const jamPinjam = document.getElementById('editJamPinjam');
            const jamKembali = document.getElementById('editJamKembali');

            if (pickupDateHari && returnDateHari) {
                pickupDateHari.addEventListener('change', function() {
                    if (!this.value) return;
                    const pickup = new Date(this.value);
                    const maxReturn = new Date(pickup);
                    maxReturn.setDate(maxReturn.getDate() + 7);
                    const maxReturnStr = formatDate(maxReturn);
                    returnDateHari.max = maxReturnStr;

                    if (!returnDateHari.value || returnDateHari.value > maxReturnStr) {
                        returnDateHari.value = maxReturnStr;
                    }
                });

                returnDateHari.addEventListener('change', function() {
                    if (!pickupDateHari.value || !this.value) return;
                    const pickup = new Date(pickupDateHari.value);
                    const ret = new Date(this.value);

                    if (ret < pickup) {
                        alert('Tanggal kembali tidak boleh kurang dari tanggal ambil!');
                        this.value = pickupDateHari.value;
                        return;
                    }

                    const diffDays = Math.ceil((ret - pickup) / (1000 * 60 * 60 * 24));
                    if (diffDays > 7) {
                        alert('Maksimal peminjaman adalah 7 hari!');
                        const maxReturn = new Date(pickup);
                        maxReturn.setDate(maxReturn.getDate() + 7);
                        this.value = formatDate(maxReturn);
                    }
                });

                if (pickupDateHari.value) {
                    const pickup = new Date(pickupDateHari.value);
                    const maxReturn = new Date(pickup);
                    maxReturn.setDate(maxReturn.getDate() + 7);
                    const maxReturnStr = formatDate(maxReturn);
                    returnDateHari.max = maxReturnStr;
                    if (!returnDateHari.value || returnDateHari.value > maxReturnStr) {
                        returnDateHari.value = maxReturnStr;
                    }
                }
            }

            if (pickupDateJam && jamPinjam && jamKembali) {
                const updateJamKembaliLimits = function() {
                    if (!jamPinjam.value) return;
                    const start = jamPinjam.value.split(':');
                    const minHour = parseInt(start[0], 10);
                    const minMinutes = start[1];
                    let nextHour = minHour + 1;
                    if (nextHour > 23) nextHour = 23;
                    const minTime = `${String(nextHour).padStart(2, '0')}:${minMinutes}`;
                    const maxHour = Math.min(minHour + 8, 23);
                    const maxTime = `${String(maxHour).padStart(2, '0')}:${minMinutes}`;
                    jamKembali.min = minTime;
                    jamKembali.max = maxTime;

                    if (!jamKembali.value || jamKembali.value < minTime) {
                        jamKembali.value = minTime;
                    }
                    if (jamKembali.value > maxTime) {
                        jamKembali.value = maxTime;
                    }
                };

                jamPinjam.addEventListener('change', function() {
                    updateJamKembaliLimits();
                });

                jamKembali.addEventListener('change', function() {
                    if (!jamPinjam.value || !this.value) return;

                    if (this.value <= jamPinjam.value) {
                        alert('Jam kembali harus lebih dari jam ambil!');
                        this.value = jamPinjam.value;
                        return;
                    }

                    const start = jamPinjam.value.split(':');
                    const end = this.value.split(':');
                    const startDate = new Date(0, 0, 0, parseInt(start[0], 10), parseInt(start[1], 10), 0);
                    const endDate = new Date(0, 0, 0, parseInt(end[0], 10), parseInt(end[1], 10), 0);
                    const diffHours = (endDate - startDate) / 1000 / 60 / 60;

                    if (diffHours > 8) {
                        alert('Maksimal peminjaman adalah 8 jam!');
                        const maxHour = Math.min(parseInt(start[0], 10) + 8, 23);
                        this.value = `${String(maxHour).padStart(2, '0')}:${start[1]}`;
                    }
                });

                if (jamPinjam.value) {
                    const start = jamPinjam.value.split(':');
                    const minHour = parseInt(start[0], 10);
                    const minMinutes = start[1];
                    let nextHour = minHour + 1;
                    if (nextHour > 23) nextHour = 23;
                    const minTime = `${String(nextHour).padStart(2, '0')}:${minMinutes}`;
                    const maxHour = Math.min(minHour + 8, 23);
                    const maxTime = `${String(maxHour).padStart(2, '0')}:${minMinutes}`;
                    jamKembali.min = minTime;
                    jamKembali.max = maxTime;
                    if (!jamKembali.value || jamKembali.value < minTime) {
                        jamKembali.value = minTime;
                    }
                    if (jamKembali.value > maxTime) {
                        jamKembali.value = maxTime;
                    }
                }
            }
        }

        // Load items saat page load
        document.addEventListener('DOMContentLoaded', function() {
            loadCartItems();
            setupEditModalValidation();
        });

        // Load all cart items
        function loadCartItems() {
            const items = cart.getItems();
            const container = document.getElementById('cartItemsContainer');
            const clearBtn = document.getElementById('clearCartBtn');
            const checkoutBtn = document.getElementById('checkoutBtn');
            const statusElement = document.getElementById('cartStatus');

            // Update summary
            document.getElementById('summaryItems').textContent = items.length;
            document.getElementById('summaryUnits').textContent = cart.getTotalItems() + ' unit';

            if (items.length === 0) {
                container.innerHTML = `
                    <div class="bg-white rounded-2xl p-12 text-center border border-gray-100 shadow-sm">
                        <svg class="w-24 h-24 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Keranjang Kosong</h3>
                        <p class="text-gray-600 mb-6">Mulai dengan menambahkan barang ke keranjang</p>
                        <a href="{{ route('peminjam.beranda') }}" class="inline-block px-6 py-2 bg-pink-500 text-white rounded-lg font-semibold hover:bg-pink-600 transition-colors">
                            Belanja Sekarang
                        </a>
                    </div>
                `;
                clearBtn.classList.add('hidden');
                checkoutBtn.classList.add('hidden');
                statusElement.textContent = 'Kosong';
            } else {
                container.innerHTML = items.map(item => `
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all overflow-hidden" data-item-id="${item.barangId}">
                        <div class="p-6">
                            <div class="flex gap-4">
                                <!-- Gambar -->
                                <div class="flex-shrink-0">
                                    <img src="${item.gambar}" alt="${item.barangNama}" class="w-24 h-24 object-cover rounded-lg">
                                </div>

                                <!-- Info -->
                                <div class="flex-1">
                                    <div class="flex items-start justify-between mb-3">
                                        <div>
                                            <h3 class="text-lg font-bold text-gray-900">${item.barangNama}</h3>
                                            <p class="text-sm text-gray-500">${item.kategoriNama}</p>
                                        </div>
                                        <button onclick="removeItemFromCart(${item.barangId})" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>

                                    <!-- Quantity Controls -->
                                    <div class="flex items-center space-x-3 mb-4">
                                        <span class="text-sm text-gray-600">Jumlah:</span>
                                        <button onclick="decreaseQty(${item.barangId})" class="w-8 h-8 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors flex items-center justify-center font-bold">−</button>
                                        <input type="number" value="${item.jumlah}" readonly class="w-12 text-center border border-gray-300 rounded-lg font-semibold" disabled>
                                        <button onclick="increaseQty(${item.barangId})" class="w-8 h-8 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors flex items-center justify-center font-bold">+</button>
                                    </div>

                                    <!-- Status Badges -->
                                    <div class="flex items-center space-x-2 flex-wrap">
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full ${item.tipe_pinjam === 'hari' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700'}">
                                            ${item.tipe_pinjam === 'hari' ? '📅 Per Hari' : '⏰ Per Jam'}
                                        </span>
                                        ${item.alasan ? `<span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">✓ Alasan Ada</span>` : `<span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700">⚠ Alasan Diperlukan</span>`}
                                    </div>
                                </div>
                            </div>

                            <!-- Edit Button -->
                            <button onclick="openEditModal(${item.barangId})" class="mt-4 w-full px-4 py-2.5 bg-emerald-50 text-emerald-600 rounded-lg font-semibold hover:bg-emerald-100 transition-colors border border-emerald-200 flex items-center justify-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                <span>Atur Detail Peminjaman</span>
                            </button>
                        </div>
                    </div>
                `).join('');

                clearBtn.classList.remove('hidden');
                checkoutBtn.classList.remove('hidden');
                checkoutBtn.innerHTML = `Checkout (${items.length})`;
                statusElement.innerHTML = `<span class="text-emerald-600">${items.length} item siap</span>`;
            }
        }

        // Remove item
        function removeItemFromCart(barangId) {
            if (confirm('Hapus barang ini dari keranjang?')) {
                cart.removeItem(barangId);
                loadCartItems();
            }
        }

        // Increase quantity
        function increaseQty(barangId) {
            const item = cart.getItems().find(i => i.barangId === barangId);
            if (item) {
                cart.updateQuantity(barangId, item.jumlah + 1);
                loadCartItems();
            }
        }

        // Decrease quantity
        function decreaseQty(barangId) {
            const item = cart.getItems().find(i => i.barangId === barangId);
            if (item && item.jumlah > 1) {
                cart.updateQuantity(barangId, item.jumlah - 1);
                loadCartItems();
            }
        }

        // Open edit modal
        function openEditModal(barangId) {
            const item = cart.getItems().find(i => i.barangId === barangId);
            if (!item) return;

            currentEditingItemId = barangId;
            document.getElementById('editModalTitle').textContent = `Edit Detail - ${item.barangNama}`;
            
            // Set loan type  
            if (item.tipe_pinjam === 'hari') {
                setEditLoanType('hari');
                document.getElementById('editPickupDateHari').value = item.tanggal_pinjam;
                document.getElementById('editReturnDateHari').value = item.tanggal_kembali;
            } else {
                setEditLoanType('jam');
                document.getElementById('editPickupDateJam').value = item.tanggal_pinjam_jam;
                document.getElementById('editJamPinjam').value = item.jam_pinjam;
                document.getElementById('editJamKembali').value = item.jam_kembali;
            }

            document.getElementById('editReason').value = item.alasan;

            document.getElementById('editItemModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        // Close edit modal
        function closeEditModal() {
            document.getElementById('editItemModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
            currentEditingItemId = null;
        }

        // Set loan type in edit modal
        function setEditLoanType(type) {
            const hariBtn = document.getElementById('editLoanTypeHari');
            const jamBtn = document.getElementById('editLoanTypeJam');
            const formHari = document.getElementById('editFormHari');
            const formJam = document.getElementById('editFormJam');

            if (type === 'hari') {
                hariBtn.classList.add('border-emerald-500', 'bg-emerald-50', 'text-emerald-700');
                hariBtn.classList.remove('border-gray-200', 'text-gray-700');
                jamBtn.classList.add('border-gray-200', 'text-gray-700');
                jamBtn.classList.remove('border-emerald-500', 'bg-emerald-50', 'text-emerald-700');
                formHari.classList.remove('hidden');
                formJam.classList.add('hidden');
            } else {
                jamBtn.classList.add('border-emerald-500', 'bg-emerald-50', 'text-emerald-700');
                jamBtn.classList.remove('border-gray-200', 'text-gray-700');
                hariBtn.classList.add('border-gray-200', 'text-gray-700');
                hariBtn.classList.remove('border-emerald-500', 'bg-emerald-50', 'text-emerald-700');
                formJam.classList.remove('hidden');
                formHari.classList.add('hidden');
            }
        }

        // Save edited item
        function saveEditedItem() {
            if (!currentEditingItemId) return;

            const item = cart.getItems().find(i => i.barangId === currentEditingItemId);
            if (!item) return;

            try {
                // Validate reason
                const reason = document.getElementById('editReason').value.trim();
                if (!reason || reason.length < 5) {
                    alert('Alasan peminjaman minimal 5 karakter!');
                    return;
                }

                // Save based on loan type
                const hariBtn = document.getElementById('editLoanTypeHari');
                if (hariBtn.classList.contains('border-emerald-500')) {
                    // Daily loan
                    const pickupDate = document.getElementById('editPickupDateHari').value;
                    const returnDate = document.getElementById('editReturnDateHari').value;

                    if (!pickupDate || !returnDate) {
                        alert('Harap isi semua tanggal!');
                        return;
                    }

                    if (returnDate < pickupDate) {
                        alert('Tanggal kembali tidak boleh kurang dari tanggal ambil!');
                        return;
                    }

                    const pickup = new Date(pickupDate);
                    const ret = new Date(returnDate);
                    const diffDays = Math.floor((ret - pickup) / (1000 * 60 * 60 * 24)) + 1;

                    if (diffDays > 7) {
                        alert('Maksimal peminjaman per hari adalah 7 hari. Silakan pilih tanggal kembali yang lebih dekat.');
                        return;
                    }

                    cart.updateLoanType(currentEditingItemId, 'hari');
                    cart.updateDates(currentEditingItemId, pickupDate, returnDate);
                } else {
                    // Hourly loan
                    const pickupDate = document.getElementById('editPickupDateJam').value;
                    const jamPinjam = document.getElementById('editJamPinjam').value;
                    const jamKembali = document.getElementById('editJamKembali').value;

                    if (!pickupDate || !jamPinjam || !jamKembali) {
                        alert('Harap isi semua jam!');
                        return;
                    }

                    if (jamKembali <= jamPinjam) {
                        alert('Jam kembali harus lebih dari jam ambil!');
                        return;
                    }

                    const startDateTime = new Date(`${pickupDate}T${jamPinjam}`);
                    const endDateTime = new Date(`${pickupDate}T${jamKembali}`);
                    const diffHours = (endDateTime - startDateTime) / (1000 * 60 * 60);

                    if (diffHours > 8) {
                        alert('Maksimal peminjaman per jam adalah 8 jam. Silakan pilih jam kembali dalam 8 jam setelah jam ambil.');
                        return;
                    }

                    cart.updateLoanType(currentEditingItemId, 'jam');
                    cart.updateTimes(currentEditingItemId, pickupDate, jamPinjam, jamKembali);
                }

                cart.updateReason(currentEditingItemId, reason);

                showNotification('success', 'Detail berhasil diupdate!');
                closeEditModal();
                loadCartItems();
            } catch (error) {
                showNotification('error', error.message);
            }
        }

        // Checkout all items
        function checkoutAllItems() {
            const items = cart.getItems();

            if (items.length === 0) {
                alert('Keranjang kosong!');
                return;
            }

            // Validate all items
            const itemsWithoutReason = items.filter(item => !item.alasan || item.alasan.trim().length < 5);
            if (itemsWithoutReason.length > 0) {
                alert(`${itemsWithoutReason.length} item belum memiliki alasan peminjaman!`);
                return;
            }

            if (confirm(`Checkout ${items.length} item? Tindakan ini tidak bisa dibatalkan.`)) {
                const checkoutBtn = document.getElementById('checkoutBtn');
                const originalHTML = checkoutBtn.innerHTML;
                checkoutBtn.innerHTML = '<svg class="animate-spin inline-block w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Memproses...';
                checkoutBtn.disabled = true;

                let successCount = 0;
                let totalItems = items.length;

                items.forEach((item, index) => {
                    submitLoanRequest(item).then(() => {
                        successCount++;
                        if (successCount === totalItems) {
                            checkoutBtn.innerHTML = originalHTML;
                            checkoutBtn.disabled = false;

                            showNotification('success', `${successCount} item berhasil dipinjam!`);
                            cart.clearCart();
                            loadCartItems();

                            setTimeout(() => {
                                window.location.href = '{{ route("peminjam.aktivitasSaya") }}';
                            }, 2000);
                        }
                    }).catch(error => {
                        successCount++;
                        if (successCount === totalItems) {
                            checkoutBtn.innerHTML = originalHTML;
                            checkoutBtn.disabled = false;
                            showNotification('error', 'Ada item yang gagal dipinjam');
                            loadCartItems();
                        }
                    });
                });
            }
        }

        // Submit loan request
        function submitLoanRequest(item) {
            return new Promise((resolve, reject) => {
                let formData = new FormData();
                formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                formData.append('barang_id', item.barangId);
                formData.append('tipe_pinjam', item.tipe_pinjam);
                formData.append('jumlah', item.jumlah);
                formData.append('alasan', item.alasan);

                if (item.tipe_pinjam === 'hari') {
                    formData.append('tanggal_pinjam', item.tanggal_pinjam);
                    formData.append('tanggal_kembali', item.tanggal_kembali);
                } else {
                    formData.append('tanggal_pinjam_jam', item.tanggal_pinjam_jam);
                    formData.append('jam_pinjam', item.jam_pinjam);
                    formData.append('jam_kembali', item.jam_kembali);
                }

                fetch('{{ route("peminjam.peminjaman.store") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        resolve(data);
                    } else {
                        reject(new Error(data.message));
                    }
                })
                .catch(error => reject(error));
            });
        }

        // Show notification
        function showNotification(type, message) {
            const existingNotif = document.querySelector('[data-notification]');
            if (existingNotif) {
                existingNotif.remove();
            }

            const notification = document.createElement('div');
            notification.setAttribute('data-notification', 'true');
            notification.className = `fixed top-20 right-4 max-w-md px-6 py-4 rounded-xl shadow-2xl transform transition-all duration-300 ${
                type === 'success' 
                    ? 'bg-gradient-to-r from-green-500 to-emerald-500 text-white' 
                    : 'bg-gradient-to-r from-red-500 to-pink-500 text-white'
            } z-50 flex items-center space-x-3`;

            notification.innerHTML = `
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
            `;

            document.body.appendChild(notification);

            setTimeout(() => {
                notification.style.opacity = '0';
                notification.style.transform = 'translateX(100%)';
                setTimeout(() => notification.remove(), 300);
            }, 5000);
        }

        // Close modal when clicking outside
        document.getElementById('editItemModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEditModal();
            }
        });
    </script>
</body>
</html>
