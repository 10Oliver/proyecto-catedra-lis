{{-- resources/views/admin/empresas.blade.php --}}
@extends('layouts.app')

@section('title', 'Gestión de Empresas')

@section('content')
<div class="p-6" x-data="{ showModal: false, actionUrl: '', percentage: '' }">
    <h2 class="text-2xl font-bold mb-6">Gestión de Empresas (Solicitudes)</h2>

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
                    <th class="px-4 py-3">Usuario</th>
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
                                ($empresa->status === 'aprobada'   ? 'bg-green-600' :
                                 'bg-red-600') }}">
                            {{ ucfirst($empresa->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        @if($empresa->users->isNotEmpty())
                            <span class="text-green-600">Creado</span>
                        @else
                            <span class="text-gray-500">No creado</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 space-x-2">
    @if($empresa->status === 'pendiente')
        {{-- Aprobar --}}
        <button
            @click="showModal = true;
                     actionUrl = '{{ route('admin.empresas.aprobar', $empresa->company_uuid) }}';
                     percentage = ''"
            class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
            Aprobar
        </button>
        {{-- Rechazar --}}
        <form action="{{ route('admin.empresas.rechazar', $empresa->company_uuid) }}"
              method="POST"
              class="inline">
            @csrf
            <button class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                Rechazar
            </button>
        </form>

    @elseif($empresa->status === 'aprobada')
        {{-- Editar % --}}
        <button
            @click="showModal = true;
                     actionUrl = '{{ route('admin.empresas.aprobar', $empresa->company_uuid) }}';
                     percentage = '{{ $empresa->percentage }}'"
            class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">
            Editar %
        </button>
        
        {{-- Verificar si existe usuario --}}
        @if($empresa->users->count() > 0)
            {{-- Editar usuario --}}
            <a href="{{ route('admin.empresas.users.edit', ['company' => $empresa->company_uuid, 'user' => $empresa->users->first()->user_uuid]) }}"
               class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
                Editar usuario
            </a>
        @else
            {{-- Crear usuario --}}
            <a href="{{ route('admin.empresas.users.create', $empresa->company_uuid) }}"
               class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700">
                Crear usuario
            </a>
        @endif
        
        {{-- Rechazar --}}
        <form action="{{ route('admin.empresas.rechazar', $empresa->company_uuid) }}"
              method="POST"
              class="inline">
            @csrf
            <button class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                Rechazar
            </button>
        </form>

    @elseif($empresa->status === 'rechazada')
        {{-- Volver a aprobar --}}
        <button
            @click="showModal = true;
                     actionUrl = '{{ route('admin.empresas.aprobar', $empresa->company_uuid) }}';
                     percentage = ''"
            class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700">
            Aprobar
        </button>
    @endif
</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Modal para aprobar/editar porcentaje --}}
    <div x-show="showModal" x-cloak
         class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="bg-white p-6 rounded-lg shadow-xl w-full max-w-md"
             @click.away="showModal = false">
            <h3 class="text-lg font-semibold mb-4">Porcentaje de comisión (%)</h3>
            <form :action="actionUrl" method="POST">
                @csrf
                <input type="number"
                       name="percentage"
                       x-model="percentage"
                       min="0" max="100" required
                       class="w-full border rounded px-3 py-2 mb-4"
                       placeholder="Ejemplo: 10">
                <div class="flex justify-end gap-4">
                    <button type="button"
                            @click="showModal = false"
                            class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
                        Cancelar
                    </button>
                    <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Confirmar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection