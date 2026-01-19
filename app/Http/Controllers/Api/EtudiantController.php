<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Etudiant;
use Illuminate\Http\Request;

class EtudiantController extends Controller
{
    /**
     * 📌 Liste des étudiants
     * GET /api/etudiants
     */
    public function index()
    {
        return Etudiant::with('diplome')->get();
    }

    /**
     * 📌 Ajouter un étudiant
     * POST /api/etudiants
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'matricule'   => 'required|unique:etudiants,matricule',
            'nom'         => 'required|string|max:100',
            'prenom'      => 'required|string|max:100',
            'diplome_id'  => 'required|exists:diplomes,id',
        ]);

        $etudiant = Etudiant::create($validated);

        return response()->json([
            'message' => 'Étudiant ajouté avec succès',
            'data'    => $etudiant
        ], 201);
    }

    /**
     * 📌 Afficher un étudiant précis
     * GET /api/etudiants/{id}
     */
    public function show($id)
    {
        return Etudiant::with('diplome')->findOrFail($id);
    }

    /**
     * Modifier un étudiant
     * PUT /api/etudiants/{id}
     */
    public function update(Request $request, $id)
    {
        $etudiant = Etudiant::findOrFail($id);

        $validated = $request->validate([
            'matricule'  => 'required|unique:etudiants,matricule,' . $id,
            'nom'        => 'required|string|max:100',
            'prenom'     => 'required|string|max:100',
            'diplome_id' => 'required|exists:diplomes,id',
        ]);

        $etudiant->update($validated);

        return response()->json([
            'message' => 'Étudiant modifié avec succès',
            'data'    => $etudiant
        ]);
    }

    /**
     * 📌 Supprimer un étudiant
     * DELETE /api/etudiants/{id}
     */
    public function destroy($id)
    {
        Etudiant::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Étudiant supprimé avec succès'
        ]);
    }
}
