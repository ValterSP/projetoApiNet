<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @vite(['resources/sass/app.scss'])
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://kit.fontawesome.com/1d88cd1a08.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://fonts.google.com/specimen/Source+Sans+3">
    <script type="module" src = "https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <link rel="stylesheet"href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.4.6/css/swiper.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.4.6/js/swiper.min.js"></script>
    <title>ImageShirts</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <div class="logo-container">
                <a class="navbar-brand" href="{{ route('root') }}">
                    <img src="/img/iconBranco.png" alt="Logo" class="logo-img">
                </a>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav centrar">
                    <li class="nav-item">
                        <a class="nav-link btn" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn" href="{{ route('catalogo') }}">Catalogo</a>
                    </li>
                    @if (Auth::check() && Auth::user()->user_type == 'A')
                        <li class="nav-item">
                            <a class="nav-link btn" href="{{ route('user.index') }}">Utilizadores</a>
                        </li>
                    @endif
                    @if (Auth::check() && (Auth::user()->user_type == 'A' || Auth::user()->user_type == 'E'))
                        <li class="nav-item">
                            <a class="nav-link btn" href="{{ route('order.index') }}">Encomendas</a>
                        </li>
                    @endif
                    @if (Auth::check() && Auth::user()->user_type == 'C')
                        <li class="nav-item">
                            <a class="nav-link btn" href=" {{ route('tshirtImage.indexOwn') }}"
                                style="width: 140px">Minhas Imagens</a>
                        </li>
                    @endif
                    @if(Auth::check() && Auth::user()->user_type == 'A')
                        <li class="nav-item">
                            <a class="nav-link btn" href="{{ route('estatisticas.index') }}">Estatisticas</a>
                        </li>
                    @endif

                </ul>
            </div>
            <ul class="navbar-nav ms-auto">
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                {{ __('Login') }}
                            </a>
                        </li>
                    @endif
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">
                                {{ __('Register') }}
                            </a>
                        </li>
                    @endif
                @else
                    <div class="ms-auto me-0 me-md-2 my-2 my-md-0 navbar-text name">
                        {{ Auth::user()->name }}
                    </div>
                    <li class="nav-item dropdown" style="margin-right:10px">
                        <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            @if(is_null(Auth::user()->photo_url))
                                <img src="{{ asset('img/avatar_unknown.png') }}"
                                     alt="Avatar" class="bg-dark rounded-circle" width="45" height="45">
                            @else
                                <img src="{{ asset('storage/photos/' . (Auth::user()->photo_url ?? 'avatar_unknown.png')) }}"
                                     alt="Avatar" class="bg-dark rounded-circle" width="45" height="45">
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            @if (Auth::user()->user_type == 'C')
                                <li>
                                    <a class="dropdown-item" href="{{ route('customer.show') }}">Perfil</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('order.show') }}">As Minhas Encomendas</a>
                                </li>
                            @endif
                            <li><a class="dropdown-item" href="{{ route('password.update') }}">Alterar Senha</a></li>
                            <li>
                                <hr class="dropdown-divider" />
                            </li>
                            <li>
                                <a class="dropdown-item"
                                    onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                    Sair
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
                <a href="{{ route('cart.show') }}" class="nav-link btn-carrinho">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="item-count">{{ count(session('cart', [])) }}</span>
                </a>
            </ul>
        </div>
    </nav>
    @if (session('alert-msg'))
        @include('shared.message')
    @endif
    <div class="main">
        <header>
            <h1>@yield('header-title')</h1>
        </header>
        <div class="content">
            @yield('main')
        </div>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    @vite('resources/js/app.js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>

</html>
