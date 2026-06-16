<?php

namespace App\Http\Controllers;

use App\Models\DetailOrderan;
use App\Models\Orderan;
use App\Models\Sayur;
use App\Services\ProcessOrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class OrderanController extends Controller
{
    public function __construct(
        private ProcessOrderService $processOrderService
    ) {}

    public function index(Request $request)
    {
        $query = Orderan::with(['restoran', 'karyawan', 'detailOrderan.sayur'])
            ->orderByDesc('tanggal_orderan');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        return response()->json($query->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'restoran_id' => 'required|exists:restoran,id',
            'tanggal_orderan' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.sayur_id' => 'required|exists:sayur,id',
            'items.*.jumlah' => 'required|integer|min:1',
            'items.*.satuan' => 'required|string|max:50',
        ]);

        $orderan = DB::transaction(function () use ($data, $request) {
            $orderan = Orderan::create([
                'restoran_id' => $data['restoran_id'],
                'karyawan_id' => $request->user()->id,
                'tanggal_orderan' => $data['tanggal_orderan'],
                'status' => 'draft',
            ]);

            foreach ($data['items'] as $item) {
                DetailOrderan::create([
                    'orderan_id' => $orderan->id,
                    'sayur_id' => $item['sayur_id'],
                    'jumlah' => $item['jumlah'],
                    'satuan' => $item['satuan'],
                ]);
            }

            return $orderan;
        });

        return response()->json(
            $orderan->load(['restoran', 'karyawan', 'detailOrderan.sayur']),
            201
        );
    }

    public function show(Orderan $orderan)
    {
        return response()->json(
            $orderan->load(['restoran', 'karyawan', 'detailOrderan.sayur'])
        );
    }

    public function proses(Orderan $orderan)
    {
        if ($orderan->status !== 'draft') {
            return response()->json(['message' => 'Hanya orderan draft yang dapat diproses.'], 422);
        }

        $orderan->update(['status' => 'diproses']);

        return response()->json($orderan->fresh(['restoran', 'karyawan', 'detailOrderan.sayur']));
    }

    public function selesai(Orderan $orderan)
    {
        try {
            $orderan = $this->processOrderService->selesai($orderan);
        } catch (InvalidArgumentException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }

        return response()->json($orderan);
    }
}
