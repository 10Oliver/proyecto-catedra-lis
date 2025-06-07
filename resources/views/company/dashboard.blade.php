@extends('company.app')

@section('title', 'Panel de Empresa')

@section('content')
<div class="container mx-auto px-4 mt-6">
    <h2 class="text-2xl font-semibold mb-4">Cupones Recientes</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($cupones as $cupon)
            <div class="bg-white shadow-md rounded-lg p-6">
                <h3 class="text-xl font-bold mb-2">{{ $cupon->titulo }}</h3>
                <p class="text-gray-700 mb-2">{{ $cupon->descripcion }}</p>
                <p class="text-sm text-gray-500">Válido hasta: {{ \Carbon\Carbon::parse($cupon->fecha_expiracion)->format('d/m/Y') }}</p>
                <a href="{{ route('cupones.show', $cupon->id) }}" class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Ver más</a>
            </div>
        @empty
            <p>No hay cupones disponibles en este momento.</p>
        @endforelse
    </div>
</div>
@endsection
