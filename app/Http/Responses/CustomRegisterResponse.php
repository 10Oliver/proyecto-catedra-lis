<?php

namespace App\Http\Responses;

use App\Models\Role;
use Illuminate\Http\Request;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;

class CustomRegisterResponse implements RegisterResponseContract
{
  public function toResponse($request)
  {
    $roleUuid = $request->role_uuid;

    $roleName = Role::where('role_uuid', '=', $roleUuid)->first();

    $loginRoute = match ($roleName->name) {
      'Admin'    => route('admin.login'),
      'Empresa'  => route('company.login'),
      'Cliente' => route('costumer.login'),
      default    => route('login'),
    };

    return redirect()->intended($loginRoute);
  }
}
