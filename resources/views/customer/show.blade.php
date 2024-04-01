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
            @if(is_null($user->photo_url))
                <img src="{{ asset('img/avatar_unknown.png')}}" alt="Avatar"
                     class="bg-dark rounded-circle profile-image">
            @else
                <img src="{{ asset('storage/photos/' . ($user->photo_url ?? 'avatar_unknown.png')) }}" alt="Avatar"
                     class="bg-dark rounded-circle profile-image">
            @endif
        </div>
        <div class="profile-details">
            <h1 class="profile-name">{{ $user->name }}</h1>
            <p class="profile-email">{{ $user->email }}</p>
            @if ($user->user_type === 'C')
                <div class="profile-info">
                    <strong>NIF:</strong> {{ $user->customer->nif ?? 'N/A' }}
                </div>
                <div class="profile-info">
                    <strong>Morada:</strong> {{ $user->customer->address ?? 'N/A' }}
                </div>
                <div class="profile-info">
                    <strong>Tipo de Pagamento (Padrão):</strong> {{ $user->customer->default_payment_type ?? 'N/A' }}
                </div>
                <div class="profile-info">
                    <strong>Referencia de Pagamento (Padrão):</strong> {{ $user->customer->default_payment_ref ?? 'N/A' }}
                </div>
            @endif
            <a href="{{ route('customer.edit') }}" class="edit-profile-button">Editar Perfil</a>
        </div>
    </div>
@endsection
