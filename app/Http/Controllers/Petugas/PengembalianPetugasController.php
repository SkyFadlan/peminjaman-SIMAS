<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\DendaKondisi;
use App\Notifications\PengingatPeminjamanNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PengembalianPetugasController extends Controller
{
    /**
     * Menampilkan halaman pengembalian
     */
    public function index(Request $request)
{
    // Query untuk peminjaman dengan status 'disetujui' atau 'dipinjam'
    $query = Peminjaman::with([
        'user', 
        'barang', 
        'barang.kategori'
    ])->whereIn('status', ['disetujui', 'dipinjam']);
    
    // Filter pencarian
    if ($request->has('search') && $request->search != '') {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->whereHas('user', function($sub) use ($search) {
                $sub->where('name', 'like', "%{$search}%")
                    ->orWhere('nisn', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })->orWhereHas('barang', function($sub) use ($search) {
                $sub->where('nama_barang', 'like', "%{$search}%");
            })->orWhere('kode_peminjaman', 'like', "%{$search}%");
        });
    }
    
    // Filter kategori
    if ($request->has('kategori') && $request->kategori != '') {
        $query->whereHas('barang', function($q) use ($request) {
            $q->where('kategori_id', $request->kategori);
        });
    }
    
    // Ambil data dengan pagination
    $peminjamans = $query->latest()->paginate(10)->withQueryString();
    
    // ✅ FILTER UNTUK JATUH TEMPO
    $peminjamanJatuhTempo = Peminjaman::with([
        'user', 
        'barang', 
        'barang.kategori'
    ])
        ->whereIn('status', ['disetujui', 'dipinjam'])
        ->where('tipe_pinjam', 'hari')
        ->whereDate('tanggal_kembali', Carbon::today())
        ->get();
    
    // ✅ FILTER UNTUK TERLAMBAT
    $peminjamanTerlambat = Peminjaman::with([
        'user', 
        'barang', 
        'barang.kategori'
    ])
        ->whereIn('status', ['disetujui', 'dipinjam'])
        ->where(function($q) {
            $q->where(function($sub) {
                $sub->where('tipe_pinjam', 'hari')
                    ->where('tanggal_kembali', '<', Carbon::today());
            })->orWhere(function($sub) {
                $sub->where('tipe_pinjam', 'jam')
                    ->whereDate('tanggal_pinjam_jam', '<', Carbon::today())
                    ->orWhere(function($sub2) {
                        $sub2->whereDate('tanggal_pinjam_jam', Carbon::today())
                            ->whereTime('jam_kembali', '<', Carbon::now()->format('H:i:s'));
                    });
            });
        })
        ->get();
    
    // Statistik
    $jatuhTempoHariIni = $peminjamanJatuhTempo->count();
    $terlambat = $peminjamanTerlambat->count();
    $dikembalikanHariIni = Peminjaman::where('status', 'dikembalikan')
        ->whereDate('updated_at', Carbon::today())
        ->count();
    $totalAktif = Peminjaman::whereIn('status', ['disetujui', 'dipinjam'])->count();
    
    $kategoris = Kategori::all();
    
    return view('admin.pengembalian.index', compact(
        'peminjamans',
        'peminjamanJatuhTempo',
        'peminjamanTerlambat',  // ✅ PASTIKAN VARIABEL INI ADA
        'jatuhTempoHariIni',
        'terlambat',
        'dikembalikanHariIni',
        'totalAktif',
        'kategoris'
    ));
}

    /**
     * Menampilkan detail peminjaman
     */
    public function show($id)
    {
        $peminjaman = Peminjaman::with([
            'user', 
            'barang', 
            'barang.kategori'
        ])->findOrFail($id);
        
        $dendaKondisi = DendaKondisi::select('nama', 'kode', 'jumlah')->get();

        return response()->json([
            'success' => true,
            'data' => $peminjaman,
            'denda_kondisi' => $dendaKondisi
        ]);
    }

    /**
     * Memproses pengembalian barang
     */
    public function return(Request $request, $id)
    {
        $request->validate([
            'kondisi' => 'required|string',
            'denda_kondisi_amount' => 'nullable|numeric|min:0',
            'catatan' => 'nullable|string',
            'denda_bayar' => 'nullable|boolean'
        ]);
        
        DB::beginTransaction();
        
        try {
            $peminjaman = Peminjaman::with('barang')
                ->whereIn('status', ['disetujui', 'dipinjam'])
                ->findOrFail($id);
            
            // Hitung denda keterlambatan
            $dendaTerlambat = 0;
            $kondisi = $request->kondisi;
            $dendaKondisi = (int) $request->input('denda_kondisi_amount', 0);

            if ($kondisi === 'Baik') {
                $dendaKondisi = 0;
            }

            if ($peminjaman->tipe_pinjam == 'hari') {
                $tglKembali = Carbon::parse($peminjaman->tanggal_kembali)->endOfDay();
                if ($tglKembali->isPast()) {
                    $dendaTerlambat = $tglKembali->diffInDays(now());
                }
            } elseif ($peminjaman->tipe_pinjam == 'jam') {
                $jamKembaliStr = $peminjaman->jam_kembali;
                if (strpos($jamKembaliStr, ' ') !== false) {
                    // Already contains date, parse directly
                    $jamKembali = Carbon::parse($jamKembaliStr);
                } else {
                    // Time only, combine with date
                    $jamKembali = Carbon::parse($peminjaman->tanggal_pinjam_jam->format('Y-m-d') . ' ' . $jamKembaliStr);
                }
                if ($jamKembali->isPast()) {
                    $dendaTerlambat = $jamKembali->diffInHours(now());
                }
            }

            $lateAmount = $dendaTerlambat * ($peminjaman->tipe_pinjam == 'hari' ? 5000 : 2000);
            $totalDenda = $lateAmount + $dendaKondisi;
            
            // Update data peminjaman
            $peminjaman->status = 'dikembalikan';
            $peminjaman->denda = $totalDenda;
            $peminjaman->denda_terlambat = $lateAmount;
            $peminjaman->denda_kondisi = $dendaKondisi;
            $peminjaman->kondisi_saat_kembali = $kondisi;
            $peminjaman->catatan_pengembalian = $request->catatan;
            $peminjaman->denda_bayar = $request->denda_bayar ?? false;
            $peminjaman->diproses_oleh = Auth::id();
            $peminjaman->save();
            
            // Kembalikan stok barang
            $peminjaman->barang->increment('jumlah', $peminjaman->jumlah);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Pengembalian berhasil diproses',
                'data' => [
                    'denda' => $totalDenda,
                    'denda_terlambat' => $lateAmount,
                    'denda_kondisi' => $dendaKondisi,
                    'kondisi' => $request->kondisi,
                ]
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal memproses pengembalian: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Proses pengembalian via scan QR
     */
    public function scan(Request $request)
    {
        $request->validate([
            'kode_peminjaman' => 'required|string|size:5'
        ]);
        
        $peminjaman = Peminjaman::with([
            'user', 
            'barang'
        ])
            ->where('kode_peminjaman', $request->kode_peminjaman)
            ->whereIn('status', ['disetujui', 'dipinjam'])
            ->first();
        
        if (!$peminjaman) {
            return response()->json([
                'success' => false,
                'message' => 'Kode peminjaman tidak valid atau sudah diproses'
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'data' => $peminjaman
        ]);
    }

    /**
     * Kirim pengingat ke peminjam
     */
    public function sendReminder($id)
    {
        try {
            $peminjaman = Peminjaman::with(['user', 'barang'])
                ->whereIn('status', ['disetujui', 'dipinjam'])
                ->findOrFail($id);
            
            if (!$peminjaman->user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Peminjam tidak ditemukan.'
                ], 404);
            }

            $peminjaman->user->notify(new PengingatPeminjamanNotification($peminjaman));
            
            return response()->json([
                'success' => true,
                'message' => 'Pengingat berhasil dikirim ke ' . $peminjaman->user->name
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim pengingat: ' . $e->getMessage()
            ], 500);
        }
    }
}