<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DendaKondisi extends Model
{
    protected $table = 'denda_kondisis';

    protected $fillable = [
        'nama',
        'kode',
        'jumlah',
        'keterangan',
    ];

    protected $casts = [
        'jumlah' => 'integer',
    ];
}
