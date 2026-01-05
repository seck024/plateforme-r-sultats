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
