@extends('layout')

@section('title', $title)

@section('custom_style', "full-height flex-center position-ref")

@section('content')
    <div class="title">
        Place to Pay
    </div>

    <div class="title2 m-b-md">
        Web Service client
    </div>

    <div class="links">
        <a href={{route('payment::start')}}>INICIAR</a>
        <a href={{route('payment::result_payment')}}>HISTORIAL (1 DIA)</a>
    </div>
@endsection
