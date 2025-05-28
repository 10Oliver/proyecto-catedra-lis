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
            @php
                $colors = ['bg-red-500', 'bg-blue-500', 'bg-green-500', 'bg-yellow-500', 'bg-purple-500'];
                $icons = ['local_offer', 'star', 'shopping_cart', 'loyalty', 'emoji_events'];
            @endphp
            @forelse ($availableOffers as $offer)
                @php
                    $hash = crc32($offer->offer_uuid);
                    $color = $colors[$hash % count($colors)];
                    $icon = $icons[$hash % count($icons)];
                @endphp
                <a href="{{ route('offer.detail.view', ['id' => $offer->offer_uuid]) }}"
                    class="rounded-xl grid grid-cols-[auto_1fr] border-[#929191] border-[1px] overflow-hidden">
                    <div class="{{ $color }} w-[130px] flex justify-center items-center">
                        <span class="material-symbols-outlined !text-5xl !text-white">
                            {{ $icon }}
                        </span>
                    </div>
                    <div class="grid grid-cols-[65%_35%] p-3 min-w-[250px]">
                        <h3 class="col-span-2 font-medium text-2xl">{{ $offer->title }}</h3>
                        <span class="text-sm text-[#1A6785] col-span-2">{{ $offer->companies->first()?->name }}</span>
                        @if ($offer->amount == null)
                            <p class="font-bold text-base">Sin limite</p>
                        @else
                            <p class="font-bold text-base">{{ $offer->available_quantity }} disponibles</p>
                        @endif
                        <p class="font-bold text-[#919191] line-through place-self-end">${{ $offer->regular_price }}</p>
                        <span>{{ $offer->days_left }} días restantes</span>
                        <p class="font-bold text-xl text-[#F97316] place-self-end">${{ $offer->offer_price }}</p>
                    </div>
                </a>
            @empty
                <p>No hay cupones disponibles</p>
            @endforelse

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
