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

/**
 * Presenta la página de bienvenida
 */
Route::get('/', 'PaymentController@index');

/**
 * Grupo de rutas englobadas con Payment
 */
Route::group(['as' => 'payment::', 'prefix' => 'payment'], function () {

    /**
     * (paso 1.Listar Bancos)
     */
    Route::group([],function () {
        /**
         * Presenta la página de inicio
         */
        Route::get('', [
            'as' => 'start',
            'uses' => 'PaymentController@startView'
        ]);

        /**
         * Se obtiene al banco (y tipo de cuenta) seleccionada en la página de
         * inicio, redirecciona a la página de verificación
         */
        Route::post('', [
            'as' => 'start',
            'uses' => 'PaymentController@startRequest'
        ]);
    });

    /**
     * (paso 2.Página de verificación)
     */
    Route::group([],function () {
        /**
         * Se obtiene la página de verificación
         */
        Route::get('verification', [
            'as' => 'verification',
            'uses' => 'PaymentController@verificationView'
        ]);
        /**
         * Se obtienen los datos según la opción seleccionada (Registrarse o continuar)
         * y redirecciona a la página correspondiente
         */
        Route::post('verification', [
            'as' => 'verification',
            'uses' => 'PaymentController@verificationRequest'
        ]);
    });

    /**
     * (paso 2.1.Registro de correo electrónico)
     */
    Route::group([],function () {
        /**
         * Presenta la página de registro
         */
        Route::get('register', [
            'as' => 'register_account',
            'uses' => 'PaymentController@registerView'
        ]);

        /**
         * Se obtienen los datos para el registro y redirecciona
         */
        Route::post('register', [
            'as' => 'register_account',
            'uses' => 'PaymentController@registerRequest'
        ]);
    });

    /**
     * (paso 4.Presentación de resultado de operación
     */
    Route::get('result', [
        'as' => 'result_payment',
        'uses' => 'PaymentController@result'
    ]);
});

// Rutas temporales
Route::get('/{type}', 'PaymentController@webServiceInfo');