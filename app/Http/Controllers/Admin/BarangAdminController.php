<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Support\Facades\Storage;

class BarangAdminController extends Controller
{
    public function index() {
        // Mengambil data barang dengan pagination
        $barangs = Barang::with('kategori')->latest()->paginate(10);
        
        // Mengambil data kategori untuk dropdown
        $kategoris = Kategori::all();
        
        // Hitung total untuk stats
        $totalBarang = Barang::count();
        
        return view('admin.barang.index', compact('barangs', 'kategoris', 'totalBarang'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kategori_id' => 'required|exists:kategoris,id',
            'jumlah' => 'required|integer|min:0',
            'gambar' => 'nullable|image|max:2048', // Maksimal 2MB
        ]);

        // Handle upload gambar
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('barang', 'public');
            $validated['gambar'] = $gambarPath;
        }

        // Simpan barang
        Barang::create($validated);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function destroy($id) {
        $barang = Barang::findOrFail($id);
        
        // Hapus gambar jika ada
        if ($barang->gambar && Storage::disk('public')->exists($barang->gambar)) {
            Storage::disk('public')->delete($barang->gambar);
        }
        
        $barang->delete();
        
        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus.');
    }

    public function update(Request $request, $id) {
        $barang = Barang::findOrFail($id);

        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kategori_id' => 'required|exists:kategoris,id',
            'jumlah' => 'required|integer|min:0',
            'gambar' => 'nullable|image|max:2048',
        ]);

        // Handle upload gambar baru
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($barang->gambar && Storage::disk('public')->exists($barang->gambar)) {
                Storage::disk('public')->delete($barang->gambar);
            }
            
            $gambarPath = $request->file('gambar')->store('barang', 'public');
            $validated['gambar'] = $gambarPath;
        }

        $barang->update($validated);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil diperbarui.');
    }

    public function edit($id) {
        $barang = Barang::findOrFail($id);
        $kategoris = Kategori::all();
        return view('admin.barang.edit', compact('barang', 'kategoris'));
    }
}