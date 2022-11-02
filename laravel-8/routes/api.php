<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EletroDomesticoController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


// List artigos
Route::get('listar-eletro-domestico', [EletroDomesticoController::class, 'get']);

// List marcas
Route::get('listar-marcas', [EletroDomesticoController::class, 'getMarcas']);

// List single artigo
Route::get('eletro-domestico/{id}', [EletroDomesticoController::class, 'show']);

// Create new artigo
Route::post('eletro-domestico', [EletroDomesticoController::class, 'store']);

// Update artigo
Route::put('eletro-domestico/{id}', [EletroDomesticoController::class, 'update']);

// Delete artigo
Route::delete('eletro-domestico/{id}', [EletroDomesticoController::class,'destroy']);
