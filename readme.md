## About the project

This project is a Soap Client that tests the Web Services of the Place to Pay PSE.

The Soap Client establishes a connection that allows a basic pay process. At the end of the process the user can see the
transaction result and the others stored in cache.

*Note: The "die-time" of the Transactions History is set to 1 day. If at that time none transaction is made, the history will be deleted from the cache.*  

This project was developed with Laravel 5.5.

## Installation

After clone this repo, in the current project location:

1. Install all the dependencies
```
$ composer install
```
2. Create the `.env` file (use `.env.example` as a guide). In the `.env` file, add the following environment configurations
```
PLACETOPAY_WSDL=https://test.placetopay.com/soap/pse/?wsdl
PLACETOPAY_LOCATION=https://test.placetopay.com/soap/pse/
PLACETOPAY_TRANKEY=<YOUR_TRANSACTIONAL_KEY>
PLACETOPAY_LOGIN=<YOUR_ACCESS_ID>
```
3. Serve the app
```
$ php artisan serve
```

## Issues and Security Vulnerabilities

If you discover any bug or security vulnerability, please send an e-mail to Jimy Andres Alzate via [jimyandres.ar@gmail.com](mailto:jimyandres.ar@gmail.com), or 
open a new Issue describing the process flow to replicate the problem.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
