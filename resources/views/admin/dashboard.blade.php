{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.app')

@push('styles')
<style>
  /* tu imagen de fondo */
  .dashboard-bg {
    background: url('{{ asset("resources/admin/admin-dashboard1.jpg") }}') center/cover no-repeat;
  }
</style>
@endpush

@section('title', 'Dashboard')

@section('content')
  <div class="relative min-h-screen dashboard-bg">
    {{-- capa semitransparente --}}
    <div class="absolute inset-0 bg-white opacity-75 -z-10"></div>

    <div class="relative z-10 p-16 space-y-8">
      <h2 class="text-3xl font-bold text-gray-100">
        Bienvenido, administrador!
      </h2>

      {{-- TARJETAS --}}
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 rounded-2xl">
        <div class="bg-rose-100/80 p-6 rounded-2xl shadow">
          <div class="flex items-center gap-2 text-lg font-semibold text-gray-800 h-15 text-center">
            <x-heroicon-o-building-storefront class="w-8 h-8"/> Empresas
          </div>
          <div class="mt-2 text-4xl font-bold text-gray-900 text-center">
            {{ $totalEmpresas }}
          </div>
        </div>
        <div class="bg-blue-100/80 p-6 rounded-2xl shadow">
          <div class="flex items-center gap-2 text-lg font-semibold text-gray-800 h-15">
            <x-heroicon-o-users class="w-8 h-8"/> Usuarios
          </div>
          <div class="mt-2 text-4xl font-bold text-gray-900 text-center">
            {{ $totalUsuarios }}
          </div>
        </div>
        <div class="bg-purple-100/80 p-6 rounded-2xl shadow">
          <div class="flex items-center gap-2 text-lg font-semibold text-gray-800 h-15">
            <x-heroicon-o-ticket class="w-8 h-8"/> Cupones
          </div>
          <div class="mt-2 text-4xl font-bold text-gray-900 text-center">
            {{ $totalCupones }}
          </div>
        </div>
      </div>

      {{-- Grafica y calendario --}}
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- Gráfica --}}
        <div class="md:col-span-2 bg-slate-100/90 rounded-2xl shadow p-6">
          <h3 class="flex items-center gap-2 text-lg font-semibold text-gray-900 mb-4">
            <x-heroicon-o-currency-dollar class="w-8 h-8"/> Ganancias totales
          </h3>
          <canvas id="earningsChart" height="100"></canvas>
        </div>

        {{-- Calendario --}}
        <div class="bg-slate-100/90 rounded-2xl shadow p-6">
          <h3 class="text-center text-lg font-semibold text-gray-900 mb-4">
            {{ \Carbon\Carbon::now()->locale('es')->isoFormat('MMMM YYYY') }}
          </h3>

          @php
            $start = \Carbon\Carbon::now()->startOfMonth();
            $end   = \Carbon\Carbon::now()->endOfMonth();
            $daysOfWeek = ['L','M','M','J','V','S','D'];
          @endphp

          <div class="grid grid-cols-7 gap-1 text-center text-gray-700">
           
            @foreach($daysOfWeek as $day)
              <div class="font-bold">{{ $day }}</div>
            @endforeach

            @for($i = 1; $i < $start->dayOfWeekIso; $i++)
              <div></div>
            @endfor

            @for($d = 1; $d <= $end->day; $d++)
              <div class="py-1 {{ $d == now()->day ? 'bg-blue-300 text-white rounded-full' : '' }}">
                {{ $d }}
              </div>
            @endfor
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
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
        backgroundColor: 'rgba(49, 84, 128, 0.1)',
        tension: 0.4
      }]
    },
    options: {
      scales: {
        y: { beginAtZero: true, ticks: { stepSize: 1000 } }
      }
    }
  });
</script>
@endpush
