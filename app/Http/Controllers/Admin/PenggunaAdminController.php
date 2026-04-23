<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Imports\SiswaImport;
use App\Exports\SiswaTemplateExport; 
use PDF;
use Excel;
use App\Exports\PenggunaExport;

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

    public function showImportForm()
    {
        return view('admin.pengguna.import');
    }
    
    /**
     * Download template Excel
     */
    public function downloadTemplate()
    {
        return Excel::download(new SiswaTemplateExport, 'template_import_siswa.xlsx');
    }
    
    /**
     * Import siswa from Excel
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:5120', // Max 5MB
        ]);
        
        try {
            $import = new SiswaImport();
            Excel::import($import, $request->file('file'));
            
            $successCount = $import->getSuccessCount();
            $failures = $import->getFailures();
            
            $message = "Berhasil mengimport {$successCount} data siswa.";
            
            if (count($failures) > 0) {
                session()->flash('import_failures', $failures);
                $message .= " Terdapat " . count($failures) . " data gagal diimport.";
            }
            
            return redirect()->route('admin.pengguna.index')
                ->with('success', $message);
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal mengimport data: ' . $e->getMessage());
        }
    }

    // EXPORT FUNCTIONS
    public function exportPdf()
    {
        $semuaPengguna = User::latest()->get();
        $pdf = PDF::loadView('admin.pengguna.exports.pdf-semua', compact('semuaPengguna'));
        return $pdf->download('semua-pengguna-'.date('Y-m-d').'.pdf');
    }

    public function exportPetugasPdf()
    {
        $petugas = User::where('role', 'petugas')->latest()->get();
        $pdf = PDF::loadView('admin.pengguna.exports.pdf-petugas', compact('petugas'));
        return $pdf->download('data-petugas-'.date('Y-m-d').'.pdf');
    }

    public function exportSiswaPdf()
    {
        $siswa = User::where('role', 'siswa')->latest()->get();
        $pdf = PDF::loadView('admin.pengguna.exports.pdf-siswa', compact('siswa'));
        return $pdf->download('data-siswa-'.date('Y-m-d').'.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new PenggunaExport, 'semua-pengguna-'.date('Y-m-d').'.xlsx');
    }

    public function store(Request $request) {
    // 1. Validasi dasar untuk semua role
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'role' => 'required|in:petugas,siswa',
        'password' => 'required|string|min:8',
    ]);

    // 2. Validasi tambahan & penggabungan data
    if ($request->role == 'siswa') {
    $siswaData = $request->validate([
        'nisn' => 'required|string|unique:users,nisn',
        'kelas' => 'required|string|max:255',
        'email' => 'nullable|email|unique:users,email',
    ]);
    
    // Jika email kosong, buatkan email otomatis berbasis NISN
    if (empty($siswaData['email'])) {
        $siswaData['email'] = $siswaData['nisn'] . '@siswa.com';
    }
    
    $validated = array_merge($validated, $siswaData);

    } else {
        $petugasData = $request->validate([
            'email' => 'required|email|unique:users,email',
        ]);
        $validated = array_merge($validated, $petugasData);
        $validated['nisn'] = null;
        $validated['kelas'] = null;
    }

    // 3. Set default status dan hash password
    $validated['status'] = 'aktif';
    $validated['password'] = Hash::make($request->password);

    // 4. Simpan ke database
    User::create($validated);

    return redirect()->route('admin.pengguna.index')->with('success', 'Pengguna berhasil ditambahkan.');
}

    public function destroy($id) {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.pengguna.index')->with('success', 'Pengguna berhasil dihapus.');
    }
    
    public function update(Request $request, $id) {
    $user = User::findOrFail($id);

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'role' => 'required|in:petugas,siswa',
        // Tambahkan validasi khusus jika dia siswa
        'nisn' => $request->role == 'siswa' ? 'required|string|unique:users,nisn,' . $user->id : 'nullable',
        'kelas' => $request->role == 'siswa' ? 'required|string|max:255' : 'nullable',
    ]);

    $user->update($validated);

    return redirect()->route('admin.pengguna.index')->with('success', 'Pengguna berhasil diperbarui.');
}

    public function edit($id) {
        $user = User::findOrFail($id);
        return view('admin.pengguna.edit', compact('user'));
    }
}