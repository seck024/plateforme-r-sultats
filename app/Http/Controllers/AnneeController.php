<?php
namespace App\Http\Controllers;

use App\Models\Annee;
use Illuminate\Http\Request;

class AnneeController extends Controller
{
    public function index()
    {
        return Annee::with('diplome')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'annee' => 'required|digits:4',
            'diplome_id' => 'required|exists:diplomes,id'
        ]);

        return Annee::create($request->all());
    }

    public function show(Annee $annee)
    {
        return $annee->load('diplome');
    }

    public function update(Request $request, Annee $annee)
    {
        $request->validate([
            'annee' => 'required|digits:4',
            'diplome_id' => 'required|exists:diplomes,id'
        ]);

        $annee->update($request->all());

        return $annee;
    }

    public function destroy(Annee $annee)
    {
        $annee->delete();
        return response()->json(['message' => 'Année supprimée']);
    }
}
