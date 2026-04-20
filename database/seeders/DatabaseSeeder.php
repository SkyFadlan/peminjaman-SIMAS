<?php

namespace Database\Seeders;

use App\Models\DendaKondisi;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        DendaKondisi::updateOrCreate(
            ['kode' => 'RUSAK_RINGAN'],
            ['nama' => 'Rusak Ringan', 'jumlah' => 50000, 'keterangan' => 'Biaya perbaikan kerusakan ringan']
        );

        DendaKondisi::updateOrCreate(
            ['kode' => 'RUSAK_BERAT'],
            ['nama' => 'Rusak Berat', 'jumlah' => 100000, 'keterangan' => 'Biaya perbaikan kerusakan berat']
        );

        DendaKondisi::updateOrCreate(
            ['kode' => 'HILANG'],
            ['nama' => 'Hilang', 'jumlah' => 200000, 'keterangan' => 'Biaya penggantian barang hilang']
        );
    }
}
