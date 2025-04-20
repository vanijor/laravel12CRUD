@extends('layouts.admin')
@section('content')
    <div class="content">
        <div class="content-title">
            <h1 class="page-title">Editar Usuário</h1>
            <span>
                <a href="{{ route('users.index') }}" class="btn-info">Listar</a>
                <a href="{{ route('users.show', ['user' => $user->id]) }}" class="btn-primary">Visualizar</a>
            </span>
        </div>

        <x-alert />

        <form action="{{ route('users.update', ['user' => $user->id]) }}" method="POST" class="form-container">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="form-label">Nome</label>
                <input type="text" name="name" class="form-input" placeholder="Digite seu Nome"
                    value="{{ old('name', $user->name) }}">
            </div>
            <div class="mb-4">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-input" placeholder="Digite seu Email"
                    value="{{ old('email', $user->email) }}">
            </div>

            <button type="submit" class="btn-warning">Salvar</button>
        </form>
    </div>
@endsection
