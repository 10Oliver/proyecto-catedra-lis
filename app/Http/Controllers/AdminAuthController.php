<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;

class AdminAuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function register()
    {
        $roleUuid = Role::where('name', '=', 'Admin')->first()->role_uuid;
        return view('admin.register', compact('roleUuid'));
    }
}
