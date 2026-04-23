<?php

namespace App\Exports;

use App\Models\Peminjaman;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class RiwayatExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $startDate;
    protected $endDate;
    protected $status;
    protected $kategori;
    protected $search;

    public function __construct($startDate = null, $endDate = null, $status = null, $kategori = null, $search = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->status = $status;
        $this->kategori = $kategori;
        $this->search = $search;
    }

    public function collection()
    {
        $query = Peminjaman::with(['user', 'barang', 'barang.kategori'])
            ->whereIn('status', ['dikembalikan', 'ditolak']);

        // Filter tanggal
        if ($this->startDate && $this->endDate) {
            $query->whereBetween('created_at', [
                Carbon::parse($this->startDate)->startOfDay(),
                Carbon::parse($this->endDate)->endOfDay()
            ]);
        }

        // Filter status
        if ($this->status) {
            if ($this->status == 'tepat_waktu') {
                $query->where('status', 'dikembalikan')->where('denda', 0);
            } elseif ($this->status == 'terlambat') {
                $query->where('status', 'dikembalikan')->where('denda', '>', 0);
            } elseif ($this->status == 'ditolak') {
                $query->where('status', 'ditolak');
            }
        }

        // Filter kategori
        if ($this->kategori) {
            $query->whereHas('barang', function($q) {
                $q->where('kategori_id', $this->kategori);
            });
        }

        // Filter pencarian
        if ($this->search) {
            $query->where(function($q) {
                $q->whereHas('user', function($sub) {
                    $sub->where('name', 'like', "%{$this->search}%");
                })->orWhereHas('barang', function($sub) {
                    $sub->where('nama_barang', 'like', "%{$this->search}%");
                })->orWhere('kode_peminjaman', 'like', "%{$this->search}%");
            });
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'ID Transaksi',
            'Kode Peminjaman',
            'Tanggal Transaksi',
            'Peminjam',
            'Role',
            'NISN/NIP',
            'Email',
            'Nama Barang',
            'Kode Barang',
            'Kategori',
            'Jumlah',
            'Tipe Pinjam',
            'Tanggal Pinjam',
            'Tanggal Kembali',
            'Status',
            'Denda',
            'Alasan',
            'Catatan Pengembalian',
            'Diproses Oleh'
        ];
    }

    public function map($item): array
    {
        static $no = 0;
        $no++;
        
        // Format ID Transaksi
        $transaksiId = 'TRX-' . str_pad($item->id, 6, '0', STR_PAD_LEFT);
        
        // Status text
        if ($item->status == 'dikembalikan' && $item->denda == 0) {
            $status = 'Tepat Waktu';
        } elseif ($item->status == 'dikembalikan' && $item->denda > 0) {
            $status = 'Terlambat (Denda)';
        } elseif ($item->status == 'ditolak') {
            $status = 'Ditolak';
        } else {
            $status = ucfirst($item->status);
        }
        
        // Tanggal
        $tglPinjam = $item->tipe_pinjam == 'hari'
            ? Carbon::parse($item->tanggal_pinjam)->format('d/m/Y')
            : Carbon::parse($item->tanggal_pinjam_jam)->format('d/m/Y') . ' ' . $item->jam_pinjam;
        
        $tglKembali = $item->status == 'dikembalikan'
            ? $item->updated_at->format('d/m/Y H:i')
            : ($item->tipe_pinjam == 'hari'
                ? Carbon::parse($item->tanggal_kembali)->format('d/m/Y')
                : Carbon::parse($item->tanggal_pinjam_jam)->format('d/m/Y') . ' ' . $item->jam_kembali);
        
        return [
            $no,
            $transaksiId,
            $item->kode_peminjaman ?? '-',
            $item->created_at->format('d/m/Y H:i'),
            $item->user->name,
            $item->user->role == 'siswa' ? 'Siswa' : 'Petugas',
            $item->user->nisn ?? $item->user->nip ?? '-',
            $item->user->email ?? '-',
            $item->barang->nama_barang,
            'BRG-' . str_pad($item->barang->id, 3, '0', STR_PAD_LEFT),
            $item->barang->kategori->nama_kategori ?? '-',
            $item->jumlah,
            $item->tipe_pinjam == 'hari' ? 'Per Hari' : 'Per Jam',
            $tglPinjam,
            $tglKembali,
            $status,
            $item->denda > 0 ? 'Rp ' . number_format($item->denda, 0, ',', '.') : 'Rp 0',
            $item->alasan ?? $item->alasan_penolakan ?? '-',
            $item->catatan_pengembalian ?? '-',
            $item->diproses_oleh ?? '-'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 11]],
            'A1:T1' => ['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'E5E7EB']]],
        ];
    }
}