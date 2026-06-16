<?php

namespace App\Http\Controllers;

use App\Models\Restoran;
use Illuminate\Http\Request;

class RestoranController extends Controller
{
    public function index()
    {
        return response()->json(Restoran::orderBy('nama')->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string|max:255',
            'kontak' => 'nullable|string|max:50',
        ]);

        $restoran = Restoran::create($data);

        return response()->json($restoran, 201);
    }

    public function show(Restoran $restoran)
    {
        return response()->json($restoran);
    }

    public function update(Request $request, Restoran $restoran)
    {
        $data = $request->validate([
            'nama' => 'sometimes|string|max:255',
            'alamat' => 'nullable|string|max:255',
            'kontak' => 'nullable|string|max:50',
        ]);

        $restoran->update($data);

        return response()->json($restoran->fresh());
    }

    public function destroy(Restoran $restoran)
    {
        if ($restoran->orderan()->exists()) {
            return response()->json([
                'message' => 'Restoran tidak dapat dihapus karena masih memiliki orderan.',
            ], 422);
        }

        $restoran->delete();

        return response()->json(['message' => 'Restoran berhasil dihapus.']);
    }
}
