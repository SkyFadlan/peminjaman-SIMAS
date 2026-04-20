<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjamans';

    protected $fillable = [
        'user_id',
        'barang_id',
        'kode_peminjaman',
        'tipe_pinjam',
        'tanggal_pinjam',
        'tanggal_kembali',
        'jam_pinjam',
        'jam_kembali',
        'tanggal_pinjam_jam',
        'jumlah',
        'alasan',
        'alasan_penolakan',
        'kondisi_saat_kembali',
        'catatan_pengembalian',
        'denda',
        'denda_terlambat',
        'denda_kondisi',
        'denda_bayar',
        'status',
        'tanggal_disetujui',
        'disetujui_oleh',
        'diproses_oleh',
    ];

    protected $casts = [
        'tanggal_pinjam' => 'date',
        'tanggal_kembali' => 'date',
        'tanggal_pinjam_jam' => 'date',
        'tanggal_disetujui' => 'datetime',
        'denda_bayar' => 'boolean',
        'denda_terlambat' => 'integer',
        'denda_kondisi' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'disetujui_oleh');
    }

    public function processor()
    {
        return $this->belongsTo(User::class, 'diproses_oleh');
    }
}