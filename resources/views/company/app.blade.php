<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empresa</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="grid grid-cols-[15%_85%] min-h-full">
    <aside class="bg-gray-800 grid grid-rows-[auto_auto_1fr] gap-y-5">
        <h4 class="w-full text-center text-2xl text-white font-bold px-6 py-10">Panel de Empresas</h4>
        <ul>
            <li>
                <a href="{{ route('empresa.index') }}"
                    class="{{ request()->is('empresa')
                        ? 'hover:bg-[#4f46e5] text-white'
                        : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700/50' }} flex items-center gap-3 px-4 py-3 font-medium">
                    Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('coupons.view') }}"
                    class="{{ request()->is('cupones')
                        ? 'hover:bg-[#4f46e5] text-white'
                        : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700/50' }} flex items-center gap-3 px-4 py-3 font-medium">
                    Cupones
                </a>
            </li>
        </ul>
        <form action="{{ route('logout') }}" method="post" class="self-end justify-self-start flex w-full hover:bg-red-800">
            @csrf
            <button
                class="text-red-400  p-4 flex gap-x-2 w-full hover:cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-7">
                    <title>logout-variant</title>
                    <path class="fill-red-400"
                        d="M14.08,15.59L16.67,13H7V11H16.67L14.08,8.41L15.5,7L20.5,12L15.5,17L14.08,15.59M19,3A2,2 0 0,1 21,5V9.67L19,7.67V5H5V19H19V16.33L21,14.33V19A2,2 0 0,1 19,21H5C3.89,21 3,20.1 3,19V5C3,3.89 3.89,3 5,3H19Z" />
                </svg>
                Cerrar sesión
            </button>
        </form>

    </aside>
    <main class="wallpaper p-10">
        @yield('content')
    </main>
</body>
<style>
    .wallpaper {
        background-image: url("{{ asset('resources/company/company-main-wallpaper.jpg') }}");
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        width: 85vw;
        height: 100vh;
    }

    </html>
