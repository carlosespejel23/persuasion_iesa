<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/dashboard/showAll', [NoticiaController::class, 'showAll']);
Route::middleware('auth:sanctum')->get('/dashboard/show/{noticia}', [NoticiaController::class, 'show']);
Route::middleware('auth:sanctum')->get('/deudores', [DeudorController::class, 'show']);
Route::middleware('auth:sanctum')->get('/deudas/{id}', [ComentarioActualizarDeudaController::class, 'showComment']);