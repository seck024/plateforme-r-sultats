<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FiliereController;
use App\Http\Controllers\DiplomeController;
use App\Http\Controllers\AnneeController;
use App\Http\Controllers\Api\EtudiantController;

/*
|--------------------------------------------------------------------------
| API ROUTES (JSON ONLY)
|--------------------------------------------------------------------------
*/

Route::apiResource('filieres', FiliereController::class);
Route::apiResource('diplomes', DiplomeController::class);
Route::apiResource('annees', AnneeController::class);
Route::apiResource('etudiants', EtudiantController::class);
