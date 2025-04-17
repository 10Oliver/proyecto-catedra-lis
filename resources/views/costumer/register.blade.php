<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2>Registro de Usuario</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Correo electrónico</label>
                <input type="email" name="email" id="email" class="form-control" required
                    value="{{ old('email') }}">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                    required>
            </div>
            <div class="mb-3">
                <label for="names" class="form-label">Nombres</label>
                <input type="text" name="names" id="names" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="surnames" class="form-label">Apellidos</label>
                <input type="text" name="surnames" id="surnames" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="dui" class="form-label">DUI</label>
                <input type="text" name="dui" id="dui" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="birthdate" class="form-label">Fecha de nacimiento</label>
                <input type="date" name="birthdate" id="birthdate" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="role_uuid" class="form-label">Rol</label>
                <select name="role_uuid" id="role_uuid" class="form-control" required>
                    <option value="">Seleccione un rol</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->role_uuid }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Registrarse</button>
        </form>
    </div>
</body>

</html>
