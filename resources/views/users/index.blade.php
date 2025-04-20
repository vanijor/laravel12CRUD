@extends('layouts.admin')
@section('content')
    <div class="content">
        <div class="content-title">
            <h1 class="page-title">Lista de Usuários</h1>
            <a href="{{ route('users.create') }}" class="btn-info">Cadastrar</a>
        </div>

        <x-alert />

        <div class="table-container">
            <table class="table">
                <thead>
                    <tr class="table-header">
                        <th class="table-header">ID</th>
                        <th class="table-header">Nome</th>
                        <th class="table-header">Email</th>
                        <th class="table-header center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ( $users as $user )
                        <tr class="table-row">
                            <td class="table-cell">{{ $user->id }}</td>
                            <td class="table-cell">{{ $user->name }}</td>
                            <td class="table-cell">{{ $user->email }}</td>
                            <td class="table-actions">
                                <a href="{{ route('users.show', ['user' => $user->id]) }}" class="btn-primary">Visualizar</a>
                                <a href="{{ route('users.edit', ['user' => $user->id]) }}" class="btn-warning">Editar</a>
                                <form id="delete-form-{{ $user->id }}" action="{{ route('users.destroy', ['user' => $user->id]) }}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button class="btn-danger" type="button" onclick="confirmDelete({{ $user->id }})">Apagar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <div class="alert-error">
                            Nenhum usuário encontrado!
                        </div>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="pagination">
            {{ $users->links() }}
        </div>
    </div>
@endsection
