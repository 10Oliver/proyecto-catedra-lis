<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;

class CustomerAuthController extends Controller
{
    public function show()
    {
        $roles = Role::all();
        return view('costumer/register', compact('roles'));
    }

    public function login()
    {
        return view('costumer.login');
    }

    public function landing()
    {
        return view('costumer.landing');
    }
}
