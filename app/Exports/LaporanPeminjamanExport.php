<?php

namespace App\Exports;

use App\Models\Peminjaman;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class LaporanPeminjamanExport implements FromCollection, WithHeadings, WithMapping, WithTitle, WithStyles
{
    protected $data;
    protected $statistik;
    protected $title;
    protected $periode;

    public function __construct($data, $statistik, $title, $periode)
    {
        $this->data = $data;
        $this->statistik = $statistik;
        $this->title = $title;
        $this->periode = $periode;
    }

    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Kode Pinjam',
            'Peminjam',
            'Role',
            'Barang',
            'Kategori',
            'Tipe',
            'Tanggal Pinjam',
            'Tanggal Kembali',
            'Jumlah',
            'Status',
            'Denda',
            'Alasan',
            'Dibuat',
        ];
    }

    public function map($row): array
    {
        return [
            'REQ-' . str_pad($row->id, 4, '0', STR_PAD_LEFT),
            $row->kode_peminjaman ?? '-',
            $row->user->name,
            $row->user->role,
            $row->barang->nama_barang,
            $row->barang->kategori->nama_kategori ?? '-',
            $row->tipe_pinjam == 'hari' ? 'Per Hari' : 'Per Jam',
            $row->tipe_pinjam == 'hari' 
                ? Carbon::parse($row->tanggal_pinjam)->format('d/m/Y')
                : Carbon::parse($row->tanggal_pinjam_jam)->format('d/m/Y') . ' ' . $row->jam_pinjam,
            $row->tipe_pinjam == 'hari'
                ? Carbon::parse($row->tanggal_kembali)->format('d/m/Y')
                : Carbon::parse($row->tanggal_pinjam_jam)->format('d/m/Y') . ' ' . $row->jam_kembali,
            $row->jumlah . ' unit',
            ucfirst($row->status),
            $row->denda > 0 ? 'Rp ' . number_format($row->denda, 0, ',', '.') : '-',
            $row->alasan ?? '-',
            $row->created_at->format('d/m/Y H:i'),
        ];
    }

    public function title(): string
    {
        return $this->title;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}