<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Barang;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardPetugasController extends Controller
{
    public function index()
    {
        // ================ STATISTIK CARD ================
        // 1. Permintaan Pending
        $pendingCount = Peminjaman::where('status', 'menunggu')->count();
        
        // 2. Sedang Dipinjam (status 'disetujui' dan 'dipinjam') ✅ SUDAH BENAR
        $sedangDipinjam = Peminjaman::whereIn('status', ['disetujui', 'dipinjam'])->count();
        
        // 3. ✅ Jatuh Tempo Hari Ini - PERBAIKAN: Tambah status 'disetujui'
        $jatuhTempoHariIni = Peminjaman::whereIn('status', ['disetujui', 'dipinjam'])
            ->where(function($query) {
                $query->where(function($q) {
                    $q->where('tipe_pinjam', 'hari')
                      ->whereDate('tanggal_kembali', Carbon::today());
                })->orWhere(function($q) {
                    $q->where('tipe_pinjam', 'jam')
                      ->whereDate('tanggal_pinjam_jam', Carbon::today())
                      ->whereTime('jam_kembali', '>=', Carbon::now()->format('H:i:s'));
                });
            })
            ->count();
        
        // 4. ✅ TERLAMBAT - PERBAIKAN: Tambah status 'disetujui'
        $terlambat = Peminjaman::whereIn('status', ['disetujui', 'dipinjam'])  // ✅ PERBAIKAN
            ->where(function($query) {
                $query->where(function($q) {
                    $q->where('tipe_pinjam', 'hari')
                      ->where('tanggal_kembali', '<', Carbon::today());
                })->orWhere(function($q) {
                    $q->where('tipe_pinjam', 'jam')
                      ->whereDate('tanggal_pinjam_jam', '<', Carbon::today())
                      ->orWhere(function($q2) {
                          $q2->whereDate('tanggal_pinjam_jam', Carbon::today())
                             ->whereTime('jam_kembali', '<', Carbon::now()->format('H:i:s'));
                      });
                });
            })
            ->count();

        // ================ PERMINTAAN TERBARU ================
        $permintaanTerbaru = Peminjaman::with(['user', 'barang', 'barang.kategori'])
            ->where('status', 'menunggu')
            ->latest()
            ->take(5)
            ->get();

        // ================ ✅ PENGEMBALIAN HARI INI - PERBAIKAN ================
        $pengembalianHariIni = Peminjaman::with(['user', 'barang'])
            ->whereIn('status', ['disetujui', 'dipinjam'])  // ✅ PERBAIKAN: tambah disetujui
            ->where(function($query) {
                $query->where(function($q) {
                    $q->where('tipe_pinjam', 'hari')
                      ->whereDate('tanggal_kembali', Carbon::today());
                })->orWhere(function($q) {
                    $q->where('tipe_pinjam', 'jam')
                      ->whereDate('tanggal_pinjam_jam', Carbon::today());
                });
            })
            ->take(3)
            ->get();

        // ================ ✅ ITEM TERLAMBAT - PERBAIKAN ================
        $itemTerlambat = Peminjaman::with(['user', 'barang'])
            ->whereIn('status', ['disetujui', 'dipinjam'])  // ✅ PERBAIKAN: tambah disetujui
            ->where(function($query) {
                $query->where(function($q) {
                    $q->where('tipe_pinjam', 'hari')
                      ->where('tanggal_kembali', '<', Carbon::today());
                })->orWhere(function($q) {
                    $q->where('tipe_pinjam', 'jam')
                      ->whereDate('tanggal_pinjam_jam', '<', Carbon::today())
                      ->orWhere(function($q2) {
                          $q2->whereDate('tanggal_pinjam_jam', Carbon::today())
                             ->whereTime('jam_kembali', '<', Carbon::now()->format('H:i:s'));
                      });
                });
            })
            ->take(5)
            ->get();

        // ================ STATISTIK HARI INI ================
        $statistikHariIni = [
            'disetujui' => Peminjaman::where('status', 'disetujui')
                ->whereDate('tanggal_disetujui', Carbon::today())
                ->count(),
            'ditolak' => Peminjaman::where('status', 'ditolak')
                ->whereDate('updated_at', Carbon::today())
                ->count(),
            'dikembalikan' => Peminjaman::where('status', 'dikembalikan')
                ->whereDate('updated_at', Carbon::today())
                ->count(),
        ];

        // ================ AKTIVITAS SAYA ================
        $aktivitasSaya = Peminjaman::with(['user', 'barang'])
            ->whereIn('status', ['disetujui', 'ditolak', 'dikembalikan'])
            ->where(function($query) {
                $query->whereDate('tanggal_disetujui', Carbon::today())
                      ->orWhereDate('updated_at', Carbon::today());
            })
            ->latest()
            ->take(5)
            ->get();

        // ================ HITUNG PERSENTASE ================
        $totalPending = $pendingCount;
        $totalAktif = $sedangDipinjam;
        $persentaseKenaikan = $totalAktif > 0 ? 8 : 0; // Contoh statis, bisa dikembangkan

        return view('petugas.dashboard.index', compact(
            'pendingCount',
            'sedangDipinjam',
            'jatuhTempoHariIni',
            'terlambat',
            'permintaanTerbaru',
            'pengembalianHariIni',
            'itemTerlambat',
            'statistikHariIni',
            'aktivitasSaya',
            'persentaseKenaikan',
            'totalPending',
            'totalAktif'
        ));
    }
}