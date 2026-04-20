<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SiswaTemplateExport implements FromArray, WithHeadings, WithStyles, ShouldAutoSize
{
    public function array(): array
    {
        // Data contoh untuk template
        return [
            [
                '12345678',
                'Ahmad Fauzi',
                'XII RPL 1',
                'ahmad@siswa.sch.id',
                'siswa123'
            ],
            [
                '87654321',
                'Siti Nurhaliza',
                'XII RPL 2',
                'siti@siswa.sch.id',
                'siswa123'
            ],
        ];
    }
    
    public function headings(): array
    {
        return [
            'NISN (*)',
            'Nama Lengkap (*)',
            'Kelas (*)',
            'Email (Opsional)',
            'Password (Opsional, default: siswa123)'
        ];
    }
    
    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 12],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'E5E7EB']
                ]
            ],
        ];
    }
}