@extends('template.layout')

@section('main')
    <style>
        .form-container {
            max-width: 450px;
            margin: 0 auto;
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


        body.dragover {
            background-color: rgba(0, 0, 0, 0.5);
        }

        .drop-message {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-weight: 800;
            display: none;
            font-size: 40px;
            z-index: 9999;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        body.dragover #dropContainer,
        body.dragover h1{
            filter: blur(5px);
        }
    </style>
    <h1>Criar Imagem</h1>
    <div class="form-container" id="dropContainer">
        <form method="POST"
            action=" @if (Auth::check() && Auth::user()->user_type == 'A') {{ route('tshirtImage.store') }} @else  {{ route('tshirtImage.storeOwn') }} @endif"
            enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="inputName">Nome:</label>
                <input class="form-control @error('name') is-invalid @enderror" type="text" id="inputName" name="name"
                    value="{{ $tshirtImage->name }}" required autofocus>
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
            <div class="form-group">
                <label for="inputImage">Imagem:</label>
                <input class="form-control @error('image') is-invalid @enderror" type="file" id="inputImage"
                    name="image" accept="image/*">
                <img id="imagePreview" src="#" alt="Preview da imagem"
                    style="display: none; width: 100px; height: 100px">
                @error('image')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
                <script>
                    const body = document.body;
                    const inputImage = document.getElementById('inputImage');
                    const imagePreview = document.getElementById('imagePreview');
                    body.addEventListener('dragenter', showDropMessage, false);
                    body.addEventListener('dragover', showDropMessage, false);
                    body.addEventListener('dragleave', hideDropMessage, false);
                    body.addEventListener('drop', hideDropMessage, false);


                    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                        body.addEventListener(eventName, preventDefaults, false);
                    });


                    ['dragenter', 'dragover'].forEach(eventName => {
                        body.addEventListener(eventName, highlight, false);
                    });


                    ['dragleave', 'drop'].forEach(eventName => {
                        body.addEventListener(eventName, unhighlight, false);
                    });


                    body.addEventListener('drop', handleDrop, false);


                    function preventDefaults(event) {
                        event.preventDefault();
                        event.stopPropagation();
                    }

                    function highlight() {
                        body.classList.add('dragover');
                    }

                    function unhighlight() {
                        body.classList.remove('dragover');
                    }


                    function handleDrop(event) {
                        const files = event.dataTransfer.files;
                        if (files.length > 0) {
                            inputImage.files = files;
                            showPreview(files[0]);
                        }
                    }

                    function showPreview(file) {
                        const reader = new FileReader();
                        reader.onload = function() {
                            imagePreview.src = reader.result;
                            imagePreview.style.display = 'block';
                        }
                        reader.readAsDataURL(file);
                    }

                    function showDropMessage() {
                        body.classList.add('dragover');
                        dropMessage.style.display = 'block';
                    }

                    function hideDropMessage() {
                        body.classList.remove('dragover');
                        dropMessage.style.display = 'none';
                    }

                </script>

            </div>
            <div class="form-group">
                @if(Auth::user()->user_type == 'A')
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
                @else
                    <input type="hidden" name="category_id" value="">
                @endif

                @if (Auth::user()->user_type == 'A')
                    <a href="{{ route('categorie.create') }}" class="btn btn-success"><i class="fa fa-plus"
                            aria-hidden="true"></i></a>
                    <a href="{{ route('categorie.index') }}" class="btn btn-dark"><i
                            class="fas fa-eye"></i></a>
                @endif
                @error('category_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            @if (Auth::user()->user_type == 'C')
                <input type="hidden" name="customer_id" value="{{ Auth::user()->id }}">
            @endif
            <div class="form-group">
                <button type="submit" class="btn">Criar Imagem</button>
            </div>
        </form>
    </div>
    <div class="drop-message" id="dropMessage">
        SOLTE A IMAGEM PARA ADICIONAR
    </div>
@endsection
