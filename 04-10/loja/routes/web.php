<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//rota c/ o dashboard
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard'); //faz o controle

require __DIR__.'/auth.php';

//chama o método middleware

//rota resource p/ funcionar como crud (faz q req por métodos diferentes o htttp)
Route::resource('/clientes', App\Http\Controllers\clienteController::class)->middleware(['auth']); //pega o método do objeto middleware
Route::resource('/vendedores', App\Http\Controllers\vendedoresController::class)->middleware(['auth']); //puxar rota para funcionar
Route::resource('/produtos', App\Http\Controllers\produtosController::class)->middleware(['auth']);
