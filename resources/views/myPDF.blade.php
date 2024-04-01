<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }

        img {
            width: 80px;
            height: 80px;
        }

        .total {
            text-align: right;
            font-size: 18px;
            font-weight: bold;
        }

        .details {
            margin-top: 20px;
            font-size: 16px;
        }

        .details ul {
            list-style-type: none;
            padding-left: 0;
        }

        .details li {
            margin-bottom: 10px;
        }
        .logo-img{
            float: right;
            width: 150px;
            height: 69px;
        }
    </style>
    <title>Fatura Imagine Shirts</title>
</head>
<body>
<img src="{{asset("/img/iconPreto.png")}}" alt="Logo" class="logo-img">
<h1>Fatura Image Shirts</h1>

<p>Obrigado, {{$encomenda->customer->user->name}}! Agradecemos a sua compra na loja Image Shirts!</p>

<div class="details">
    <p>Detalhes da encomenda:</p>
    <ul>
        <li><strong>NIF:</strong> {{ $encomenda->nif }}</li>
        <li><strong>Morada:</strong> {{ $encomenda->address }}</li>
        <li><strong>Referência de pagamento:</strong> {{ $encomenda->payment_ref }}</li>
        <li><strong>Método de pagamento:</strong> {{ $encomenda->payment_type }}</li>
    </ul>
</div>

<table>
    <thead>
    <tr>
        <th>Imagem</th>
        <th>Cor</th>
        <th>Tamanho</th>
        <th>Quantidade</th>
        <th>Sub Total</th>
    </tr>
    </thead>
    <tbody>
    @php
        $precoTotal = 0;
    @endphp
    @foreach ($encomenda->orderItem as $item)
        <tr>
            <td>
                @if(!Storage::disk('tshirt_images_private')->exists($item->tshirtImage->image_url))
                    <img src="{{ asset('storage/tshirt_images/' . $item->tshirtImage->image_url) }}" alt="">
                @else
                    <img src="data:image/png;base64, {{ base64_encode(Storage::disk('tshirt_images_private')->get($item->tshirtImage->image_url)) }}" alt="">
                @endif
            </td>
            <td> <img src="{{ asset('storage/tshirt_base/' . $item['color_code'] . '.jpg') }}" alt=""> </td>
            <td>{{ $item->size }}</td>
            <td>{{ $item->qty }}</td>
            <td>{{ $item->sub_total }}€</td>

            @php
                $precoTotal += $item->sub_total;
            @endphp
        </tr>
    @endforeach
    </tbody>
</table>
<p class="total">Preço total: {{ $precoTotal }}€</p>

</body>
</html>
