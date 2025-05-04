<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Olvidé mi contraseña - Cliente</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="wallpaper flex justify-center items-center">
    @if (session('status'))
        <div id="status-message"
            class="absolute top-5 right-5 bg-white px-4 py-2 rounded-sm transition-all duration-1000">
            Se ha enviado el correo de recuperación, revisa tu bandeja de entrada.
        </div>
    @endif
    <div class="bg-white w-[65%] h-[70%] grid grid-cols-2">
        <div class="add-wallpaper px-[7%] py-[10%] flex flex-col justify-between">
            <h1 class="font-bold text-[64px] text-white leading-16">Pronto estarás de vuelta</h1>
            <p class="text-white">
                Sabemos que los errores pasan, por eso estamos aquí para ayudarte a recuperar el acceso y seguir
                disfrutando sin complicaciones.
            </p>
            <div class="flex">
                <a href="{{ route('customer.login') }}"
                    class="w-[35%] bg-white py-3 rounded-[50px] text-center font-bold text-[#1A6785]">Volver</a>
            </div>
        </div>
        <form method="POST" action="{{ route('cliente.password.email') }}" class="py-[10%] px-[7%] flex flex-col">
            @csrf
            <h3 class="font-bold text-4xl">Recuperación</h3>
            <p class="mt-[60px] text-[#6F6F6F] font-medium">
                Introduce el correo electrónico asociado a tu cuenta y te enviaremos un enlace para que
                puedas restablecer tu contraseña.</p>
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
            <button type="submit"
                class="bg-[#F7931E] text-white font-bold text-lg px-7 py-3 rounded-[50px] max-w-max place-self-end mt-10 hover:cursor-pointer">
                Confirmar
            </button>
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
