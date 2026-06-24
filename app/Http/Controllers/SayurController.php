<?php

namespace App\Http\Controllers;

use App\Models\Sayur;
use Illuminate\Http\Request;

class SayurController extends Controller
{

    public function index()
    {
        return response()->json(Sayur::orderBy('nama')->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'satuan' => 'required|string|max:50',
            'jumlah_persediaan' => 'required|integer|min:0',
            'batas_minimum' => 'nullable|integer|min:0',
        ]);

        $sayur = Sayur::create($data);

        return response()->json($sayur, 201);
    }

    public function show(Sayur $sayur)
    {
        return response()->json($sayur);
    }

    public function update(Request $request, Sayur $sayur)
    {
        $data = $request->validate([
            'nama' => 'sometimes|string|max:255',
            'satuan' => 'sometimes|string|max:50',
            'jumlah_persediaan' => 'sometimes|integer|min:0',
            'batas_minimum' => 'sometimes|integer|min:0',
        ]);

        $sayur->update($data);

        return response()->json($sayur->fresh());
    }

    public function destroy(Sayur $sayur)
    {
        $sayur->delete();

        return response()->json(['message' => 'Sayur berhasil dihapus.']);
    }
}
