@extends('layouts.admin')
@section('content')
    <div class="content">
        <div class="content-title">
            <h1 class="page-title">Detalhes do Usuário</h1>
            <span class="flex space-x-1">
                <a href="{{ route('users.index') }}" class="btn-info">Listar</a>
                <a href="{{ route('users.edit', ['user' => $user->id]) }}" class="btn-warning">Editar</a>
                <a href="{{ route('users.edit-password', ['user' => $user->id]) }}" class="btn-warning">Editar Senha</a>
                <form id="delete-form-{{ $user->id }}" action="{{ route('users.destroy', ['user' => $user->id]) }}" method="POST">
                    @csrf
                    @method('delete')
                    <button class="btn-danger" type="button" onclick="confirmDelete({{ $user->id }})">Apagar</button>
                </form>
            </span>
        </div>

        <x-alert />

        <div class="card">
            <h2 class="card-title">Informações do Usuário</h2>
            <div class="card-content">
                <div class="card-row">
                    <span class="font-bold">ID:</span>
                    <span>{{ $user->id }}</span>
                </div>
                <div class="card-row">
                    <span class="font-bold">Nome:</span>
                    <span>{{ $user->name }}</span>
                </div>
                <div class="card-row">
                    <span class="font-bold">Email:</span>
                    <span>{{ $user->email }}</span>
                </div>
                <div class="card-row">
                    <span class="font-bold">Criado em:</span>
                    <span>{{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y H:i:s') }}</span>
                </div>
                <div class="card-row">
                    <span class="font-bold">Editado em:</span>
                    <span>{{ \Carbon\Carbon::parse($user->updated_at)->format('d/m/Y H:i:s') }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection
