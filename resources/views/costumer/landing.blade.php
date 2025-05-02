@extends('costumer.app')

@section('content')
    <div class="wallpaper w-screen h-[90vh] -mt-[70px] flex flex-col justify-center items-start px-[3%] pt-[5%]">
        <div class="max-w-[32%] flex flex-col gap-y-5">
            <h2 class="font-bold text-white text-5xl leading-14">
                ¡Ahorra con cupones exclusivos!
            </h2>
            <p class="text-white text-lg">
                Regístrate gratis y accede a descuentos que no encontrarás en ningún otro lugar.
            </p>
            <div class="flex gap-x-4">
                <a href="{{ route('customer.register') }}" class="bg-[#F7931E] rounded-[50px] px-5 py-3 text-white font-bold">
                    Registrate
                </a>
                <a href="#ver-cupones" class="rounded-[50px] px-5 py-3 font-bold text-[#1A6785] bg-white">
                    Ver cupones
                </a>
            </div>
        </div>
    </div>
    <div class="py-10 w-4/5 flex flex-col items-center mx-[10%]">
        <h3 id="ver-cupones" class="text-4xl font-bold">Cupones disponibles</h3>
    </div>
    <style>
        .wallpaper {
            background-image: url("{{ asset('resources/customer/landing-wallpaper.png') }}");
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
@endsection
