@extends('costumer.app')

@section('content')
<div class="w-full px-[7%] grid grid-cols-[70%_30%] mt-10 mb-16">
    <h1 class="col-span-2 text-center text-4xl font-bold my-10">Work almost done...</h1>
    <div class="flex justify-center">
        <form action="{{ route('pay.request') }}" method="post" class="w-[70%] grid grid-cols-2 grid-rows-[50px_50px_50px_50px] gap-x-3 gap-y-5 max-h-max">
            @csrf
            <h6 class="text-2xl mb-5">Detalle de pago</h6>
            <div class="relative flex flex-col group mt-5 col-span-2">
                <input type="text" name="name" id="name" class="outline-none right-0 border-none peer" placeholder=" ">
                <label for="name" class="absolute bottom-full peer-placeholder-shown:bottom-0 peer-focus:bottom-full transition-all duration-500 ease-in-out text-[#116399] peer-placeholder-shown:text-black peer-focus:text-[#116399] font-medium">Nombre del titular</label>
                <div class="border-b-2 border-b-gray-800 w-full absolute -bottom-px rounded-3xl"></div>
                <div class="w-full bg-linear-65 from-[#116399] to-[#38caef] absolute h-[3px] -bottom-0.5 rounded-3xl max-w-full peer-placeholder-shown:max-w-0 peer-focus:max-w-full transition-all duration-500 ease-out z-10"></div>
            </div>
            <div class="relative flex flex-col group mt-5 col-span-2">
                <input type="text" name="card_number" id="card_number" class="outline-none right-0 border-none peer" placeholder=" ">
                <label for="card_number" class="absolute bottom-full peer-placeholder-shown:bottom-0 peer-focus:bottom-full transition-all duration-500 ease-in-out text-[#116399] peer-placeholder-shown:text-black peer-focus:text-[#116399] font-medium">Número de tarjeta</label>
                <div class="border-b-2 border-b-gray-800 w-full absolute -bottom-px rounded-3xl"></div>
                <div class="w-full bg-linear-65 from-[#116399] to-[#38caef] absolute h-[3px] -bottom-0.5 rounded-3xl max-w-full peer-placeholder-shown:max-w-0 peer-focus:max-w-full transition-all duration-500 ease-out z-10"></div>
            </div>
            <div class="relative flex flex-col group mt-5">
                <input type="text" name="cvv" id="cvv" class="outline-none right-0 border-none peer" placeholder=" ">
                <label for="cvv" class="absolute bottom-full peer-placeholder-shown:bottom-0 peer-focus:bottom-full transition-all duration-500 ease-in-out text-[#116399] peer-placeholder-shown:text-black peer-focus:text-[#116399] font-medium">CVV</label>
                <div class="border-b-2 border-b-gray-800 w-full absolute -bottom-px rounded-3xl"></div>
                <div class="w-full bg-linear-65 from-[#116399] to-[#38caef] absolute h-[3px] -bottom-0.5 rounded-3xl max-w-full peer-placeholder-shown:max-w-0 peer-focus:max-w-full transition-all duration-500 ease-out z-10"></div>
            </div>
            <div class="relative flex flex-col group mt-5">
                <input type="text" name="expiration_date" id="expiration_date" class="outline-none right-0 border-none peer" placeholder=" ">
                <label for="expiration_date" class="absolute bottom-full peer-placeholder-shown:bottom-0 peer-focus:bottom-full transition-all duration-500 ease-in-out text-[#116399] peer-placeholder-shown:text-black peer-focus:text-[#116399] font-medium">Fecha de vencimiento</label>
                <div class="border-b-2 border-b-gray-800 w-full absolute -bottom-px rounded-3xl"></div>
                <div class="w-full bg-linear-65 from-[#116399] to-[#38caef] absolute h-[3px] -bottom-0.5 rounded-3xl max-w-full peer-placeholder-shown:max-w-0 peer-focus:max-w-full transition-all duration-500 ease-out z-10"></div>
                {{-- <div class="border-b-4 border-b-[#116399] absolute -bottom-0.5 w-full max-w-full z-[2] peer-placeholder-shown:max-w-0 peer-focus:max-w-full transition-all duration-500 ease-out rounded-3xl"></div> --}}
            </div>
        </form>
    </div>
    <div class="bg-[#E7E7E7] p-4 flex flex-col gap-y-5">
        <h4 class="font-bold text-3xl">Resumen de pedido</h4>
        <div class="flex flex-col bg-white p-4 gap-y-4 min-h-52">
            <div class="grid grid-cols-[50px_1fr_auto]">
                <span>1</span>
                <span>Nombre del cupón</span>
                <span>$40.00</span>
            </div>
        </div>
        <div class="font-bold text-center bg-[#1A6785] py-2 text-white">
            Confirmar compra
        </div>
    </div>
</div>
@endsection
