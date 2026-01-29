<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Diplome; //

class DiplomeController extends Controller
{
    public function index()
    {
        return Diplome::with('filiere')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nom' => 'required|string|max:255',
            'filiere_id' => 'required|exists:filieres,id'
        ]);

        $diplome = Diplome::create($data);

        return response()->json($diplome, 201);
    }
}
