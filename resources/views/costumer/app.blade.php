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
        class="w-full px-4 h-[70px] {{ request()->is('/') ? 'bg-[#0000004d]' : 'bg-[#4D4D4D]' }} flex justify-between items-center z-10">
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
    <footer class="bg-[#1A6785] w-full min-h-[10vh] grid grid-cols-[1fr_auto_1fr] px-[5%] py-7">
        <ul class="flex flex-col justify-center">
            <li class="text-white">
                <a href="{{ url('/') }}">Hogar</a>
            </li>
            <li class="text-white">
                <a href="#ver-cupones">Cupones</a>
            </li>
            <li class="text-white">
                <a href="/sobre-nosotros">Sobre nosotros</a>
            </li>
            <li class="text-white">
                <a href="/carrito">Carrito de compras</a>
            </li>
        </ul>
        <div>
            <h1 class="text-[64px] font-bold text-white">Cuponera SV</h1>
            <hr class="border-b-white border-[3px] border-t-0">
            <div class="flex justify-between mt-4">
                <div class="rounded-full bg-[#D9D9D9] w-[50px] p-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <title>facebook</title>
                        <path
                            d="M12 2.04C6.5 2.04 2 6.53 2 12.06C2 17.06 5.66 21.21 10.44 21.96V14.96H7.9V12.06H10.44V9.85C10.44 7.34 11.93 5.96 14.22 5.96C15.31 5.96 16.45 6.15 16.45 6.15V8.62H15.19C13.95 8.62 13.56 9.39 13.56 10.18V12.06H16.34L15.89 14.96H13.56V21.96A10 10 0 0 0 22 12.06C22 6.53 17.5 2.04 12 2.04Z" />
                    </svg>
                </div>
                <div class="rounded-full bg-[#D9D9D9] w-[50px] p-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <title>reddit</title>
                        <path
                            d="M14.5 15.41C14.58 15.5 14.58 15.69 14.5 15.8C13.77 16.5 12.41 16.56 12 16.56C11.61 16.56 10.25 16.5 9.54 15.8C9.44 15.69 9.44 15.5 9.54 15.41C9.65 15.31 9.82 15.31 9.92 15.41C10.38 15.87 11.33 16 12 16C12.69 16 13.66 15.87 14.1 15.41C14.21 15.31 14.38 15.31 14.5 15.41M10.75 13.04C10.75 12.47 10.28 12 9.71 12C9.14 12 8.67 12.47 8.67 13.04C8.67 13.61 9.14 14.09 9.71 14.08C10.28 14.08 10.75 13.61 10.75 13.04M14.29 12C13.72 12 13.25 12.5 13.25 13.05S13.72 14.09 14.29 14.09C14.86 14.09 15.33 13.61 15.33 13.05C15.33 12.5 14.86 12 14.29 12M22 12C22 17.5 17.5 22 12 22S2 17.5 2 12C2 6.5 6.5 2 12 2S22 6.5 22 12M18.67 12C18.67 11.19 18 10.54 17.22 10.54C16.82 10.54 16.46 10.7 16.2 10.95C15.2 10.23 13.83 9.77 12.3 9.71L12.97 6.58L15.14 7.05C15.16 7.6 15.62 8.04 16.18 8.04C16.75 8.04 17.22 7.57 17.22 7C17.22 6.43 16.75 5.96 16.18 5.96C15.77 5.96 15.41 6.2 15.25 6.55L12.82 6.03C12.75 6 12.68 6.03 12.63 6.07C12.57 6.11 12.54 6.17 12.53 6.24L11.79 9.72C10.24 9.77 8.84 10.23 7.82 10.96C7.56 10.71 7.2 10.56 6.81 10.56C6 10.56 5.35 11.21 5.35 12C5.35 12.61 5.71 13.11 6.21 13.34C6.19 13.5 6.18 13.62 6.18 13.78C6.18 16 8.79 17.85 12 17.85C15.23 17.85 17.85 16.03 17.85 13.78C17.85 13.64 17.84 13.5 17.81 13.34C18.31 13.11 18.67 12.6 18.67 12Z" />
                    </svg>
                </div>
                <div class="rounded-full bg-[#D9D9D9] w-[50px] p-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <title>whatsapp</title>
                        <path
                            d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91C2.13 13.66 2.59 15.36 3.45 16.86L2.05 22L7.3 20.62C8.75 21.41 10.38 21.83 12.04 21.83C17.5 21.83 21.95 17.38 21.95 11.92C21.95 9.27 20.92 6.78 19.05 4.91C17.18 3.03 14.69 2 12.04 2M12.05 3.67C14.25 3.67 16.31 4.53 17.87 6.09C19.42 7.65 20.28 9.72 20.28 11.92C20.28 16.46 16.58 20.15 12.04 20.15C10.56 20.15 9.11 19.76 7.85 19L7.55 18.83L4.43 19.65L5.26 16.61L5.06 16.29C4.24 15 3.8 13.47 3.8 11.91C3.81 7.37 7.5 3.67 12.05 3.67M8.53 7.33C8.37 7.33 8.1 7.39 7.87 7.64C7.65 7.89 7 8.5 7 9.71C7 10.93 7.89 12.1 8 12.27C8.14 12.44 9.76 14.94 12.25 16C12.84 16.27 13.3 16.42 13.66 16.53C14.25 16.72 14.79 16.69 15.22 16.63C15.7 16.56 16.68 16.03 16.89 15.45C17.1 14.87 17.1 14.38 17.04 14.27C16.97 14.17 16.81 14.11 16.56 14C16.31 13.86 15.09 13.26 14.87 13.18C14.64 13.1 14.5 13.06 14.31 13.3C14.15 13.55 13.67 14.11 13.53 14.27C13.38 14.44 13.24 14.46 13 14.34C12.74 14.21 11.94 13.95 11 13.11C10.26 12.45 9.77 11.64 9.62 11.39C9.5 11.15 9.61 11 9.73 10.89C9.84 10.78 10 10.6 10.1 10.45C10.23 10.31 10.27 10.2 10.35 10.04C10.43 9.87 10.39 9.73 10.33 9.61C10.27 9.5 9.77 8.26 9.56 7.77C9.36 7.29 9.16 7.35 9 7.34C8.86 7.34 8.7 7.33 8.53 7.33Z" />
                    </svg>
                </div>
                <div class="rounded-full bg-[#D9D9D9] w-[50px] p-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <title>instagram</title>
                        <path
                            d="M7.8,2H16.2C19.4,2 22,4.6 22,7.8V16.2A5.8,5.8 0 0,1 16.2,22H7.8C4.6,22 2,19.4 2,16.2V7.8A5.8,5.8 0 0,1 7.8,2M7.6,4A3.6,3.6 0 0,0 4,7.6V16.4C4,18.39 5.61,20 7.6,20H16.4A3.6,3.6 0 0,0 20,16.4V7.6C20,5.61 18.39,4 16.4,4H7.6M17.25,5.5A1.25,1.25 0 0,1 18.5,6.75A1.25,1.25 0 0,1 17.25,8A1.25,1.25 0 0,1 16,6.75A1.25,1.25 0 0,1 17.25,5.5M12,7A5,5 0 0,1 17,12A5,5 0 0,1 12,17A5,5 0 0,1 7,12A5,5 0 0,1 12,7M12,9A3,3 0 0,0 9,12A3,3 0 0,0 12,15A3,3 0 0,0 15,12A3,3 0 0,0 12,9Z" />
                    </svg>
                </div>
            </div>
        </div>
        <div class="flex flex-col items-end justify-center gap-y-2">
            <div class="text-center">
                <h6 class="text-white font-bold">¿Deseas participar?</h6>
                <a class="text-white" href="{{ route('empresa.apply') }}">Enviar solicitud</a>
                <h6 class="text-white font-bold">Ó</h6>
                <a class="text-white" href="{{ route('private.login') }}">Inicia sesión</a>
            </div>
        </div>
    </footer>
</body>

</html>
