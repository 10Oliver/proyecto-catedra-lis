<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Olvidé mi contraseña - Cliente/admin</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="flex justify-center items-center wallpaper relative">
    @if (session('status'))
        <div id="status-message"
            class="absolute top-5 right-5 bg-white px-4 py-2 rounded-sm transition-all duration-1000">
            Se ha enviado el correo de recuperación, revisa tu bandeja de entrada.
        </div>
    @endif
    <form action="{{ route('private.password.email') }}" method="post"
        class="bg-white rounded-[28px] w-[500px] min-h-[500px] flex flex-col py-10 px-14 gap-y-10">
        @csrf
        <h2 class="text-4xl font-bold">Recuperar contraseña</h2>

        <p class="text-base font-bold text-[#323232]">
            Coloca tu correo electrónico, recibirás indicaciones para que puedas cambiar tu contraseña.
        </p>
        <div class="mt-3 mb-7">
            <div class="flex flex-col relative pt-5">
                <input type="email" id="email" name="email" required placeholder=" " autofocus
                    class="!border-b-2 border-[#808080] outline-none peer placeholder-transparent">
                <div
                    class="border-b-4 border-[#F7931E] absolute peer-focus:w-full peer-placeholder-shown:w-0 w-full z-10 top-[95%] transition-all duration-300 ease-in-out">
                </div>
                <label for="email"
                    class="font-bold absolute peer-focus:top-0 peer-placeholder-shown:top-[45%] top-0 transition-all duration-300 ease-in-out peer-focus:text-[#3a3a3a] peer-placeholder-shown:text-[#808080] text-[#3a3a3a]">Correo
                    electrónico</label>
            </div>
            @error('email')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit"
            class="text-white bg-[#F7931E] py-2 rounded-[50px] font-bold hover:cursor-pointer">Confirmar</button>
    </form>
    <script>
        window.addEventListener('DOMContentLoaded', function() {
            const msg = document.getElementById('status-message');
            if (!msg) return;

            setTimeout(() => {
                msg.classList.add('opacity-0');
            }, 5000);
        });
    </script>
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
