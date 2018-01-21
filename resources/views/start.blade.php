<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Raleway', sans-serif;
            font-weight: 100;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .title2 {
            font-size: 42px;
        }

        .m-b-md {
            margin-bottom: 40px;
        }
    </style>
</head>
<body>
<div class="flex-center position-ref full-height">
    @if (Route::has('login'))
        <div class="top-right links">
            @auth
            <a href="{{ url('/home') }}">Home</a>
            @else
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}">Register</a>
                @endauth
        </div>
    @endif

    <div class="content">
        <div class="title">
            Place to Pay
        </div>

        <div class="title2 m-b-md">
            Web Service client
        </div>


        <form action="{{ url('/payment') }}" method="POST">
            {{ csrf_field() }}

            <div>
                <p for="account">Indique el tipo de cuenta con la cual realizará el pago:</p>
            </div>
            <select name="accountCode">
                @foreach($accounts as $account)
                    <option value="{{ $account['accountCode'] }}">{{ $account['accountType'] }}</option>
                    <li></li>
                @endforeach
            </select>
            <div>
                <p for="bank">Seleccione la entidad con la que desea realizar el pago:</p>
            </div>
            <div>
                <select name="bankCode">
                    @foreach($ArrayOfBank as $bank)
'                        <option {{ $bank->bankCode == '1022'? 'selected': '' }} value="{{ $bank->bankCode }}">{{ $bank->bankName }}</option>
                        <li></li>
                    @endforeach
                </select>
            </div>

            <br />

            <div>
                <button type="submit">Continuar</button>
            </div>
        </form>


    </div>
</div>
</body>
</html>
