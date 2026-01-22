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
            'diplome_id' => 'required',
            'annee_id' => 'required',
        ]);

        return Etudiant::create($validated);
    }
}
