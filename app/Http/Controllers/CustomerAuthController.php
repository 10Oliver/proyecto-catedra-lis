<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;

class CustomerAuthController extends Controller
{
    public function register()
    {
        $roleUuid = Role::where('name', '=', 'Cliente')->first()->role_uuid;
        return view('costumer/register', compact('roleUuid'));
    }

    public function login()
    {
        return view('costumer.login');
    }
}
