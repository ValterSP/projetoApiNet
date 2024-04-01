<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .title {
            font-size: 24px;
            margin-top: 0;
            margin-bottom: 10px;
        }

        .subtitle {
            font-size: 16px;
            margin-top: 0;
            margin-bottom: 20px;
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

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .table th {
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
            margin-top: 20px;
        }

        .logo-img{
            width: 150px;
            height: 69px;
        }

        .important {
            color: #ff0000;
            font-weight: bold;
        }

        .support-email {
            font-weight: bold;
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
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <img src="data:image/png;base64,{{base64_encode(file_get_contents(public_path('img/iconPreto.png')))}}" alt="Logo" class="logo-img">
        <h1 class="title">Image Shirts</h1>
        <p class="subtitle important">Importante: A sua encomenda foi cancelada</p>
    </div>

    <div class="details">
        <p>Lamentamos informar que a sua encomenda foi cancelada. Para obter mais informações sobre o motivo do cancelamento, por favor entre em contato com o nosso suporte através do seguinte endereço de e-mail:</p>
        <p class="support-email">suporte@imageshirt.com</p>
    </div>

    <table class="table">
        <thead>
        <tr>
            <th>Tshirt</th>
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
                    <div class="tshirtEstampa">
                        <img src="data:image/png;base64,{{ base64_encode(Storage::disk('tshirt_base')->get($item['color_code'] . ".jpg")) }}" alt="">
                        @if(!Storage::disk('tshirt_images_private')->exists($item->tshirtImage->image_url))
                            <img src="data:image/png;base64,{{ base64_encode(Storage::disk('tshirt_images')->get($item->tshirtImage->image_url)) }}" alt="" class="estampa">
                        @else
                            <img src="data:image/png;base64, {{ base64_encode(Storage::disk('tshirt_images_private')->get($item->tshirtImage->image_url)) }}" alt="" class="estampa">
                        @endif
                    </div>
                </td>
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
</div>
</body>
</html>
