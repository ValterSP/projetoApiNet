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
                <th>Preço Unitario Catalogo</th>
                <th>Preço Unitario Dono</th>
                <th>Desconto preço catalogo</th>
                <th>Desconto preço Dono</th>
                <th>Quantidade desconto</th>

                <th>Sub Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($prices as $price)
                <tr>
                    <td>{{ $price->id }}</td>
                    <td>{{ $price->unit_price_catalog }}</td>
                    <td>{{ $price->unit_price_own }}</td>
                    <td>{{ $price->unit_price_catalog_discount }}</td>
                    <td>{{ $price->unit_price_own_discount }}</td>
                    <td>{{ $price->qty_discount }}</td>

                </tr>
            @endforeach
        </tbody>
    </table>
    <div>
        {{ $prices->links() }}
    </div>


@endsection
