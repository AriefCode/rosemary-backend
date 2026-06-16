<?php

namespace Database\Seeders;

use App\Models\Restoran;
use Illuminate\Database\Seeder;

class RestoranSeeder extends Seeder
{
    public function run(): void
    {
        Restoran::create([
            'nama' => 'Warung Sehat Jaya',
            'alamat' => 'Jl. Melati No. 12, Bandung',
            'kontak' => '081234567890',
        ]);

        Restoran::create([
            'nama' => 'Resto Hijau',
            'alamat' => 'Jl. Mawar No. 5, Jakarta',
            'kontak' => '081298765432',
        ]);
    }
}
