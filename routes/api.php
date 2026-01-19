<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FiliereController;
use App\Http\Controllers\DiplomeController;


Route::apiResource('filieres', FiliereController::class);
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('filieres', FiliereController::class);
});
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('diplomes', DiplomeController::class);
});
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('filieres', FiliereController::class);

    Route::post(
        'filieres/{filiere}/diplomes',
        [FiliereController::class, 'attachDiplomes']
    );
});
Route::get(
    'filieres/{filiere}/diplomes',
    function (\App\Models\Filiere $filiere) {
        return $filiere->diplomes;
    }
);

use App\Http\Controllers\AnneeController;

Route::get('/filieres', [FiliereController::class, 'index']);
Route::post('/filieres', [FiliereController::class, 'store']);

Route::apiResource('diplomes', DiplomeController::class);
Route::apiResource('annees', AnneeController::class);


use App\Http\Controllers\Api\EtudiantController;

Route::get('/etudiants', [EtudiantController::class, 'index']);
Route::post('/etudiants', [EtudiantController::class, 'store']);
Route::get('/etudiants/{id}', [EtudiantController::class, 'show']);
Route::put('/etudiants/{id}', [EtudiantController::class, 'update']);
Route::delete('/etudiants/{id}', [EtudiantController::class, 'destroy']);

