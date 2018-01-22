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
                    <option {{ $bank->bankCode == '1022'? 'selected': '' }} value="{{ $bank->bankCode }}">{{ $bank->bankName }}</option>
                @endforeach
            </select>
        </div>

        <div class="row">
            <div class="column right">
                <span>Tipo de Identificación:</span>
                <select name="documentType">
                    @foreach($documentsType as $documentType)
                        <option value="{{ $documentType['documentCode'] }}">{{ $documentType['documentType'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="column left">
                <span>Número de Identificación:</span>
                <input type="number" name="document" min="0" value="1088335333">
            </div>
        </div>

        <div class="row">
            <div class="column right">
                <span>Nombre:</span>
                <input type="text" name="firstName" value="Pepito">
            </div>
            <div class="column left">
                <span>Apellido:</span>
                <input type="text" name="lastName" value="Perez">
            </div>
        </div>

        <div class="row">
            <div class="column right">
                <span>Compañía:</span>
                <input type="text" name="company" value="Pepito Perez SA">
            </div>
            <div class="column left">
                <span>E-mail:</span>
                <input type="email" name="emailAddress" value="pepito@mail.com">
            </div>
        </div>

        <div class="row">
            <div class="column right">
                <span>Dirección:</span>
                <input type="text" name="address" value="Mz B Csa 12">
            </div>
            <div class="column left">
                <span>Ciudad:</span>
                <input type="text" name="city" value="Medellín">
            </div>
        </div>

        <div class="row">
            <div class="column right">
                <span>Provincia o departamento:</span>
                <input type="text" name="province" value="Antioquia">
            </div>
            <div class="column left">
                <span>Pais:</span>
                <input type="text" name="country" value="CO" disabled>
            </div>
        </div>

        <div class="row">
            <div class="column right">
                <span>Número de telefonía fija:</span>
                <input type="text" name="phone" value="5555555">
            </div>
            <div class="column left">
                <span>Número de telefonía móvil o celular:</span>
                <input type="text" name="mobile" value="3005555555">
            </div>
        </div>

        <div>
            <a href="{{ URL::previous() }}" class="button">Regresar</a>
            <a href="#" onclick="document.getElementById('start').submit()" class="button">Continuar</a>
        </div>
    </form>
@endsection

