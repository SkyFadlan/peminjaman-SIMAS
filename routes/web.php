<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Admin\PeminjamanAdminController;
use App\Http\Controllers\Peminjam\BerandaPeminjamController;
use App\Http\Controllers\Peminjam\AktivitasPeminjamController;
use App\Http\Controllers\Petugas\DashboardPetugasController;
use App\Http\Controllers\Admin\BarangAdminController;
use App\Http\Controllers\Admin\KategoriAdminController;
use App\Http\Controllers\Admin\PenggunaAdminController;
use App\Http\Controllers\Admin\RiwayatAdminController;
use App\Http\Controllers\Admin\PengaturanAdminController;
use App\Http\Controllers\Petugas\PengembalianPetugasController;
use App\Http\Controllers\Petugas\PermintaanPetugasController;
use App\Http\Controllers\Petugas\LaporanPetugasController;
use App\Http\Controllers\Auth\RegisteredUserController;

Route::get('/', function () {
    return view('welcome');
});

// === OPTION 1: Redirect dashboard berdasarkan role ===
Route::get('/dashboard', function () {
    $user = auth()->user();
    
    return match($user->role) {
        'admin' => redirect()->route('admin.dashboard'),
        'petugas'  => redirect()->route('petugas.dashboard'),
        'siswa' => redirect()->route('peminjam.beranda'),
        default => view('dashboard'),
    };
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile routes (bisa diakses semua role)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
});

// =============== ADMIN ROUTES ===============
Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardAdminController::class, 'index'])->name('dashboard');
    
    // ===== BARANG =====
    Route::get('/barang', [BarangAdminController::class, 'index'])->name('barang.index'); // ← PASTIKAN INI ADA
    Route::get('/barang/create', [BarangAdminController::class, 'create'])->name('barang.create');
    Route::post('/barang', [BarangAdminController::class, 'store'])->name('barang.store');
    Route::get('/barang/{id}/edit', [BarangAdminController::class, 'edit'])->name('barang.edit');
    Route::put('/barang/{id}', [BarangAdminController::class, 'update'])->name('barang.update');
    Route::delete('/barang/{id}', [BarangAdminController::class, 'destroy'])->name('barang.destroy');
    
    // ===== KATEGORI =====
    Route::get('/kategori', [KategoriAdminController::class, 'index'])->name('kategori.index');
    Route::post('/kategori', [KategoriAdminController::class, 'store'])->name('kategori.store');
    Route::post('/kategori/{id}', [KategoriAdminController::class, 'update'])->name('kategori.update');
    Route::delete('/kategori/{id}', [KategoriAdminController::class, 'destroy'])->name('kategori.destroy');

        // PENGEMBALIAN
    Route::get('/pengembalian', [PengembalianPetugasController::class, 'index'])->name('pengembalian.index');
    Route::get('/pengembalian/{id}', [PengembalianPetugasController::class, 'show'])->name('pengembalian.show');
    Route::post('/pengembalian/{id}/return', [PengembalianPetugasController::class, 'return'])->name('pengembalian.return');
    Route::post('/pengembalian/scan', [PengembalianPetugasController::class, 'scan'])->name('pengembalian.scan');
    Route::post('/pengembalian/{id}/reminder', [PengembalianPetugasController::class, 'sendReminder'])->name('pengembalian.reminder');

        // PERMINTAAN PEMINJAMAN
    Route::get('/permintaan', [PermintaanPetugasController::class, 'index'])->name('permintaan.index');
    Route::get('/permintaan/{id}', [PermintaanPetugasController::class, 'show'])->name('permintaan.show');
    Route::post('/permintaan/{id}/approve', [PermintaanPetugasController::class, 'approve'])->name('permintaan.approve');
    Route::post('/permintaan/approve-selected', [PermintaanPetugasController::class, 'approveSelected'])->name('permintaan.approve-selected');
    Route::post('/permintaan/{id}/reject', [PermintaanPetugasController::class, 'reject'])->name('permintaan.reject');
    Route::post('/permintaan/reject-selected', [PermintaanPetugasController::class, 'rejectSelected'])->name('permintaan.reject-selected');

    // ===== PEMINJAMAN =====
    Route::get('/peminjaman', [PeminjamanAdminController::class, 'index'])->name('peminjaman.index');
    Route::post('/peminjaman', [PeminjamanAdminController::class, 'store'])->name('peminjaman.store');
    
// ===== PENGGUNA =====
Route::get('/pengguna', [PenggunaAdminController::class, 'index'])->name('pengguna.index');
Route::get('/pengguna/{id}/edit', [PenggunaAdminController::class, 'edit'])->name('pengguna.edit'); // <-- TAMBAHKAN INI
Route::post('/pengguna', [PenggunaAdminController::class, 'store'])->name('pengguna.store');
Route::put('/pengguna/{id}', [PenggunaAdminController::class, 'update'])->name('pengguna.update');
Route::delete('/pengguna/{id}', [PenggunaAdminController::class, 'destroy'])->name('pengguna.destroy');
// ===== EXPORT PENGGUNA =====
Route::get('/pengguna/export-pdf', [PenggunaAdminController::class, 'exportPdf'])->name('pengguna.export.pdf');
Route::get('/pengguna/export-excel', [PenggunaAdminController::class, 'exportExcel'])->name('pengguna.export.excel');
Route::get('/pengguna/export-petugas-pdf', [PenggunaAdminController::class, 'exportPetugasPdf'])->name('pengguna.export.petugas.pdf');
Route::get('/pengguna/export-siswa-pdf', [PenggunaAdminController::class, 'exportSiswaPdf'])->name('pengguna.export.siswa.pdf');
// Routes untuk import
Route::get('/pengguna/import', [PenggunaAdminController::class, 'showImportForm'])->name('pengguna.import.form');
Route::post('/pengguna/import', [PenggunaAdminController::class, 'import'])->name('pengguna.import');
Route::get('/pengguna/template/download', [PenggunaAdminController::class, 'downloadTemplate'])->name('pengguna.template.download');

    // ===== RIWAYAT =====
    Route::get('/riwayat', [RiwayatAdminController::class, 'index'])->name('riwayat.index');
    Route::get('/riwayat/{id}', [RiwayatAdminController::class, 'show'])->name('riwayat.show');
    Route::get('/riwayat/export', [RiwayatAdminController::class, 'export'])->name('riwayat.export');
    
    // ===== PENGATURAN =====
    Route::get('/pengaturan', [PengaturanAdminController::class, 'index'])->name('pengaturan.index');
    
});

// =============== PETUGAS ROUTES ===============
Route::prefix('petugas')->middleware(['auth', 'role:petugas,admin'])->name('petugas.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardPetugasController::class, 'index'])->name('dashboard');

    
    // Laporan
    Route::get('/laporan', [LaporanPetugasController::class, 'index'])->name('laporan.index');
    Route::get('/laporan', [LaporanPetugasController::class, 'index'])->name('laporan.index');
    Route::post('/laporan/generate', [LaporanPetugasController::class, 'generate'])->name('laporan.generate');
});

// =============== PEMINJAM/SISWA ROUTES ===============
Route::prefix('peminjam')->middleware(['auth', 'role:siswa'])->group(function () {
    
    // Halaman Beranda
    Route::get('/beranda', [BerandaPeminjamController::class, 'index'])->name('peminjam.beranda');
    
    // Halaman Keranjang
    Route::get('/keranjang', function() {
        return view('peminjam.keranjang.index');
    })->name('peminjam.keranjang');
    
    // API untuk ambil detail barang (AJAX)
    Route::get('/barang/{id}', [BerandaPeminjamController::class, 'show'])->name('peminjam.barang.show');
    
    // 🔥 STORE PEMINJAMAN - YANG INI DIPANGGIL DI JAVASCRIPT
    Route::post('/peminjaman', [BerandaPeminjamController::class, 'store'])->name('peminjam.peminjaman.store');
    // ← PERBAIKAN: nama route jadi 'peminjam.peminjaman.store' (konsisten dengan prefix)
    
    // Halaman Aktivitas Saya
    Route::get('/aktivitasSaya', [AktivitasPeminjamController::class, 'index'])->name('peminjam.aktivitasSaya');
    Route::get('/aktivitasSaya/{id}', [AktivitasPeminjamController::class, 'show'])->name('peminjam.aktivitasSaya.show');
    // 🔥 TAMBAHKAN ROUTE INI - untuk detail AJAX
    Route::get('/aktivitas-saya/{id}', [AktivitasPeminjamController::class, 'show'])->name('aktivitasSaya.show');

    // Notifikasi peminjam
    Route::get('/notifications', [\App\Http\Controllers\Peminjam\NotificationController::class, 'index'])
        ->name('peminjam.notifications.index');
    Route::post('/notifications/read-all', [\App\Http\Controllers\Peminjam\NotificationController::class, 'markAllAsRead'])
        ->name('peminjam.notifications.readAll');
    Route::post('/notifications/{id}/read', [\App\Http\Controllers\Peminjam\NotificationController::class, 'markAsRead'])
        ->name('peminjam.notifications.read');

    // Tambahkan route peminjam lainnya di sini
});

// Route untuk registrasi siswa
Route::get('/register/siswa', [RegisteredUserController::class, 'createSiswa'])->name('register.siswa');
Route::post('/register/siswa', [RegisteredUserController::class, 'storeSiswa']);

require __DIR__.'/auth.php';