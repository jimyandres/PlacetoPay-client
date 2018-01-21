@extends('layout')

@section('title', $title)

@section('content')
    <div class="title">
        Place to Pay
    </div>

    <div class="title2 m-b-md">
        Web Service client
    </div>


    <form action="{{ route('payment::start') }}" id="start" method="POST">
        {{ csrf_field() }}

        <div>
            <p for="account">Indique el tipo de cuenta con la cual realizará el pago:</p>
        </div>
        <select name="accountCode">
            @foreach($accounts as $account)
                <option value="{{ $account['accountCode'] }}">{{ $account['accountType'] }}</option>
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
            <a href="#" onclick="document.getElementById('start').submit()" class="button">Continuar</a>
        </div>
    </form>
@endsection

