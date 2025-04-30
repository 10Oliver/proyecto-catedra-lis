@extends('layouts.app')

@section('content')
<div class="p-6" x-data="{ showModal: false, actionUrl: '', percentage: '' }">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Gestión de Empresas</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full text-sm text-left border rounded bg-white shadow">
            <thead class="bg-gray-100 uppercase text-gray-700 text-xs">
                <tr>
                    <th class="px-4 py-3">Empresa</th>
                    <th class="px-4 py-3">NIT</th>
                    <th class="px-4 py-3">Correo</th>
                    <th class="px-4 py-3">Estado</th>
                    <th class="px-4 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach($empresas as $empresa)
                <tr>
                    <td class="px-4 py-3">{{ $empresa->name }}</td>
                    <td class="px-4 py-3">{{ $empresa->nit }}</td>
                    <td class="px-4 py-3">{{ $empresa->email }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold text-white
                            {{ $empresa->status === 'pendiente' ? 'bg-yellow-500' :
                               ($empresa->status === 'aprobada' ? 'bg-green-600' : 'bg-red-600') }}">
                            {{ ucfirst($empresa->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 space-x-2">
                        @if($empresa->status === 'pendiente')
                            <button 
                                @click="showModal = true; actionUrl = '{{ route('admin.empresas.aprobar', $empresa->company_uuid) }}'" 
                                class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
                                Aprobar
                            </button>
                            <form action="{{ route('admin.empresas.rechazar', $empresa->company_uuid) }}" method="POST" class="inline">
                                @csrf
                                <button class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                    Rechazar
                                </button>
                            </form>
                        @elseif($empresa->status === 'aprobada')
                            <button 
                                @click="showModal = true; actionUrl = '{{ route('admin.empresas.aprobar', $empresa->company_uuid) }}'" 
                                class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                                Editar %
                            </button>
                        @else
                            <span class="text-gray-400 text-xs">—</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div x-show="showModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="bg-white p-6 rounded shadow-xl w-full max-w-md" @click.away="showModal = false">
            <h3 class="text-lg font-semibold mb-4 text-gray-800">Aprobar Empresa</h3>
            <form :action="actionUrl" method="POST">
                @csrf
                <label class="block text-sm text-gray-700 mb-2">Porcentaje de comisión (%)</label>
                <input type="number" name="percentage" min="0" max="100" required 
                       class="w-full border rounded px-3 py-2 mb-4" placeholder="Ejemplo: 10">

                <div class="flex justify-end gap-4">
                    <button type="button" @click="showModal = false"
                        class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
                        Cancelar
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Confirmar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
