<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Olvidé mi contraseña - Cliente</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.0.0/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="w-full max-w-md bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-semibold mb-4">¿Olvidaste tu contraseña?</h1>
        <p class="mb-6 text-gray-600">Introduce tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña.</p>
        <form method="POST" action="{{ route('private.password.email') }}">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-gray-700">Correo electrónico</label>
                <input id="email" name="email" type="email" required autofocus
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
                @error('email')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit"
                    class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
                Enviar enlace de recuperación
            </button>
        </form>
        <p class="mt-4 text-center text-sm">
            <a href="{{ route('private.login') }}" class="text-blue-600 hover:underline">Volver al inicio de sesión</a>
        </p>
    </div>
</body>
</html>