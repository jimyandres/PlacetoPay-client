@extends('layout')

@section('title', $title)

@section('content')
    <div class="title2 m-b-md">
        Registro
    </div>

    <form action="{{ route('payment::register_account') }}" id="register" method="POST">
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
            <p for="account">
                Al diligenciar el formulario dale clic al botón "Registrar" y listo, podrás empezar a realizar
                tus pagos con PSE y disfrutar sus beneficios.
            </p>
        </div>
        <div>
            <p>Tipo de Identificación:</p>
            <select name="documentType">
                @foreach($documentsType as $documentType)
                    <option value="{{ $documentType['documentCode'] }}">{{ $documentType['documentType'] }}</option>
                @endforeach
            </select>

            <p>Número de Identificación:</p>
            <input type="number" name="document" min="0">
        </div>
        <div>
            <p>Nombre:</p>
            <input type="text" name="firstName">

            <p>Apellido:</p>
            <input type="text" name="lastName">
        </div>
        <div>
            <p>Número de celular:</p>
            <input type="text" name="mobile">

            <p>Dirección:</p>
            <input type="text" name="address">
        </div>
        <div>
            <p>E-mail:</p>
            <input type="text" name="emailAddress">

            <p>Confirmación e-mail:</p>
            <input type="text" name="emailAddressConfirmation">
        </div>
        <div>
            <input type="checkbox" name="accountCode"  value="{{ $account['accountCode'] }}">
                Acepto voluntariamente los términos, condiciones y el aviso de Política de Privacidad
                de ACH Colombia S.A.
            <a href="#">Ver más</a>
            <br>
        </div>

        <div>
            <a href="{{ URL::previous() }}" class="button">Regresar</a>
            <a href="#" onclick="document.getElementById('register').submit()" class="button">Seguir con el Pago</a>
        </div>
    </form>
@endsection