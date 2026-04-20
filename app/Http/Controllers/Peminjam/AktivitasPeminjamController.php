<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AktivitasPeminjamController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // DEFINISI TANGGAL
        $hariIni = Carbon::today();
        $sekarang = Carbon::now();
        
        // ================ STATISTIK CARDS ================
        // 1. Sedang Dipinjam (status disetujui atau dipinjam)
        $sedangDipinjam = Peminjaman::where('user_id', $user->id)
            ->whereIn('status', ['disetujui', 'dipinjam'])
            ->count();
        
        // 2. JATUH TEMPO HARI INI - PAKAI whereIn('status', ['disetujui', 'dipinjam'])
        $jatuhTempoHariIni = Peminjaman::where('user_id', $user->id)
            ->whereIn('status', ['disetujui', 'dipinjam'])  // ✅ PERBAIKAN: tambah disetujui
            ->where(function($query) use ($hariIni, $sekarang) {
                // Tipe Hari: tanggal kembali = hari ini
                $query->where(function($q) use ($hariIni) {
                    $q->where('tipe_pinjam', 'hari')
                      ->whereDate('tanggal_kembali', $hariIni);
                })
                // Tipe Jam: tanggal = hari ini DAN jam > sekarang
                ->orWhere(function($q) use ($hariIni, $sekarang) {
                    $q->where('tipe_pinjam', 'jam')
                      ->whereDate('tanggal_pinjam_jam', $hariIni)
                      ->whereTime('jam_kembali', '>', $sekarang->format('H:i:s'));
                });
            })->count();
        
        // 3. TERLAMBAT - PAKAI whereIn('status', ['disetujui', 'dipinjam'])
        $terlambat = Peminjaman::where('user_id', $user->id)
            ->whereIn('status', ['disetujui', 'dipinjam'])  // ✅ PERBAIKAN: tambah disetujui
            ->where(function($query) use ($hariIni, $sekarang) {
                // Tipe Hari: tanggal kembali < hari ini
                $query->where(function($q) use ($hariIni) {
                    $q->where('tipe_pinjam', 'hari')
                      ->whereDate('tanggal_kembali', '<', $hariIni);
                })
                // Tipe Jam: tanggal < hari ini ATAU (tanggal = hari ini DAN jam <= sekarang)
                ->orWhere(function($q) use ($hariIni, $sekarang) {
                    $q->where('tipe_pinjam', 'jam')
                      ->where(function($q2) use ($hariIni, $sekarang) {
                          $q2->whereDate('tanggal_pinjam_jam', '<', $hariIni)
                             ->orWhere(function($q3) use ($hariIni, $sekarang) {
                                 $q3->whereDate('tanggal_pinjam_jam', $hariIni)
                                    ->whereTime('jam_kembali', '<=', $sekarang->format('H:i:s'));
                             });
                      });
                });
            })->count();
        
        // 4. Total Peminjaman
        $totalPeminjaman = Peminjaman::where('user_id', $user->id)->count();
        
        // ================ DATA UNTUK TAB ================
        // 1. Peminjaman Aktif (menunggu, disetujui, dipinjam)
        $peminjamanAktif = Peminjaman::with(['barang', 'barang.kategori'])
            ->where('user_id', $user->id)
            ->whereIn('status', ['menunggu', 'disetujui', 'dipinjam'])
            ->latest()
            ->get();
        
        // 2. JATUH TEMPO - PAKAI whereIn('status', ['disetujui', 'dipinjam'])
        $peminjamanJatuhTempo = Peminjaman::with(['barang', 'barang.kategori'])
            ->where('user_id', $user->id)
            ->whereIn('status', ['disetujui', 'dipinjam'])  // ✅ PERBAIKAN: tambah disetujui
            ->where(function($query) use ($hariIni, $sekarang) {
                $query->where(function($q) use ($hariIni) {
                    $q->where('tipe_pinjam', 'hari')
                      ->whereDate('tanggal_kembali', $hariIni);
                })
                ->orWhere(function($q) use ($hariIni, $sekarang) {
                    $q->where('tipe_pinjam', 'jam')
                      ->whereDate('tanggal_pinjam_jam', $hariIni)
                      ->whereTime('jam_kembali', '>', $sekarang->format('H:i:s'));
                });
            })
            ->latest()
            ->get();
        
        // 3. TERLAMBAT - PAKAI whereIn('status', ['disetujui', 'dipinjam'])
        $peminjamanTerlambat = Peminjaman::with(['barang', 'barang.kategori'])
            ->where('user_id', $user->id)
            ->whereIn('status', ['disetujui', 'dipinjam'])  // ✅ PERBAIKAN: tambah disetujui
            ->where(function($query) use ($hariIni, $sekarang) {
                $query->where(function($q) use ($hariIni) {
                    $q->where('tipe_pinjam', 'hari')
                      ->whereDate('tanggal_kembali', '<', $hariIni);
                })
                ->orWhere(function($q) use ($hariIni, $sekarang) {
                    $q->where('tipe_pinjam', 'jam')
                      ->where(function($q2) use ($hariIni, $sekarang) {
                          $q2->whereDate('tanggal_pinjam_jam', '<', $hariIni)
                             ->orWhere(function($q3) use ($hariIni, $sekarang) {
                                 $q3->whereDate('tanggal_pinjam_jam', $hariIni)
                                    ->whereTime('jam_kembali', '<=', $sekarang->format('H:i:s'));
                             });
                      });
                });
            })
            ->latest()
            ->get();
        
        // 4. Riwayat
        $riwayatPeminjaman = Peminjaman::with(['barang', 'barang.kategori'])
            ->where('user_id', $user->id)
            ->whereIn('status', ['dikembalikan', 'ditolak'])
            ->latest()
            ->paginate(10);
        
        return view('peminjam.aktivitasSaya.index', compact(
            'sedangDipinjam',
            'jatuhTempoHariIni',
            'terlambat',
            'totalPeminjaman',
            'peminjamanAktif',
            'peminjamanJatuhTempo',
            'peminjamanTerlambat',
            'riwayatPeminjaman'
        ));
    }
    
    public function show($id)
    {
        $peminjaman = Peminjaman::with(['barang.kategori', 'user'])
            ->where('user_id', auth()->id())
            ->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'data' => $peminjaman
        ]);
    }
}