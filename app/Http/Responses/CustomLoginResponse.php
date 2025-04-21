<?php

namespace App\Http\Responses;

use App\Models\Role;
use Illuminate\Http\Request;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class CustomLoginResponse implements LoginResponseContract
{
  /**
   * Build the HTTP response for a successful authentication.
   */
  public function toResponse($request)
  {
    $user = $request->user();
    $role = optional($user->role)->name;

    $destination = match ($role) {
      'Admin'    => route('administrador.index'),
      'Empresa'  => route('empresa.index'),
      default    => route('index'),
    };

    return redirect()->intended($destination);
  }
}
