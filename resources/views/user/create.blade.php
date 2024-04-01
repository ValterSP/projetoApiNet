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
        .form-group input[type="email"],
        .form-group input[type="password"],
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
    <h1>Criar Utilizador</h1>
    <div class="form-container">
        <form method="POST" action="{{ route('user.store') }}">
            @csrf
            <div class="form-group">
                <label for="inputName">Nome:</label>
                <input class="form-control @error('name') is-invalid @enderror" type="text" id="inputName" name="name"
                    value="{{ old('name'), $user->name }}" required autofocus>
                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="inputEmail">Email:</label>
                <input class="form-control @error('email') is-invalid @enderror" type="email" id="inputEmail"
                    name="email" value="{{ old('email'), $user->email }}" required>
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="inputPassword">Password:</label>
                <input class="form-control @error('password') is-invalid @enderror" type="password" id="inputPassword"
                    name="password" required>
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="inputUserType">Tipo de utilizador:</label>
                <select id="inputUserType" name="user_type" class="@error('user_type') is-invalid @enderror" required>
                    <option value="A">Admin</option>
                    <option value="E">Empregado</option>
                </select>
                @error('user_type')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <button type="submit" class="btn">Criar Utilizador</button>
            </div>
        </form>
    </div>
@endsection
