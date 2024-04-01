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

        .form-group input[type="text"],
        .form-group input[type="file"],
        .form-group input[type="description"],
        .form-group select {
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
    </style>
    <h1>Criar Categoria</h1>
    <div class="form-container">
        <form method="POST" action="{{ route('categorie.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="inputName">Nome:</label>
                <input class="form-control @error('name') is-invalid @enderror" type="text" id="inputName" name="name"
                    value="" required autofocus>
                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <button type="submit" class="btn">Criar Categoria</button>
            </div>
        </form>
    </div>
@endsection
