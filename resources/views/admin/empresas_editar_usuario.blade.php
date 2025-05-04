@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto p-6 bg-white rounded shadow">
  <h2 class="text-xl font-bold mb-4">Editar Usuario para {{ $company->name }}</h2>

  <form method="POST" action="{{ route('admin.empresas.users.update', ['company' => $company->company_uuid, 'user' => $user->user_uuid]) }}">
    @csrf
    @method('PUT')

    <div class="mb-3">
      <label class="block mb-1">Email</label>
      <input type="email" name="email" value="{{ $user->email }}" required class="w-full p-2 border rounded">
      @error('email') <p class="text-red-600">{{ $message }}</p> @enderror
    </div>

    <div class="mb-3">
      <label class="block mb-1">Nombres</label>
      <input type="text" name="names" value="{{ $user->names }}" required class="w-full p-2 border rounded">
      @error('names') <p class="text-red-600">{{ $message }}</p> @enderror
    </div>

    <div class="mb-3">
      <label class="block mb-1">Apellidos</label>
      <input type="text" name="surnames" value="{{ $user->surnames }}" required class="w-full p-2 border rounded">
      @error('surnames') <p class="text-red-600">{{ $message }}</p> @enderror
    </div>

    <div class="mb-3">
      <label class="block mb-1">DUI</label>
      <input type="text" name="dui" value="{{ $user->dui }}" required class="w-full p-2 border rounded">
      @error('dui') <p class="text-red-600">{{ $message }}</p> @enderror
    </div>

    <div class="mb-4">
      <label class="block mb-1">Fecha de Nacimiento</label>
      <input type="date" name="birthdate" value="{{ $user->birthdate->format('Y-m-d') }}" required class="w-full p-2 border rounded">
      @error('birthdate') <p class="text-red-600">{{ $message }}</p> @enderror
    </div>

    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded">Actualizar Usuario</button>
  </form>
</div>
@endsection