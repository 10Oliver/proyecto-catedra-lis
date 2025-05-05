<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Administrador</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2 class="mb-4">Registro de Administrador</h2>

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
                <input type="email" name="email" id="email" class="form-control"
                       value="{{ old('email') }}" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" name="password" id="password" class="form-control"
                       required>
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                       class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="names" class="form-label">Nombres</label>
                <input type="text" name="names" pattern="[\pL\s\-]+"
    title="Solo letras, espacios y guiones" id="names" class="form-control"
                       value="{{ old('names') }}" required>
            </div>

            <div class="mb-3">
                <label for="surnames" class="form-label">Apellidos</label>
                <input type="text" name="surnames" pattern="[\pL\s\-]+"
    title="Solo letras, espacios y guiones" id="surnames" class="form-control"
                       value="{{ old('surnames') }}" required>
            </div>

            <div class="mb-3">
                <label for="dui" class="form-label">DUI</label>
                <input type="text" name="dui" id="dui" class="form-control"
                       value="{{ old('dui') }}" required>
            </div>

            <div class="mb-3">
                <label for="birthdate" class="form-label">Fecha de nacimiento</label>
                <input type="date" name="birthdate" id="birthdate" class="form-control"
                       value="{{ old('birthdate') }}" required>
            </div>

            <input type="hidden" name="role_uuid" value="{{ $roleUuid }}">

            <button type="submit" class="btn btn-primary">Registrarse</button>
        </form>
    </div>
</body>
</html>
