@extends('costumer.app')

@section('content')
    <form action="{{ route('pay.request') }}" method="post" class="w-full px-[7%] grid grid-cols-[70%_30%] mt-10 mb-16">
        <h1 class="col-span-2 text-center text-4xl font-bold my-10">Proceso de compra</h1>
        <div class="flex justify-center">
            <div class="w-[70%] grid grid-cols-4 grid-rows-[50px_50px_50px_50px] gap-x-3 gap-y-5 max-h-max">
                @csrf
                <h6 class="text-2xl mb-5 col-span-2">Detalle de pago</h6>
                <div class="relative flex flex-col group mt-5 col-span-4">
                    <input type="text" name="card_holder_name" id="card_holder_name"
                        class="outline-none right-0 border-none peer" placeholder=" ">
                    @error('card_holder_name')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                    <label for="card_holder_name"
                        class="absolute bottom-full peer-placeholder-shown:bottom-0 peer-focus:bottom-full transition-all duration-500 ease-in-out text-[#116399] peer-placeholder-shown:text-black peer-focus:text-[#116399] font-medium">Nombre
                        del titular</label>
                    <div class="border-b-2 border-b-gray-800 w-full absolute -bottom-px rounded-3xl"></div>
                    <div
                        class="w-full bg-linear-65 from-[#116399] to-[#38caef] absolute h-[3px] -bottom-0.5 rounded-3xl max-w-full peer-placeholder-shown:max-w-0 peer-focus:max-w-full transition-all duration-500 ease-out z-10">
                    </div>
                </div>
                <div class="relative flex flex-col group mt-5 col-span-4">
                    <input type="text" name="card_number" id="card_number" class="outline-none right-0 border-none peer"
                        placeholder=" ">
                    @error('card_number')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                    <label for="card_number"
                        class="absolute bottom-full peer-placeholder-shown:bottom-0 peer-focus:bottom-full transition-all duration-500 ease-in-out text-[#116399] peer-placeholder-shown:text-black peer-focus:text-[#116399] font-medium">Número
                        de tarjeta</label>
                    <div class="border-b-2 border-b-gray-800 w-full absolute -bottom-px rounded-3xl"></div>
                    <div
                        class="w-full bg-linear-65 from-[#116399] to-[#38caef] absolute h-[3px] -bottom-0.5 rounded-3xl max-w-full peer-placeholder-shown:max-w-0 peer-focus:max-w-full transition-all duration-500 ease-out z-10">
                    </div>
                </div>
                <div class="relative flex flex-col group mt-5 col-span-2">
                    <input type="text" name="cvv" id="cvv" class="outline-none right-0 border-none peer"
                        placeholder=" ">
                    @error('cvv')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                    <label for="cvv"
                        class="absolute bottom-full peer-placeholder-shown:bottom-0 peer-focus:bottom-full transition-all duration-500 ease-in-out text-[#116399] peer-placeholder-shown:text-black peer-focus:text-[#116399] font-medium">CVV</label>
                    <div class="border-b-2 border-b-gray-800 w-full absolute -bottom-px rounded-3xl"></div>
                    <div
                        class="w-full bg-linear-65 from-[#116399] to-[#38caef] absolute h-[3px] -bottom-0.5 rounded-3xl max-w-full peer-placeholder-shown:max-w-0 peer-focus:max-w-full transition-all duration-500 ease-out z-10">
                    </div>
                </div>
                <div class="relative flex flex-col group mt-5">
                    <input type="text" name="expiration_month" id="expiration_month"
                        class="outline-none right-0 border-none peer" placeholder=" ">
                    @error('expiration_month')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                    <label for="expiration_month"
                        class="absolute bottom-full peer-placeholder-shown:bottom-0 peer-focus:bottom-full transition-all duration-500 ease-in-out text-[#116399] peer-placeholder-shown:text-black peer-focus:text-[#116399] font-medium">
                        Mes</label>
                    <div class="border-b-2 border-b-gray-800 w-full absolute -bottom-px rounded-3xl"></div>
                    <div
                        class="w-full bg-linear-65 from-[#116399] to-[#38caef] absolute h-[3px] -bottom-0.5 rounded-3xl max-w-full peer-placeholder-shown:max-w-0 peer-focus:max-w-full transition-all duration-500 ease-out z-10">
                    </div>
                </div>
                <div class="relative flex flex-col group mt-5">
                    <input type="text" name="expiration_year" id="expiration_year"
                        class="outline-none right-0 border-none peer" placeholder=" ">
                    @error('expiration_year')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                    <label for="expiration_year"
                        class="absolute bottom-full peer-placeholder-shown:bottom-0 peer-focus:bottom-full transition-all duration-500 ease-in-out text-[#116399] peer-placeholder-shown:text-black peer-focus:text-[#116399] font-medium">
                        Año</label>
                    <div class="border-b-2 border-b-gray-800 w-full absolute -bottom-px rounded-3xl"></div>
                    <div
                        class="w-full bg-linear-65 from-[#116399] to-[#38caef] absolute h-[3px] -bottom-0.5 rounded-3xl max-w-full peer-placeholder-shown:max-w-0 peer-focus:max-w-full transition-all duration-500 ease-out z-10">
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-[#E7E7E7] p-4 flex flex-col gap-y-5">
            <h4 class="font-bold text-3xl">Resumen de pedido</h4>
            <div class="flex flex-col bg-white p-4 gap-y-4 min-h-52">
                @foreach ($cartDetails as $item)
                    <div class="grid grid-cols-[50px_1fr_auto]">
                        <span>{{ $item->quantity }}</span>
                        <span>{{ $item->title }}</span>
                        <span>${{ $item->price }}</span>
                    </div>
                @endforeach

            </div>
            <div class="flex gap-x-3 text-xl">
                <span>Total de compra:</span>
                <span class="font-bold">${{ number_format($totalCents / 100, 2) }}</span>
            </div>
            <button type="submit" class="font-bold text-center bg-[#1A6785] py-2 text-white">
                Confirmar compra
            </button>
        </div>
    </form>
    <script>
        console.log(@json($cartDetails))
    </script>
@endsection
