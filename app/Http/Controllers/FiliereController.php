<?php

namespace App\Http\Controllers;

use App\Models\Filiere;
use Illuminate\Http\Request;

class FiliereController extends Controller
{
    public function index()
    {
        return Filiere::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string'
        ]);

        return Filiere::create($request->only('nom'));
    }
}
