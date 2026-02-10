<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kategori; // Pastikan Model diimport

class KategoriAdminController extends Controller
{
    public function index() {
        // Ambil data kategori terbaru
        // Jika ada relasi ke tabel barang/aset, bisa pakai withCount('aset')
        $kategoris = Kategori::latest()->get(); 
        
        return view('admin.kategori.index', compact('kategoris'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|unique:kategoris,nama_kategori',
            'deskripsi' => 'nullable|string',
        ]);

        Kategori::create($validated);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function destroy($id) {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();
        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }

    public function update(Request $request, $id) {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|unique:kategoris,nama_kategori,' . $id,
            'deskripsi' => 'nullable|string',
        ]);

        $kategori = Kategori::findOrFail($id);
        $kategori->update($validated);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }
}