@extends('layouts.app')

@section('content')
<div class="container">
  <h2>Crear nuevo usuario</h2>
  <form method="POST" action="{{ route('admin.users.store') }}">
    @csrf
    <div>
      <label>Nombre completo</label>
      <input type="text" name="name" required>
    </div>

    <div>
      <label>Correo electrónico</label>
      <input type="email" name="email" required>
    </div>

    <div>
      <label>Contraseña</label>
      <input type="password" name="password" required>
    </div>

    <div>
      <label>Rol</label>
      <select name="role" required>
        <option value="admin">Administrador</option>
        <option value="cliente">Cliente</option>
        <option value="empresa">Empresa</option>
      </select>
    </div>

    <button type="submit">Crear usuario</button>
  </form>
</div>
@endsection
