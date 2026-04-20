// 🛒 CART MANAGEMENT SYSTEM - localStorage based
class ShoppingCart {
    constructor() {
        this.storageKey = "sarpras_cart";
        this.cart = this.loadCart();
        this.initializeBadge();
    }

    loadCart() {
        try {
            const saved = localStorage.getItem(this.storageKey);
            return saved ? JSON.parse(saved) : [];
        } catch (error) {
            console.error("Error loading cart:", error);
            return [];
        }
    }

    saveCart() {
        try {
            localStorage.setItem(this.storageKey, JSON.stringify(this.cart));
            this.updateBadge();
        } catch (error) {
            console.error("Error saving cart:", error);
        }
    }

    addItem(
        barangId,
        barangNama,
        gambar,
        kategoriId,
        kategoriNama,
        jumlah = 1,
        stokTersedia = 0,
    ) {
        const existingItem = this.cart.find(
            (item) => item.barangId === barangId,
        );

        if (existingItem) {
            if (existingItem.jumlah + jumlah <= stokTersedia) {
                existingItem.jumlah += jumlah;
            } else {
                throw new Error(
                    `Maksimal ${stokTersedia} unit yang dapat ditambahkan! Sudah ada ${existingItem.jumlah} unit di keranjang.`,
                );
            }
        } else {
            if (jumlah > stokTersedia) {
                throw new Error(
                    `Maksimal ${stokTersedia} unit yang dapat ditambahkan!`,
                );
            }
            this.cart.push({
                barangId,
                barangNama,
                gambar,
                kategoriId,
                kategoriNama,
                jumlah,
                tipe_pinjam: "hari",
                tanggal_pinjam: this.getTodayDate(),
                tanggal_kembali: this.getTomorrowDate(),
                tanggal_pinjam_jam: this.getTodayDate(),
                jam_pinjam: this.getCurrentTime(),
                jam_kembali: this.getOneHourLater(),
                alasan: "",
            });
        }
        this.saveCart();
    }

    removeItem(barangId) {
        this.cart = this.cart.filter((item) => item.barangId !== barangId);
        this.saveCart();
    }

    updateQuantity(barangId, jumlah) {
        const item = this.cart.find((item) => item.barangId === barangId);
        if (item) {
            item.jumlah = Math.max(1, jumlah);
            this.saveCart();
        }
    }

    updateLoanType(barangId, tipe_pinjam) {
        const item = this.cart.find((item) => item.barangId === barangId);
        if (item) {
            item.tipe_pinjam = tipe_pinjam;
            this.saveCart();
        }
    }

    updateReason(barangId, alasan) {
        const item = this.cart.find((item) => item.barangId === barangId);
        if (item) {
            item.alasan = alasan;
            this.saveCart();
        }
    }

    updateDates(barangId, tanggal_pinjam, tanggal_kembali) {
        const item = this.cart.find((item) => item.barangId === barangId);
        if (item) {
            item.tanggal_pinjam = tanggal_pinjam;
            item.tanggal_kembali = tanggal_kembali;
            this.saveCart();
        }
    }

    updateTimes(barangId, tanggal_pinjam_jam, jam_pinjam, jam_kembali) {
        const item = this.cart.find((item) => item.barangId === barangId);
        if (item) {
            item.tanggal_pinjam_jam = tanggal_pinjam_jam;
            item.jam_pinjam = jam_pinjam;
            item.jam_kembali = jam_kembali;
            this.saveCart();
        }
    }

    getTotalItems() {
        return this.cart.reduce((sum, item) => sum + item.jumlah, 0);
    }

    getTotalCount() {
        return this.cart.length;
    }

    getItems() {
        return this.cart;
    }

    clearCart() {
        this.cart = [];
        this.saveCart();
    }

    initializeBadge() {
        this.updateBadge();
        setInterval(() => {
            this.cart = this.loadCart();
            this.updateBadge();
        }, 500);
    }

    updateBadge() {
        const badge = document.getElementById("cartBadge");
        if (!badge) return;
        const total = this.getTotalItems();
        if (total > 0) {
            badge.textContent = total;
            badge.classList.remove("hidden");
        } else {
            badge.classList.add("hidden");
        }
    }

    getTodayDate() {
        const d = new Date();
        const year = d.getFullYear();
        const month = String(d.getMonth() + 1).padStart(2, "0");
        const day = String(d.getDate()).padStart(2, "0");
        return `${year}-${month}-${day}`;
    }

    getTomorrowDate() {
        const tomorrow = new Date();
        tomorrow.setDate(tomorrow.getDate() + 1);
        const year = tomorrow.getFullYear();
        const month = String(tomorrow.getMonth() + 1).padStart(2, "0");
        const day = String(tomorrow.getDate()).padStart(2, "0");
        return `${year}-${month}-${day}`;
    }

    getCurrentTime() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, "0");
        const minutes = String(now.getMinutes()).padStart(2, "0");
        return `${hours}:${minutes}`;
    }

    getOneHourLater() {
        const now = new Date();
        now.setHours(now.getHours() + 1);
        const hours = String(now.getHours()).padStart(2, "0");
        const minutes = String(now.getMinutes()).padStart(2, "0");
        return `${hours}:${minutes}`;
    }
}

window.cart = new ShoppingCart();

function addToCartFromModal(
    barangId,
    barangNama,
    gambar,
    kategoriId,
    kategoriNama,
    stokTersedia,
) {
    const jumlahInput = document.getElementById("jumlahPinjam");
    const jumlah = jumlahInput ? parseInt(jumlahInput.value) || 1 : 1;

    try {
        cart.addItem(
            barangId,
            barangNama,
            gambar,
            kategoriId,
            kategoriNama,
            jumlah,
            stokTersedia,
        );
        showNotification(
            "success",
            `✅ ${barangNama} ditambahkan ke keranjang! (${jumlah} unit)`,
        );
        setTimeout(() => {
            closeModal();
        }, 1500);
    } catch (error) {
        showNotification("error", error.message);
    }
}

function showNotification(type, message) {
    const existingNotif = document.querySelector("[data-notif]");
    if (existingNotif) {
        existingNotif.remove();
    }

    const notification = document.createElement("div");
    notification.setAttribute("data-notif", "true");
    notification.className = `fixed top-20 right-4 max-w-md px-6 py-4 rounded-xl shadow-2xl transform transition-all duration-300 z-50 flex items-start space-x-3 ${
        type === "success"
            ? "bg-gradient-to-r from-green-500 to-emerald-500 text-white"
            : "bg-gradient-to-r from-red-500 to-pink-500 text-white"
    }`;

    const iconSVG =
        type === "success"
            ? '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'
            : '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';

    const title = type === "success" ? "Berhasil!" : "Error!";

    notification.innerHTML = `
        <div class="flex-shrink-0 mt-0.5">
            ${iconSVG}
        </div>
        <div class="flex-1">
            <p class="font-semibold">${title}</p>
            <p class="text-sm opacity-90">${message}</p>
        </div>
        <button onclick="this.parentElement.remove()" class="flex-shrink-0 hover:opacity-75">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    `;

    document.body.appendChild(notification);

    setTimeout(() => {
        notification.style.opacity = "0";
        notification.style.transform = "translateX(100%)";
        setTimeout(() => notification.remove(), 300);
    }, 5000);
}

window.addToCartFromModal = addToCartFromModal;
window.showNotification = showNotification;

document.addEventListener("DOMContentLoaded", function () {
    cart.updateBadge();
});
