<?php

namespace App\Services;

use App\Models\Sayur;
use App\Models\StockNotification;

class StockNotificationService
{
    public function checkAndNotify(Sayur $sayur): void
    {
        if ($sayur->jumlah_persediaan >= $sayur->batas_minimum) {
            return;
        }

        $message = $sayur->jumlah_persediaan <= 0
            ? "Stok {$sayur->nama} habis."
            : "Stok {$sayur->nama} menipis ({$sayur->jumlah_persediaan} {$sayur->satuan}).";

        $exists = StockNotification::where('sayur_id', $sayur->id)
            ->whereNull('read_at')
            ->where('message', $message)
            ->exists();

        if (! $exists) {
            StockNotification::create([
                'sayur_id' => $sayur->id,
                'message' => $message,
            ]);
        }
    }
}
