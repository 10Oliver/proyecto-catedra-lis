<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer contraseña - Empresa/admin</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="flex justify-center items-center wallpaper">
    <form method="POST" action="{{ route('private.password.update') }}"
        class="bg-white rounded-[28px] w-[500px] min-h-[500px] flex flex-col py-10 px-14 gap-y-10">
        @csrf
        <h2 class="text-4xl font-bold">Cambiar contraseña</h2>
        <p class="text-base font-bold text-[#323232]">
            Coloca la nueva contraseña para tu usuario.
        </p>
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <input id="email" name="email" type="hidden" value="{{ old('email', $request->email) }}" />
        <div class="flex flex-col">
            <div class="mt-3 mb-7">
                <div class="flex flex-col relative pt-5">
                    <input id="password" name="password" type="password" required placeholder=" "
                        class="!border-b-2 border-[#808080] outline-none peer placeholder-transparent" />
                    <div
                        class="border-b-4 border-[#F7931E] absolute peer-focus:w-full peer-placeholder-shown:w-0 w-full z-10 top-[95%] transition-all duration-300 ease-in-out">
                    </div>
                    <label for="password"
                        class="font-bold absolute peer-focus:top-0 peer-placeholder-shown:top-[45%] top-0 transition-all duration-300 ease-in-out peer-focus:text-[#3a3a3a] peer-placeholder-shown:text-[#808080] text-[#3a3a3a]">Nueva
                        contraseña</label>

                </div>
                @error('password')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>


            <div class="flex flex-col relative pt-5 mt-3 mb-7">
                <input id="password_confirmation" name="password_confirmation" type="password" required placeholder=" "
                    class="!border-b-2 border-[#808080] outline-none peer placeholder-transparent" />
                <div
                    class="border-b-4 border-[#F7931E] absolute peer-focus:w-full peer-placeholder-shown:w-0 w-full z-10 top-[95%] transition-all duration-300 ease-in-out">
                </div>
                <label for="password_confirmation"
                    class="font-bold absolute peer-focus:top-0 peer-placeholder-shown:top-[45%] top-0 transition-all duration-300 ease-in-out peer-focus:text-[#3a3a3a] peer-placeholder-shown:text-[#808080] text-[#3a3a3a]">Confirmar
                    contraseña</label>

            </div>
        </div>
        <button type="submit"
            class="text-white bg-[#F7931E] py-2 rounded-[50px] font-bold hover:cursor-pointer">Confirmar</button>
    </form>
</body>
<style>
    .wallpaper {
        background-image: url("{{ asset('resources/auth/reset-password-wallpaper.png') }}");
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        width: 100vw;
        height: 100vh;
    }
</style>

</html>
