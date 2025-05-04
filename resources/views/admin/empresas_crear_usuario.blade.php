@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto p-6 bg-white rounded shadow">
  <h2 class="text-xl font-bold mb-4">Crear Usuario para {{ $company->name }}</h2>

  <form method="POST" action="{{ route('admin.empresas.users.store', $company->company_uuid) }}">
    @csrf

    <div class="mb-3">
      <label class="block mb-1">Email</label>
      <input type="email" name="email" value="{{ old('email') }}" required class="w-full p-2 border rounded">
      @error('email') <p class="text-red-600">{{ $message }}</p> @enderror
    </div>

    <div class="mb-3">
      <label class="block mb-1">Contraseña</label>
      <input type="password" name="password" required class="w-full p-2 border rounded">
      @error('password') <p class="text-red-600">{{ $message }}</p> @enderror
    </div>

    <div class="mb-3">
      <label class="block mb-1">Confirmar Contraseña</label>
      <input type="password" name="password_confirmation" required class="w-full p-2 border rounded">
    </div>

    <div class="mb-3">
      <label class="block mb-1">Nombres</label>
      <input type="text" name="names" value="{{ old('names') }}" required class="w-full p-2 border rounded">
      @error('names') <p class="text-red-600">{{ $message }}</p> @enderror
    </div>

    <div class="mb-3">
      <label class="block mb-1">Apellidos</label>
      <input type="text" name="surnames" value="{{ old('surnames') }}" required class="w-full p-2 border rounded">
      @error('surnames') <p class="text-red-600">{{ $message }}</p> @enderror
    </div>

    <div class="mb-3">
      <label class="block mb-1">DUI</label>
      <input type="text" name="dui" value="{{ old('dui') }}" required class="w-full p-2 border rounded">
      @error('dui') <p class="text-red-600">{{ $message }}</p> @enderror
    </div>

    <div class="mb-4">
      <label class="block mb-1">Fecha de Nacimiento</label>
      <input type="date" name="birthdate" value="{{ old('birthdate') }}" required class="w-full p-2 border rounded">
      @error('birthdate') <p class="text-red-600">{{ $message }}</p> @enderror
    </div>

    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded">Crear Usuario</button>
  </form>
</div>
@endsection
