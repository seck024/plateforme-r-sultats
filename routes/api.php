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
