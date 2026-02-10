<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BarangAdminController extends Controller
{
    public function index() {
        return view('admin.barang.index');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'nama_barang' => 'required|string',
            'deskripsi' => 'nullable|string',
            'kategori_id' => 'required|exists:kategoris,id',
            'jumlah' => 'required|integer|min=0',
            'gambar' => 'nullable|image|max:2048', // Maksimal 2MB
        ]);
    }

    public function destroy($id) {
        // Logika untuk menghapus barang berdasarkan ID
        $barang = \App\Models\Barang::findOrFail($id);
        $barang->delete();
        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus.');
    }

    public function update(Request $request, $id) {
        $validated = $request->validate([
            'nama_barang' => 'required|string',
            'deskripsi' => 'nullable|string',
            'kategori_id' => 'required|exists:kategoris,id',
            'jumlah' => 'required|integer|min=0',
            'gambar' => 'nullable|image|max:2048', // Maksimal 2MB
        ]);

        $barang = \App\Models\Barang::findOrFail($id);
        $barang->update($validated);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil diperbarui.');
}
}
