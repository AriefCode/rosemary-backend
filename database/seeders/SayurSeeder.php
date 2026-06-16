<?php

namespace Database\Seeders;

use App\Models\Sayur;
use App\Services\StockNotificationService;
use Illuminate\Database\Seeder;

class SayurSeeder extends Seeder
{
    public function run(): void
    {
        $notificationService = app(StockNotificationService::class);

        $items = [
            ['nama' => 'Bayam', 'satuan' => 'Ikat', 'jumlah_persediaan' => 15, 'batas_minimum' => 5],
            ['nama' => 'Wortel', 'satuan' => 'Kg', 'jumlah_persediaan' => 2, 'batas_minimum' => 5],
            ['nama' => 'Kangkung', 'satuan' => 'Ikat', 'jumlah_persediaan' => 0, 'batas_minimum' => 5],
            ['nama' => 'Tomat', 'satuan' => 'Kg', 'jumlah_persediaan' => 8, 'batas_minimum' => 3],
        ];

        foreach ($items as $item) {
            $sayur = Sayur::create($item);
            $notificationService->checkAndNotify($sayur);
        }
    }
}
