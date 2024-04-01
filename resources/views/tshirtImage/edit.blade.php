@extends('template.layout')

@section('main')
    <style>
        .form-container {
            max-width: 450px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .form-content {
            flex: 1;
        }

        .form-image {
            margin-left: 20px;
            display: flex;
            align-items: center;
        }

        .form-group {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }

        .form-group label {
            font-weight: bold;
            display: block;
            width: 120px;
        }

        .form-group input[type="text"],
        .form-group input[type="file"],
        .form-group textarea,
        .form-group select {
            flex: 1;
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

        .form-group .btn-success {
            background-color: limegreen;
            color: #fff;
            border-radius: 5px;
            margin-left: 10px;
            margin-right: 10px;
        }

        .form-group .btn-success:hover {
            background-color: green;
        }

        .form-group .btn-danger {
            background-color: red;
            color: #fff;
            border-radius: 5px;
            margin-left: 5px;
        }

        .form-group .btn-danger:hover {
            background-color: rgb(177, 0, 0);
        }

        .imagemTshirt {
            width: 150px;
            height: 150px;
        }
    </style>
    <h1>Editar Imagem</h1>
    <div class="form-container">
        <div class="form-content">
            <form method="POST" action="@if (Auth::user()->user_type == 'A') {{ route('tshirtImage.update', [$tshirtImage]) }} @else {{ route('tshirtImage.updateOwn', [$tshirtImage]) }} @endif" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="inputName">Nome:</label>
                    <input class="form-control @error('name') is-invalid @enderror" type="text" id="inputName"
                        name="name" value="{{ $tshirtImage->name }}" required autofocus>
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="inputDescription">Descrição:</label>
                    <textarea class="form-control" id="inputDescription" name="description" rows="4">{{ $tshirtImage->description }}</textarea>
                </div>
                @if(Auth::user()->user_type == 'A')
                    <div class="form-group">
                        <label for="inputCategoryId">Categoria: </label>
                        <select name="category_id" id="inputCategoryId">
                            <option value="">
                                Sem categoria
                            </option>
                            @foreach ($categorias as $categorie)
                                <option value="{{ $categorie->id }}">
                                    {{ $categorie->name }}
                                </option>
                            @endforeach
                        </select>
                        <a href="{{ route('categorie.create') }}" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i></a>
                        <a href="{{ route('categorie.index') }}" class="btn btn-dark"><i
                                class="fas fa-eye"></i></a>
                        @error('category_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                @endif
                <input type="hidden" value="{{ $tshirtImage->image_url }}", id="image" name="image">
                <div class="form-group">
                    <button type="submit" class="btn">Editar Imagem</button>
                </div>
            </form>
        </div>
        @if(Auth::user()->user_type == 'C')
            <div class="form-image">
                <img src="data:image/png;base64, {{ base64_encode(Storage::disk('tshirt_images_private')->get($tshirtImage->image_url)) }}" alt="" class="imagemTshirt">
            </div>
        @else
            <div class="form-image">
                <img src="{{ asset('storage/tshirt_images/' . $tshirtImage->image_url) }}" class="imagemTshirt">
            </div>
        @endif

    </div>
@endsection
