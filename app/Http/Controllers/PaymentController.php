<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use SoapClient;

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
        $this->client = new SoapClient(env('PLACETOPAY_WSDL'), array('trace' => true));
        $this->client->__setLocation(env('PLACETOPAY_LOCATION'));
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function startView ()
    {
        /**
         * Titulo que tendrá la vista
         * @var String $title */
        $title = 'Start - Place to Pay';

        /** @var ArrayOfBank $resp */
        $resp = $this->client->__call('getBankList', self::authentication());

        /** @var item $resp */
        $resp = $resp->getBankListResult->item;

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

        return view('start',compact('title', 'resp', 'accounts'));
    }


    /**
     *
     * Genera estructura Auth para la autenticación con el Web Service
     *
     */
    private function authentication ()
    {
        $login = env('PLACETOPAY_LOGIN');
        $tranKey = env('PLACETOPAY_TRANKEY');

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
