<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer contraseña - Cliente</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="wallpaper flex justify-center items-center">
    <div class="bg-white w-[65%] h-[70%] grid grid-cols-2">
        <div class="add-wallpaper px-[7%] py-[10%] flex flex-col justify-between">
            <h1 class="font-bold text-[48px] text-white leading-16">Un nuevo comienzo te espera</h1>
            <div>
                <p class="text-white">
                    Protege tu cuenta y sigue disfrutando de todo lo que tenemos para ti.
                </p>
                <p class="text-white">
                    Tus datos están seguros y listos para seguir acompañándote.
                </p>
            </div>

            <div class="flex">
                <a href="{{ route('customer.login') }}"
                    class="w-[35%] bg-white py-3 rounded-[50px] text-center font-bold text-[#1A6785]">Volver</a>
            </div>
        </div>
        <form method="POST" action="{{ route('cliente.password.update') }}" class="py-[10%] px-[7%] flex flex-col">
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <input id="email" name="email" type="hidden" value="{{ old('email', $request->email) }}" />
            <h3 class="font-bold text-4xl">Cambiar contraseña</h3>
            <p class="mt-[60px] text-[#6F6F6F] font-medium">
                Por favor, ingresa una nueva contraseña segura. Asegúrate de que sea fácil de recordar pero difícil de
                adivinar.</p>
            <div class="mt-3 mb-7">
                <div class="flex flex-col relative pt-5">
                    <input id="password" name="password" type="password" required placeholder=" "
                        class="!border-b-2 border-[#808080] outline-none peer placeholder-transparent" />
                    <div
                        class="border-b-4 border-[#F7931E] absolute peer-focus:w-full peer-placeholder-shown:w-0 w-full z-10 top-[95%] transition-all duration-300 ease-in-out">
                    </div>
                    <label for="password"
                        class="font-bold absolute peer-focus:top-0 peer-placeholder-shown:top-[45%] top-0 transition-all duration-300 ease-in-out peer-focus:text-[#3a3a3a] peer-placeholder-shown:text-[#808080] text-[#3a3a3a]">
                        Nueva contraseña
                    </label>

                </div>
                @error('password')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mt-3 mb-7">
                <div class="flex flex-col relative pt-5">
                    <input id="password_confirmation" name="password_confirmation" type="password" required
                        placeholder=" "
                        class="!border-b-2 border-[#808080] outline-none peer placeholder-transparent" />
                    <div
                        class="border-b-4 border-[#F7931E] absolute peer-focus:w-full peer-placeholder-shown:w-0 w-full z-10 top-[95%] transition-all duration-300 ease-in-out">
                    </div>
                    <label for="password_confirmation"
                        class="font-bold absolute peer-focus:top-0 peer-placeholder-shown:top-[45%] top-0 transition-all duration-300 ease-in-out peer-focus:text-[#3a3a3a] peer-placeholder-shown:text-[#808080] text-[#3a3a3a]">
                        Confirmar contraseña
                    </label>

                </div>
                @error('password_confirmation')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit"
                class="bg-[#F7931E] text-white font-bold text-lg px-7 py-3 rounded-[50px] max-w-max place-self-end mt-10 hover:cursor-pointer">
                Cambiar
            </button>
        </form>
    </div>
</body>
<style>
    .wallpaper {
        background-image: url("{{ asset('resources/customer/forgot-password-wallpaper.png') }}");
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        width: 100vw;
        height: 100vh;
    }

    .add-wallpaper {
        background-image: url("{{ asset('resources/customer/forgot-password-add-wallpaper.png') }}");
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }
</style>

</html>
