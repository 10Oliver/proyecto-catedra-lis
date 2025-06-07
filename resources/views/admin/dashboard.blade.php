@extends('layouts.app')

@push('styles')
<style>
  .dashboard-bg {
    background: url('{{ asset("resources/admin/admin-dashboard1.jpg") }}') center/cover no-repeat;
  }
  .card-hover { transition: .2s; }
  .card-hover:hover { transform: translateY(-4px); box-shadow:0 8px 20px rgba(0,0,0,.1); }
  .tabla-empresas { max-height:400px; overflow-y:auto; }
</style>
@endpush

@section('title','Dashboard')

@section('content')
<div class="relative min-h-screen dashboard-bg">
  <div class="absolute inset-0 bg-white/80 -z-10"></div>

  <div class="relative z-10 p-8 space-y-6">

    {{-- CARDS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

      {{-- Empresas --}}
      <div class="card-hover p-6 rounded-2xl shadow-lg bg-rose-100/80">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-900">Empresas</p>
            <p class="mt-2 text-3xl font-bold text-gray-900">{{ number_format($totalEmpresas) }}</p>
            <span class="block text-xs text-green-800">{{ $empresasAprobadas }} aprobadas</span>
            <span class="block text-xs text-blue-900">{{ $empresasPendientes }} pendientes</span>
          </div>
          <x-heroicon-o-building-storefront class="w-12 h-12 text-gray-900"/>
        </div>
      </div>

      {{-- Usuarios --}}
      <div class="card-hover p-6 rounded-2xl shadow-lg bg-rose-100/80">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-900">Usuarios</p>
            <p class="mt-2 text-3xl font-bold text-gray-900">{{ number_format($totalUsuarios) }}</p>
            <span class="block text-xs text-green-800">{{ $usuariosNuevos }} nuevos</span>
          </div>
          <x-heroicon-o-users class="w-12 h-12 text-gray-900"/>
        </div>
      </div>

      {{-- Ofertas --}}
      <div class="card-hover p-6 rounded-2xl shadow-lg bg-blue-100/80">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-900">Ofertas</p>
            <p class="mt-2 text-3xl font-bold text-gray-900">{{ number_format($totalOfertas) }}</p>
          </div>
          <x-heroicon-o-gift class="w-12 h-12 text-gray-900"/>
        </div>
      </div>

      {{-- Cupones vendidos --}}
      <div class="card-hover p-6 rounded-2xl shadow-lg bg-purple-100/80">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-900">Cupones vendidos</p>
            <p class="mt-2 text-3xl font-bold text-gray-900">{{ number_format($cuponesVendidos) }}</p>
          </div>
          <x-heroicon-o-ticket class="w-12 h-12 text-gray-900"/>
        </div>
      </div>

    </div>

    {{-- FILTRO DE FECHAS --}}
    <form method="GET" class="flex flex-wrap gap-2 items-end mb-6 bg-white/70 p-4 rounded-xl shadow">
      <div>
        <label class="block text-sm font-medium">Desde</label>
        <input type="date" name="start_date" 
               value="{{ $startDate->format('Y-m-d') }}"
               class="mt-1 block w-full border rounded p-2 text-sm"/>
      </div>
      <div>
        <label class="block text-sm font-medium">Hasta</label>
        <input type="date" name="end_date" 
               value="{{ $endDate->format('Y-m-d') }}"
               class="mt-1 block w-full border rounded p-2 text-sm"/>
      </div>
      <button type="submit" 
              class="px-4 py-2 bg-blue-800 text-white rounded-lg hover:bg-blue-700 ">
        Filtrar
      </button>
    </form>

    {{-- INGRESOS vs GANANCIAS --}}
    <div class="bg-white/90 rounded-2xl shadow p-6">
      <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
        <x-heroicon-o-currency-dollar class="w-6 h-6"/> Ingresos vs Ganancias
      </h3>
      <canvas id="revChart" height="100"></canvas>
    </div>

    {{-- DETALLE POR EMPRESA --}}
    <div class="bg-white/90 rounded-2xl shadow p-6 tabla-empresas">
      <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
        <x-heroicon-o-squares-2x2 class="w-5 h-5"/> Estadísticas por Empresa
        <span class="text-sm font-normal text-gray-600">
          ({{ $startDate->format('d/m/Y') }} – {{ $endDate->format('d/m/Y') }})
        </span>
      </h3>

      @if($detallePorEmpresa->isEmpty())
        <p class="text-gray-600">No hay datos en el periodo seleccionado.</p>
      @else
      <table class="w-full text-sm">
        <thead class="bg-gray-50">
          <tr>
            <th class="p-2 text-left">Empresa</th>
            <th class="p-2 text-right">Cupones</th>
            <th class="p-2 text-right">Ventas</th>
            <th class="p-2 text-right">Ganancias</th>
          </tr>
        </thead>
        <tbody class="divide-y">
          @foreach($detallePorEmpresa as $item)
          <tr>
            <td class="p-2">{{ $item->company_name }}</td>
            <td class="p-2 text-right">{{ number_format($item->total_coupons_sold) }}</td>
            <td class="p-2 text-right">${{ number_format($item->total_sales,2,'.',',') }}</td>
            <td class="p-2 text-right">${{ number_format($item->total_earnings,2,'.',',') }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
      @endif
    </div>

  </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const ctx = document.getElementById('revChart').getContext('2d');
  new Chart(ctx, {
    type: 'line',
    data: {
      labels: @json($meses),
      datasets: [
        {
          label: 'Ingresos ($)',
          data: @json($ingresos),
          borderColor: '#10b981',
          backgroundColor: 'rgba(16,185,129,0.2)',
          tension: 0.3,
          fill: true,
        },
        {
          label: 'Ganancias ($)',
          data: @json($ganancias),
          borderColor: '#3b82f6',
          backgroundColor: 'rgba(59,130,246,0.2)',
          tension: 0.3,
          fill: true,
        }
      ]
    },
    options: {
      responsive: true,
      interaction: { mode:'index', intersect: false },
      plugins: {
        tooltip: {
          callbacks: {
            label: ctx => '$' + ctx.parsed.y.toLocaleString()
          }
        },
        legend: { position: 'bottom' }
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            callback: v => '$' + v.toLocaleString()
          }
        }
      }
    }
  });
</script>
@endpush
