@extends('layouts.app')

@section('title', 'Gestión de Empresas')

@section('content')
<div 
  class="p-6 space-y-12"
  x-data="{ 
    showModal: false, 
    actionUrl: '', 
    percentage: '',
    showDeleteModal: false,
    deleteUrl: '',
    companyName: ''
  }"
>
  @if(session('success'))
    <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
      {{ session('success') }}
    </div>
  @endif

  {{-- Empresas por aprobar--}}
  <section>
    <h2 class="text-2xl font-bold mb-4">Empresas por Aprobar</h2>
    <table class="min-w-full text-sm text-left border rounded bg-white shadow mb-8">
      <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
        <tr>
          <th class="px-4 py-2">Empresa</th>
          <th class="px-4 py-2">NIT</th>
          <th class="px-4 py-2">Correo</th>
          <th class="px-4 py-2">Acciones</th>
        </tr>
      </thead>
      <tbody>
        @forelse($toApprove as $company)
          <tr class="border-t">
            <td class="px-4 py-2">{{ $company->name }}</td>
            <td class="px-4 py-2">{{ $company->nit }}</td>
            <td class="px-4 py-2">{{ $company->email }}</td>
            <td class="px-4 py-2 space-x-2">
              
              <button
                @click="
                  showModal = true;
                  actionUrl = '{{ route('admin.empresas.aprobar', $company) }}';
                  percentage = ''
                "
                class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700"
              >Aprobar</button>
              
              <form action="{{ route('admin.empresas.rechazar', $company) }}" method="POST" class="inline">
                @csrf
                <button class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">Rechazar</button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="4" class="px-4 py-2 text-center text-gray-500">
              No hay empresas pendientes por aprobar.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </section>

  {{-- Gestión de usuarios de empresas --}}
<section>
  <h2 class="text-2xl font-bold mb-4">Gestión de Usuarios</h2>
  <table class="min-w-full text-sm text-left border rounded bg-white shadow">
    <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
      <tr>
        <th class="px-4 py-2">Empresa</th>
        <th class="px-4 py-2">Correo Empresa</th>
        <th class="px-4 py-2">Usuario</th>
        <th class="px-4 py-2">Acciones</th>
      </tr>
    </thead>
    <tbody>
      @forelse($forUsers as $company)
        <tr class="border-t">
          <td class="px-4 py-2">{{ $company->name }}</td>
          <td class="px-4 py-2">{{ $company->email }}</td>
          <td class="px-4 py-2">
            @if($company->users->isNotEmpty())
              <span class="text-green-600 font-medium">Creado</span>
            @else
              <span class="text-gray-500">No creado</span>
            @endif
          </td>
          <td class="px-4 py-2 flex gap-2">
            @if($company->users->isNotEmpty())
              <a
                href="{{ route('admin.empresas.users.edit', [
                  'company' => $company->company_uuid,
                  'user'    => $company->users->first()->user_uuid
                ]) }}"
                class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600"
              >Editar</a>
              
              <button
                @click="
                  showDeleteModal = true;
                  deleteUrl = '{{ route('admin.empresas.users.destroy', [
                    'company' => $company->company_uuid,
                    'user' => $company->users->first()->user_uuid
                  ]) }}';
                  companyName = '{{ $company->name }}'
                "
                class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700"
              >Eliminar</button>
            @else
              
              <a
                href="{{ route('admin.empresas.users.create', $company) }}"
                class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700"
              >Crear usuario</a>
            @endif
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="4" class="px-4 py-2 text-center text-gray-500">
            No hay empresas aprobadas.
          </td>
        </tr>
      @endforelse
    </tbody>
  </table>
</section>

  {{-- Modal porcentaje --}}
  <div
    x-show="showModal"
    x-cloak
    class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
  >
    <div
      class="bg-white p-6 rounded-lg shadow-xl w-full max-w-md"
      @click.away="showModal = false"
    >
      <h3 class="text-lg font-semibold mb-4">Porcentaje de comisión (%)</h3>
      <form :action="actionUrl" method="POST">
        @csrf
        <input
          type="number"
          name="percentage"
          x-model="percentage"
          min="0"
          max="100"
          required
          class="w-full border rounded px-3 py-2 mb-4"
          placeholder="Ej: 10"
        >
        <div class="flex justify-end space-x-2">
          <button
            type="button"
            @click="showModal = false"
            class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300"
          >Cancelar</button>
          <button
            type="submit"
            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
          >Confirmar</button>
        </div>
      </form>
    </div>
  </div>
  
  {{-- Modal eliminar usuario --}}
  <div
    x-show="showDeleteModal"
    x-cloak
    class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
  >
    <div
      class="bg-white p-6 rounded-lg shadow-xl w-full max-w-md"
      @click.away="showDeleteModal = false"
    >
      <h3 class="text-lg font-semibold mb-4">Confirmar eliminación</h3>
      <p class="mb-4">¿Estás seguro de que deseas eliminar el usuario de la empresa <span class="font-bold" x-text="companyName"></span>? Esta acción no se puede deshacer.</p>
      
      <form :action="deleteUrl" method="POST">
        @csrf
        @method('DELETE')
        <div class="flex justify-end space-x-2">
          <button
            type="button"
            @click="showDeleteModal = false"
            class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300"
          >Cancelar</button>
          <button
            type="submit"
            class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700"
          >Eliminar</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection