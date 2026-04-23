<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PeminjamanAdminController extends Controller
{
    public function index()
    {
        // 1. Ambil user dengan role 'siswa' (sesuaikan nama role di DB kamu)
        $users = User::where('role', 'siswa')->get(); 
        
        // 2. Ambil barang yang stoknya tersedia
        $barangs = Barang::where('jumlah', '>', 0)->latest()->get();
        
        return view('admin.peminjaman.index', compact('users', 'barangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'barang_id' => 'required|exists:barangs,id',
            'jumlah' => 'required|integer|min:1',
            'alasan' => 'nullable|string|max:255',
            'tipe_pinjam' => 'required|in:hari,jam',
            'tanggal_pinjam' => 'required_if:tipe_pinjam,hari|date',
            'tanggal_kembali' => 'required_if:tipe_pinjam,hari|date|after_or_equal:tanggal_pinjam',
            'tanggal_pinjam_jam' => 'required_if:tipe_pinjam,jam|date',
            'jam_pinjam' => 'required_if:tipe_pinjam,jam',
            'jam_kembali' => 'required_if:tipe_pinjam,jam',
        ]);

        DB::beginTransaction();
        try {
            $barang = Barang::findOrFail($request->barang_id);

            if ($barang->jumlah < $request->jumlah) {
                return back()->with('error', 'Stok tidak mencukupi!');
            }

            $peminjaman = new Peminjaman();
            $peminjaman->user_id = $request->user_id; // ID Siswa yang dipilih
            $peminjaman->barang_id = $request->barang_id;
            $peminjaman->jumlah = $request->jumlah;
            $peminjaman->kode_peminjaman = $this->generateKode();
            $peminjaman->status = 'disetujui'; // Langsung disetujui
            $peminjaman->alasan = $request->alasan;

            if ($request->tipe_pinjam === 'hari') {
                $peminjaman->tanggal_pinjam = $request->tanggal_pinjam;
                $peminjaman->tanggal_kembali = $request->tanggal_kembali;
            } else {
                $peminjaman->tanggal_pinjam_jam = $request->tanggal_pinjam_jam;
                $peminjaman->jam_pinjam = $request->jam_pinjam;
                $peminjaman->jam_kembali = $request->jam_kembali;
            }
            
            $peminjaman->save();

            // Potong stok otomatis
            $barang->jumlah -= $request->jumlah;
            $barang->save();

            DB::commit();
            return back()->with('success', 'Peminjaman Berhasil! Kode: ' . $peminjaman->kode_peminjaman);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    private function generateKode()
    {
        $characters = 'ABCDEFGHJKLMNPQRSTUVWXYZ123456789';
        do {
            $kode = substr(str_shuffle($characters), 0, 5);
        } while (Peminjaman::where('kode_peminjaman', $kode)->exists());
        return $kode;
    }

    public function bayarDenda($id)
{
    $peminjaman = Peminjaman::findOrFail($id);
    $peminjaman->status_denda = 'lunas';
    $peminjaman->tanggal_bayar_denda = now();
    $peminjaman->save();
    
    return response()->json(['success' => true, 'message' => 'Pembayaran denda berhasil dikonfirmasi']);
}
}