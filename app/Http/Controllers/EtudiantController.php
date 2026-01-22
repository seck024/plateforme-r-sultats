<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Etudiant;
use Illuminate\Http\Request;

class EtudiantController extends Controller
{
    public function index()
    {
        return Etudiant::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'numero_etudiant' => 'required|unique:etudiants',
            'nom' => 'required',
            'prenom' => 'required',
            'diplome_id' => 'required|exists:diplomes,id',
            'annee_id' => 'required|exists:annees,id',
        ]);

        return Etudiant::create($validated);
    }

    public function show($id)
    {
        return Etudiant::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $etudiant = Etudiant::findOrFail($id);

        $validated = $request->validate([
            'numero_etudiant' => 'required',
            'nom' => 'required',
            'prenom' => 'required',
            'diplome_id' => 'required',
            'annee_id' => 'required',
        ]);

        $etudiant->update($validated);

        return $etudiant;
    }

    public function destroy($id)
    {
        Etudiant::destroy($id);
        return response()->json(['message' => 'Supprimé']);
    }
}
