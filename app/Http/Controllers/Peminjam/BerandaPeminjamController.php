<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BerandaPeminjamController extends Controller
{
    public function index()
    {
        // Ambil data barang yang tersedia (jumlah > 0)
        $barangs = Barang::where('jumlah', '>', 0)
            ->with('kategori')
            ->latest()
            ->paginate(12);
        
        // Ambil semua kategori dengan count barang
        $kategoris = Kategori::withCount(['barang' => function($query) {
            $query->where('jumlah', '>', 0);
        }])->get();
        
        // Hitung total barang tersedia
        $totalBarang = Barang::where('jumlah', '>', 0)->count();
        
        // Data peminjaman user
        $user = Auth::user();
        $totalDipinjam = 0;
        $jatuhTempo = 0;

        if ($user) {
            $totalDipinjam = Peminjaman::where('user_id', $user->id)
                ->whereIn('status', ['disetujui', 'dipinjam'])
                ->count();

            $jatuhTempo = Peminjaman::where('user_id', $user->id)
                ->whereIn('status', ['disetujui', 'dipinjam'])
                ->where(function($q) {
                    $q->where('tanggal_kembali', '<', Carbon::today())
                      ->orWhere(function($sq) {
                          $sq->whereNotNull('jam_kembali')
                             ->where('tanggal_pinjam_jam', Carbon::today())
                             ->where('jam_kembali', '<', Carbon::now()->format('H:i'));
                      });
                })->count();
        }
        
        return view('peminjam.beranda.index', compact('barangs', 'kategoris', 'totalBarang', 'totalDipinjam', 'jatuhTempo'));
    }

    public function store(Request $request)
    {
        // 1. VALIDASI
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'jumlah' => 'required|integer|min:1',
            'alasan' => 'nullable|string|max:255',
            'tipe_pinjam' => 'required|in:hari,jam',
            // Perbaikan: menggunakan after_or_equal agar tidak error
            'tanggal_pinjam' => 'required_if:tipe_pinjam,hari|nullable|date',
            'tanggal_kembali' => 'required_if:tipe_pinjam,hari|nullable|date|after_or_equal:tanggal_pinjam',
            'tanggal_pinjam_jam' => 'required_if:tipe_pinjam,jam|nullable|date',
            'jam_pinjam' => 'required_if:tipe_pinjam,jam|nullable',
            'jam_kembali' => 'required_if:tipe_pinjam,jam|nullable',
        ]);

        DB::beginTransaction();
        try {
            $barang = Barang::findOrFail($request->barang_id);

            // Cek ketersediaan stok
            if ($barang->jumlah < $request->jumlah) {
                return response()->json([
                    'success' => false,
                    'message' => 'Maaf, stok buku tidak mencukupi.'
                ], 400);
            }

            // 2. SIMPAN DATA PEMINJAMAN
            $peminjaman = new Peminjaman();
            $peminjaman->user_id = Auth::id();
            $peminjaman->barang_id = $request->barang_id;
            $peminjaman->jumlah = $request->jumlah;
            $peminjaman->alasan = $request->alasan;
            
            // SET STATUS LANGSUNG DISETUJUI (INSTAN)
            $peminjaman->status = 'menunggu'; // Bisa langsung disetujui jika ingin instan

            if ($request->tipe_pinjam === 'hari') {
                $peminjaman->tanggal_pinjam = $request->tanggal_pinjam;
                $peminjaman->tanggal_kembali = $request->tanggal_kembali;
            } else {
                $peminjaman->tanggal_pinjam_jam = $request->tanggal_pinjam_jam;
                $peminjaman->jam_pinjam = $request->jam_pinjam;
                $peminjaman->jam_kembali = $request->jam_kembali;
            }
            
            $peminjaman->save();

            // 3. POTONG STOK SECARA OTOMATIS
            $barang->jumlah -= $request->jumlah;
            $barang->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Peminjaman Berhasil! Menunggu persetujuan.',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal memproses peminjaman: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $barang = Barang::with('kategori')->findOrFail($id);
        return response()->json($barang);
    }
}