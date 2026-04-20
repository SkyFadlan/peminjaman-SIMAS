<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('peminjamans', function (Blueprint $table) {
            $table->string('kondisi_saat_kembali')->nullable()->after('alasan_penolakan');
            $table->text('catatan_pengembalian')->nullable()->after('kondisi_saat_kembali');
            $table->boolean('denda_bayar')->default(false)->after('denda');
            $table->unsignedBigInteger('diproses_oleh')->nullable()->after('disetujui_oleh');
            
            $table->foreign('diproses_oleh')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('peminjamans', function (Blueprint $table) {
            $table->dropForeign(['diproses_oleh']);
            $table->dropColumn([
                'kondisi_saat_kembali',
                'catatan_pengembalian',
                'denda_bayar',
                'diproses_oleh'
            ]);
        });
    }
};