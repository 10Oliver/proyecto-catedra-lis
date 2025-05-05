<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuponera</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="flex flex-col">
    <nav
        class="w-screen px-4 h-[70px] {{ request()->is('/') ? 'bg-[#0000004d]' : 'bg-[#4D4D4D]' }} flex justify-between items-center z-10">
        <h5 class="font-bold text-white text-3xl">Cuponera SV</h5>
        <ul class="flex justify-around w-2/5">
            <li class="text-white font-bold">
                <a href="{{ url('/') }}">Hogar</a>
            </li>
            <li class="text-white font-bold">
                <a href="#ver-cupones">Cupones</a>
            </li>
            <li class="text-white font-bold">
                <a href="/sobre-nosotros">Sobre nosotros</a>
            </li>
            <li class="text-white font-bold">
                <a href="/carrito">Carrito de compras</a>
            </li>
        </ul>
        <div>
            <a href="{{ route('customer.login') }}"
                class="bg-white rounded-[50px] px-5 py-3 text-[#1A6785] font-bold">Iniciar sesión</a>
        </div>
    </nav>

    @yield('content')
</body>

</html>
