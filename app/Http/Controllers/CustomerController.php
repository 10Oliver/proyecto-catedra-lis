<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function index()
    {
        $company = Auth::user()->companies()->first();
        $offers = Offer::where('state', '!=', false)
        ->whereDate('end_date', '>=', now())
        ->with('companies')
        ->get();

        return view('costumer.landing', compact('offers', 'company'));
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
