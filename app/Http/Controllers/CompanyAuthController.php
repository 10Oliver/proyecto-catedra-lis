<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;

class CompanyAuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function register()
    {
        $roleUuid = Role::where('name', '=', 'Empresa')->first()->role_uuid;
        return view('company.register', compact('roleUuid'));
    }
}
