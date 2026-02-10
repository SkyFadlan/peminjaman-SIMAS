<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardAdminController;
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
});

// Admin routes
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [DashboardAdminController::class, 'index'])->name('admin.dashboard');

    Route::get('/barang', [BarangAdminController::class, 'index'])->name('admin.barang');

    Route::get('/kategori', [KategoriAdminController::class, 'index'])->name('admin.kategori');
    Route::resource('/kategori', KategoriAdminController::class)->except(['show','edit','update']);
    Route::post('/kategori', [KategoriAdminController::class,'store'])->name('admin.kategori.store');


    Route::get('/pengguna', [PenggunaAdminController::class, 'index'])->name('admin.pengguna');
    Route::resource('/pengguna', PenggunaAdminController::class)->except(['show','edit','update']);
    Route::post('/pengguna', [PenggunaAdminController::class,'store'])->name('admin.pengguna.store');

    Route::get('/riwayat', [RiwayatAdminController::class, 'index'])->name('admin.riwayat');
    
    Route::get('/pengaturan', [PengaturanAdminController::class, 'index'])->name('admin.pengaturan');
});

// Petugas/Guru routes
Route::prefix('petugas')->middleware(['auth', 'role:petugas'])->group(function () {
    Route::get('/dashboard', [DashboardPetugasController::class, 'index'])->name('petugas.dashboard');
    // Tambahkan route petugas lainnya di sini
});

// Peminjam/Siswa routes
Route::prefix('peminjam')->middleware(['auth', 'role:siswa'])->group(function () {
    Route::get('/beranda', [BerandaPeminjamController::class, 'index'])->name('peminjam.beranda');
    Route::get('/aktivitas-saya', [AktivitasPeminjamController::class, 'index'])->name('peminjam.aktivitasSaya');
    // Tambahkan route peminjam lainnya di sini
});

require __DIR__.'/auth.php';