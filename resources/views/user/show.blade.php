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
            margin-right: 20px;
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
            padding: 8px 16px;
            border-radius: 4px;
            text-decoration: none;
        }

        .edit-profile-button:hover {
            background-color: #fff;
            color: #000;
            border: 1px solid black;
        }
    </style>
    <div class="profile-container">
        <div class="profile-picture">
            <img src="{{ asset('storage/photos/' . ($user->photo_url ?? 'avatar_unknown.png')) }}" alt="Avatar"
                class="bg-dark rounded-circle profile-image">
        </div>
        <div class="profile-details">
            <h1 class="profile-name">{{ $user->name }}</h1>
            <p class="profile-email">{{ $user->email }}</p>
            <p class="profile-type">{{ getTypeLabel($user->user_type) }}</p>
            <a href="{{ route('user.edit', [$user]) }}" class="edit-profile-button">Editar Perfil</a>
        </div>
    </div>
@endsection


@php
    function getTypeLabel($type)
    {
        switch ($type) {
            case 'A':
                return 'Admin';
            case 'E':
                return 'Empregado';
            case 'C':
                return 'Cliente';
        }
    }
@endphp
