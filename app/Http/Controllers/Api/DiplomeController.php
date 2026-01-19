<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DiplomeController extends Controller
{
    public function index()
    {
        return Diplome::with('filiere')->get();
    }

    public function store(Request $request)
    {
        return Diplome::create($request->validate([
            'nom' => 'required',
            'filiere_id' => 'required|exists:filieres,id'
        ]));
    }
}

