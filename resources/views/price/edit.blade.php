@extends('template.layout')

@section('main')
    <style>
        .form-container {
            max-width: 400px;
            margin: 0 auto;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: bold;
            display: block;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .form-group .btn {
            padding: 10px 20px;
            background-color: #000;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .form-group .btn:hover {
            background-color: #333;
        }

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
    </style>
    <h1 class="page-title">EDITAR PREÇO</h1>
    <div class="form-container">
        <form method="POST" action="{{ route('price.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="inputPrecoUnitario">Preço Unitário:</label>
                <input class="form-control @error('unit_price_catalog') is-invalid @enderror" type="number" step="0.01"
                    id="inputPrecoUnitario" name="unit_price_catalog" value="{{ $price->unit_price_catalog }}" required
                    autofocus>
                @error('unit_price_catalog')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="inputPrecoUnitarioDesconto">Preço Unitário com Desconto:</label>
                <input class="form-control @error('unit_price_catalog_discount') is-invalid @enderror" type="text"
                    id="inputPrecoUnitarioDesconto" name="unit_price_catalog_discount"
                    value="{{ $price->unit_price_catalog_discount }}" required>
                @error('unit_price_catalog_discount')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="inputQuantidadeDesconto">Quantidade de Desconto:</label>
                <input class="form-control @error('qty_discount') is-invalid @enderror" type="text"
                    id="inputQuantidadeDesconto" name="qty_discount" value="{{ $price->qty_discount }}" required>
                @error('qty_discount')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="inputPrecoUnitarioTshirtsProprias">Preço Unitário T-Shirts Próprias:</label>
                <input class="form-control @error('unit_price_own') is-invalid @enderror" type="text"
                    id="inputPrecoUnitarioTshirtsProprias" name="unit_price_own" value="{{ $price->unit_price_own }}"
                    required>
                @error('unit_price_own')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="inputPrecoUnitarioTshirtsPropriasDesconto">Preço Unitário T-Shirts Próprias com
                    Desconto:</label>
                <input class="form-control @error('unit_price_own_discount') is-invalid @enderror" type="text"
                    id="inputPrecoUnitarioTshirtsPropriasDesconto" name="unit_price_own_discount"
                    value="{{ $price->unit_price_own_discount }}" required>
                @error('unit_price_own_discount')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <button type="submit" class="btn">Atualizar Preço</button>
            </div>
        </form>
    </div>
@endsection
