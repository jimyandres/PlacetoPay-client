<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use SoapClient;
use Illuminate\Support\Facades\Cache;

/**
 * @property SoapClient client
 */
class PaymentController extends Controller
{

    /**
     * PaymentController constructor.
     *
     * El cliente Soap es generado
     *
     */
    public function __construct()
    {
        $this->client = new SoapClient(config('app.ws_wsdl'), array('trace' => true));
        $this->client->__setLocation(config('app.ws_location'));
    }

    /**
     * Representa la página principal de la app
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index ()
    {
        /**
         * Titulo que tendrá la vista
         * @var String $title */
        $title = 'Welcome - Place to Pay';

        return view('welcome', compact('title'));
    }

    /**
     * Representa la página de Inicio del proceso de pago
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function startView ()
    {
        /**
         * Titulo que tendrá la vista
         * @var String $title */
        $title = 'Start - Place to Pay';

        if (!Cache::has('ArrayOfBank')) {

            /** @var ArrayOfBank $resp */
            $resp = $this->client->__call('getBankList', self::authentication());

            /** @var item ArrayOfBank */
            $ArrayOfBank = $resp->getBankListResult->item;

            $expiresAt = now()->addDay(1);

            Cache::put('ArrayOfBank', $ArrayOfBank, $expiresAt);

        }
        else
        {
            $ArrayOfBank = Cache::get('ArrayOfBank');
        }

        /**
         * Definición de tipos de cuenta para la vista
         * @var array $accounts */
        $accounts = array(
            array(
                'accountCode' => 0,
                'accountType' => 'Persona',
            ),
            array(
                'accountCode' => 1,
                'accountType' => 'Empresa',
            ),
        );

        return view('start',compact('title', 'ArrayOfBank', 'accounts'));
    }

    /**
     * Recibe los datos obtenidos en la página de inicio y los almacena en Cache:
     * accountCode, bankCode
     *
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function startRequest ()
    {
        $accountCode = \request('accountCode');
        $bankCode = \request('bankCode');

        $expiresAt = now()->addHour(1);

        Cache::put('accountCode', $accountCode, $expiresAt);
        Cache::put('bankCode', $bankCode, $expiresAt);

        return url('/payment/verification');
    }

    /**
     *
     * Genera estructura Auth para la autenticación con el Web Service
     *
     */
    private function authentication ()
    {
        $login = config('app.ws_login');
        $tranKey = config('app.ws_tranKey');

//        Generación de la semilla
        $seed = date('c');

        $tranKey = sha1($seed.$tranKey);

        $auth = array(
            'auth' => array(
                'login' => $login,
                'tranKey' => $tranKey,
                'seed' => $seed,
            )
        );

        return array($auth);
    }

    /**
     *
     * Temporal method to get the web service info
     *
     * TODO
     * Delete function
     *
     * @param $type
     */
    public function webServiceInfo ($type)
    {
        if (!$type)
            dd($this->client->__getTypes());
        else
            dd($this->client->__getFunctions());
    }

}
