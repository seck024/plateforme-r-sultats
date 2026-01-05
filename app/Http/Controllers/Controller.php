<?php

namespace App\Http\Controllers;
use App\Models\Diplome;
use Illuminate\Http\Request;

class DiplomeController extends Controller
{
    public function index()
    {
        return response()->json(Diplome::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255'
        ]);

        $diplome = Diplome::create($request->only('nom'));

        return response()->json($diplome, 201);
    }

    public function show(Diplome $diplome)
    {
        return response()->json($diplome);
    }

    public function update(Request $request, Diplome $diplome)
    {
        $request->validate([
            'nom' => 'required|string|max:255'
        ]);

        $diplome->update($request->only('nom'));

        return response()->json($diplome);
    }

    public function destroy(Diplome $diplome)
    {
        $diplome->delete();

        return response()->json(['message' => 'Diplôme supprimé']);
    }
}
abstract class Controller
{
    //
}
