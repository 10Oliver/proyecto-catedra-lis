<!DOCTYPE html>
<html lang="es">
 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Solicitud de empresa</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
 
<body class="wallpaper flex justify-center items-center">
    @if (session('success'))
        <div id="status-message"
            class="absolute top-5 right-5 bg-white px-4 py-2 rounded-sm transition-all duration-1000">
            Solicitud enviada, por favor espera hasta que sea aprobada.
        </div>
    @endif
    <form method="POST" action="{{ route('empresa.store') }}"
        class="bg-white w-[30%] rounded-[28px] px-[4%] py-10 flex flex-col">
        @csrf
        <h3 class="text-4xl font-bold text-center">Solicitud</h3>
        <div class="mt-3 ">
            <div class="flex flex-col relative pt-5">
                <input id="name" name="name" type="text" required placeholder=" "
                    class="!border-b-2 border-[#808080] outline-none peer placeholder-transparent" />
                <div
                    class="border-b-4 border-[#F7931E] absolute peer-focus:w-full peer-placeholder-shown:w-0 w-full z-10 top-[95%] transition-all duration-300 ease-in-out">
                </div>
                <label for="name"
                    class="font-bold absolute peer-focus:top-0 peer-placeholder-shown:top-[45%] top-0 transition-all duration-300 ease-in-out peer-focus:text-[#3a3a3a] peer-placeholder-shown:text-[#808080] text-[#3a3a3a]">
                    Nombre de empresa
                </label>
 
            </div>
            @error('name')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <div class="mt-3 ">
            <div class="flex flex-col relative pt-5">
                <input id="nit" name="nit" type="text" required placeholder=" "
                    class="!border-b-2 border-[#808080] outline-none peer placeholder-transparent" />
                <div
                    class="border-b-4 border-[#F7931E] absolute peer-focus:w-full peer-placeholder-shown:w-0 w-full z-10 top-[95%] transition-all duration-300 ease-in-out">
                </div>
                <label for="nit"
                    class="font-bold absolute peer-focus:top-0 peer-placeholder-shown:top-[45%] top-0 transition-all duration-300 ease-in-out peer-focus:text-[#3a3a3a] peer-placeholder-shown:text-[#808080] text-[#3a3a3a]">
                    NIT
                </label>
 
            </div>
            @error('nit')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <div class="mt-3 ">
            <div class="flex flex-col relative pt-5">
                <input id="address" name="address" type="text" required placeholder=" "
                    class="!border-b-2 border-[#808080] outline-none peer placeholder-transparent" />
                <div
                    class="border-b-4 border-[#F7931E] absolute peer-focus:w-full peer-placeholder-shown:w-0 w-full z-10 top-[95%] transition-all duration-300 ease-in-out">
                </div>
                <label for="address"
                    class="font-bold absolute peer-focus:top-0 peer-placeholder-shown:top-[45%] top-0 transition-all duration-300 ease-in-out peer-focus:text-[#3a3a3a] peer-placeholder-shown:text-[#808080] text-[#3a3a3a]">
                    Dirección
                </label>
 
            </div>
            @error('address')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <div class="mt-3 ">
            <div class="flex flex-col relative pt-5">
                <input id="phone" name="phone" type="text" required placeholder=" "
                    class="!border-b-2 border-[#808080] outline-none peer placeholder-transparent" />
                <div
                    class="border-b-4 border-[#F7931E] absolute peer-focus:w-full peer-placeholder-shown:w-0 w-full z-10 top-[95%] transition-all duration-300 ease-in-out">
                </div>
                <label for="phone"
                    class="font-bold absolute peer-focus:top-0 peer-placeholder-shown:top-[45%] top-0 transition-all duration-300 ease-in-out peer-focus:text-[#3a3a3a] peer-placeholder-shown:text-[#808080] text-[#3a3a3a]">
                    Teléfono
                </label>
 
            </div>
            @error('phone')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <div class="mt-3 ">
            <div class="flex flex-col relative pt-5">
                <input id="email" name="email" type="email" required placeholder=" "
                    class="!border-b-2 border-[#808080] outline-none peer placeholder-transparent" />
                <div
                    class="border-b-4 border-[#F7931E] absolute peer-focus:w-full peer-placeholder-shown:w-0 w-full z-10 top-[95%] transition-all duration-300 ease-in-out">
                </div>
                <label for="email"
                    class="font-bold absolute peer-focus:top-0 peer-placeholder-shown:top-[45%] top-0 transition-all duration-300 ease-in-out peer-focus:text-[#3a3a3a] peer-placeholder-shown:text-[#808080] text-[#3a3a3a]">
                    Correo eletrónico
                </label>
 
            </div>
            @error('email')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <p class="mt-10 text-center">Recuerda que luego de enviar la solicitud, debes de esperar a que sea aprobada.</p>
        <button type="submit"
            class="bg-[#F7931E] text-white font-bold text-base px-7 py-3 rounded-[50px] mt-10 hover:cursor-pointer">
            Enviar solicitud
        </button>
    </form>
    <style>
        .wallpaper {
            background-image: url("{{ asset('resources/company/company-apply-wallpaper.png') }}");
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            width: 100vw;
            height: 100vh;
        }
    </style>
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
 
</html>
 