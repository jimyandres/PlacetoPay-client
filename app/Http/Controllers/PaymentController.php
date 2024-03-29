<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mockery\Exception;
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

        if (!Cache::has('ArrayOfBank'))
        {
            try
            {
                $arguments = array(
                    'auth' => self::authentication()
                );

                /** @var ArrayOfBank $resp */
                $resp = $this->client->__call('getBankList', array($arguments));

                /** @var item ArrayOfBank */
                $ArrayOfBank = $resp->getBankListResult->item;

                $expiresAt = now()->addDay(1);

                /** Almacena la lista de Bancos disponibles en cache */
                Cache::put('ArrayOfBank', $ArrayOfBank, $expiresAt);
            }
            catch (Exception $e) /** Hubo un error consumiendo el método getBankList */
            {
                $message = 'No se pudo obtener la lista de Entidades Financieras, por favor intente más tarde';
                Cache::flush();
                return view('start_error', compact('title','message'));
            }
        }
        else
        {
            /** Obtiene de cache la lista de bancos disponibles */
            $ArrayOfBank = Cache::get('ArrayOfBank');
        }

        $accounts = $this->accounts_array;
        $documentsType = $this->documentsType_array;

        return view('start',compact('title', 'ArrayOfBank', 'accounts', 'documentsType'));
    }

    /**
     * Recibe los datos obtenidos en la página de inicio y los almacena en Cache:
     * accountCode, bankCode
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function startRequest ()
    {
        $accountCode = request('accountCode');
        $bankCode = request('bankCode');

        $request = request();

        $payer = self::person($request);

        $arguments = array(
            'auth' => self::authentication(),
            'transaction' => self::transaction($accountCode,$bankCode,$payer),
        );

        $resp = $this->client->__call('createTransaction', array($arguments));

        $responseTransactionResult = $resp->createTransactionResult;

        if ($responseTransactionResult->returnCode == "SUCCESS")
        {
            $bankUrl = $responseTransactionResult->bankURL;
            $transactionID = $responseTransactionResult->transactionID;


            $expiresAt = now()->addHour(1);
            Cache::put('transactionID', $transactionID, $expiresAt);

            return redirect($bankUrl);
        }

        return redirect()->route('payment::start');
    }

    /**
     * Representa la visualización del historial de transacciones en el último día
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function result ()
    {
        /**
         * Titulo que tendrá la vista
         * @var String $title */
        $title = 'Result - Place to Pay';

        $arguments = array(
            'auth' => self::authentication(),
            'transactionID' => Cache::get('transactionID'),
        );

        if (is_null($arguments['transactionID']))
        {
            $TransactionHistory = null;
            return view('result', compact('title', 'TransactionHistory'));
        }

        $resp = $this->client->__call('getTransactionInformation', array($arguments));

        $resp = $resp->getTransactionInformationResult;

        /**
         * Verificar si en Cache NO se tiene historial de transacciones
         */
        if (!Cache::has('TransactionHistory'))
        {
            /** Se almacena en Cache (por un dia) el registro de las transacciones */
            $expiresAt = now()->addDay(1);
            $TransactionHistory = array((string)$resp->transactionID => $resp);
            Cache::put('TransactionHistory', $TransactionHistory,$expiresAt);
        }
        else
        {
            $TransactionHistory = Cache::get('TransactionHistory');


            if (!array_key_exists((string)$resp->transactionID, $TransactionHistory))
            {
                /** Se almacena en Cache (por un dia) el registro de las transacciones */
                $new_transaction = array((string)$resp->transactionID => $resp);
                $TransactionHistory = $TransactionHistory + $new_transaction;
                $expiresAt = now()->addDay(1);
                Cache::put('TransactionHistory', $TransactionHistory,$expiresAt);
            }
        }

        /** Se obtiene el historial de transacciones */
        $TransactionHistory = Cache::get('TransactionHistory');

        return view('result', compact('title','TransactionHistory'));

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

        //  Generación de la semilla
        $seed = date('c');

        $tranKey = sha1($seed.$tranKey);

        $auth = array(
            'login' => $login,
            'tranKey' => $tranKey,
            'seed' => $seed,
        );

        return $auth;
    }

    /**
     * Método para crear un objeto transaction con valores ficticios
     *
     * @param $bankInterface
     * @param $bankCode
     * @param $payer
     * @return array
     */
    private function transaction ($bankInterface, $bankCode, $payer)
    {
        $transaction = array(
            'bankCode' => $bankCode,
            'bankInterface' => $bankInterface,
            'returnURL' => url('/payment/result'),
            'reference' => '#reference',
            'description' => 'Description.',
            'language' => 'ES',
            'currency' => 'COP',
            'totalAmount' => 50000.3,
            'taxAmount' => 150.55,
            'devolutionBase' => 15,
            'tipAmount' => 100,
            'payer' => $payer,
            'shipping' => $payer,
            'ipAddress' => '127.0.0.1',
            'userAgent' => '',
        );

        return $transaction;
    }

    /**
     * Método para crear un objeto person según los datos proporcionados por el usuario
     *
     * @param Request $request
     * @return array
     */
    private function person (Request $request)
    {
        $person = array(
            'document' => $request['document'],
            'documentType' => $request['documentType'],
            'firstName' => $request['firstName'],
            'lastName' => $request['lastName'],
            'company' => $request['company'],
            'emailAddress' => $request['emailAddress'],
            'address' => $request['address'],
            'city' => $request['city'],
            'province' => $request['province'],
            'country' => $request['country'],
            'phone' => $request['phone'],
            'mobile' => $request['mobile'],
        );

        return $person;
    }

    /**
     * Definición de tipos de cuenta para la vista
     * @var array $accounts */
    public $accounts_array = array(
        array(
            'accountCode' => 0,
            'accountType' => 'Persona',
        ),
        array(
            'accountCode' => 1,
            'accountType' => 'Empresa',
        ),
    );

    /**
     * Tipo de documento de identificación de la persona [CC, CE, TI, PPN]
     * @var array $documentsType */
    public $documentsType_array = array(
        array(
        'documentCode' => 'CC',
        'documentType' => 'Cédula de ciudanía colombiana',
        ),
        array(
        'documentCode' => 'CE',
        'documentType' => 'Cédula de extranjería',
        ),
        array(
        'documentCode' => 'TI',
        'documentType' => 'Tarjeta de identidad',
        ),
        array(
        'documentCode' => 'PPN',
        'documentType' => 'Pasaporte',
        ),
        array(
        'documentCode' => 'NIT',
        'documentType' => 'Número de identificación tributaria',
        ),
        array(
        'documentCode' => 'SSN',
        'documentType' => 'Social Security Number',
        )
    );
}
