<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('peminjamans', function (Blueprint $table) {
            $table->unsignedBigInteger('denda_terlambat')->default(0)->after('denda');
            $table->unsignedBigInteger('denda_kondisi')->default(0)->after('denda_terlambat');
        });
    }

    public function down(): void
    {
        Schema::table('peminjamans', function (Blueprint $table) {
            $table->dropColumn(['denda_terlambat', 'denda_kondisi', 'kondisi_saat_kembali']);
        });
    }
};
