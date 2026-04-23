<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Barang extends Model
{
    protected $table = 'barangs';

    protected $fillable = [
        'nama_barang',
        'deskripsi',
        'kategori_id',
        'jumlah',
        'stok_tersedia',
        'gambar',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class, 'barang_id');
    }

    // Accessor untuk gambar URL
    public function getGambarUrlAttribute()
    {
        return $this->barang ? Storage::url($this->barang) : null;
    }
    
    // Append accessor ke JSON
    protected $appends = ['gambar_url'];
}
