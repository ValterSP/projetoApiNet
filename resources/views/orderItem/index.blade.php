@extends('template.layout')

@section('header-title', 'Lista de Encomendas')

@section('main')

    <title>Itens Encomendados</title>
    <style>
        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
    <table>
        <thead>
            <tr>
                <th>id</th>
                <th>Order_ID</th>
                <th>Imagem Tshirt_id</th>
                <th>Codigo Cor</th>
                <th>Tamanho</th>
                <th>Quantidade</th>
                <th>Preço Unitario</th>
                <th>Sub Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orderItems as $orderItem)
                <tr>
                    <td>{{ $orderItem->id }}</td>
                    <td>{{ $orderItem->order_id }}</td>
                    <td>{{ $orderItem->tshirt_image_id }}</td>
                    <td>{{ $orderItem->color_code }}</td>
                    <td>{{ $orderItem->size }}</td>
                    <td>{{ $orderItem->qty }}</td>
                    <td>{{ $orderItem->unit_price }}</td>
                    <td>{{ $orderItem->sub_total }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div>
        {{ $orderItems->links() }}
    </div>


@endsection
