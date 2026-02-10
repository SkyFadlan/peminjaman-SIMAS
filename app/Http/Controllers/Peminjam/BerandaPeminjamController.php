<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Support\Facades\Auth;

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
        
        // Data peminjaman user (jika ada fitur peminjaman)
        $user = Auth::user();
        $totalDipinjam = 0; // Ganti dengan logika peminjaman
        $jatuhTempo = 0; // Ganti dengan logika jatuh tempo
        
        // PERHATIAN: Pastikan view yang benar dipanggil
        // Jika file view Anda di: resources/views/peminjam/beranda/index.blade.php
        return view('peminjam.beranda.index', compact('barangs', 'kategoris', 'totalBarang', 'totalDipinjam', 'jatuhTempo'));
        
        // CATATAN: Pada kode sebelumnya Anda menggunakan 'peminjam.index'
        // Tapi error menunjukkan view di: peminjam/beranda/index.blade.php
        // Sesuaikan dengan struktur folder Anda
    }
    
    public function show($id)
    {
        $barang = Barang::with('kategori')->findOrFail($id);
        return response()->json($barang);
    }
}