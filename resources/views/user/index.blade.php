@extends('template.layout')

@section('main')
    <style>
        .page-title {
            font-size: 50px;
            font-family: "Arial", sans-serif;
            font-weight: bold;
            margin-bottom: 20px;
            color: #333;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-align: center;
        }

        .pagination-container .pagination {
            display: flex;
            justify-content: center;
            list-style: none;
            margin-left: 10px;
        }

        .pagination-container .page-item {
            margin-right: 5px;
        }

        .pagination-container .page-item .page-link {
            padding: 5px 10px;
            border-radius: 10px;
            color: #000;
            background-color: #fff;
            border: 1px solid #000;
            text-decoration: none;
        }

        .pagination-container .page-item.active .page-link {
            background-color: #000;
            color: #fff;
        }

        .pagination-container .page-link:hover {
            background-color: #000;
            color: #fff;
        }

        .form-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
        }

        .form-container .form-group {
            margin-right: 10px;
            display: flex;
            align-items: center;
        }

        .form-container .form-group .form-control {
            width: 100%;
            margin-left: 5px;
        }

        .form-container .form-group .btn {
            margin-left: 10px;
        }

        .form-container .form-group .btn.filtrar-btn {
            background-color: #000;
            color: #fff;
            border: 1px solid #000;
        }

        .form-container .form-group .btn.filtrar-btn:hover {
            background-color: #fff;
            color: #000;
        }

        .form-container .form-group .btn.limpar-btn {
            background-color: transparent;
            color: #000;
            border: 1px solid #000;
        }

        .form-container .form-group .btn.limpar-btn:hover {
            background-color: #ff0000;
            color: #fff;
        }

        .form-container .form-group .btn.criar-btn {
            background-color: #28a745;
            color: #fff;
            border: none;
        }

        .form-container .form-group .btn.criar-btn:hover {
            background-color: #218838;
        }

        .form-container .form-group .btn-icon {
            margin-right: 5px;
        }

        /* Styles for table */
        .user-table {
            width: 100%;
            border-collapse: collapse;
        }

        .user-table th,
        .user-table td {
            padding: 10px;
            border: 1px solid #ccc;
        }

        .user-table th {
            background-color: #f0f0f0;
            text-align: left;
        }

        .softDeleted {
            background-color: grey;
        }

        .action-buttons .btn {
            margin-right: 5px;
        }

        .action-buttons .btn.btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .action-buttons .btn.btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }

        .action-buttons .btn.btn-info {
            background-color: darkgray;
            border-color: gray;
        }

        .action-buttons .btn.btn-restore {
            background-color: limegreen;
            color: white;
        }

        .action-buttons .btn.btn-restore:hover {
            background-color: rgb(35, 142, 35);
            color: white;
        }

        .action-buttons .btn.btn-info:hover {
            background-color: gray;
            border-color: darkgray;
        }

        .action-buttons .btn.btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .action-buttons .btn.btn-primary:hover {
            background-color: #0069d9;
            border-color: #0062cc;
        }

        .form-group select {
            display: block;
            width: 100%;
            margin-left: 3px;
            padding: 0.375rem 0.75rem;
            font-size: .9rem;
            font-weight: 400;
            line-height: 1.6;
            background-color: #f8fafc;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            border-radius: 0.375rem;
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }
    </style>
    <h1 class="page-title">UTILIZADORES</h1>
    <div>
        <form method="GET" action="{{ route('user.index') }}" class="form-container">
            <div class="form-group">
                <label for="inputCategoryId">Utilizador: </label>
                <select name="user_type" id="inputCategoryId">
                    <option {{ old('user_type', $filterByType) === '' ? 'selected' : '' }} value="">Todos os
                        utilizadores</option>
                    <option {{ old('user_type', $filterByType) == 'A' ? 'selected' : '' }} value="A">Admin</option>
                    <option {{ old('user_type', $filterByType) == 'E' ? 'selected' : '' }} value="E">Empregado</option>
                    <option {{ old('user_type', $filterByType) == 'C' ? 'selected' : '' }} value="C">Cliente</option>
                </select>
            </div>
            <div class="form-group">
                <label for="inputBlocked">Bloqueado:</label>
                <select name="blocked" id="inputBlocked">
                    <option {{ old('blocked', $filterByBlocked) === '' ? 'selected' : '' }} value="">Todos</option>
                    <option {{ old('blocked', $filterByBlocked) == '1' ? 'selected' : '' }} value="1">Sim</option>
                    <option {{ old('blocked', $filterByBlocked) == '0' ? 'selected' : '' }} value="0">Não</option>
                </select>
            </div>
            <div class="form-group">
                <label for="inputNome">Nome: </label>
                <input type="text" class="form-control" name="name" id="inputNome"
                    value="{{ old('name', $filterByNome) }}">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary filtrar-btn" name="filtrar">Filtrar</button>
            </div>
            <div class="form-group">
                <a href="{{ route('user.index') }}" class="btn btn-secondary limpar-btn">Limpar</a>
            </div>
            <div class="form-group">
                <a href="{{ route('user.create') }}" class="btn btn-success criar-btn"><i
                        class="fas fa-plus btn-icon"></i>Criar utilizador</a>
            </div>
        </form>
    </div>
    <div>
        <table class="user-table">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Tipo de Utilizador</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    @if ($user->trashed())
                        <tr class="softDeleted">
                        @else
                        <tr>
                    @endif
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td class="user-type {{ strtolower($user->user_type) }}">{{ getTypeLabel($user->user_type) }}</td>
                    <td class="action-buttons">
                        @if ($user->trashed())
                            <a href="{{ route('user.restore', [$user->id]) }}" class="btn btn-restore"><i
                                    class="fas fa-trash-restore"></i></a>
                        @else
                            @if ($user->user_type == 'A' || $user->user_type == 'E')
                                <a href="{{ route('user.show', [$user]) }}" class="btn btn-dark"><i
                                        class="fas fa-eye"></i></a>
                                <a href="{{ route('user.edit', [$user]) }}" class="btn btn-primary"><i
                                        class="fas fa-edit"></i></a>
                            @endif
                            @if ($user->blocked == '0')
                                <a href="{{ route('user.changeBlock', [$user]) }}" class="btn btn-danger"><i
                                        class="fa fa-ban"></i></a>
                            @else
                                <a href="{{ route('user.changeBlock', [$user]) }}" class="btn btn-success"><i
                                        class="fa fa-lock-open"></i></a>
                            @endif
                            <form method="POST" action="{{ route('user.destroy', ['user' => $user]) }}"
                                style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" name="delete" class="btn btn-info">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        @endif
                    </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination-container">
            {{ $users->withQueryString()->links() }}
        </div>
    </div>
@endsection

@php
    function getTypeLabel($type)
    {
        switch ($type) {
            case 'A':
                return 'Admin';
            case 'E':
                return 'Empregado';
            case 'C':
                return 'Cliente';
        }
    }
@endphp
