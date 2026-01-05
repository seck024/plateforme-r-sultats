<?php

namespace App\Http\Controllers;

use App\Models\Filiere;
use Illuminate\Http\Request;

class FiliereController extends Controller
{
    public function index()
    {
        return response()->json(Filiere::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255'
        ]);

        $filiere = Filiere::create($request->only('nom'));

        return response()->json($filiere, 201);
    }

    public function show(Filiere $filiere)
    {
        return response()->json($filiere);
    }

    public function update(Request $request, Filiere $filiere)
    {
        $request->validate([
            'nom' => 'required|string|max:255'
        ]);

        $filiere->update($request->only('nom'));

        return response()->json($filiere);
    }

    public function destroy(Filiere $filiere)
    {
        $filiere->delete();

        return response()->json([
            'message' => 'Filière supprimée'
        ]);
    }
}
