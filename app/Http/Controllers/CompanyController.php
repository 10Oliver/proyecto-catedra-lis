<?php

namespace App\Http\Controllers;


use App\Http\Requests\CouponRequest;
use App\Http\Requests\StoreCompanyApplyRequest;
use App\Models\Company;
use App\Models\CompanyOffer;
use App\Models\Coupon;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{

    public function index()
    {
        $cupones = Coupon::with('offers')->latest()->take(5)->get();

        return view('company.dashboard', compact('cupones'));
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


    public function saveOffer(CouponRequest $request)
    {
        $user = Auth::user();

        $company = $user->companies()->first();

        if (!$company) {
            return response()->json(['error' => 'No tienes una empresa asociada'], 403);
        }

        $offer = Offer::create($request->validated());

        CompanyOffer::create([
            'company_uuid' => $company->company_uuid,
            'offer_uuid' => $offer->offer_uuid
        ]);


        return redirect()->route('coupons.view')->with('message', 'Cupón creado correctamente')->with('state', true);
    }

    public function updateOffer(CouponRequest $request, Offer $offer)
    {
        $validatedData = $request->validated();

        $validatedData['open_amount'] = (bool) $validatedData['open_amount'];
        $validatedData['state'] = (bool) $validatedData['state'];

        $offer->update($validatedData);

        return redirect()->route('coupons.view')->with('message', 'Cupón editado correctamente')->with('state', true);
    }

    public function deleteOffer(Offer $offer)
    {
        $offer->delete();

        return redirect()->route('coupons.view')->with('message', 'Cupón eliminado correctamente')->with('state', true);
    }

    public function coupons()
    {
        $user = Auth::user();

        $company = $user->companies()->first();

        $offers = $company ? $company->offers()->withCount('coupons as purchased_coupons_count')->get() : collect();

        return view('company.coupons', compact('offers'));
    }
}
