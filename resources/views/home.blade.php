@extends('template.layout')

@section('main')
    <style>
        .imgShirt {
            width: 150px;
            height: 150px;
        }

        .swiper-slide {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .image-container {
            display: flex;
            align-items: flex-start;
            flex-wrap: wrap;
            justify-content: center;
        }

        .image-card {
            position: relative;
            width: 280px;
            height: 350px;
            text-align: center;
            background-color: #f2f2f2;
            border-radius: 5px;
            padding: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .image-card h4 {
            margin-top: 10px;
            font-size: 18px;
            font-weight: bold;
        }

        .image-card p {
            margin-top: 5px;
            font-size: 14px;
            color: #888;
        }

        .swiper-container {
            position: relative;
            overflow: hidden;
            width: 100%;
            height: 100%;
        }

        .swiper-button-next,
        .swiper-button-prev {
            background-image: none;
            color: #fff;
            background-color: #000;
            font-size: 16px;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            transition: background-color 0.3s ease;
            padding: 6px;
            opacity: 0.8;
        }

        .swiper-button-next:hover,
        .swiper-button-prev:hover {
            background-color: #333;
        }


        h1 {
            font-size: 24px;
            font-weight: bold;
        }

        .advertisement {
            background-color: #f1ebdf;
            color: #000;
            padding: 20px;
            text-align: center;
            margin-bottom: 20px;
        }

        .advertisement h2 {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .advertisement p {
            color: #e50010;
            font-size: 40px;
            font-weight: 700;
        }
    </style>
    <div class="advertisement">
        <h2>Aproveite!</h2>
        <p>{{ round(($preco->unit_price_catalog_discount * 100) / $preco->unit_price_catalog) - 100 }}% na compra de
            {{ $preco->qty_discount }} tshirts com a mesma imagem</p>
    </div>
    <h1>As mais vendidas:</h1>
    <div class="swiper-container">
        <div class="swiper-wrapper">
            @foreach($tshirtsMaisVendidas as $key => $tshirtImage)
                <div class="swiper-slide">
                    <div class="image-container">
                        <form method="GET" action="{{ route('catalogo') }}">
                            @csrf
                            <div class="image-card">
                                <input type="hidden" name="name" value="{{$tshirtImage->name}}">
                                <a href="javascript:void(0)" onclick="this.parentNode.parentNode.submit()">
                                    <img src="{{ asset('storage/tshirt_images/' . $tshirtImage->image_url) }}" alt="{{ $tshirtImage->name }}" class="imgShirt">
                                    <h4>{{ $tshirtImage->name }}</h4>
                                    <p>{{ $tshirtImage->description }}</p>
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>

    <script src="{{ asset('js/swiper-bundle.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            swiper = new Swiper('.swiper-container', {
                slidesPerView: 5,
                spaceBetween: 20,
                loop: true,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
            });
        });
    </script>
@endsection
