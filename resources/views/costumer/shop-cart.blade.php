@extends('costumer.app')

@section('content')
    <div class="w-full px-[7%] grid grid-cols-[70%_30%] my-10">
        <h1 class="col-span-2 text-center text-4xl font-bold mb-10">Carrito de compras</h1>
        <!-- #region Coupons list -->
        <div class="flex flex-col gap-y-3">
            <div class="w-[80%] border-[1px] border-black grid grid-cols-[30%_70%] bg-white">
                <div class="flex justify-center items-center bg-amber-600">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="max-w-[50px]">
                        <title>star-four-points-outline</title>
                        <path
                            class=" fill-amber-300"
                            d="M12,6.7L13.45,10.55L17.3,12L13.45,13.45L12,17.3L10.55,13.45L6.7,12L10.55,10.55L12,6.7M12,1L9,9L1,12L9,15L12,23L15,15L23,12L15,9L12,1Z" />
                    </svg>
                </div>
                <div class="py-3 px-4 grid grid-cols-[60%_40%] grid-rows-[auto_auto_100px]">
                    <span class="text-[#1A6785] font-bold text-xs">Nombre de la empresa</span>
                    <h4 class="font-bold row-start-2 text-xl">Nombre de la oferta</h4>
                    <h4 class="font-bold row-span-2 place-self-end items-center text-xl">$40.00</h4>
                    <div class="place-content-end">
                        <div class="flex ml-5">
                            <div class="border-[1px] border-black rounded-full w-7 h-7 p-1 hover:cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <title>plus</title>
                                    <path d="M19,13H13V19H11V13H5V11H11V5H13V11H19V13Z" />
                                </svg>
                            </div>
                            <div class="border-b-2 border-b-[#1A6785] w-[50px] text-center relative mx-2">
                                <input type="number" name="" id=""
                                    class="opacity-0 absolute top-0 bottom-0 left-0 right-0 z-10">
                                <span>
                                    1
                                </span>
                            </div>
                            <div class="border-[1px] border-black rounded-full w-7 h-7 p-1 hover:cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <title>minus</title>
                                    <path d="M19,13H5V11H19V13Z" />
                                </svg>
                            </div>
                        </div>

                    </div>
                    <div class="place-self-end">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-7">
                            <title>delete</title>
                            <path class="fill-[#E10000]" d="M19,4H15.5L14.5,3H9.5L8.5,4H5V6H19M6,19A2,2 0 0,0 8,21H16A2,2 0 0,0 18,19V7H6V19Z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <!-- #endregion -->
        <div class="bg-[#E7E7E7] flex flex-col gap-y-5 p-5">
            <h2 class="font-bold text-3xl">Resumen de pedido</h2>
            <div class="flex bg-white justify-between py-3 px-5">
                <span class="font-bold">Total</span>
                <span>$40.00</span>
            </div>
            <div class="grid grid-cols-[70%_30%] bg-white p-5">
                <span class="font-bold">Cantidad de productos</span>
                <span class="place-self-end">1</span>
                <span class="font-bold">Total ahorrado</span>
                <span class="place-self-end">$15.00</span>
            </div>
            <div class="text-white bg-[#1A6785] py-2 text-center font-bold" id="pay-button">
                Pagar
            </div>
        </div>
    </div>

    <script>
        const payButton = document.getElementById("pay-button");

        payButton.addEventListener('click', () => {
            location.href = @json(route('pay.view'));
            console.log(@json(route('pay.view')));
        });
    </script>
@endsection
