@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">
    <h2 class="text-3xl font-bold mb-6 text-gray-800">Bienvenido, administrador!</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6 rounded-lg">
        <div class="bg-orange-100 p-4 rounded-lg shadow flex flex-col items-start">
            <div class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                <x-heroicon-o-building-storefront class="w-6 h-6"/> Empresas
            </div>
            <div class="text-4xl font-bold mt-2">{{ $totalEmpresas }}</div>
        </div>
        <div class="bg-red-100 p-4 rounded-lg shadow flex flex-col items-start">
            <div class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                <x-heroicon-o-users class="w-6 h-6"/> Usuarios
            </div>
            <div class="text-4xl font-bold mt-2">{{ $totalUsuarios }}</div>
        </div>
        <div class="bg-lime-100 p-4 rounded-lg shadow flex flex-col items-start">
            <div class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                <x-heroicon-o-ticket class="w-6 h-6"/> Cupones
            </div>
            <div class="text-4xl font-bold mt-2">{{ $totalCupones }}</div>
        </div>
    </div>
    

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="md:col-span-2 bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
                <x-heroicon-o-currency-dollar class="w-5 h-5"/> Ganancias totales
            </h3>
            <canvas id="earningsChart" height="100"></canvas>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4 text-center">Mayo</h3>
            <div class="text-center text-sm text-gray-600">
                @php
                    $today = \Carbon\Carbon::now();
                    $start = $today->copy()->startOfMonth();
                    $end = $today->copy()->endOfMonth();
                @endphp
                <div class="grid grid-cols-7 gap-1">
                    @foreach (['L', 'M', 'M', 'J', 'V', 'S', 'D'] as $day)
                        <div class="font-bold">{{ $day }}</div>
                    @endforeach
                    @for ($i = 1; $i <= $start->dayOfWeekIso - 1; $i++)
                        <div></div>
                    @endfor
                    @for ($i = 1; $i <= $end->day; $i++)
                        <div class="{{ $i == now()->day ? 'bg-blue-200 font-bold rounded' : '' }}">{{ $i }}</div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
    
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('earningsChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($meses) !!},
            datasets: [{
                label: 'Ganancias ($)',
                data: {!! json_encode($ganancias) !!},
                borderColor: '#60a5fa',
                backgroundColor: 'rgba(96,165,250,0.1)',
                tension: 0.4
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1000
                    }
                }
            }
        }
    });
</script>
@endsection