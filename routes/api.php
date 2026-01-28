<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FiliereController;
use App\Http\Controllers\DiplomeController;
use App\Http\Controllers\AnneeController;
use App\Http\Controllers\Api\EtudiantController;
use App\Http\Controllers\Api\ResultatController;
use App\Http\Controllers\Api\AdminAuthController;

Route::post('admin/login', [AdminAuthController::class, 'login']);
Route::post('admin/logout', [AdminAuthController::class, 'logout']);
Route::get('admin/me', [AdminAuthController::class, 'me']);


/*
|--------------------------------------------------------------------------
| API ROUTES (JSON ONLY)
|--------------------------------------------------------------------------
*/

Route::apiResource('filieres', FiliereController::class);
Route::apiResource('diplomes', DiplomeController::class);
Route::apiResource('annees', AnneeController::class);
Route::apiResource('etudiants', EtudiantController::class);


Route::apiResource('resultats', ResultatController::class);

Route::post('resultats/{id}/valider', [ResultatController::class, 'valider']);
Route::post('resultats/{id}/publier', [ResultatController::class, 'publier']);
Route::get('resultats/taux/{annee_id}', [ResultatController::class, 'tauxReussite']);

