<?php

namespace App\Http\Controllers;

use App\Models\Orderan;
use App\Models\Sayur;
use Illuminate\Http\Request;

class DaftarBelanjaController extends Controller
{
    public function index(Request $request)
    {
        $items = [];

        $stokRendah = Sayur::whereColumn('jumlah_persediaan', '<', 'batas_minimum')->get();
        foreach ($stokRendah as $sayur) {
            $kekurangan = max($sayur->batas_minimum - $sayur->jumlah_persediaan, 0);
            if ($kekurangan > 0) {
                $items[] = [
                    'sayur_id' => $sayur->id,
                    'nama' => $sayur->nama,
                    'satuan' => $sayur->satuan,
                    'stok_saat_ini' => $sayur->jumlah_persediaan,
                    'jumlah_dibutuhkan' => $kekurangan,
                    'alasan' => 'Stok di bawah batas minimum',
                ];
            }
        }

        $orderanPending = Orderan::with('detailOrderan.sayur')
            ->where('status', 'pending')
            ->get();

        foreach ($orderanPending as $orderan) {
            foreach ($orderan->detailOrderan as $detail) {
                $sayur = $detail->sayur;
                $kekurangan = max($detail->jumlah - $sayur->jumlah_persediaan, 0);

                if ($kekurangan > 0) {
                    $items[] = [
                        'sayur_id' => $sayur->id,
                        'nama' => $sayur->nama,
                        'satuan' => $sayur->satuan,
                        'stok_saat_ini' => $sayur->jumlah_persediaan,
                        'jumlah_dibutuhkan' => $kekurangan,
                        'alasan' => "Orderan #{$orderan->id} (pending)",
                    ];
                }
            }
        }

        $merged = collect($items)
            ->groupBy('sayur_id')
            ->map(function ($group) {
                $first = $group->first();
                return [
                    'sayur_id' => $first['sayur_id'],
                    'nama' => $first['nama'],
                    'satuan' => $first['satuan'],
                    'stok_saat_ini' => $first['stok_saat_ini'],
                    'jumlah_dibutuhkan' => $group->max('jumlah_dibutuhkan'),
                    'alasan' => $group->pluck('alasan')->unique()->implode('; '),
                ];
            })
            ->values();

        return response()->json($merged);
    }
}
