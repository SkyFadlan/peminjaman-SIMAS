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
        
        if ($user) {
            $hariIni = Carbon::today();
            $sekarang = Carbon::now();

            $totalDipinjam = Peminjaman::where('user_id', $user->id)
                ->whereIn('status', ['disetujui', 'dipinjam'])
                ->count();

            $jatuhTempo = Peminjaman::where('user_id', $user->id)
                ->whereIn('status', ['disetujui', 'dipinjam'])
                ->where(function ($query) use ($hariIni, $sekarang) {
                    $query->where(function ($q) use ($hariIni) {
                        $q->where('tipe_pinjam', 'hari')
                          ->whereDate('tanggal_kembali', $hariIni);
                    })
                    ->orWhere(function ($q) use ($hariIni, $sekarang) {
                        $q->where('tipe_pinjam', 'jam')
                          ->whereDate('tanggal_pinjam_jam', $hariIni)
                          ->whereTime('jam_kembali', '>', $sekarang->format('H:i:s'));
                    });
                })
                ->count();

            $terlambat = Peminjaman::where('user_id', $user->id)
                ->whereIn('status', ['disetujui', 'dipinjam'])
                ->where(function ($query) use ($hariIni, $sekarang) {
                    $query->where(function ($q) use ($hariIni) {
                        $q->where('tipe_pinjam', 'hari')
                          ->whereDate('tanggal_kembali', '<', $hariIni);
                    })
                    ->orWhere(function ($q) use ($hariIni, $sekarang) {
                        $q->where('tipe_pinjam', 'jam')
                          ->where(function ($q2) use ($hariIni, $sekarang) {
                              $q2->whereDate('tanggal_pinjam_jam', '<', $hariIni)
                                 ->orWhere(function ($q3) use ($hariIni, $sekarang) {
                                     $q3->whereDate('tanggal_pinjam_jam', $hariIni)
                                        ->whereTime('jam_kembali', '<=', $sekarang->format('H:i:s'));
                                 });
                          });
                    });
                })
                ->count();
        } else {
            $totalDipinjam = 0;
            $jatuhTempo = 0;
            $terlambat = 0;
        }
        
        return view('peminjam.beranda.index', compact(
            'barangs', 
            'kategoris', 
            'totalBarang', 
            'totalDipinjam', 
            'jatuhTempo',
            'terlambat'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'tipe_pinjam' => 'required|in:hari,jam',
            'jumlah' => 'required|integer|min:1',
            'alasan' => 'required|string|min:5',
            
            // Validasi untuk tipe hari
            'tanggal_pinjam' => 'required_if:tipe_pinjam,hari|date|after_or_equal:today',
            'tanggal_kembali' => 'required_if:tipe_pinjam,hari|date|after_or_equal:tanggal_pinjam',
            
            // Validasi untuk tipe jam
            'tanggal_pinjam_jam' => 'required_if:tipe_pinjam,jam|date|after_or_equal:today',
            'jam_pinjam' => 'required_if:tipe_pinjam,jam|date_format:H:i',
            'jam_kembali' => 'required_if:tipe_pinjam,jam|date_format:H:i|after:jam_pinjam',
        ], [
            'alasan.required' => 'Alasan peminjaman wajib diisi',
            'alasan.min' => 'Alasan peminjaman minimal 5 karakter',
            'tanggal_kembali.after_or_equal' => 'Tanggal kembali tidak boleh kurang dari tanggal pinjam',
            'jam_kembali.after' => 'Jam kembali harus setelah jam pinjam',
        ]);

        try {
            DB::beginTransaction();

            // Cek stok barang
            $barang = Barang::findOrFail($request->barang_id);
            
            if ($barang->jumlah < $request->jumlah) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stok barang tidak mencukupi!'
                ], 422);
            }
            
            if ($request->tipe_pinjam === 'hari') {
                $tglPinjam = \Carbon\Carbon::parse($request->tanggal_pinjam);
                $tglKembali = \Carbon\Carbon::parse($request->tanggal_kembali);
                
                // Cek selisih hari
                if ($tglPinjam->diffInDays($tglKembali) > 7) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Maksimal peminjaman adalah 7 hari.'
                    ], 422);
                }
            } else if ($request->tipe_pinjam === 'jam') {
                $jamPinjam = \Carbon\Carbon::parse($request->jam_pinjam);
                $jamKembali = \Carbon\Carbon::parse($request->jam_kembali);
                
                // Cek selisih jam
                if ($jamPinjam->diffInHours($jamKembali) > 8) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Maksimal peminjaman adalah 8 jam.'
                    ], 422);
                }
            }
            
            // Buat data peminjaman
            $peminjaman = new Peminjaman();
            $peminjaman->user_id = Auth::id();
            $peminjaman->barang_id = $request->barang_id;
            $peminjaman->tipe_pinjam = $request->tipe_pinjam;
            $peminjaman->jumlah = $request->jumlah;
            $peminjaman->alasan = $request->alasan;
            $peminjaman->status = 'menunggu'; // Perlu persetujuan admin/petugas
            
            // Set data berdasarkan tipe
            if ($request->tipe_pinjam === 'hari') {
                $peminjaman->tanggal_pinjam = $request->tanggal_pinjam;
                $peminjaman->tanggal_kembali = $request->tanggal_kembali;
            } else {
                $peminjaman->tanggal_pinjam_jam = $request->tanggal_pinjam_jam;
                $peminjaman->jam_pinjam = $request->jam_pinjam;
                $peminjaman->jam_kembali = $request->jam_kembali;
                // Set tanggal pinjam dan kembali ke null untuk tipe jam
                $peminjaman->tanggal_pinjam = null;
                $peminjaman->tanggal_kembali = null;
            }
            
            $peminjaman->save();

            // Kurangi stok barang (opsional, bisa juga setelah disetujui)
            // $barang->jumlah -= $request->jumlah;
            // $barang->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Permintaan peminjaman berhasil diajukan!',
                'data' => $peminjaman
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengajukan peminjaman: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function show($id)
    {
        $barang = Barang::with('kategori')->findOrFail($id);
        return response()->json($barang);
    }
}