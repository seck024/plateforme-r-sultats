<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Etudiant;
use Illuminate\Http\Request;

class EtudiantController extends Controller
{
    public function index()
    {
        return Etudiant::with('filiere')->get();
    }

    public function store(Request $request)
    {
        return Etudiant::create($request->validate([
            'nom' => 'required',
            'filiere_id' => 'required|exists:filieres,id'
        ]));
    }
}

