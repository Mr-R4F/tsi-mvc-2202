<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(static function() { //prefixo para todos os 'end points'.
	Route::get('/vendedores', [App\Http\Controllers\VendedoresApiController::class, 'index']); //chama método index da classe api controller.
    Route::post('/vendedores', [App\Http\Controllers\VendedoresApiController::class, 'store']); //chama método store da classe api controller.
    Route::delete('/vendedores/{id}', [App\Http\Controllers\VendedoresApiController::class, 'destroy']); //chama método destroy passando o id especificado
    Route::get('/vendedores/{id}', [App\Http\Controllers\VendedoresApiController::class, 'show']); //chama método show passando o id especificado
    Route::put('/vendedores/{id}', [App\Http\Controllers\VendedoresApiController::class, 'update']); //chama método update pelo put
});

Route::prefix('v2')->group(static function() { //prefixo para todos os 'end points'.
	Route::get('/produtos', [App\Http\Controllers\ProdutosApiController::class, 'index']); //chama método index da classe api controller.
    Route::post('/produtos', [App\Http\Controllers\ProdutosApiController::class, 'store']); //chama método store da classe api controller.
    Route::delete('/produtos/{id}', [App\Http\Controllers\ProdutosApiController::class, 'destroy']); //chama método destroy passando o id especificado
    Route::get('/produtos/{id}', [App\Http\Controllers\ProdutosApiController::class, 'show']); //chama método show passando o id especificado
    Route::put('/produtos/{id}', [App\Http\Controllers\ProdutosApiController::class, 'update']); //chama método update pelo put
});

Route::prefix('v3')->group(static function() { //prefixo para todos os 'end points'.
	Route::get('/clientes', [App\Http\Controllers\ClientesApiController::class, 'index']); //chama método index da classe api controller.
    Route::post('/clientes', [App\Http\Controllers\ClientesApiController::class, 'store']); //chama método store da classe api controller.
    Route::delete('/clientes/{id}', [App\Http\Controllers\ClientesApiController::class, 'destroy']); //chama método destroy passando o id especificado
    Route::get('/clientes/{id}', [App\Http\Controllers\ClientesApiController::class, 'show']); //chama método show passando o id especificado
    Route::put('/clientes/{id}', [App\Http\Controllers\ClientesApiController::class, 'update']); //chama método update pelo put
});

