<?php

namespace App\Http\Controllers;

use App\Models\Orderan;
use App\Models\Sayur;

class DashboardController extends Controller
{
    public function index()
    {
        $sayur = Sayur::orderByDesc('updated_at')->get();

        $total = $sayur->count();
        $aman = $sayur->where('status', 'aman')->count();
        $rendah = $sayur->where('status', 'rendah')->count();
        $habis = $sayur->where('status', 'habis')->count();

        return response()->json([
            'stats' => [
                'total' => $total,
                'aman' => $aman,
                'rendah' => $rendah,
                'habis' => $habis,
            ],
            'recent_sayur' => $sayur->take(10)->values(),
            'recent_orderan' => Orderan::with(['restoran', 'karyawan'])
                ->orderByDesc('tanggal_orderan')
                ->take(5)
                ->get(),
        ]);
    }
}
