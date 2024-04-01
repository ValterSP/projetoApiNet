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

        .table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .table th,
        .table td {
            padding: 10px;
            border: 1px solid #ccc;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .table th {
            background-color: #f0f0f0;
            text-align: left;
        }

        .discount {
            color: #e50010;
            font-size: 14px;
            font-weight: 700;
        }

        .btn-compra {
            background-color: green;
            color: white;
            padding: 5px 10px;
            border-radius: 10px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-compra:hover {
            background-color: darkgreen;
        }

        .btn-limpar {
            background-color: red;
            color: white;
            padding: 7px 10px;
            border-radius: 10px;
            margin-left: 10px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-limpar:hover {
            background-color: darkred;
        }

        .form-container {
            max-width: 500px;
            margin: 0 auto;
        }

        .form-container label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-container input[type="text"],
        .form-container textarea,
        .form-container select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .empty-cart-message {
            font-weight: bold;
            text-align: center;
            margin-top: 50px;
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
            width: 100px;
            height: 100px;
        }

        .tshirtEstampa .estampa {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width:48px;
            height: 48px;
            z-index: 1;
        }


    </style>
    <h1 class="page-title">CARRINHO</h1>
    <div>
        <div style="overflow-x: auto;">
            @if (count($cart) == 0)
                <p class="empty-cart-message">Não existe nenhum item no carrinho</p>
            @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>Tshirt</th>
                            <th>Quantidade</th>
                            <th>Tamanho</th>
                            <th>Preço Total</th>
                            <th>Remover Carrinho</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $precoTotal = 0;
                        @endphp
                        @foreach ($cart as $key => $item)
                            <tr>
                                <td>
                                    <div class="tshirtEstampa">
                                        <img src="{{ asset('storage/tshirt_base/' . $item['color_code'] . '.jpg') }}" alt="">
                                        @if(!$item['private'] == '1')
                                            <img src="{{ asset('storage/tshirt_images/' . $item['image_url']) }}" alt=""
                                                 class="estampa">
                                        @else
                                            <img src="data:image/png;base64, {{ base64_encode(Storage::disk('tshirt_images_private')->get($item['image_url'])) }}" alt="" class="estampa">
                                        @endif
                                    </div>
                                </td>
                                <td>{{ $item['qty'] }}</td>
                                <td>{{ $item['size'] }}</td>
                                @if ($item['qty'] >= $price->qty_discount)
                                    @if($item['private'] == '1')
                                        <td>{{ $item['qty'] * $price->unit_price_own_discount }}€ <span
                                                class="discount">{{ -($price->unit_price_own - $price->unit_price_own_discount) * $item['qty'] }}€</span>
                                        </td>
                                        @php
                                            $precoTotal += $item['qty'] * $price->unit_price_own_discount;
                                        @endphp
                                    @else
                                        <td>{{ $item['qty'] * $price->unit_price_catalog_discount }}€ <span
                                                class="discount">{{ -($price->unit_price_catalog - $price->unit_price_catalog_discount) * $item['qty'] }}€</span>
                                        </td>
                                        @php
                                            $precoTotal += $item['qty'] * $price->unit_price_catalog_discount;
                                        @endphp
                                    @endif
                                @else
                                    @if($item['private'] == '1')
                                        <td>{{ $item['qty'] * $price->unit_price_own }}€</td>
                                        @php
                                            $precoTotal += $item['qty'] * $price->unit_price_own;
                                        @endphp
                                    @else
                                        <td>{{ $item['qty'] * $price->unit_price_catalog }}€</td>
                                        @php
                                            $precoTotal += $item['qty'] * $price->unit_price_catalog;
                                        @endphp
                                    @endif

                                @endif
                                <td class="button-icon-col">
                                    <form method="POST" action="{{ route('cart.remove', ['id' => $key]) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" name="removeFromCart" class="btn btn-danger">
                                            <i class="fas fa-remove"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
        </div>
        <h1>Preço Total: {{ $precoTotal }}€</h1>
        <div class="form-container">
            <form id="formStore" method="POST" action="{{ route('cart.store') }}">
                @csrf
                @if (count($cart) > 0 and Auth::user() ?? false)
                    <input type="hidden" name="total_price" value="{{ $precoTotal }}">
                    <input type="hidden" name="status" value="pending">
                    <label for="nif">NIF:</label>
                    <input type="text" id="nif" name="nif" pattern="[0-9]+" class="@error('nif') is-invalid @enderror" required
                        value="{{ Auth::user()->customer->nif ?? '' }}">
                    <br>
                    @error('nif')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                    <label for="address">Endereço:</label>
                    <textarea id="address" name="address"  class="@error('nif') is-invalid @enderror" required>{{ Auth::user()->customer->address ?? '' }}</textarea>
                    <br>
                    @error('address')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                    <label for="paymentType">Tipo de Pagamento:</label>
                    <select id="paymentType" name="payment_type" required>
                        <option value="PAYPAL"
                            {{ (Auth::user()->customer->default_payment_type ?? '') === 'PAYPAL' ? 'selected' : '' }}>
                            PAYPAL</option>
                        <option value="VISA"
                            {{ (Auth::user()->customer->default_payment_type ?? '') === 'VISA' ? 'selected' : '' }}>VISA
                        </option>
                        <option value="MC"
                            {{ (Auth::user()->customer->default_payment_type ?? '') === 'MC' ? 'selected' : '' }}>MC
                        </option>
                    </select>
                    @error('payment_type')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                    <br>
                    <label for="paymentRef">Referência de Pagamento:</label>
                    <input type="text" id="paymentRef" name="payment_ref" class="@error('payment_ref') is-invalid @enderror" required
                        value="{{ Auth::user()->customer->default_payment_ref ?? '' }}">
                    @error('payment_ref')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                    <br>
                    <label for="address">Notas(opcional):</label>
                    <textarea id="notes" name="notes"></textarea>
                @endif
                <div class="my-4 d-flex justify-content-end">
                    <button type="submit" class="btn-compra" name="ok">Confirmar Compra</button>
                    <button type="submit" class="btn-limpar" name="clear" form="formClear">Limpar Carrinho</button>
                </div>
            </form>
            <form id="formClear" method="POST" action="{{ route('cart.destroy') }}" class="d-none">
                @csrf
                @method('DELETE')
            </form>
            @endif
        </div>
    </div>
@endsection
