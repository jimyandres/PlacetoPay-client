<?php

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

use App\Http\Controllers\PaymentController;

// Presenta la página de bienvenida
Route::get('/', 'PaymentController@index');

// Presenta la página de inicio (paso 1.Listar Bancos)
Route::get('/start', 'PaymentController@start');

// Se obtiene al banco (y tipo de cuenta) seleccionada en la página de
// inicio, redirecciona a la página de verificación si el banco seleccionado existe
Route::post('/start', 'PaymentController@verification');
