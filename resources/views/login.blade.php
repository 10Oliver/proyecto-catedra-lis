<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="wallpaper flex justify-center items-center">
    <form method="POST" action="{{ route('login') }}" class="p-[4%] flex flex-col w-[33%] bg-white rounded-[26px]">
        @csrf
        <h3 class="font-bold text-4xl text-center">Cuponera SV</h3>
        <div class="mt-3 mb-7">
            <div class="flex flex-col relative pt-5">
                <input id="email" name="email" type="email" required placeholder=" "
                    class="!border-b-2 border-[#808080] outline-none peer placeholder-transparent" />
                <div
                    class="border-b-4 border-[#F7931E] absolute peer-focus:w-full peer-placeholder-shown:w-0 w-full z-10 top-[95%] transition-all duration-300 ease-in-out">
                </div>
                <label for="email"
                    class="font-bold absolute peer-focus:top-0 peer-placeholder-shown:top-[45%] top-0 transition-all duration-300 ease-in-out peer-focus:text-[#3a3a3a] peer-placeholder-shown:text-[#808080] text-[#3a3a3a]">
                    Correo electrónico
                </label>

            </div>
            @error('email')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <div class="mt-3 mb-7">
            <div class="flex flex-col relative pt-5">
                <input id="password" name="password" type="password" required placeholder=" "
                    class="!border-b-2 border-[#808080] outline-none peer placeholder-transparent" />
                <div
                    class="border-b-4 border-[#F7931E] absolute peer-focus:w-full peer-placeholder-shown:w-0 w-full z-10 top-[95%] transition-all duration-300 ease-in-out">
                </div>
                <label for="password"
                    class="font-bold absolute peer-focus:top-0 peer-placeholder-shown:top-[45%] top-0 transition-all duration-300 ease-in-out peer-focus:text-[#3a3a3a] peer-placeholder-shown:text-[#808080] text-[#3a3a3a]">
                    Contraseña</label>

            </div>
            @error('password')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit" class="bg-[#F7931E] text-white font-bold text-lg px-5 py-3 rounded-[50px] mt-10">
            Iniciar sesión
        </button>
        <div class="flex justify-center mt-10">
            <p class="font-bold mr-2">¿Olvidaste tu contraseña?</p>
            <a href="{{ route('private.password.request') }}" class="text-[#1887B2] font-bold">Recuperar
                contraseña</a>
        </div>

    </form>
    <style>
        .wallpaper {
            background-image: url("{{ asset('resources/auth/login-wallpaper.png') }}");
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            width: 100vw;
            height: 100vh;
        }
    </style>
</body>

</html>
