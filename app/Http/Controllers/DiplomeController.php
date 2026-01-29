<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Diplome;
use Illuminate\Http\Request;

class DiplomeController extends Controller
{
    public function index()
    {
        return Diplome::with('filiere')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nom' => 'required',
            'filiere_id' => 'required|exists:filieres,id',
        ]);

        return Diplome::create($data);
    }


    public function destroy(Diplome $diplome)
    {
        // supprimer les étudiants liés
        $diplome->etudiants()->delete();

        // supprimer le diplôme
        $diplome->delete();

        return response()->json([
            'message' => 'Diplôme supprimé avec succès'
        ]);
    }
}
