@extends('layout')

@section('title', $title)

@section('content')
    <div class="title2 m-b-md">
        Transaction Results (Last day)
    </div>

    @if(!is_null($TransactionHistory))
        @foreach($TransactionHistory as $Transaction)
            <div class="row">
                <div class="column">
                    <strong>ID:</strong>
                    {{ $Transaction->transactionID }}
                </div>
                <div class="column">
                    <strong>Estado:</strong>
                    {{ $Transaction->transactionState }}
                </div>
                <div class="column">
                    <strong>Fecha:</strong>
                    {{ $Transaction->requestDate }}
                </div>
                <div class="column">
                    <strong>Respuesta:</strong>
                    {{ $Transaction->responseReasonText }}
                </div>
            </div>
        @endforeach
    @else
        <div>
            <strong>Transaction History Empty!</strong>
        </div>
        <br />
    @endif
    <a href="{{ url('/') }}" class="button">Regresar</a>

@endsection