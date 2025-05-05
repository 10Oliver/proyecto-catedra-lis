@extends('costumer.app')

@section('content')
    <div class="wallpaper w-[100%] h-[90vh] -mt-[70px] flex flex-col justify-center items-start px-[3%] pt-[5%]">
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
        <h3 id="ver-cupones" class="text-4xl font-bold mb-5">Cupones disponibles</h3>
        <div class="grid grid-cols-3 gap-5">
            <div class="rounded-xl grid grid-cols-[auto_1fr] border-[#929191] border-[1px] overflow-hidden">
                <div class="bg-[#a83131] w-[130px] flex justify-center items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12" viewBox="0 0 24 24">
                        <title>tag</title>
                        <path class=" fill-amber-600"
                            d="M5.5,7A1.5,1.5 0 0,1 4,5.5A1.5,1.5 0 0,1 5.5,4A1.5,1.5 0 0,1 7,5.5A1.5,1.5 0 0,1 5.5,7M21.41,11.58L12.41,2.58C12.05,2.22 11.55,2 11,2H4C2.89,2 2,2.89 2,4V11C2,11.55 2.22,12.05 2.59,12.41L11.58,21.41C11.95,21.77 12.45,22 13,22C13.55,22 14.05,21.77 14.41,21.41L21.41,14.41C21.78,14.05 22,13.55 22,13C22,12.44 21.77,11.94 21.41,11.58Z" />
                    </svg>
                </div>
                <div class="grid grid-cols-[65%_35%] p-3">
                    <h3 class="col-span-2 font-medium text-2xl">Nombre de la oferta</h3>
                    <span class="text-sm text-[#1A6785] col-span-2">Nombre empresa</span>
                    <p class="font-bold text-base">30 disponibles</p>
                    <p class="font-bold text-[#919191] line-through place-self-end">$25.00</p>
                    <span>15 días restantes</span>
                    <p class="font-bold text-xl text-[#F97316] place-self-end">$20.00</p>
                </div>
            </div>
            <div class="rounded-xl grid grid-cols-[auto_1fr] border-[#929191] border-[1px] overflow-hidden">
                <div class="bg-[#a83131] w-[130px] flex justify-center items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12" viewBox="0 0 24 24">
                        <title>tag</title>
                        <path class=" fill-amber-600"
                            d="M5.5,7A1.5,1.5 0 0,1 4,5.5A1.5,1.5 0 0,1 5.5,4A1.5,1.5 0 0,1 7,5.5A1.5,1.5 0 0,1 5.5,7M21.41,11.58L12.41,2.58C12.05,2.22 11.55,2 11,2H4C2.89,2 2,2.89 2,4V11C2,11.55 2.22,12.05 2.59,12.41L11.58,21.41C11.95,21.77 12.45,22 13,22C13.55,22 14.05,21.77 14.41,21.41L21.41,14.41C21.78,14.05 22,13.55 22,13C22,12.44 21.77,11.94 21.41,11.58Z" />
                    </svg>
                </div>
                <div class="grid grid-cols-[65%_35%] p-3">
                    <h3 class="col-span-2 font-medium text-2xl">Nombre de la oferta</h3>
                    <span class="text-sm text-[#1A6785] col-span-2">Nombre empresa</span>
                    <p class="font-bold text-base">30 disponibles</p>
                    <p class="font-bold text-[#919191] line-through place-self-end">$25.00</p>
                    <span>15 días restantes</span>
                    <p class="font-bold text-xl text-[#F97316] place-self-end">$20.00</p>
                </div>
            </div>
            <div class="rounded-xl grid grid-cols-[auto_1fr] border-[#929191] border-[1px] overflow-hidden">
                <div class="bg-[#a83131] w-[130px] flex justify-center items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12" viewBox="0 0 24 24">
                        <title>tag</title>
                        <path class=" fill-amber-600"
                            d="M5.5,7A1.5,1.5 0 0,1 4,5.5A1.5,1.5 0 0,1 5.5,4A1.5,1.5 0 0,1 7,5.5A1.5,1.5 0 0,1 5.5,7M21.41,11.58L12.41,2.58C12.05,2.22 11.55,2 11,2H4C2.89,2 2,2.89 2,4V11C2,11.55 2.22,12.05 2.59,12.41L11.58,21.41C11.95,21.77 12.45,22 13,22C13.55,22 14.05,21.77 14.41,21.41L21.41,14.41C21.78,14.05 22,13.55 22,13C22,12.44 21.77,11.94 21.41,11.58Z" />
                    </svg>
                </div>
                <div class="grid grid-cols-[65%_35%] p-3">
                    <h3 class="col-span-2 font-medium text-2xl">Nombre de la oferta</h3>
                    <span class="text-sm text-[#1A6785] col-span-2">Nombre empresa</span>
                    <p class="font-bold text-base">30 disponibles</p>
                    <p class="font-bold text-[#919191] line-through place-self-end">$25.00</p>
                    <span>15 días restantes</span>
                    <p class="font-bold text-xl text-[#F97316] place-self-end">$20.00</p>
                </div>
            </div>
            <div class="rounded-xl grid grid-cols-[auto_1fr] border-[#929191] border-[1px] overflow-hidden">
                <div class="bg-[#a83131] w-[130px] flex justify-center items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12" viewBox="0 0 24 24">
                        <title>tag</title>
                        <path class=" fill-amber-600"
                            d="M5.5,7A1.5,1.5 0 0,1 4,5.5A1.5,1.5 0 0,1 5.5,4A1.5,1.5 0 0,1 7,5.5A1.5,1.5 0 0,1 5.5,7M21.41,11.58L12.41,2.58C12.05,2.22 11.55,2 11,2H4C2.89,2 2,2.89 2,4V11C2,11.55 2.22,12.05 2.59,12.41L11.58,21.41C11.95,21.77 12.45,22 13,22C13.55,22 14.05,21.77 14.41,21.41L21.41,14.41C21.78,14.05 22,13.55 22,13C22,12.44 21.77,11.94 21.41,11.58Z" />
                    </svg>
                </div>
                <div class="grid grid-cols-[65%_35%] p-3">
                    <h3 class="col-span-2 font-medium text-2xl">Nombre de la oferta</h3>
                    <span class="text-sm text-[#1A6785] col-span-2">Nombre empresa</span>
                    <p class="font-bold text-base">30 disponibles</p>
                    <p class="font-bold text-[#919191] line-through place-self-end">$25.00</p>
                    <span>15 días restantes</span>
                    <p class="font-bold text-xl text-[#F97316] place-self-end">$20.00</p>
                </div>
            </div>
            <div class="rounded-xl grid grid-cols-[auto_1fr] border-[#929191] border-[1px] overflow-hidden">
                <div class="bg-[#a83131] w-[130px] flex justify-center items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12" viewBox="0 0 24 24">
                        <title>tag</title>
                        <path class=" fill-amber-600"
                            d="M5.5,7A1.5,1.5 0 0,1 4,5.5A1.5,1.5 0 0,1 5.5,4A1.5,1.5 0 0,1 7,5.5A1.5,1.5 0 0,1 5.5,7M21.41,11.58L12.41,2.58C12.05,2.22 11.55,2 11,2H4C2.89,2 2,2.89 2,4V11C2,11.55 2.22,12.05 2.59,12.41L11.58,21.41C11.95,21.77 12.45,22 13,22C13.55,22 14.05,21.77 14.41,21.41L21.41,14.41C21.78,14.05 22,13.55 22,13C22,12.44 21.77,11.94 21.41,11.58Z" />
                    </svg>
                </div>
                <div class="grid grid-cols-[65%_35%] p-3">
                    <h3 class="col-span-2 font-medium text-2xl">Nombre de la oferta</h3>
                    <span class="text-sm text-[#1A6785] col-span-2">Nombre empresa</span>
                    <p class="font-bold text-base">30 disponibles</p>
                    <p class="font-bold text-[#919191] line-through place-self-end">$25.00</p>
                    <span>15 días restantes</span>
                    <p class="font-bold text-xl text-[#F97316] place-self-end">$20.00</p>
                </div>
            </div>
        </div>
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
