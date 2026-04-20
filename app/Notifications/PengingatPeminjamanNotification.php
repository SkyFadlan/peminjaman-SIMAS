<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Notification;

class PengingatPeminjamanNotification extends Notification
{
    use Queueable;

    public $peminjaman;

    public function __construct($peminjaman)
    {
        $this->peminjaman = $peminjaman;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Pengingat Pengembalian',
            'message' => 'Segera kembalikan barang ' . $this->peminjaman->barang->nama_barang . ' (kode: ' . $this->peminjaman->kode_peminjaman . ').',
            'peminjaman_id' => $this->peminjaman->id,
            'barang_id' => $this->peminjaman->barang_id,
            'url' => route('peminjam.aktivitasSaya.show', $this->peminjaman->id),
        ];
    }
}
