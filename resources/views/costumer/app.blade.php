<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Cuponera SV')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .floating-label {
            position: relative;
            margin-bottom: 1.5rem;
        }
        .floating-label input {
            border: none;
            border-bottom: 2px solid #808080;
            border-radius: 0;
            padding-left: 0;
            padding-right: 0;
        }
        .floating-label input:focus {
            box-shadow: none;
            border-bottom: 4px solid #F7931E;
        }
        .floating-label label {
            position: absolute;
            top: 0;
            left: 0;
            transition: all 0.3s ease;
            color: #808080;
            font-weight: bold;
        }
        .floating-label input:focus + label,
        .floating-label input:not(:placeholder-shown) + label {
            top: -1.2rem;
            font-size: 0.8rem;
            color: #3a3a3a;
        }
        .btn-primary {
            background-color: #F7931E;
            border-color: #F7931E;
            border-radius: 50px;
            padding: 0.5rem 2rem;
            font-weight: bold;
        }
        .status-message {
            position: fixed;
            top: 20px;
            right: 20px;
            background: white;
            padding: 10px 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            opacity: 1;
            transition: opacity 1s ease;
        }
    </style>
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
                    <a href="{{ route('customer.login') }}" class="btn bg-white text-dark fw-bold px-4 py-2 rounded-pill">Iniciar sesión</a>
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