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

        .form-group input[type="text"] {
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

        .form-color {
            width: 60px;
            height: 50px;
        }

        .form-color input[type="color"] {
            width: 100%;
            height: 100%;
        }
    </style>
    <h1>Criar Cor</h1>
    <div class="form-container">
        <form method="POST" action="{{ route('color.store') }}" enctype="multipart/form-data">
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
                <label for="inputCode">Código Cor:</label>
                <div class="form-color">
                    <input class="form-control" type="color" id="inputCode" name="code" value="" required
                        autofocus>
                </div>
                @error('code')
                    <div class="invalid-feedback" style="display: block">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <button type="submit" class="btn">Criar Cor</button>
            </div>
        </form>

        <script>
            function changeBackground() {
                    
                    fabric.Image.fromURL('caminho/para/imagem-de-fundo.jpg', function(background) {
                    background.scaleToWidth(500);
                    background.scaleToHeight(500);
                    canvas.setBackgroundImage(background, canvas.renderAll.bind(canvas));
                });
            }
        </script>
    </div>
@endsection
