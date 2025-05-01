<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Role;


class AdminController extends Controller
{
    public function index()
{
    $totalEmpresas = \App\Models\Company::count();
    $totalUsuarios = \App\Models\User::count();
    $totalCupones = \App\Models\Coupon::count();

    $meses = collect();
    $ganancias = collect();
    $now = Carbon::now();

    for ($i = 5; $i >= 0; $i--) {
        $inicio = $now->copy()->subMonths($i)->startOfMonth();
        $fin = $inicio->copy()->endOfMonth();
        $nombreMes = ucfirst($inicio->locale('es')->isoFormat('MMMM'));

        $facturas = DB::table('bill')
            ->join('coupon', 'bill.bill_uuid', '=', 'coupon.bill_uuid')
            ->join('offer_coupon', 'coupon.coupon_uuid', '=', 'offer_coupon.coupon_uuid')
            ->join('offer', 'offer_coupon.offer_uuid', '=', 'offer.offer_uuid')
            ->join('company_offer', 'offer.offer_uuid', '=', 'company_offer.offer_uuid')
            ->join('company', 'company.company_uuid', '=', 'company_offer.company_uuid')
            ->whereBetween('bill.created_at', [$inicio, $fin])
            ->select(DB::raw('SUM(bill.amount * company.percentage / 100) as total'))
            ->first();

        $meses->push($nombreMes);
        $ganancias->push(round($facturas->total ?? 0, 2));
    }

    return view('admin.dashboard', [
        'totalEmpresas' => $totalEmpresas,
        'totalUsuarios' => $totalUsuarios,
        'totalCupones' => $totalCupones,
        'meses' => $meses,
        'ganancias' => $ganancias
    ]);
}

    public function empresas()
    {
       $empresas = \App\Models\Company::all();
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

    public function admins()
    {
    $admins = User::whereHas('role', fn($q) => $q->where('name', 'Admin'))->get();
    $roleUuid = Role::where('name', 'Admin')->first()->role_uuid;
    return view('admin.admins', compact('admins', 'roleUuid'));
    }

    public function update(Request $request, User $user)
    {
    $request->validate([
        'names' => 'required|string|max:255',
        'surnames' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:user,email,' . $user->user_uuid . ',user_uuid',
        'dui' => 'required|max:10',
        'birthdate' => 'required|date',
    ]);

    $user->update($request->only('names', 'surnames', 'email', 'dui', 'birthdate'));

    return redirect()->back()->with('success', 'Administrador actualizado.');
    }

    public function destroy(User $user)
    {
    $user->delete();
    return redirect()->back()->with('success', 'Administrador eliminado.');
    }
}
