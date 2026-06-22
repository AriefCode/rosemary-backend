<?php

namespace Database\Seeders;

use App\Models\Sayur;
use Illuminate\Database\Seeder;

class SayurSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'nama' => 'Bayam',
                'satuan' => 'Ikat',
                'jumlah_persediaan' => 15.00,
                'batas_minimum' => 5.00,
                'tanggal_masuk' => '2026-06-01',
                'estimasi_ketahanan' => 3,
            ],
            [
                'nama' => 'Wortel',
                'satuan' => 'Kg',
                'jumlah_persediaan' => 2.50,
                'batas_minimum' => 5.00,
                'tanggal_masuk' => '2026-06-10',
                'estimasi_ketahanan' => 14,
            ],
            [
                'nama' => 'Kangkung',
                'satuan' => 'Ikat',
                'jumlah_persediaan' => 0.00,
                'batas_minimum' => 5.00,
                'tanggal_masuk' => null,
                'estimasi_ketahanan' => null,
            ],
            [
                'nama' => 'Tomat',
                'satuan' => 'Kg',
                'jumlah_persediaan' => 8.00,
                'batas_minimum' => 3.00,
                'tanggal_masuk' => '2026-06-15',
                'estimasi_ketahanan' => 7,
            ],
        ];

        foreach ($items as $item) {
            Sayur::create($item);
        }
    }
}
