<?php

namespace App\Http\Controllers;

use App\Models\Sayur;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Sayur::whereColumn('jumlah_persediaan', '<', 'batas_minimum')
            ->orWhere('jumlah_persediaan', '<=', 0)
            ->orderBy('jumlah_persediaan')
            ->get()
            ->map(fn(Sayur $sayur) => [
                'sayur_id' => $sayur->id,
                'nama' => $sayur->nama,
                'satuan' => $sayur->satuan,
                'jumlah_persediaan' => $sayur->jumlah_persediaan,
                'batas_minimum' => $sayur->batas_minimum,
                'status_persediaan' => $sayur->status_persediaan,
            ]);

        return response()->json($notifications);
    }
}
