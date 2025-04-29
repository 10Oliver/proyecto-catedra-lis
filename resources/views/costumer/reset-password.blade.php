<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer contraseña - Cliente</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="w-full max-w-md bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-semibold mb-4">Restablecer contraseña</h1>
        <form method="POST" action="{{ route('cliente.password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="mb-4">
                <label for="email" class="block text-gray-700">Correo electrónico</label>
                <input id="email" name="email" type="email" value="{{ old('email', $request->email) }}" required autofocus
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
                @error('email')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700">Nueva contraseña</label>
                <input id="password" name="password" type="password" required
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
                @error('password')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-6">
                <label for="password_confirmation" class="block text-gray-700">Confirmar contraseña</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>

            <button type="submit"
                    class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition">
                Restablecer contraseña
            </button>
        </form>
        <p class="mt-4 text-center text-sm">
            <a href="{{ route('customer.login') }}" class="text-blue-600 hover:underline">Volver al inicio de sesión</a>
        </p>
    </div>
</body>
</html>