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
    
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $this->rowNumber++;
        
        // Cek apakah NISN sudah ada
        $existingUser = User::where('nisn', $row['nisn'])->first();
        
        if ($existingUser) {
            $this->failures[] = [
                'row' => $this->rowNumber,
                'errors' => ['NISN ' . $row['nisn'] . ' sudah terdaftar']
            ];
            return null;
        }
        
        // Cek apakah email sudah ada
        $email = $row['email'] ?? $row['nisn'] . '@siswa.sch.id';
        
        // Cek email duplicate
        if (User::where('email', $email)->exists()) {
            $this->failures[] = [
                'row' => $this->rowNumber,
                'errors' => ['Email ' . $email . ' sudah terdaftar']
            ];
            return null;
        }
        
        $this->successCount++;
        
        return new User([
            'name' => $row['nama_lengkap'],
            'nisn' => (string) $row['nisn'],
            'email' => $email,
            'kelas' => $row['kelas'],
            'role' => 'siswa',
            'password' => Hash::make($row['password'] ?? 'siswa123'),
            'status' => 'aktif',
        ]);
    }
    
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'nisn' => 'required|numeric|digits_between:8,12',
            'nama_lengkap' => 'required|string|max:255',
            'kelas' => 'required|string|max:50',
            'email' => 'nullable|email',
            'password' => 'nullable|min:4',
        ];
    }
    
    /**
     * @return array
     */
    public function customValidationMessages()
    {
        return [
            'nisn.required' => 'NISN wajib diisi',
            'nisn.numeric' => 'NISN harus berupa angka',
            'nisn.digits_between' => 'NISN harus antara 8-12 digit',
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