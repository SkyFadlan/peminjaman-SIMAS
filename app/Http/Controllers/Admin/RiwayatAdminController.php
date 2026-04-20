<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RiwayatAdminController extends Controller
{
    /**
     * Menampilkan halaman riwayat peminjaman
     */
    public function index(Request $request)
    {
        // Query dasar - hanya status yang sudah selesai (dikembalikan, ditolak, terlambat)
        $query = Peminjaman::with(['user', 'barang', 'barang.kategori'])
            ->whereIn('status', ['dikembalikan', 'ditolak', 'terlambat'])
            ->latest('updated_at');

        // ================ FILTER TANGGAL ================
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = Carbon::parse($request->start_date)->startOfDay();
            $endDate = Carbon::parse($request->end_date)->endOfDay();
            $query->whereBetween('updated_at', [$startDate, $endDate]);
        }

        // ================ FILTER STATUS ================
        if ($request->filled('status')) {
            if ($request->status == 'tepat_waktu') {
                $query->where('status', 'dikembalikan')
                    ->where('denda', 0);
            } elseif ($request->status == 'terlambat') {
                $query->where(function($q) {
                    $q->where('status', 'terlambat')
                      ->orWhere(function($q2) {
                          $q2->where('status', 'dikembalikan')
                             ->where('denda', '>', 0);
                      });
                });
            } elseif ($request->status == 'ditolak') {
                $query->where('status', 'ditolak');
            }
        }

        // ================ FILTER KATEGORI ================
        if ($request->filled('kategori')) {
            $query->whereHas('barang', function($q) use ($request) {
                $q->where('kategori_id', $request->kategori);
            });
        }

        // ================ PENCARIAN ================
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('user', function($sub) use ($search) {
                    $sub->where('name', 'like', "%{$search}%")
                        ->orWhere('nisn', 'like', "%{$search}%");
                })->orWhereHas('barang', function($sub) use ($search) {
                    $sub->where('nama_barang', 'like', "%{$search}%");
                })->orWhere('kode_peminjaman', 'like', "%{$search}%");
            });
        }

        // ================ PAGINATION ================
        $transaksi = $query->paginate(10)->withQueryString();

        // ================ STATISTIK SEDERHANA ================
        $totalTransaksi = Peminjaman::whereIn('status', ['dikembalikan', 'ditolak', 'terlambat'])->count();
        $tepatWaktu = Peminjaman::where('status', 'dikembalikan')->where('denda', 0)->count();
        $terlambat = Peminjaman::where('status', 'terlambat')
            ->orWhere(function($q) {
                $q->where('status', 'dikembalikan')->where('denda', '>', 0);
            })->count();

        // ================ DATA UNTUK FILTER ================
        $kategoris = Kategori::all();

        return view('admin.riwayat.index', compact(
            'transaksi',
            'totalTransaksi',
            'tepatWaktu',
            'terlambat',
            'kategoris'
        ));
    }

    /**
     * Menampilkan detail transaksi
     */
    public function show($id)
    {
        $transaksi = Peminjaman::with([
            'user', 
            'barang', 
            'barang.kategori'
        ])->findOrFail($id);
        
        return response()->json($transaksi);
    }
}