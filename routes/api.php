<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ScanController;
use App\Http\Controllers\Api\ProjectController;

Route::post('/scan', [ScanController::class, 'store']);
Route::get('/projects', [ProjectController::class, 'index']);
Route::get('/projects/{id}/vulnerabilities', [ProjectController::class, 'vulnerabilities']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
