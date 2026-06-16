<?php

namespace App\Services;

use App\Models\Orderan;
use App\Models\Sayur;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class ProcessOrderService
{
    public function __construct(
        private StockNotificationService $notificationService
    ) {}

    public function selesai(Orderan $orderan): Orderan
    {
        if ($orderan->status === 'selesai') {
            throw new InvalidArgumentException('Orderan sudah selesai.');
        }

        return DB::transaction(function () use ($orderan) {
            $orderan->load('detailOrderan.sayur');

            foreach ($orderan->detailOrderan as $detail) {
                $sayur = Sayur::lockForUpdate()->find($detail->sayur_id);

                if ($sayur->jumlah_persediaan < $detail->jumlah) {
                    throw new InvalidArgumentException(
                        "Stok {$sayur->nama} tidak cukup. Tersedia: {$sayur->jumlah_persediaan}."
                    );
                }

                $sayur->jumlah_persediaan -= $detail->jumlah;
                $sayur->save();

                $this->notificationService->checkAndNotify($sayur->fresh());
            }

            $orderan->update(['status' => 'selesai']);

            return $orderan->fresh(['restoran', 'karyawan', 'detailOrderan.sayur']);
        });
    }
}
