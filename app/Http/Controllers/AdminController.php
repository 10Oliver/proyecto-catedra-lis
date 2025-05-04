<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

public function formCrearUsuario()
{
    return view('admin.crear-usuario');
}

public function guardarNuevoUsuario(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6',
        'role' => 'required|in:admin,cliente,empresa'
    ]);

    $roleId = match ($request->role) {
        'admin' => 1,
        'empresa' => 2,
        'cliente' => 3,
    };

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role_id' => $roleId,
        'uuid' => Str::uuid(), // si usas uuid en User
    ]);

    return redirect()->route('admin.dashboard')->with('success', 'Usuario creado correctamente.');
}

}

