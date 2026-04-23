<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Models\Barang;

class KategoriAdminController extends Controller
{
    public function index()
    {
        // Ambil semua kategori dengan count barang
        $kategoris = Kategori::withCount('barang')->latest()->get();
        
        // Hitung total item (jumlah semua barang)
        $totalItems = Barang::sum('jumlah');
        
        // Cari kategori dengan barang terbanyak
        $mostPopularCategory = 'Belum ada data';
        $maxCount = 0;
        
        foreach ($kategoris as $kategori) {
            if ($kategori->barang_count > $maxCount) {
                $maxCount = $kategori->barang_count;
                $mostPopularCategory = $kategori->nama_kategori;
            }
        }
        
        return view('admin.kategori.index', compact('kategoris', 'totalItems', 'mostPopularCategory'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategoris',
            'deskripsi' => 'nullable|string',
        ]);

        Kategori::create($validated);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);

        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategoris,nama_kategori,' . $id,
            'deskripsi' => 'nullable|string',
        ]);

        $kategori->update($validated);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        
        // Cek apakah kategori digunakan oleh barang
        if ($kategori->barang()->count() > 0) {
            return redirect()->route('admin.kategori.index')
                ->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh beberapa barang.');
        }
        
        $kategori->delete();
        
        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }
}