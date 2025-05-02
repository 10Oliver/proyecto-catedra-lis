<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="flex justify-center items-center wallpaper">
    <div class="bg-white w-[65%] h-[70%] grid grid-cols-2">
        <div class="add-wallpaper px-[7%] py-[10%] flex flex-col justify-between">
            <h1 class="font-bold text-[64px] text-white leading-16">Bienvenido de vuelta</h1>
            <p class="text-white">
                Inicia sesión y accede a tus cupones exclusivos.
                Administra tus ofertas, descubre descuentos personalizados y ahorra en cada compra.
            </p>
            <div class="flex justify-around">
                <a href="{{ url('/') }}"
                    class="w-[35%] bg-white py-3 rounded-[50px] text-center font-bold text-[#1A6785]">Volver</a>
                <a href="{{ route('customer.register') }}"
                    class="w-[35%] bg-[#0284C7] text-white py-3 rounded-[50px] text-center font-bold">Registrate</a>
            </div>
        </div>
        <form method="POST" action="{{ route('login') }}" class="py-[10%] px-[7%] flex flex-col">
            @csrf
            <h3 class="font-bold text-4xl">Inicio de sesión</h3>
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
            <button type="submit"
                class="bg-[#F7931E] text-white font-bold text-lg px-5 py-3 rounded-[50px] max-w-max place-self-end mt-10">
                Iniciar sesión
            </button>
            <div class="flex justify-center mt-10">
                <p class="font-bold mr-2">¿Olvidaste tu contraseña?</p>
                <a href="{{ route('cliente.password.request') }}" class="text-[#1887B2] font-bold">Recuperar
                    contraseña</a>
            </div>

        </form>
    </div>
</body>
<style>
    .wallpaper {
        background-image: url("{{ asset('resources/customer/login-wallpaper.png') }}");
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        width: 100vw;
        height: 100vh;
    }

    .add-wallpaper {
        background-image: url("{{ asset('resources/customer/login-add-wallpaper.png') }}");
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }
</style>

</html>
