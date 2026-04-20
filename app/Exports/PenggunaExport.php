<?php
// app/Exports/PenggunaExport.php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PenggunaExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    public function collection()
    {
        return User::latest()->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Lengkap',
            'Email',
            'NISN',
            'Kelas',
            'NIP',
            'Jabatan',
            'Role',
            'Status',
            'Tanggal Dibuat'
        ];
    }

    public function map($user): array
    {
        return [
            $user->id,
            $user->name,
            $user->email,
            $user->nisn ?? '-',
            $user->kelas ?? '-',
            $user->nip ?? '-',
            $user->jabatan ?? '-',
            ucfirst($user->role),
            ucfirst($user->status ?? 'aktif'),
            $user->created_at->format('d/m/Y H:i')
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}