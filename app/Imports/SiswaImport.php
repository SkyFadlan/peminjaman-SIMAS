<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class SiswaImport implements ToModel, WithHeadingRow, WithValidation, WithBatchInserts, WithChunkReading
{
    use Importable;
    
    private $successCount = 0;
    private $failures = [];
    private $rowNumber = 1;
    
    public function model(array $row)
    {
        $this->rowNumber++;
        
        // Ambil nilai dengan aman menggunakan array_key_exists
        $nisn = isset($row['nisn']) ? (string) trim($row['nisn']) : '';
        $namaLengkap = isset($row['nama_lengkap']) ? trim($row['nama_lengkap']) : (isset($row['nama']) ? trim($row['nama']) : '');
        $kelas = isset($row['kelas']) ? trim($row['kelas']) : '';
        
        // Email opsional - jika tidak diisi, buat dari NISN
        $email = '';
        if (isset($row['email']) && !empty(trim($row['email']))) {
            $email = trim($row['email']);
        } else {
            $email = $nisn . '@siswa.sch.id';
        }
        
        // Password opsional - jika tidak diisi, default 'siswa123'
        $password = (isset($row['password']) && !empty(trim($row['password']))) ? trim($row['password']) : 'siswa123';
        
        // Validasi dasar
        if (empty($nisn)) {
            $this->failures[] = [
                'row' => $this->rowNumber,
                'errors' => ['NISN tidak boleh kosong'],
                'values' => $row
            ];
            return null;
        }
        
        if (empty($namaLengkap)) {
            $this->failures[] = [
                'row' => $this->rowNumber,
                'errors' => ['Nama lengkap tidak boleh kosong'],
                'values' => $row
            ];
            return null;
        }
        
        if (empty($kelas)) {
            $this->failures[] = [
                'row' => $this->rowNumber,
                'errors' => ['Kelas tidak boleh kosong'],
                'values' => $row
            ];
            return null;
        }
        
        // Cek apakah NISN sudah ada (ini yang utama untuk login)
        $existingUser = User::where('nisn', $nisn)->first();
        if ($existingUser) {
            $this->failures[] = [
                'row' => $this->rowNumber,
                'errors' => ['NISN ' . $nisn . ' sudah terdaftar'],
                'values' => $row
            ];
            return null;
        }
        
        // Cek email duplicate (opsional, hanya jika email sudah ada di database)
        if (User::where('email', $email)->exists()) {
            $this->failures[] = [
                'row' => $this->rowNumber,
                'errors' => ['Email ' . $email . ' sudah terdaftar'],
                'values' => $row
            ];
            return null;
        }
        
        $this->successCount++;
        
        return new User([
            'name' => $namaLengkap,
            'nisn' => $nisn,
            'email' => $email,
            'kelas' => $kelas,
            'role' => 'siswa',
            'password' => Hash::make($password),
            'status' => 'aktif',
        ]);
    }
    
    public function rules(): array
    {
        return [
            'nisn' => 'required',
            'nama_lengkap' => 'required|string|max:255',
            'kelas' => 'required|string|max:50',
            'email' => 'nullable|email',
            'password' => 'nullable|min:4',
        ];
    }
    
    public function customValidationMessages()
    {
        return [
            'nisn.required' => 'NISN wajib diisi',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi',
            'kelas.required' => 'Kelas wajib diisi',
        ];
    }
    
    public function getSuccessCount()
    {
        return $this->successCount;
    }
    
    public function getFailures()
    {
        return $this->failures;
    }
    
    public function batchSize(): int
    {
        return 100;
    }
    
    public function chunkSize(): int
    {
        return 100;
    }
}