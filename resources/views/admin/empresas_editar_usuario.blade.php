@extends('layouts.app')

@section('title', 'Editar Usuario de Empresa')

@section('content')
<div class="max-w-md mx-auto p-6 bg-white rounded shadow">
  <h2 class="text-xl font-bold mb-4">Editar Usuario para {{ $company->name }}</h2>

  <form method="POST"
        action="{{ route('admin.empresas.users.update', [
          'company' => $company->company_uuid,
          'user'    => $user->user_uuid,
        ]) }}">
    @csrf
    @method('PUT')

    <div class="mb-3">
      <label class="block mb-1">Email</label>
      <input type="email"
             name="email"
             value="{{ old('email', $user->email) }}"
             required
             class="w-full p-2 border rounded">
      @error('email')
        <p class="text-red-600">{{ $message }}</p>
      @enderror
    </div>

    <div class="mb-3">
      <label class="block mb-1">Nombres</label>
      <input type="text"
             name="names"
             value="{{ old('names', $user->names) }}"
             required
             class="w-full p-2 border rounded">
      @error('names')
        <p class="text-red-600">{{ $message }}</p>
      @enderror
    </div>

    <div class="mb-3">
      <label class="block mb-1">Apellidos</label>
      <input type="text"
             name="surnames"
             value="{{ old('surnames', $user->surnames) }}"
             required
             class="w-full p-2 border rounded">
      @error('surnames')
        <p class="text-red-600">{{ $message }}</p>
      @enderror
    </div>

    <div class="mb-3">
      <label class="block mb-1">DUI</label>
      <input type="text"
             name="dui"
             value="{{ old('dui', $user->dui) }}"
             required
             class="w-full p-2 border rounded">
      @error('dui')
        <p class="text-red-600">{{ $message }}</p>
      @enderror
    </div>

    <div class="mb-4">
      <label class="block mb-1">Fecha de Nacimiento</label>
      @php
        $bd = old('birthdate') 
              ?? (\Carbon\Carbon::parse($user->birthdate)->format('Y-m-d') ?? '');
      @endphp
      <input type="date"
             name="birthdate"
             value="{{ $bd }}"
             required
             class="w-full p-2 border rounded">
      @error('birthdate')
        <p class="text-red-600">{{ $message }}</p>
      @enderror
    </div>

    <!-- Cambiar contraseña-->
    <div class="mb-4 border-t pt-4">
      <h3 class="font-medium mb-2">Cambiar Contraseña (opcional)</h3>
      
      <div class="mb-3">
        <label class="block mb-1">Nueva Contraseña</label>
        <input type="password"
               name="password"
               class="w-full p-2 border rounded">
        <p class="text-gray-500 text-xs mt-1">Dejar en blanco para mantener la contraseña actual</p>
        @error('password')
          <p class="text-red-600">{{ $message }}</p>
        @enderror
      </div>
      
      <div class="mb-3">
        <label class="block mb-1">Confirmar Nueva Contraseña</label>
        <input type="password"
               name="password_confirmation"
               class="w-full p-2 border rounded">
      </div>
    </div>

    <div class="flex gap-2">
      <a href="{{ route('admin.empresas') }}" 
         class="flex-1 bg-gray-500 text-white py-2 rounded hover:bg-gray-600 text-center">
        Cancelar
      </a>
      <button type="submit"
              class="flex-1 bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
        Actualizar Usuario
      </button>
    </div>
  </form>
</div>
@endsection