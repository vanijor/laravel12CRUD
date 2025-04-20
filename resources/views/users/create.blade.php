@extends('layouts.admin')
@section('content')
    <div class="content">
        <div class="content-title">
            <h1 class="page-title">Cadastrar Usuário</h1>
            <a href="{{ route('users.index') }}" class="btn-info">Listar</a>
        </div>

        <x-alert />

        <form action="{{ route('users.store') }}" method="POST" class="form-container">
            @csrf
            <div class="mb-4">
                <label for="name" class="form-label">Nome</label>
                <input type="text" name="name" class="form-input" placeholder="Digite seu Nome"
                    value="{{ old('name') }}" >
            </div>
            <div class="mb-4">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-input" placeholder="Digite seu Email"
                    value="{{ old('email') }}" >
            </div>
            <div class="mb-4">
                <label for="password" class="form-label">Senha</label>
                <input type="password" name="password" class="form-input" placeholder="Senha de no mínimo 6 dígitos"
                    value="{{ old('password') }}" >
            </div>
            <button type="submit" class="btn-success">Cadastrar</button>
        </form>
    </div>
@endsection
