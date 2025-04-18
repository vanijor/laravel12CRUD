@extends('layout.admin')
@section('content')
    <div class="home">
        <h1>Bem Vindo ao Curso de Laravel!</h1>
        <a href="{{ route('users.create') }}" class="btn-primary">Cadastrar</a>
    </div>
@endsection
