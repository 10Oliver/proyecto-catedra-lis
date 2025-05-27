@extends('costumer.app')

@section('content')
    @php
        $colors = ['bg-red-500', 'bg-blue-500', 'bg-green-500', 'bg-yellow-500', 'bg-purple-500'];
        $icons = ['local_offer', 'star', 'shopping_cart', 'loyalty', 'emoji_events'];
        $hash = crc32($offer->offer_uuid);
        $color = $colors[$hash % count($colors)];
        $icon = $icons[$hash % count($icons)];
    @endphp
    <div class="flex justify-center py-16 min-h-[61vh]">
        <div class="grid grid-cols-2 w-3/5 gap-y-5 gap-x-7 relative">
            <a href="{{ url('/') }}" class="absolute -left-12 hover:cursor-pointer">
                <span class="material-symbols-outlined">
                    arrow_back
                </span>
            </a>
            <div class="{{ $color }} flex justify-center items-center h-64">
                <span class="material-symbols-outlined !text-6xl !text-white">
                    {{ $icon }}
                </span>
            </div>
            <div class="flex flex-col gap-y-2">
                <h4 class="font-bold text-3xl">{{ $offer->title }}</h4>
                <span class="font-medium text-sm -mt-1">{{ $offer->companies->first()?->name }}</span>
                <div class="flex flex-col">
                    <span class="text-gray-400 line-through">${{ $offer->regular_price }}</span>
                    <span class="text-[#F97316] text-xl font-bold -mt-2">${{ $offer->offer_price }}</span>
                </div>
                <span>
                    Días restantes:
                    <span class="font-bold">{{ $offer->days_left }}</span>
                </span>
                <div class="flex gap-x-3 mt-5 mb-9">
                    <a id="minus-button" class="select-none hover:cursor-pointer text-gray-400">
                        <span class="material-symbols-outlined">
                            remove
                        </span>
                    </a>
                    <div class="relative w-16">
                        <input type="number" name="quantity" id="quantity" disabled
                            class="w-full h-full text-center outline-none ring-0 select-none" value="1">
                        <div class="border-b-[1px] border-b-black w-full absolute bottom-0"></div>
                    </div>
                    <a id="add-button" class="select-none hover:cursor-pointer">
                        <span class="material-symbols-outlined">
                            add
                        </span>
                    </a>
                </div>
                <a id="cart-button" class="py-3 px-5 bg-blue-500 text-white max-w-max font-medium rounded-sm">
                    Agregar al carrito
                </a>
            </div>
            <p class="text-base col-span-2">
                {{ $offer->description }}
            </p>
        </div>
    </div>
    <script>
        const quantityField = document.getElementById("quantity");
        const addButton = document.getElementById("add-button");
        const minusButton = document.getElementById("minus-button");
        const cartButton = document.getElementById("cart-button");
        const offerAmount = @json($offer->amount);
        const isAuthenticated = @json(Auth::check());

        quantityField.value = 1;

        addButton.addEventListener('click', () => {
            if (quantityField.value >= 5 || (offerAmount && Number(quantityField.value)) >= offerAmount) {
                showToast('#ca9f00', 'No puedes agregar más cupones');
                addButton.classList.add('text-gray-400');
                return;
            }
            minusButton.classList.remove('text-gray-400');
            quantityField.value++;
        });

        minusButton.addEventListener('click', () => {
            if (quantityField.value <= 1) {
                showToast('#ca9f00', 'El mínimo de cupones es 1');
                minusButton.classList.add('text-gray-400');
                return;
            }
            addButton.classList.remove('text-gray-400');
            quantityField.value--;
        });

        cartButton.addEventListener('click', async () => {
            const uuid = @json($offer->offer_uuid);
            const newQuantity = Number(quantityField.value);

            if (!isAuthenticated) {
                showToast("#ca9f00", "Debes de iniciar sesión para guardar productos en el carrito");
                return;
            }

            try {
                const response = await fetch(@json(route('cart.add')), {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        offer_uuid: uuid,
                        quantity: newQuantity
                    }),
                });

                const data = await response.json();

                if (response.ok) {
                    showToast("#008532", data.message);
                    quantityField.value = 1;
                } else {
                    showToast("#ca9f00", data.message || "Error al añadir producto.");
                }
            } catch (error) {
                console.error('Error al añadir al carrito:', error);
                showToast("#ff0000", "Error de conexión. Inténtalo de nuevo.");
            }
        });
    </script>
@endsection
