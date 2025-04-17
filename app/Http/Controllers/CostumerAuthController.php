<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;

class CostumerAuthController extends Controller
{
    public function show()
    {
        $roles = Role::all();
        return view('costumer/register', compact('roles'));
    }
}
