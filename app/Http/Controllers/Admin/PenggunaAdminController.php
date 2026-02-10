<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash; // Wajib import ini

class PenggunaAdminController extends Controller
{
    public function index() {
        // Mengambil data user terbaru dengan pagination
        $users = User::latest()->paginate(10);
        return view('admin.pengguna.index', compact('users'));
    }

    public function store(Request $request) {
        // 1. Validasi Dasar (Wajib untuk semua)
        $rules = [
            'name' => 'required|string|max:255',
            'role' => 'required|in:petugas,siswa',
            'password' => 'required|string|min:6',
        ];

        // 2. Validasi Khusus Berdasarkan Role
        if ($request->role === 'siswa') {
            // Jika Siswa: NISN & Kelas Wajib, Email tidak perlu diinput user
            $rules['nisn'] = 'required|string|unique:users,nisn';
            $rules['kelas'] = 'required|string';
        } else {
            // Jika Admin/Petugas: Email Wajib
            $rules['email'] = 'required|email|unique:users,email';
        }

        $validated = $request->validate($rules);

        // 3. Generate Email Dummy untuk Siswa
        // Database Laravel biasanya mewajibkan kolom email.
        // Kita buat email palsu: [nisn]@siswa.sekolah agar tidak error.
        if ($request->role === 'siswa') {
            $validated['email'] = $request->nisn . '@siswa.sekolah';
        } else {
            $validated['email'] = $request->email;
        }

        // 4. Hash Password (Keamanan)
        $validated['password'] = Hash::make($request->password);

        // 5. Simpan
        User::create($validated);

        return redirect()->route('admin.pengguna.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function destroy($id) {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.pengguna.index')->with('success', 'Pengguna berhasil dihapus.');
    }
    
    public function update(Request $request, $id) {
        $user = \App\Models\User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'nisn' => 'nullable|string|unique:users,nisn,' . $user->id,
            'kelas' => 'nullable|string|max:255',
            'role' => 'required|in:petugas,siswa'
        ]);

        $user->update($validated);

        return redirect()->route('admin.pengguna.index')->with('success', 'Pengguna berhasil diperbarui.');
}

}
    
