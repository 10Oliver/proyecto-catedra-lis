<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Cuponera SV')</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg {{ request()->is('/') ? 'bg-transparent' : 'bg-dark' }} py-3">
        <div class="container">
            <a class="navbar-brand text-white fw-bold fs-3" href="#">Cuponera SV</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link text-white fw-bold" href="{{ url('/') }}">Hogar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white fw-bold" href="#ver-cupones">Cupones</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white fw-bold" href="/sobre-nosotros">Sobre nosotros</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white fw-bold" href="/carrito">Carrito</a>
                    </li>
                </ul>
                <div>
                    <a href="{{ route('customer.login') }}"
                        class="btn bg-white text-dark fw-bold px-4 py-2 rounded-pill">Iniciar sesión</a>
                </div>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>

</html>
