<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PenggunaAdminController extends Controller
{
    public function index() {
        // Mengambil data user dengan role petugas dan siswa secara terpisah
        $petugas = User::where('role', 'petugas')->latest()->paginate(10, ['*'], 'petugas_page');
        $siswa = User::where('role', 'siswa')->latest()->paginate(10, ['*'], 'siswa_page');
        
        // Hitung total untuk stats
        $totalPengguna = User::count();
        $totalPetugas = User::where('role', 'petugas')->count();
        $totalSiswa = User::where('role', 'siswa')->count();
        
        return view('admin.pengguna.index', compact(
            'petugas', 
            'siswa', 
            'totalPengguna', 
            'totalPetugas', 
            'totalSiswa'
        ));
    }

    public function store(Request $request) {
        // 1. Validasi Dasar
        $rules = [
            'name' => 'required|string|max:255',
            'role' => 'required|in:petugas,siswa',
            'password' => 'required|string|min:6',
        ];

        // 2. Validasi Khusus Berdasarkan Role
        if ($request->role === 'siswa') {
            $rules['nisn'] = 'required|string|unique:users,nisn';
            $rules['kelas'] = 'required|string';
        } else {
            $rules['email'] = 'required|email|unique:users,email';
        }

        $validated = $request->validate($rules);

        // 3. Generate Email Dummy untuk Siswa
        if ($request->role === 'siswa') {
            $validated['email'] = $request->nisn . '@siswa.sekolah';
            $validated['nisn'] = $request->nisn;
            $validated['kelas'] = $request->kelas;
        } else {
            $validated['email'] = $request->email;
            $validated['nisn'] = null;
            $validated['kelas'] = null;
        }

        // 4. Set default status dan hash password
        $validated['status'] = 'aktif';
        $validated['password'] = Hash::make($request->password);

        // 5. Simpan
        User::create($validated);

        return redirect()->route('pengguna.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function destroy($id) {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('pengguna.index')->with('success', 'Pengguna berhasil dihapus.');
    }
    
    public function update(Request $request, $id) {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'nisn' => 'nullable|string|unique:users,nisn,' . $user->id,
            'kelas' => 'nullable|string|max:255',
            'role' => 'required|in:petugas,siswa',
        ]);

        $user->update($validated);

        return redirect()->route('pengguna.index')->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function edit($id) {
        $user = User::findOrFail($id);
        return view('admin.pengguna.edit', compact('user'));
    }
}