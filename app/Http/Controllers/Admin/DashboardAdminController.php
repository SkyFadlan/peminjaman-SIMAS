<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Barang;
use App\Models\User;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardAdminController extends Controller
{
    public function index()
    {
        // ================ STATISTIK CARD ================
        // 1. Pemesanan (Menunggu Persetujuan)
        $pemesanan = Peminjaman::where('status', 'menunggu')->count();
        
        // Hitung persentase perubahan dari kemarin
        $pemesananKemarin = Peminjaman::where('status', 'menunggu')
            ->whereDate('created_at', Carbon::yesterday())
            ->count();
        $pemesananPersentase = $pemesananKemarin > 0 
            ? round((($pemesanan - $pemesananKemarin) / $pemesananKemarin) * 100) 
            : 100;
        
        // 2. ✅ DIPINJAM (Sedang Dipinjam) - PERBAIKAN: Tambah status 'disetujui' dan 'dipinjam'
        $dipinjam = Peminjaman::whereIn('status', ['disetujui', 'dipinjam'])->count();
        
        $dipinjamKemarin = Peminjaman::whereIn('status', ['disetujui', 'dipinjam'])
            ->whereDate('created_at', Carbon::yesterday())
            ->count();
        $dipinjamPersentase = $dipinjamKemarin > 0 
            ? round((($dipinjam - $dipinjamKemarin) / $dipinjamKemarin) * 100) 
            : 0;
        
        // 3. ✅ TERLAMBAT - PERBAIKAN: Tambah status 'disetujui' karena yang disetujui juga bisa terlambat
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
        
        $terlambatKemarin = Peminjaman::whereIn('status', ['disetujui', 'dipinjam'])  // ✅ PERBAIKAN
            ->where(function($query) {
                $query->where('tipe_pinjam', 'hari')
                      ->whereDate('tanggal_kembali', Carbon::yesterday());
            })->count();
        $terlambatPersentase = $terlambatKemarin > 0 
            ? round((($terlambat - $terlambatKemarin) / $terlambatKemarin) * 100) 
            : 0;
        
        // 4. Total Aset
        $totalAset = Barang::count();
        $totalAsetBulanLalu = Barang::whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->count();
        $asetPersentase = $totalAsetBulanLalu > 0 
            ? round((($totalAset - $totalAsetBulanLalu) / $totalAsetBulanLalu) * 100) 
            : $totalAset;

        // ================ HITUNG STOK MENIPIS ================
        $stokMenipis = Barang::where('jumlah', '<=', 5)
            ->where('jumlah', '>', 0)
            ->count();

        // ================ HITUNG RATA-RATA PER HARI ================
        $rataPerHari = $dipinjam > 30 ? round($dipinjam / 30, 1) : 0;

        // ================ STATISTIK PEMINJAMAN 7 HARI ================
        $statistikHari = [];
        $statistikJumlah = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $hari = $date->format('D');
            $namaHari = [
                'Mon' => 'Senin', 
                'Tue' => 'Selasa', 
                'Wed' => 'Rabu', 
                'Thu' => 'Kamis', 
                'Fri' => 'Jumat', 
                'Sat' => 'Sabtu', 
                'Sun' => 'Minggu'
            ][$hari] ?? $hari;
            
            $statistikHari[] = $namaHari;
            
            $jumlah = Peminjaman::whereDate('created_at', $date->format('Y-m-d'))->count();
            $statistikJumlah[] = $jumlah;
        }
        
        $maxJumlah = max($statistikJumlah) > 0 ? max($statistikJumlah) : 1;

         // ================ TOTAL DENDA DARI SEMUA PENGEMBALIAN ================
        // Ambil semua denda dari peminjaman yang sudah dikembalikan dan memiliki denda > 0
        $totalDenda = Peminjaman::where('status', 'dikembalikan')
            ->where('denda', '>', 0)
            ->sum('denda');

        // ================ ✅ DAFTAR TERLAMBAT - PERBAIKAN ================
        $daftarTerlambat = Peminjaman::with(['user', 'barang', 'barang.kategori'])
            ->whereIn('status', ['disetujui', 'dipinjam'])  // ✅ PERBAIKAN
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
            ->orderBy('tanggal_kembali', 'asc')
            ->take(5)
            ->get()
            ->map(function($item) {
                if ($item->tipe_pinjam == 'hari') {
                    $tglKembali = Carbon::parse($item->tanggal_kembali);
                    $item->lama_terlambat = $tglKembali->diffInDays(Carbon::today()) . ' hari';
                } else {
                    // Handle both time format (H:i:s) and datetime format
                    $jamKembaliStr = $item->jam_kembali;
                    if (strpos($jamKembaliStr, ' ') !== false) {
                        // Already contains date, parse directly
                        $jamKembali = Carbon::parse($jamKembaliStr);
                    } else {
                        // Time only, combine with date
                        $jamKembali = Carbon::parse($item->tanggal_pinjam_jam->format('Y-m-d') . ' ' . $jamKembaliStr);
                    }
                    $item->lama_terlambat = $jamKembali->diffInHours(Carbon::now()) . ' jam';
                }
                return $item;
            });

        // ================ AKTIVITAS TERBARU ================
        $aktivitasTerbaru = Peminjaman::with(['user', 'barang'])
            ->whereIn('status', ['menunggu', 'disetujui', 'dikembalikan', 'ditolak'])
            ->orderBy('updated_at', 'desc')
            ->take(5)
            ->get()
            ->map(function($item) {
                $item->waktu = $item->updated_at->diffForHumans();
                
                switch($item->status) {
                    case 'menunggu':
                        $item->icon_bg = 'bg-yellow-100';
                        $item->icon_color = 'text-yellow-600';
                        $item->icon_path = 'M12 4v16m8-8H4';
                        $item->deskripsi = 'mengajukan peminjaman';
                        break;
                    case 'disetujui':
                        $item->icon_bg = 'bg-green-100';
                        $item->icon_color = 'text-green-600';
                        $item->icon_path = 'M5 13l4 4L19 7';
                        $item->deskripsi = 'menyetujui peminjaman';
                        break;
                    case 'dikembalikan':
                        $item->icon_bg = 'bg-blue-100';
                        $item->icon_color = 'text-blue-600';
                        $item->icon_path = 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z';
                        $item->deskripsi = 'mengembalikan';
                        break;
                    case 'ditolak':
                        $item->icon_bg = 'bg-red-100';
                        $item->icon_color = 'text-red-600';
                        $item->icon_path = 'M6 18L18 6M6 6l12 12';
                        $item->deskripsi = 'menolak peminjaman';
                        break;
                    default:
                        $item->icon_bg = 'bg-gray-100';
                        $item->icon_color = 'text-gray-600';
                        $item->icon_path = 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z';
                        $item->deskripsi = 'memproses';
                }
                
                return $item;
            });

        // ================ DAFTAR PEMESANAN (MENUNGGU) ================
        $daftarPemesanan = Peminjaman::with(['user', 'barang', 'barang.kategori'])
            ->where('status', 'menunggu')
            ->orderBy('created_at', 'desc')
            ->paginate(5);
        
        $totalPemesanan = Peminjaman::where('status', 'menunggu')->count();

        // ================ STATISTIK TAMBAHAN ================
        $totalPengguna = User::count();
        $totalPetugas = User::where('role', 'petugas')->count();
        $totalSiswa = User::where('role', 'siswa')->count();
        
        $dikembalikanHariIni = Peminjaman::where('status', 'dikembalikan')
            ->whereDate('updated_at', Carbon::today())
            ->count();
        
        $disetujuiHariIni = Peminjaman::where('status', 'disetujui')
            ->whereDate('tanggal_disetujui', Carbon::today())
            ->count();

        // KIRIM SEMUA DATA KE VIEW
        return view('admin.dashboard.index', compact(
            'pemesanan',
            'pemesananPersentase',
            'dipinjam',
            'dipinjamPersentase',
            'terlambat',
            'terlambatPersentase',
            'totalAset',
            'asetPersentase',
            'stokMenipis',
            'rataPerHari',
            'statistikHari',
            'statistikJumlah',
            'maxJumlah',
            'daftarTerlambat',
            'aktivitasTerbaru',
            'daftarPemesanan',
            'totalPemesanan',
            'totalPengguna',
            'totalPetugas',
            'totalSiswa',
            'dikembalikanHariIni',
            'disetujuiHariIni',
            'totalDenda'
        ));
    }
}