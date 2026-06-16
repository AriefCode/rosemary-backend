<?php

namespace App\Http\Controllers;

use App\Models\Orderan;
use App\Models\Sayur;

class LaporanController extends Controller
{
    public function index()
    {
        return response()->json([
            'orderan' => Orderan::with(['restoran', 'karyawan', 'detailOrderan.sayur'])
                ->orderByDesc('tanggal_orderan')
                ->get(),
            'sayur' => Sayur::orderBy('nama')->get(),
        ]);
    }
}
