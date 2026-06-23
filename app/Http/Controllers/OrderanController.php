<?php

namespace App\Http\Controllers;

use App\Models\DetailOrderan;
use App\Models\Orderan;
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
            'items.*.jumlah' => 'required|numeric|min:0.01',
        ]);

        $orderan = DB::transaction(function () use ($data, $request) {
            $orderan = Orderan::create([
                'restoran_id' => $data['restoran_id'],
                'karyawan_id' => $request->user()->id,
                'tanggal_orderan' => $data['tanggal_orderan'],
                'status' => 'pending',
            ]);

            foreach ($data['items'] as $item) {
                DetailOrderan::create([
                    'orderan_id' => $orderan->id,
                    'sayur_id' => $item['sayur_id'],
                    'jumlah' => $item['jumlah'],
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

    public function update(Request $request, Orderan $orderan)
    {
        if ($orderan->status !== 'pending') {
            return response()->json(['message' => 'Hanya orderan pending yang dapat diubah.'], 422);
        }

        $data = $request->validate([
            'restoran_id' => 'sometimes|exists:restoran,id',
            'tanggal_orderan' => 'sometimes|date',
            'items' => 'sometimes|array|min:1',
            'items.*.sayur_id' => 'required_with:items|exists:sayur,id',
            'items.*.jumlah' => 'required_with:items|numeric|min:0.01',
        ]);

        $orderan = DB::transaction(function () use ($data, $orderan) {
            $orderan->update(array_filter([
                'restoran_id' => $data['restoran_id'] ?? null,
                'tanggal_orderan' => $data['tanggal_orderan'] ?? null,
            ], fn($v) => $v !== null));

            if (isset($data['items'])) {
                $orderan->detailOrderan()->delete();

                foreach ($data['items'] as $item) {
                    DetailOrderan::create([
                        'orderan_id' => $orderan->id,
                        'sayur_id' => $item['sayur_id'],
                        'jumlah' => $item['jumlah'],
                    ]);
                }
            }

            return $orderan;
        });

        return response()->json(
            $orderan->load(['restoran', 'karyawan', 'detailOrderan.sayur'])
        );
    }

    public function destroy(Orderan $orderan)
    {
        if ($orderan->status !== 'pending') {
            return response()->json(['message' => 'Hanya orderan pending yang dapat dihapus.'], 422);
        }

        $orderan->delete();

        return response()->json(null, 204);
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
