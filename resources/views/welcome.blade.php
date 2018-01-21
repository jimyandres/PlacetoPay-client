@extends('layout')

@section('title', $title)

@section('content')
    <div class="title">
        Place to Pay
    </div>

    <div class="title2 m-b-md">
        Web Service client
    </div>

    <div class="links">
        <a href={{route('payment::start')}}>INICIAR</a>
    </div>
@endsection
