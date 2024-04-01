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

        .table-container {
            margin-bottom: 20px;
        }

        .table-container table {
            width: 100%;
            border-collapse: collapse;
        }

        .table-container th,
        .table-container td {
            padding: 10px;
            border: 1px solid #ccc;
        }

        .table-container th {
            background-color: #f1f1f1;
            font-weight: bold;
            text-align: left;
        }

        .dropdown-content.orderItems {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            left: 50%;
            transform: translateX(-50%);
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .order-details-table td {
            background-color: #fff9f6;
        }

        .dropdown.active .dropdown-content.orderItems {
            display: block;
        }

        .dropdown-item.orderItems {
            padding: 10px;
            cursor: pointer;
        }

        .order-details-table {
            width: 100%;
            border-collapse: collapse;
        }

        .order-details-table th,
        .order-details-table td {
            padding: 10px;
            border: 1px solid #ccc;
        }

        .order-details-table th {
            background-color: #f1f1f1;
            font-weight: bold;
            text-align: left;
        }

        .clickable {
            cursor: pointer;
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


        .form-container .form-group .btn-icon {
            margin-right: 5px;
        }

        .date-input {
            appearance: none;
            background-color: #f8fafc;
            border: 1px solid #ced4da;
            border-radius: 0.375rem;
            padding: 0.375rem 0.75rem;
            font-size: 0.9rem;
            font-weight: 400;
            line-height: 1.6;
            width: 100%;
            margin-left: 3px;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .btn-icon {
            position: relative;
        }

        .btn-icon-right {
            position: absolute;
            font-size: 10px;
            bottom: 6px;
            right: 6px;
        }

        .labelNome {
            width: 115px;
        }

        .tshirtEstampa {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
        }

        .tshirtEstampa img {
            width: 80px;
            height: 80px;
        }

        .tshirtEstampa .estampa {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width:38px;
            height: 38px;
            z-index: 1;
        }

        .cancelado {
            color: #ff0000;
        }

        .pago {
            color: #1bb21b;
        }

        .pago, .pendente, .cancelado, .fechado{
            font-weight: bold;
        }

        .pendente {
            color: #0066ff;
        }

        .fechado {
            color: #808080;
        }
    </style>

    <h1 class="page-title">Encomendas</h1>
    <div>
        <form method="GET" action="{{ route('order.index') }}" class="form-container">
            @if (Auth::user()->user_type == 'A')
                <div class="form-group">
                    <label for="name" class="labelNome">Nome Cliente:</label>
                    <select name="user" id="name">
                        <option {{ old('status', $filterByUser) === '' ? 'selected' : '' }} value="">Todos os clientes
                        @foreach ($users as $user)
                            <option {{ old('user', $filterByUser) == $user->id ? 'selected' : '' }}
                                value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
            @endif
            @include('order.shared.formfields', ['view' => 'order.index'])
        </form>
    </div>
    @include('order.shared.table', ['encomendas' => $encomendas, 'user_type' => Auth::user()->user_type])
@endsection
