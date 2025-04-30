<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Olvidé mi contraseña - Cliente/admin</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
{{-- <body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="w-full max-w-md bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-semibold mb-4">¿Olvidaste tu contraseña?</h1>
        <p class="mb-6 text-gray-600">Introduce tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña.</p>
        <form method="POST" action="{{ route('private.password.email') }}">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-gray-700">Correo electrónico</label>
                <input id="email" name="email" type="email" required autofocus
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
                @error('email')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit"
                    class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
                Enviar enlace de recuperación
            </button>
        </form>
        <p class="mt-4 text-center text-sm">
            <a href="{{ route('private.login') }}" class="text-blue-600 hover:underline">Volver al inicio de sesión</a>
        </p>
    </div>
</body> --}}

<body class="flex justify-center items-center wallpaper">
    <form action="{{ route('private.password.email') }}" method="post"
        class="bg-white rounded-[28px] w-[500px] min-h-[500px] flex flex-col py-10 px-14 gap-y-10">
        @csrf
        <h2 class="text-4xl font-bold">Recuperar contraseña</h2>

        <p class="text-base font-bold text-[#323232]">
            Coloca tu correo electrónico, recibirás indicaciones para que puedas cambiar tu contraseña.
        </p>
        <div class="flex flex-col relative pt-5 mt-3 mb-7 input-field">
            <input type="email" id="email" name="email" required placeholder=" " autofocus class="!border-b-2 border-[#808080] outline-none peer placeholder-transparent">
            <div class="border-b-[3px] border-[#F7931E] absolute peer-focus:w-full peer-placeholder-shown:w-0 w-full z-10 top-[97%] transition-all duration-300 ease-in-out"></div>
            <label for="email" class="font-bold absolute peer-focus:top-0 peer-placeholder-shown:top-[45%] top-0 transition-all duration-300 ease-in-out peer-focus:text-[#3a3a3a] peer-placeholder-shown:text-[#808080] text-[#3a3a3a]">Correo electrónico</label>
            @error('email')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit" class="text-white bg-[#F7931E] py-2 rounded-[50px] font-bold hover:cursor-pointer">Confirmar</button>
    </form>
    {{-- <form method="POST" action="{{ route('private.password.email') }}">
        @csrf
        <div class="mb-4">
            <label for="email" class="block text-gray-700">Correo electrónico</label>
            <input id="email" name="email" type="email" required autofocus
                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
            @error('email')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
            Enviar enlace de recuperación
        </button>
    </form> --}}
</body>
<style>
    .wallpaper {
        background-image: url('../resources/auth/reset-password-wallpaper.png');
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        width: 100vw;
        height: 100vh;
    }
    /* @layer input-field {
        .input-field > input:focus  {
            background-color: green;
        }
    } */
</style>

</html>
