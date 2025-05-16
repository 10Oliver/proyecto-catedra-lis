<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        return view('costumer.landing');
    }

    public function cart()
    {
        return view('costumer.shop-cart');
    }

    public function pay()
    {
        return view('costumer.pay');
    }

    public function payCoupons($request)
    {

    }
}
