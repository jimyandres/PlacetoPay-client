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

/*
 * Presenta la página de bienvenida
 */
Route::get('/', 'PaymentController@index');

/*
 * Grupo de rutas englobadas con Payment
 */
Route::group(['as' => 'payment::', 'prefix' => 'payment'], function () {

    /*
     * (paso 1.Listar Bancos)
     * Presenta la página de inicio
     */

    Route::get('', [
        'as' => 'start',
        'uses' => 'PaymentController@startView'
    ]);

    /*
     * Se obtiene datos requeridos en la página de
     * inicio, redirecciona a la página de verificación
     */
    Route::post('', [
        'as' => 'start',
        'uses' => 'PaymentController@startRequest'
    ]);

    /*
     * (paso 4.Presentación de resultado de operación
     */
    Route::get('result', [
        'as' => 'result_payment',
        'uses' => 'PaymentController@result'
    ]);
});

// Rutas temporales
Route::get('/{type}', 'PaymentController@webServiceInfo');