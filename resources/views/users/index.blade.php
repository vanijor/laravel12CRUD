@extends('layouts.admin')
@section('content')
    <div class="content">
        <div class="content-title">
            <h1 class="page-title">Lista de Usuários</h1>
            <span class="flex space-x-1">
                <a href="{{ route('users.create') }}" class="btn-info">Cadastrar</a>
                <a href="{{ url('generate-pdf-user') . (request()->getQueryString() ? '?' . request()->getQueryString() : '') }}" class="btn-success">Gerar PDF</a>
            </span>
        </div>

        <x-alert />

        <form action="#" class="form-search">
            {{-- pesquisar nome e email --}}
            <input type="text" name="name" class="form-input" placeholder="Pesquisar o nome"
                value="{{ $name }}">
            <input type="text" name="email" class="form-input" placeholder="Pesquisar o email"
                value="{{ $email }}">

            {{-- pesquisar entre datas --}}
            <input type="datetime-local" name="start_date_registration" class="form-input"
                value="{{ $start_date_registration }}">
            <input type="datetime-local" name="end_date_registration" class="form-input"
                value="{{ $end_date_registration }}">


            <div class="form-buttons">
                <button type="submit" class="btn-success">Pesquisar</button>
                <a href="{{ route('users.index') }}" class="btn-primary">Limpar</a>
            </div>
        </form>

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
                    @forelse ($users as $user)
                        <tr class="table-row">
                            <td class="table-cell">{{ $user->id }}</td>
                            <td class="table-cell">{{ $user->name }}</td>
                            <td class="table-cell">{{ $user->email }}</td>
                            <td class="table-actions">
                                <a href="{{ route('users.show', ['user' => $user->id]) }}"
                                    class="btn-primary">Visualizar</a>
                                <a href="{{ route('users.edit', ['user' => $user->id]) }}" class="btn-warning">Editar</a>
                                <form id="delete-form-{{ $user->id }}"
                                    action="{{ route('users.destroy', ['user' => $user->id]) }}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button class="btn-danger" type="button"
                                        onclick="confirmDelete({{ $user->id }})">Apagar</button>
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
