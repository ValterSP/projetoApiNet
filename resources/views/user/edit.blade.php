@extends('template.layout')

@section('main')
    <style>
        .profile-container {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .profile-picture {
            margin-right: 0px;
        }

        .profile-image {
            width: 150px;
            height: 150px;
            border-radius: 50%;
        }

        .profile-details {
            font-size: 20px;
        }

        .profile-name {
            margin-bottom: 10px;
        }

        .profile-email {
            color: #777;
            margin-bottom: 10px;
        }

        .profile-info {
            margin-bottom: 10px;
        }

        .edit-profile-button {
            background-color: #000;
            color: #fff;
            margin-top: 20px;
            padding: 8px 16px;
            border-radius: 4px;
            text-decoration: none;
        }

        .edit-profile-button:hover {
            background-color: #fff;
            color: #000;
            margin-top: 20px;
            border: 1px solid black;
        }

        .remove-photo-button {
            background-color: #ff0000;
            color: #fff;
            margin-top: 10px;
            padding: 8px 16px;
            border-radius: 4px;
            text-decoration: none;
        }

        .remove-photo-button:hover {
            background-color: #fff;
            color: #ff0000;
            margin-top: 10px;
            border: 1px solid #ff0000;
        }

        .change-photo-input {
            display: none;
        }

        .upload-photo-button {
            background-color: #000;
            color: #fff;
            padding: 8px 16px;
            border-radius: 4px;
            text-decoration: none;
            cursor: pointer;
        }

        .upload-photo-button:hover {
            background-color: #fff;
            color: #000;
            border: 1px solid black;
        }

        .form-group select {
            display: block;
            width: 100%;
            padding: 0.375rem 0.75rem;
            font-size: .9rem;
            font-weight: 400;
            line-height: 1.6;
            border: 1px solid #ced4da;
            border-radius: 0.375rem;
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }
    </style>
    <div class="profile-container">
        <div class="profile-picture">
            <img src="{{ asset('storage/photos/' . ($user->photo_url ?? 'avatar_unknown.png')) }}" alt="Avatar"
                class="bg-dark rounded-circle profile-image">
            <form action="{{ route('user.updatePhoto', ['user' => $user]) }}" method="POST" enctype="multipart/form-data"
                style="margin-top:20px">
                @csrf
                <input type="file" name="photo" accept="image/*" style="width:50%">
                <button type="submit">Mudar</button>
            </form>
        </div>
        <div class="profile-details">
            <h1 class="profile-name">{{ $user->name }}</h1>
            <p class="profile-email">{{ $user->email }}</p>
            <form id="form_customer" action="{{ route('user.update', ['user' => $user]) }}" novalidate
                class="needs-validation" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Nome:</label>
                    <input type="text" name="name" id="name"
                        class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}">
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="text" name="email" id="email"
                        class="form-control @error('email') is-invalid @enderror" value="{{ $user->email ?? '' }}">

                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="user_type">Tipo Utilizador:</label>
                    <select name="user_type" id="user_type">
                        <option value="E" {{ ($user->user_type ?? '') == 'E' ? 'selected' : '' }}>Empregado</option>
                        <option value="A" {{ ($user->user_type ?? '') == 'A' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>
                <button type="submit" class="edit-profile-button" form="form_customer">Atualizar Perfil</button>
            </form>
            @if ($user->photo_url)
                <form action="{{ route('user.remove_photo', ['user' => $user]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="remove-photo-button">Remover Foto</button>
                </form>
            @endif
        </div>
    </div>
@endsection
