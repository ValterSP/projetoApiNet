    @extends('template.layout')

    @section('main')
        <style>
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

            .price-container {
                display: flex;
                align-items: center;
            }

            .price-label {
                font-size: 10px;
                font-weight: bold;
                color: #333;
                text-transform: uppercase;
                letter-spacing: 2px;
                margin-left: 2px;
                margin-top: 10px;
            }

            .price-value {
                align-items: center;
                text-align: center;
                font-size: 24px;
                font-weight: 900;
                color: white;
                background-color: red;
                padding: 0px 5px;
                border-radius: 10px;
                letter-spacing: 0px;
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

            .image-container {
                display: flex;
                align-items: flex-start;
                flex-wrap: wrap;
                justify-content: center;
            }

            .image-card {
                position: relative;
                width: 20%;
                margin: 10px;
                text-align: center;
                background-color: #f2f2f2;
                border-radius: 5px;
                padding: 10px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }

            .image-card img {
                height: 150px;
                width: 150px;
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

            @media (max-width: 800px) {
                .image-card {
                    position: relative;
                    width: calc(33.33% - 50px);
                }
            }

            @media (max-width: 600px) {
                .image-card {
                    position: relative;
                    width: calc(50% - 50px);
                }
            }

            @media (max-width: 440px) {
                .image-card {
                    position: relative;
                    width: calc(100%);
                }
            }

            .form-container {
                display: flex;
                justify-content: center;
                align-items: center;
                margin-bottom: 20px;
                flex-wrap: wrap;
            }

            .form-group select {
                width: 100%;
                margin-left: 3px;
                padding: 10px;
                border-radius: 5px;
                border: 1px solid #ccc;
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

            .image-card .btn-container {
                position: absolute;
                top: 0;
                right: 0;
            }

            .image-card.trashed {
                background-color: #888;
            }

            .image-card.trashed p {
                color: black;
            }

            .btn.btn-restore {
                background-color: limegreen;
                color: white;
            }

            .btn.btn-restore:hover {
                background-color: rgb(35, 142, 35);
                color: white;
            }

            .btn-edit {
                background-color: #0a58ca;
                color: white;
            }

            .btn-edit:hover {
                background-color: #3075db;
                color: white;
            }

            .fade-in {
                opacity: 0;
                animation: fadeInAnimation ease-in-out 1s forwards;
            }

            .image-card .quantity-container {
                display: block;
                align-items: center;
                margin-top: 5px;
            }

            .image-card .quantity-container label {
                margin-right: 5px;
            }

            .image-card .quantity-container input {
                width: 50px;
                margin-right: 5px;
            }

            @keyframes fadeInAnimation {
                0% {
                    opacity: 0;
                }

                100% {
                    opacity: 1;
                }
            }

            .carrinho-container {
                display: block;
                align-items: center;
                margin-top: 5px;
            }

            .button {
                display: inline-block;
                background-color: green;
                color: #fff;
                border: none;
                padding: 5px 10px;
                border-radius: 10px;
                font-size: 12px;
                font-weight: bold;
                text-transform: uppercase;
                cursor: pointer;
                transition: background-color 0.3s ease;
            }

            .button:hover {
                background-color: darkgreen;
            }

            .rainbow-button {
                display: inline-block;
                background-image: linear-gradient(to right, red, orange, yellow, green, blue, indigo, violet);
                background-size: 200% 100%;
                background-position: left center;
                transition: background-position 0.5s;
                color: black;
                font-weight: bold;
                text-transform: uppercase;
                cursor: pointer;
                border: none;
            }

            .rainbow-button:hover {
                background-position: right center;
            }
        </style>
        <div class="advertisement">
            <h2>Aproveite!</h2>
            <p>{{ round(($preco->unit_price_catalog_discount * 100) / $preco->unit_price_catalog) - 100 }}% na compra de
                {{ $preco->qty_discount }} tshirts com a mesma imagem</p>
        </div>
        <h1 class="page-title">CATÁLOGO</h1>

        <div class="filter-container">
            <form method="GET" action="{{ route('catalogo') }}" class="form-container">
                @csrf
                <div class="form-group">
                    <label for="inputCategoryId">Categoria: </label>
                    <select name="category_id" id="inputCategoryId">
                        <option {{ old('category_id', $filterByCategorie) === '' ? 'selected' : '' }} value="">Todas as
                            categorias</option>
                        @foreach ($categorias as $categorie)
                            <option {{ old('category_id', $filterByCategorie) == $categorie->id ? 'selected' : '' }}
                                value="{{ $categorie->id }}">{{ $categorie->name }}</option>
                        @endforeach
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
                    <a href="{{ route('catalogo') }}" class="btn btn-secondary limpar-btn">Limpar</a>
                </div>
                @if (Auth::check() && Auth::user()->user_type == 'A')
                    <div class="form-group">
                        <a href="{{ route('tshirtImage.create') }}" class="btn btn-success criar-btn"><i
                                class="fas fa-plus btn-icon"></i>Adicionar imagem</a>
                    </div>
                    <div>
                        <a href="{{ route('color.index') }}" class="btn btn-primary rainbow-button" style="margin-right: 10px">Cores</a>
                    </div>
                @endif
                <div class="price-container">
                    <span class="price-value">{{ $preco->unit_price_catalog }}€</span>
                    <span class="price-label">p/unidade</span>
                    @if (Auth::check() && Auth::user()->user_type == 'A')
                        <a href="{{ route('price.edit') }}" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                    @endif
                </div>
            </form>
        </div>
        <div class="image-container fade-in">
            @forelse ($tshirtImages as $tshirtImage)
                @if ((Auth::check() && Auth::user()->user_type == 'A') || !$tshirtImage->trashed())
                    <div class="image-card @if ($tshirtImage->trashed()) trashed @endif">
                        @if (Auth::check() && Auth::user()->user_type == 'A')
                            <div class="btn-container">
                                @if ($tshirtImage->trashed())
                                    <a href="{{ route('tshirtImage.restore', [$tshirtImage->id]) }}" class="btn btn-restore"><i
                                            class="fas fa-trash-restore"></i></a>
                                @endif
                                <a href="{{ route('tshirtImage.edit', [$tshirtImage]) }}" class="btn btn-edit"><i
                                        class="fa fa-edit" aria-hidden="true"></i></a>
                                <form method="POST" action="{{ route('tshirtImage.destroy', [$tshirtImage->id]) }}"
                                    style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" name="delete" class="btn btn-danger">
                                        <i class="fa fa-close" aria-hidden="true"></i>
                                    </button>
                                </form>
                            </div>
                        @endif
                        <img src="{{ asset('storage/tshirt_images/' . $tshirtImage->image_url) }}" alt="">
                        <h4>{{ $tshirtImage->name }}</h4>
                        <p>{{ $tshirtImage->description }}</p>
                        <form method="POST" action="{{ route('cart.add') }}">
                            @csrf
                            <input type="hidden" name="tshirt_image_id" id="tshirt_image_id" value="{{ $tshirtImage->id }}">
                            <input type="hidden" name="image_url" id="image_url" value="{{ $tshirtImage->image_url }}">
                            <select name="color_code" id="color_code" class="select-cor">
                                @foreach ($cores as $cor)
                                    <option value="{{ $cor->code }}" class="optionCor">{{ $cor->name }}</option>
                                @endforeach
                                @error('color_code')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </select>
                            <select name="size" id="size">
                                <option value="XS">XS</option>
                                <option value="S">S</option>
                                <option value="M">M</option>
                                <option value="L">L</option>
                            </select>
                            @error('size')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            <div class="quantity-container">
                                <label for="inputQuantidade">Quantidade:</label>
                                <input type="number" name="qty" id="qty" step="1" max="100" min="1"
                                    value="1" required>
                                @error('qty')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <input type="hidden" name="private" value="0">
                            <div class="carrinho-container">
                                <button type="submit" class="button">
                                    <i class="fas fa-shopping-cart"></i>
                                    Adicionar ao Carrinho
                                </button>
                            </div>
                        </form>
                    </div>
                @endif
            @empty
                <p> Não foram encontradas imagens</p>
            @endforelse
        </div>
        <div class="pagination-container">
            {{ $tshirtImages->withQueryString()->links() }}
        </div>
        </div>
    @endsection
