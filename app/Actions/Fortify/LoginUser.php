<?php

namespace App\Actions\Fortify;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class LoginUser
{
  /**
   * Maneja la autenticación personalizada.
   *
   * @param \Illuminate\Http\Request $request
   * @return \App\Models\User|null
   *
   * @throws \Illuminate\Validation\ValidationException
   */
  public function __invoke(Request $request)
  {
    $user = User::where('email', $request->email)->first();

    if (! $user) {
      throw ValidationException::withMessages([
        'email' => ['No encontramos un usuario con ese correo electrónico.'],
      ]);
    }

    if (! Hash::check($request->password, $user->password)) {
      throw ValidationException::withMessages([
        'password' => ['La contraseña que ingresaste no es válida.'],
      ]);
    }

    return $user;
  }
}
