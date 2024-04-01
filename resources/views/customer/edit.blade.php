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
            <form action="{{ route('user.updatePhoto', ['user' => Auth::user()]) }}" method="POST"
                enctype="multipart/form-data" style="margin-top:20px">
                @csrf
                <input type="file" name="photo" accept="image/*" style="width:50%">
                <button type="submit">Mudar</button>
            </form>
        </div>
        <div class="profile-details">
            <h1 class="profile-name">{{ $user->name }}</h1>
            <p class="profile-email">{{ $user->email }}</p>
            @if ($user->user_type === 'C')
                <form id="form_customer" action="{{ route('customer.update', ['customer' => $customer]) }}" novalidate
                    class="needs-validation" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="nif">NIF:</label>
                        <input type="text" name="nif" id="nif"
                            class="form-control @error('nif') is-invalid @enderror"
                            value="{{ old('nif', $customer->nif) }}">
                        @error('nif')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="address">Morada:</label>
                        <textarea type="text" name="address" id="address" class="form-control">{{ $customer->address ?? '' }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="default_payment_type">Tipo de Pagamento:</label>
                        <select name="default_payment_type" id="payment_type">
                            <option value="">Selecione um tipo de pagamento</option>
                            <option value="MC" {{ ($customer->default_payment_type ?? '') === 'MC' ? 'selected' : '' }}>
                                Mastercard</option>
                            <option value="VISA"
                                {{ ($customer->default_payment_type ?? '') === 'VISA' ? 'selected' : '' }}>VISA</option>
                            <option value="PAYPAL"
                                {{ ($customer->default_payment_type ?? '') === 'PAYPAL' ? 'selected' : '' }}>PAYPAL
                            </option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="default_payment_ref">Referencia do Pagamento:</label>
                        <input type="text" name="default_payment_ref" id="payment_ref" class="form-control"
                            value="{{ $customer->default_payment_ref ?? '' }}">
                    </div>
                    <button type="submit" class="edit-profile-button" form="form_customer">Atualizar Perfil</button>
                </form>
                @if ($user->photo_url)
                    <form action="{{ route('user.remove_photo', ['user' => Auth::user()]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="remove-photo-button">Remover Foto</button>
                    </form>
                @endif
            @endif
        </div>
    </div>
@endsection
