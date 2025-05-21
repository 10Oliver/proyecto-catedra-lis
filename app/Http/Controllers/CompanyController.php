<?php

namespace App\Http\Controllers;

use App\Http\Requests\CouponRequest;
use App\Http\Requests\StoreCompanyApplyRequest;
use App\Models\Company;
use App\Models\Coupon;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    public function index()
    {
        return view('company.dashboard');
    }

    public function showApplyForm()
    {
        return view('company.apply');
    }

    public function store(StoreCompanyApplyRequest $request)
    {
        Company::create($request->validated());

        return redirect()
            ->route('empresa.apply')
            ->with('success', 'Solicitud enviada con éxito');
    }

    public function test(CouponRequest $request) {
        dd($request);
        $company = auth()->user()->companies()->firstOrFail();

        $offer = DB::transaction(function() use ($request, $company) {
            $newOffer = Offer::create($request->validated());

            $company->offers()->attach($newOffer->offer_uuid);

            return $newOffer;
        });

        return response()->json([
            'Message' => 'Oferta creada'
        ]);
    }

    /*public function saveOffers(CouponRequest $request)
    {
        dd($request->all());
        $company = auth()->user()->companies()->firstOrFail();


        $offer = DB::transaction(function() use ($request, $company) {
            $newOffer = Offer::create($request->validated());

            $company->offers()->attach($newOffer->offer_uuid);

            return $newOffer;
        });

        return response()->json([
            'Message' => 'Oferta creada'
        ]);
    }*/

    public function coupons()
    {
        return view('company.coupons');
    }
}
