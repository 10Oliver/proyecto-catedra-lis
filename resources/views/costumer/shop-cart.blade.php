@extends('costumer.app')

@section('content')
    @php
        $colors = ['bg-red-500', 'bg-blue-500', 'bg-green-500', 'bg-yellow-500', 'bg-purple-500'];
        $icons = ['local_offer', 'star', 'shopping_cart', 'loyalty', 'emoji_events'];
    @endphp
    <div class="w-full px-[7%] grid grid-cols-[70%_30%] my-10">
        <h1 class="col-span-2 text-center text-4xl font-bold mb-10">Carrito de compras</h1>
        <!-- #region Coupons list -->
        <div class="flex flex-col gap-y-3">
            @forelse ($cartDetails as $offer)
                @php
                    $hash = crc32($offer->offer_uuid);
                    $color = $colors[$hash % count($colors)];
                    $icon = $icons[$hash % count($icons)];
                @endphp
                <div class="w-[80%] border-[1px] border-black grid grid-cols-[30%_70%] bg-white">
                    <div class="{{ $color }} flex justify-center items-center h-full">
                        <span class="material-symbols-outlined !text-6xl !text-white">
                            {{ $icon }}
                        </span>
                    </div>
                    <div class="py-3 px-4 grid grid-cols-[60%_40%] grid-rows-[auto_auto_100px]">
                        <span class="text-[#1A6785] font-bold text-xs">{{ $offer->companies->first()->name ?? 'Sin empresa' }} </span>
                        <h4 class="font-bold row-start-2 text-xl">{{ $offer->title }}</h4>
                        <h4 class="font-bold row-span-2 place-self-end items-center text-xl">
                            ${{ $offer->offer_price }}</h4>
                        <div class="place-content-end">
                            <div class="flex ml-5">
                                <div onclick="decrease('{{ $offer->offer_uuid }}')"
                                    class="border-[1px] border-black rounded-full w-7 h-7 hover:cursor-pointer flex justify-center items-center select-none">
                                    <span class="material-symbols-outlined">
                                        remove
                                    </span>
                                </div>
                                <div class="border-b-2 border-b-[#1A6785] w-[50px] text-center relative mx-2 select-none">
                                    <span id="{{ $offer->offer_uuid }}">
                                        {{ $offer->quantity }}
                                    </span>
                                </div>
                                <div onclick="increase('{{ $offer->offer_uuid }}')"
                                    class="border-[1px] border-black rounded-full w-7 h-7 hover:cursor-pointer flex justify-center items-center select-none">
                                    <span class="material-symbols-outlined">
                                        add
                                    </span>
                                </div>
                            </div>

                        </div>
                        <div class="place-self-end hover:cursor-pointer" onclick="remove('{{ $offer->offer_uuid }}')">
                            <span class="material-symbols-outlined !text-red-700 !text-2xl">
                                delete
                                </span>
                        </div>
                    </div>
                </div>
            @empty
            <div class="w-full py-5">
                <h6 class="font-semibold text-center text-xl">No hay productos</h6>
            </div>
            @endforelse
        </div>
        <!-- #endregion -->
        <div class="bg-[#E7E7E7] flex flex-col gap-y-5 p-5">
            <h2 class="font-bold text-3xl">Resumen de pedido</h2>
            <div class="flex bg-white justify-between py-3 px-5">
                <span class="font-bold">Total</span>
                <span>${{ number_format($totalCents / 100, 2) }}</span>
            </div>
            <div class="grid grid-cols-[70%_30%] bg-white p-5">
                <span class="font-bold">Cantidad de productos</span>
                <span class="place-self-end"> {{ $totalCoupons }}</span>
                <span class="font-bold">Total ahorrado</span>
                <span class="place-self-end">${{ number_format($discountsCents / 100, 2) }}</span>
            </div>
            <div class="text-white bg-[#1A6785] py-2 text-center font-bold hover:cursor-pointer" id="pay-button">
                Pagar
            </div>
        </div>
    </div>

    <script>
        const payButton = document.getElementById("pay-button");
        const emptyCart = @json($totalCoupons);

        payButton.addEventListener('click', () => {
            if (!emptyCart) {
                showToast("#ca9f00", 'Necesitar agregar al menos un cupón para continuar');
                return;
            }
            location.href = @json(route('pay.view'));
        });

        const decrease = async (id) => {
            let endpoint = @json(route('cart.decrease', ['uuid' => 'UUID']));
            endpoint = endpoint.replace('UUID', id);
            const response = await fetch(endpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({})
            });

            const data = await response.json();
            if (response.ok) {
                showToast("#008532", data.message);
                document.getElementById(id).textContent = data.new_quantity;
            } else {
                showToast("#ca9f00", data.message || "Error en la operación del carrito.");
            }
        }
        const increase = async (id) => {
            let endpoint = @json(route('cart.increase', ['uuid' => 'UUID']));
            endpoint = endpoint.replace('UUID', id);
            const response = await fetch(endpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({})
            });

            const data = await response.json();
            if (response.ok) {
                showToast("#008532", data.message);
                document.getElementById(id).textContent = data.new_quantity;
            } else {
                showToast("#ca9f00", data.message || "Error en la operación del carrito.");
            }
        }

        const remove = async (id) => {
            console.log(id)
            let endpoint = @json(route('cart.remove', ['uuid' => 'UUID']));
            endpoint = endpoint.replace('UUID', id);
            const response = await fetch(endpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({})
            });

            const data = await response.json();
            if (response.ok) {
                window.location.href = @json(route('cart.view'))
            } else {
                showToast("#ca9f00", data.message || "Error en la operación del carrito.");
            }
        }
    </script>
@endsection
