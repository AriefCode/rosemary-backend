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
        $aman = $sayur->where('status_persediaan', 'aman')->count();
        $menipis = $sayur->where('status_persediaan', 'menipis')->count();
        $habis = $sayur->where('status_persediaan', 'habis')->count();

        return response()->json([
            'stats' => [
                'total' => $total,
                'aman' => $aman,
                'menipis' => $menipis,
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
