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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/avisos', function () { //chama a view avisos
    /*XPTO com 1

    $aviso = [
        'data' => '06-09-2022',
        'aviso' => 'Amanhã será o bicentenário da independencia do Brasil',
        'exibir' => true
    ];
    */

    // com vários (passar nome para chamar no blade)
    $avisos = [ 'avisos' => [
            0 => [
                'data' => '06-09-2022',
                'aviso' => 'Amanhã será o bicentenário da independencia do Brasil',
                'exibir' => true
            ],

            1 => [
                'data' => '05-09-2022',
                'aviso' => 'Depois de amanhã será o bicentenário da independencia do Brasil',
                'exibir' => true
            ],

            2 => [
                'data' => '04-09-2022',
                'aviso' => 'Depois de depois amanhã será o bicentenário da independencia do Brasil',
                'exibir' => true
            ]
        ]
    ];

    //o blade disponibilia a var avisos (tira um nivel do vetor e diponibilia a var)
    return view('avisos', $avisos); //chama a rota e quando for chamada retorna uma view
});
//rota resource p/ funcionar como crud (faz q req por métodos diferentes o htttp)
Route::resource('/clientes', App\Http\Controllers\clienteController::class);
Route::resource('/vendedores', App\Http\Controllers\vendedoresController::class); //puxar rota para funcionar
Route::resource('/produtos', App\Http\Controllers\produtosController::class);
