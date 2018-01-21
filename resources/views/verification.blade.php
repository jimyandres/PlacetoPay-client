@extends('layout')

@section('title', $title)

@section('content')
    <div class="title">
        Place to Pay
    </div>

    <div class="title2 m-b-md">
        Web Service client
    </div>


    <form action="{{ route('payment::verification') }}" id="verification" method="POST">
        {{ csrf_field() }}

        <div>
            <p for="account">Indique el tipo de cuenta con la cual realizará el pago:</p>
        </div>
        <div>
            @foreach($accounts as $account)
                <input type="radio" name="accountCode"  value="{{ $account['accountCode'] }}">{{ $account['accountType'] }}<br>
            @endforeach
        </div>
        <div>
            <a class="button" href="{{ route('payment::register_account') }}">Quiero registrarme ahora</a>
        </div>
        <div>
            <span>E-mail:</span>
            <input type="email" name="email">
        </div>

        <br />

        <div>
            <a href="{{ url('/') }}" class="button">Abandonar el pago</a>
            <a href="#" onclick="document.getElementById('verification').submit()" class="button">Continuar</a>
        </div>
    </form>
@endsection