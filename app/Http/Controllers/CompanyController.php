<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyApplyRequest;
use App\Models\Company;
use Illuminate\Http\Request;

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
}
