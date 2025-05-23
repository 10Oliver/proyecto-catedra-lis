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
        <div class="grid grid-cols-2 w-3/5 gap-y-5 gap-x-7">
            <div class="{{ $color }} flex justify-center items-center h-64">
                <span class="material-symbols-outlined !text-5xl !text-white">
                    {{ $icon }}
                </span>
            </div>
            <div class="flex flex-col gap-y-2">
                <h4 class="font-bold text-3xl">{{ $offer->title }}</h4>
                <span class="font-medium text-sm -mt-1">{{ $offer->companies->first()?->name }}</span>
                <div class="flex flex-col">
                    <span class="text-gray-400 line-through">${{ $offer->regular_price }}</span>
                    <span class="text-[#F97316] text-xl font-bold -mt-3">${{ $offer->offer_price }}</span>
                </div>
                <span>
                    Días restantes:
                    <span class="font-bold">{{ $offer->days_left }}</span>
                </span>
                <div class="flex gap-x-3 mt-5 mb-9">
                    <a>
                        <span class="material-symbols-outlined">
                            remove
                        </span>
                    </a>
                    <div class="relative w-16">
                        <input type="number" name="quantity" id="quantity" disabled class="w-full h-full text-center outline-none ring-0" value="1">
                        <div class="border-b-[1px] border-b-black w-full absolute bottom-0"></div>
                    </div>
                    <a>
                        <span class="material-symbols-outlined">
                            add
                        </span>
                    </a>
                </div>
                <a class="py-3 px-5 bg-blue-500 text-white max-w-max font-medium rounded-sm">
                    Agregar al carrito
                </a>
            </div>
            <p class="text-base col-span-2">
                {{ $offer->description }}
            </p>
        </div>
    </div>
@endsection
