<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BerandaPeminjamController extends Controller
{
    public function index() {
        return view('peminjam.beranda.index');
    }
}
