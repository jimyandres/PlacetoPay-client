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

// (paso 1.Listar Bancos)
// Presenta la página de inicio
Route::get('/payment', 'PaymentController@startView');

// Se obtiene al banco (y tipo de cuenta) seleccionada en la página de
// inicio, redirecciona a la página de verificación si el banco seleccionado existe
Route::post('/payment', 'PaymentController@startRequest');

// (paso 2.Página de verificación)
// Se obtiene la página de verificación
Route::get('/payment/verification', 'PaymentController@verificationView');

// Se obtienen los datos según la opción seleccionada (Registrarse o continuar) y redirecciona
Route::post('/payment/verification', 'PaymentController@verificationRequest');

// (paso 2.1.Registro de correo electrónico)
// Presenta la página de registro
Route::get('/payment/register', 'PaymentController@registerView');

// Se obtienen los datos para el registro y redirecciona
Route::post('/payment/register', 'PaymentController@registerRequest');

// (paso 3.Página simuladora de Banco)

// (paso 4.Presentación de resultado de operación
Route::get('/payment/result', 'PaymentController@result');
