<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="flex justify-center items-center wallpaper">
    <div class="bg-white w-[65%] h-[85%] grid grid-cols-2">
        <div class="add-wallpaper px-[7%] py-[10%] flex flex-col justify-between h-full">
            <h1 class="font-bold text-5xl text-white leading-16">
                Únete y empieza a ahorrar
            </h1>
            <p class="text-white">
                Crea tu cuenta y accede a promociones exclusivas. Disfruta descuentos personalizados, administra tus
                cupones y aprovecha cada oportunidad.
            </p>
            <div class="flex">
                <a href="{{ route('customer.login') }}"
                    class="w-[35%] bg-white py-3 rounded-[50px] text-center font-bold text-[#1A6785]">Volver</a>
            </div>
        </div>
        <form method="POST" action="{{ route('login') }}" class="py-[9%] px-[7%] flex flex-col" autocomplete="off">
            @csrf
            <h3 class="font-bold text-4xl">Registro</h3>
            <div class="mt-3 ">
                <div class="flex flex-col relative pt-5">
                    <input id="names" name="names" type="text" required placeholder=" "
                        class="!border-b-2 border-[#808080] outline-none peer placeholder-transparent" />
                    <div
                        class="border-b-4 border-[#F7931E] absolute peer-focus:w-full peer-placeholder-shown:w-0 w-full z-10 top-[95%] transition-all duration-300 ease-in-out">
                    </div>
                    <label for="names"
                        class="font-bold absolute peer-focus:top-0 peer-placeholder-shown:top-[45%] top-0 transition-all duration-300 ease-in-out peer-focus:text-[#3a3a3a] peer-placeholder-shown:text-[#808080] text-[#3a3a3a]">
                        Nombres
                    </label>

                </div>
                @error('names')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mt-3 ">
                <div class="flex flex-col relative pt-5">
                    <input id="surnames" name="surnames" type="text" required placeholder=" "
                        class="!border-b-2 border-[#808080] outline-none peer placeholder-transparent" />
                    <div
                        class="border-b-4 border-[#F7931E] absolute peer-focus:w-full peer-placeholder-shown:w-0 w-full z-10 top-[95%] transition-all duration-300 ease-in-out">
                    </div>
                    <label for="surnames"
                        class="font-bold absolute peer-focus:top-0 peer-placeholder-shown:top-[45%] top-0 transition-all duration-300 ease-in-out peer-focus:text-[#3a3a3a] peer-placeholder-shown:text-[#808080] text-[#3a3a3a]">
                        Apellidos
                    </label>

                </div>
                @error('surnames')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mt-3 ">
                <div class="flex flex-col relative pt-5">
                    <input id="dui" name="dui" type="text" required placeholder=" "
                        class="!border-b-2 border-[#808080] outline-none peer placeholder-transparent" />
                    <div
                        class="border-b-4 border-[#F7931E] absolute peer-focus:w-full peer-placeholder-shown:w-0 w-full z-10 top-[95%] transition-all duration-300 ease-in-out">
                    </div>
                    <label for="dui"
                        class="font-bold absolute peer-focus:top-0 peer-placeholder-shown:top-[45%] top-0 transition-all duration-300 ease-in-out peer-focus:text-[#3a3a3a] peer-placeholder-shown:text-[#808080] text-[#3a3a3a]">
                        DUI
                    </label>

                </div>
                @error('dui')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mt-3 ">
                <div class="flex flex-col relative pt-5">
                    <input id="birthdate" name="birthdate" type="date" required placeholder=" "
                        class="!border-b-2 border-[#808080] outline-none peer placeholder-transparent text-transparent focus:text-black valid:text-black" />
                    <div
                        class="border-b-4 border-[#F7931E] absolute peer-focus:w-full peer-valid:w-full w-0 z-10 top-[95%] transition-all duration-300 ease-in-out">
                    </div>
                    <label for="birthdate"
                        class="font-bold absolute transition-all duration-300 ease-in-out peer-valid:top-0 top-[45%] peer-valid:text-[#3a3a3a] text-[#808080] peer-focus:top-0 peer-focus:text-[#3a3a3a]">
                        Fecha de nacimiento
                    </label>

                </div>
                @error('birthdate')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mt-3 ">
                <div class="flex flex-col relative pt-5">
                    <input id="email" name="email" type="email" required placeholder=" "
                        class="!border-b-2 border-[#808080] outline-none peer placeholder-transparent text-transparent focus:text-black valid:text-black" />
                    <div
                        class="border-b-4 border-[#F7931E] absolute peer-focus:w-full peer-valid:w-full w-0 z-10 top-[95%] transition-all duration-300 ease-in-out">
                    </div>
                    <label for="email"
                        class="font-bold absolute transition-all duration-300 ease-in-out peer-valid:top-0 top-[45%] peer-valid:text-[#3a3a3a] text-[#808080] peer-focus:top-0 peer-focus:text-[#3a3a3a]">
                        Correo eletrónico
                    </label>

                </div>
                @error('email')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mt-3 ">
                <div class="flex flex-col relative pt-5">
                    <input id="password" name="password" type="password" required placeholder=" "
                        class="!border-b-2 border-[#808080] outline-none peer placeholder-transparent" />
                    <div
                        class="border-b-4 border-[#F7931E] absolute peer-focus:w-full peer-placeholder-shown:w-0 w-full z-10 top-[95%] transition-all duration-300 ease-in-out">
                    </div>
                    <label for="password"
                        class="font-bold absolute peer-focus:top-0 peer-placeholder-shown:top-[45%] top-0 transition-all duration-300 ease-in-out peer-focus:text-[#3a3a3a] peer-placeholder-shown:text-[#808080] text-[#3a3a3a]">
                        Contraseña
                    </label>

                </div>
                @error('password')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mt-3 ">
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
                class="bg-[#F7931E] text-white font-bold text-lg px-5 py-3 rounded-[50px] max-w-max place-self-end mt-10">
                Registrarse
            </button>
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
        background-size: auto;
        height: 100%;
    }
</style>

</html>
