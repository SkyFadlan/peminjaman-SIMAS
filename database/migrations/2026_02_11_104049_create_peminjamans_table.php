<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peminjamans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('barang_id');
            
            // Kode unik peminjaman (5 karakter)
            $table->string('kode_peminjaman', 5)->unique()->nullable();
            
            // Tipe peminjaman: 'hari' atau 'jam'
            $table->enum('tipe_pinjam', ['hari', 'jam'])->default('hari');
            
            // Untuk peminjaman per hari
            $table->date('tanggal_pinjam')->nullable();
            $table->date('tanggal_kembali')->nullable();
            
            // Untuk peminjaman per jam
            $table->time('jam_pinjam')->nullable();
            $table->time('jam_kembali')->nullable();
            $table->date('tanggal_pinjam_jam')->nullable();
            
            $table->integer('jumlah')->default(1);
            $table->text('alasan')->nullable();
            $table->integer('denda')->default(0);
            $table->enum('status', ['menunggu', 'disetujui', 'dipinjam', 'dikembalikan', 'terlambat', 'ditolak'])->default('menunggu');
            
            $table->timestamp('tanggal_disetujui')->nullable();
            $table->unsignedBigInteger('disetujui_oleh')->nullable();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('barang_id')->references('id')->on('barangs')->onDelete('cascade');
            $table->foreign('disetujui_oleh')->references('id')->on('users')->onDelete('set null');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjamans');
    }
};