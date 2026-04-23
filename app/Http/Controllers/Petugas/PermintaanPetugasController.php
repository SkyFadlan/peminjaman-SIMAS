<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PermintaanPetugasController extends Controller
{
    /**
     * Menampilkan daftar permintaan peminjaman
     */
    public function index(Request $request)
    {
        // Query dasar untuk peminjaman dengan status 'menunggu'
        $query = Peminjaman::with(['user', 'barang', 'barang.kategori'])
            ->where('status', 'menunggu')
            ->latest();
        
        // Filter berdasarkan tanggal
        if ($request->has('tanggal') && $request->tanggal != '') {
            $query->whereDate('created_at', $request->tanggal);
        }
        
        // Filter berdasarkan tipe peminjam (siswa/guru)
        if ($request->has('tipe') && $request->tipe != '') {
            if ($request->tipe == 'siswa') {
                $query->whereHas('user', function($q) {
                    $q->where('role', 'siswa');
                });
            } elseif ($request->tipe == 'guru') {
                $query->whereHas('user', function($q) {
                    $q->where('role', 'guru');
                });
            }
        }
        
        // Filter berdasarkan kategori barang
        if ($request->has('kategori') && $request->kategori != '') {
            $query->whereHas('barang', function($q) use ($request) {
                $q->where('kategori_id', $request->kategori);
            });
        }
        
        // Pencarian
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('user', function($sub) use ($search) {
                    $sub->where('name', 'like', "%{$search}%")
                        ->orWhere('nisn', 'like', "%{$search}%");
                })->orWhereHas('barang', function($sub) use ($search) {
                    $sub->where('nama_barang', 'like', "%{$search}%");
                });
            });
        }
        
        // Ambil data dengan pagination
        $peminjamans = $query->paginate(10)->withQueryString();
        
        // Statistik untuk cards
        $totalPending = Peminjaman::where('status', 'menunggu')->count();
        
        $hariIni = Peminjaman::where('status', 'menunggu')
            ->whereDate('created_at', now()->format('Y-m-d'))
            ->count();
        
        $dariSiswa = Peminjaman::where('status', 'menunggu')
            ->whereHas('user', function($q) {
                $q->where('role', 'siswa');
            })
            ->count();
        
        $dariGuru = Peminjaman::where('status', 'menunggu')
            ->whereHas('user', function($q) {
                $q->where('role', 'guru');
            })
            ->count();
        
        // Data untuk filter kategori
        $kategoris = \App\Models\Kategori::all();
        
        return view('admin.permintaan.index', compact(
            'peminjamans',
            'totalPending',
            'hariIni',
            'dariSiswa',
            'dariGuru',
            'kategoris'
        ));
    }

    /**
     * Menyetujui peminjaman
     */
    public function approve($id)
    {
        DB::beginTransaction();
        
        try {
            $peminjaman = Peminjaman::with('barang')
                ->where('status', 'menunggu')
                ->findOrFail($id);
            
            // Cek stok
            if ($peminjaman->barang->jumlah < $peminjaman->jumlah) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stok barang tidak mencukupi!'
                ], 422);
            }
            
            // Generate kode peminjaman (5 karakter)
            $kode = $this->generateKodePeminjaman();
            
            // Update status dan data
            $peminjaman->kode_peminjaman = $kode;
            $peminjaman->status = 'disetujui';
            $peminjaman->tanggal_disetujui = now();
            $peminjaman->disetujui_oleh = Auth::id();
            
            // Catatan: Stok barang sudah dikurangi saat peminjaman dibuat
            // Jangan kurangi lagi di sini untuk menghindari double deduction
            
            $peminjaman->save();
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Peminjaman berhasil disetujui',
                'kode_peminjaman' => $kode,
                'data' => $peminjaman
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyetujui peminjaman: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Menyetujui banyak peminjaman sekaligus
     */
    public function approveSelected(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:peminjamans,id'
        ]);
        
        DB::beginTransaction();
        
        try {
            $peminjamans = Peminjaman::with('barang')
                ->whereIn('id', $request->ids)
                ->where('status', 'menunggu')
                ->get();
            
            $successCount = 0;
            $failedCount = 0;
            
            foreach ($peminjamans as $peminjaman) {
                // Cek stok
                if ($peminjaman->barang->jumlah < $peminjaman->jumlah) {
                    $failedCount++;
                    continue;
                }
                
                // Generate kode
                $peminjaman->kode_peminjaman = $this->generateKodePeminjaman();
                $peminjaman->status = 'disetujui';
                $peminjaman->tanggal_disetujui = now();
                $peminjaman->disetujui_oleh = Auth::id();
                // Catatan: Stok barang sudah dikurangi saat peminjaman dibuat
                $peminjaman->save();
                
                $successCount++;
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => "{$successCount} peminjaman disetujui, {$failedCount} gagal (stok tidak cukup)"
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyetujui peminjaman: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Menolak peminjaman
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'alasan_penolakan' => 'required|string|min:5'
        ]);
        
        DB::beginTransaction();
        
        try {
            $peminjaman = Peminjaman::where('status', 'menunggu')->findOrFail($id);
            
            $peminjaman->status = 'ditolak';
            $peminjaman->alasan_penolakan = $request->alasan_penolakan;
            $peminjaman->save();
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Peminjaman ditolak',
                'alasan' => $request->alasan_penolakan
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal menolak peminjaman: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Menolak banyak peminjaman sekaligus
     */
    public function rejectSelected(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:peminjamans,id',
            'alasan_penolakan' => 'required|string|min:5'
        ]);
        
        DB::beginTransaction();
        
        try {
            $affected = Peminjaman::whereIn('id', $request->ids)
                ->where('status', 'menunggu')
                ->update([
                    'status' => 'ditolak',
                    'alasan_penolakan' => $request->alasan_penolakan
                ]);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => "{$affected} peminjaman ditolak"
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal menolak peminjaman: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Melihat detail peminjaman
     */
    public function show($id)
    {
        $peminjaman = Peminjaman::with(['user', 'barang', 'barang.kategori'])
            ->findOrFail($id);
        
        return response()->json($peminjaman);
    }

    /**
     * Generate kode peminjaman unik 5 karakter
     */
    private function generateKodePeminjaman()
    {
        $characters = 'ABCDEFGHJKLMNPQRSTUVWXYZ123456789';
        $charactersLength = strlen($characters);
        
        do {
            $kode = '';
            for ($i = 0; $i < 5; $i++) {
                $kode .= $characters[rand(0, $charactersLength - 1)];
            }
        } while (Peminjaman::where('kode_peminjaman', $kode)->exists());
        
        return $kode;
    }
}