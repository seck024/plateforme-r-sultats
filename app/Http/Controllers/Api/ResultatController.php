<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Resultat;
use App\Models\Etudiant;
use Illuminate\Http\Request;
class ResultatController extends Controller
{
    public function index()
    {
        return Resultat::with('etudiant')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'numero_etudiant' => 'required|exists:etudiants,numero_etudiant',
            'annee_id' => 'required|exists:annees,id',
            'statut' => 'required|in:admis,rattrapage,refuse',
        ]);

        //  récupération réelle de l'étudiant
        $etudiant = Etudiant::where(
            'numero_etudiant',
            $validated['numero_etudiant']
        )->first();

        $resultat = Resultat::create([
            'etudiant_id' => $etudiant->id,
            'annee_id' => $validated['annee_id'],
            'statut' => $validated['statut'],
            'valide' => false,
            'publie' => false,
        ]);

        return $resultat;
    }


    /**
    Voir un résultat
     */
    public function show($id)
    {
        return Resultat::with('etudiant')->findOrFail($id);
    }

    /**
    Modifier un résultat
     */
    public function update(Request $request, $id)
    {
        $resultat = Resultat::findOrFail($id);

        $validated = $request->validate([
            'statut' => 'required|in:admis,rattrapage,refuse',
        ]);

        $resultat->update($validated);

        return $resultat;
    }

    /**
    Supprimer un résultat
     */
    public function destroy($id)
    {
        Resultat::destroy($id);

        return response()->json([
            'message' => 'Résultat supprimé'
        ]);
    }

    /**
    Validation interne des résultats
     */
    public function valider($id)
    {
        $resultat = Resultat::findOrFail($id);
        $resultat->valide = true;
        $resultat->save();

        return response()->json([
            'message' => 'Résultat validé'
        ]);
    }

    /**
    Publication des résultats
     */
    public function publier($id)
    {
        $resultat = Resultat::findOrFail($id);

        if (!$resultat->valide) {
            return response()->json([
                'message' => 'Le résultat doit être validé avant publication'
            ], 403);
        }

        $resultat->publie = true;
        $resultat->save();

        return response()->json([
            'message' => 'Résultat publié'
        ]);
    }
    public function tauxReussite($annee_id)
    {
        $admis = Resultat::where('annee_id', $annee_id)
            ->where('statut', 'admis')
            ->count();

        $total = Resultat::where('annee_id', $annee_id)->count();

        $taux = ($admis / $total) * 100;


        return response()->json([
            'annee_id' => $annee_id,
            'taux_reussite' => $taux . '%'
        ]);
    }


}
