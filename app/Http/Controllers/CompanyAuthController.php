<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CompanyAuthController extends Controller
{
    public function login()
    {
        return view('costumer.login');
    }
}
