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

        /* Estilos para alinhar botões na mesma linha */
        .criar-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
        }

        .criar-container .criar-botao {
            margin-right: 10px;
            display: flex;
            align-items: center;
        }

        .criar-container .criar-botao .form-control {
            width: 100%;
            margin-left: 5px;
        }

        .criar-container .criar-botao .btn {
            margin-left: 10px;
        }

        .criar-container .criar-botao .btn.criar-btn {
            background-color: #28a745;
            color: #fff;
            border: none;
        }

        .criar-container .criar-botao .btn.criar-btn:hover {
            background-color: #218838;
        }

        .criar-container .criar-botao .btn-icon {
            margin-right: 5px;
        }

        /* Styles for table */
        .cor-table {
            width: 100%;
            border-collapse: collapse;
        }

        .cor-table th,
        .cor-table td {
            padding: 10px;
            border: 1px solid #ccc;
        }

        .cor-table th {
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

        .action-buttons .btn.btn-delete {
            background-color: red;
            color: white;
        }

        .action-buttons .btn.btn-delete:hover {
            background-color: darkred;
        }
    </style>
    <h1 class="page-title">CORES</h1>
    <div>
        <div class="criar-container">
            <div class="criar-botao">
                <a href="{{ route('color.create') }}" class="btn btn-success criar-btn"><i
                        class="fas fa-plus btn-icon"></i>Criar Cor</a>
            </div>
        </div>
    </div>
    <div>
        <table class="cor-table">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Cor</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cores as $cor)
                    @if ($cor->trashed())
                        <tr class="softDeleted">
                        @else
                        <tr>
                    @endif
                    <td>{{ $cor->code }}</td>
                    <td>{{ $cor->name }}</td>
                    <td>
                        <img src="{{ asset('storage/tshirt_base/' . $cor->code .".jpg") }}" alt="" width="80px">
                    </td>
                    <td class="action-buttons">
                        @if ($cor->trashed())
                            <a href="{{ route('color.restore', [$cor->code]) }}" class="btn btn-restore"><i
                                    class="fas fa-trash-restore"></i></a>
                            <form method="POST" action="{{ route('color.destroy', ['code' => $cor->code]) }}"
                                style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" name="delete" class="btn btn-delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('color.destroy', ['code' => $cor->code]) }}"
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
            {{ $cores->withQueryString()->links() }}
        </div>
    </div>
@endsection
