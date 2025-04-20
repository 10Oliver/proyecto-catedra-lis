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
    $roleUuid = $request->role_uuid;

    $roleName = Role::where('role_uuid', '=', $roleUuid)->first();

    $destination = match ($roleName) {
      'admin'    => route('admin.dashboard'),
      'company'  => route('company.dashboard'),
      default    => route('landing'),
    };

    return redirect()->intended($destination);
  }
}
