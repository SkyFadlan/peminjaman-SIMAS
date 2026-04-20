<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Carbon\Carbon;

class LaporanTransaksiExport implements FromArray, WithHeadings, WithTitle
{
    protected $transaksi;
    protected $statistik;
    protected $periode;

    public function __construct($transaksi, $statistik, $periode)
    {
        $this->transaksi = $transaksi;
        $this->statistik = $statistik;
        $this->periode = $periode;
    }

    public function array(): array
    {
        $data = [];
        
        // Header statistik
        $data[] = ['LAPORAN TRANSAKSI PEMINJAMAN'];
        $data[] = ['Periode: ' . $this->periode];
        $data[] = [];
        $data[] = ['STATISTIK'];
        $data[] = ['Total Transaksi', $this->statistik['total']];
        $data[] = ['Menunggu', $this->statistik['menunggu']];
        $data[] = ['Disetujui', $this->statistik['disetujui']];
        $data[] = ['Dipinjam', $this->statistik['dipinjam']];
        $data[] = ['Dikembalikan', $this->statistik['dikembalikan']];
        $data[] = ['Ditolak', $this->statistik['ditolak']];
        $data[] = ['Total Denda', 'Rp ' . number_format($this->statistik['total_denda'], 0, ',', '.')];
        $data[] = [];
        $data[] = ['DETAIL TRANSAKSI'];
        $data[] = [];
        
        // Header tabel
        $data[] = [
            'No',
            'ID Transaksi',
            'Kode Pinjam',
            'Peminjam',
            'Role',
            'Barang',
            'Kategori',
            'Tipe',
            'Tgl Pinjam',
            'Tgl Kembali',
            'Jumlah',
            'Status',
            'Denda',
            'Alasan'
        ];
        
        // Data transaksi
        foreach ($this->transaksi as $index => $t) {
            $data[] = [
                $index + 1,
                'REQ-' . str_pad($t->id, 4, '0', STR_PAD_LEFT),
                $t->kode_peminjaman ?? '-',
                $t->user->name,
                $t->user->role,
                $t->barang->nama_barang,
                $t->barang->kategori->nama_kategori ?? '-',
                $t->tipe_pinjam == 'hari' ? 'Hari' : 'Jam',
                $t->tipe_pinjam == 'hari' 
                    ? Carbon::parse($t->tanggal_pinjam)->format('d/m/Y')
                    : Carbon::parse($t->tanggal_pinjam_jam)->format('d/m/Y') . ' ' . $t->jam_pinjam,
                $t->tipe_pinjam == 'hari'
                    ? Carbon::parse($t->tanggal_kembali)->format('d/m/Y')
                    : Carbon::parse($t->tanggal_pinjam_jam)->format('d/m/Y') . ' ' . $t->jam_kembali,
                $t->jumlah . ' unit',
                ucfirst($t->status),
                $t->denda > 0 ? 'Rp ' . number_format($t->denda, 0, ',', '.') : '-',
                $t->alasan ?? '-',
            ];
        }
        
        return $data;
    }

    public function headings(): array
    {
        return [];
    }

    public function title(): string
    {
        return 'Laporan Transaksi';
    }
}