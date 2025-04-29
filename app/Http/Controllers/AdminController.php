<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function empresas()
    {
        $empresas= Company::where('status', 'pendiente')
            ->whereNull('company_user.approved_uuid')
            ->select('company.*')
            ->get();

            return view('admin.empresas', compact('empresas'));
    }

    public function aprobarEmpresa(Request $request, Company $company)
    {
        $request->validate([
            'percentage' => 'required|numeric|min:0|max:100',
        ]);

        $company->update([
            'percentage' => $request->percentage,
            'status' => 'aprobada',
        ]);
        
        $company->users()->updateExistingPivot(Auth::id(), [
            'approved_uuid' => Auth::user()->user_uuid,
        ]);

        return redirect()->route('admin.empresas')->with('success', 'Empresa aprobada correctamente.');
    }

    public function rechazarEmpresa(Company $company)
    {
        $company->update(
            [
                'status' => 'rechazada',
            ]
        );

        return redirect()->route('admin.empresas')->with('success', 'Empresa rechazada correctamente.');
    }
}
