<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\CompanyUser;
use App\Models\User;
use App\Models\Role;
use App\Models\Coupon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AdminController extends Controller
{
  /**
   * Dashboard del administrador
   */
  public function index()
  {
    $totalEmpresas = Company::count();
    $totalUsuarios = User::count();
    $totalCupones = Coupon::count();

    $meses = collect();
    $ganancias = collect();
    $now = Carbon::now();

    for ($i = 5; $i >= 0; $i--) {
      $start = $now->copy()->subMonths($i)->startOfMonth();
      $end = $start->copy()->endOfMonth();
      $mes = ucfirst($start->locale('es')->isoFormat('MMMM'));

      $factura = DB::table('bill')
        ->join('coupon', 'bill.bill_uuid', '=', 'coupon.bill_uuid')
        ->join('offer_coupon', 'coupon.coupon_uuid', '=', 'offer_coupon.coupon_uuid')
        ->join('offer', 'offer_coupon.offer_uuid', '=', 'offer.offer_uuid')
        ->join('company_offer', 'offer.offer_uuid', '=', 'company_offer.offer_uuid')
        ->join('company', 'company.company_uuid', '=', 'company_offer.company_uuid')
        ->whereBetween('bill.created_at', [$start, $end])
        ->select(DB::raw('SUM(bill.amount * company.percentage / 100) as total'))
        ->first();

      $meses->push($mes);
      $ganancias->push(round($factura->total ?? 0, 2));
    }

    return view(
      'admin.dashboard',
      compact('totalEmpresas', 'totalUsuarios', 'totalCupones', 'meses', 'ganancias')
    );
  }

  /**
   * Solicitudes
   */
  public function empresas()
  {
    $toApprove = Company::where('status', 'pendiente')->get();

    $forUsers = Company::where('status', 'aprobada')->with('users')->get();

    return view('admin.empresas', compact('toApprove', 'forUsers'));
  }

  /**
   * Aprobar empresa
   */
  public function aprobarEmpresa(Request $request, Company $company)
  {
    $data = $request->validate([
      'percentage' => 'required|numeric|min:0|max:100',
    ]);

    $company->update([
      'percentage' => $data['percentage'],
      'status' => 'aprobada',
    ]);

    return redirect()->route('admin.empresas')->with('success', 'Empresa aprobada correctamente.');
  }

  public function editCompanyUser(Company $company, User $user)
  {
    return view('admin.empresas_editar_usuario', compact('company', 'user'));
  }

  /**
   * Rechazar empresa
   */
  public function rechazarEmpresa(Company $company)
  {
    $company->update(['status' => 'rechazada']);

    return redirect()->route('admin.empresas')->with('success', 'Empresa rechazada correctamente.');
  }

  /**
   * Formulario para crear usuario
   */
  public function showCreateCompanyUserForm(Company $company)
  {
    return view('admin.empresas_crear_usuario', compact('company'));
  }

  public function storeCompanyUser(Request $request, Company $company)
  {
    $data = $request->validate([
      'email' => ['required', 'email', 'max:255', 'unique:user,email'],
      'password' => ['required', 'confirmed', 'min:8'],
      'names' => ['required', 'string', 'max:255'],
      'surnames' => ['required', 'string', 'max:255'],
      'dui' => ['required', 'string', 'max:10', 'regex:/^\d{8}-\d{1}$/'],
      'birthdate' => ['required', 'date', 'before:-18 years'],
    ]);

    $roleEmpresa = Role::where('name', 'Empresa')->firstOrFail();
    $user = User::create([
      'email' => $data['email'],
      'username' => $data['email'],
      'password' => Hash::make($data['password']),
      'names' => $data['names'],
      'surnames' => $data['surnames'],
      'dui' => $data['dui'],
      'birthdate' => $data['birthdate'],
      'role_uuid' => $roleEmpresa->role_uuid,
    ]);

    CompanyUser::create([
      'company_uuid' => $company->company_uuid,
      'user_uuid' => $user->user_uuid,
      'approved_uuid' => Auth::id(),
    ]);

    return redirect()->route('admin.empresas')->with('success', 'Usuario creado correctamente.');
  }

  public function updateCompanyUser(Request $request, Company $company, User $user)
  {
    $rules = [
      'email' => [
        'required',
        'email',
        'max:255',
        'unique:user,email,' . $user->user_uuid . ',user_uuid',
      ],
      'names' => ['required', 'string', 'max:255'],
      'surnames' => ['required', 'string', 'max:255'],
      'dui' => ['required', 'string', 'max:10', 'regex:/^\d{8}-\d{1}$/'],
      'birthdate' => ['required', 'date', 'before:-18 years'],
    ];

    if ($request->filled('password')) {
      $rules['password'] = ['required', 'string', 'min:8', 'confirmed'];
    }

    $data = $request->validate($rules);

    $updateData = [
      'email' => $data['email'],
      'username' => $data['email'],
      'names' => $data['names'],
      'surnames' => $data['surnames'],
      'dui' => $data['dui'],
      'birthdate' => $data['birthdate'],
    ];

    if ($request->filled('password')) {
      $updateData['password'] = Hash::make($data['password']);
    }

    $user->update($updateData);

    return redirect()
      ->route('admin.empresas')
      ->with('success', 'Usuario actualizado correctamente.');
  }

  public function destroyCompanyUser(Company $company, User $user)
  {
    if (!$company->users->contains($user)) {
      return back()->with('error', 'El usuario no pertenece a esta empresa.');
    }

    CompanyUser::where('company_uuid', $company->company_uuid)
      ->where('user_uuid', $user->user_uuid)
      ->delete();

    $user->delete();

    return redirect()
      ->route('admin.empresas')
      ->with('success', 'Usuario eliminado correctamente. Ahora puede crear uno nuevo.');
  }

  /**
   * CRUD de administradores
   */
  public function admins()
  {
    $admins = User::whereHas('role', fn($q) => $q->where('name', 'Admin'))->get();
    $roleUuid = Role::where('name', 'Admin')->first()->role_uuid;
    return view('admin.admins', compact('admins', 'roleUuid'));
  }

  /**
   * Actualizar administrador
   */
  public function update(Request $request, User $user)
  {
    $request->validate([
      'names' => 'required|string|max:255',
      'surnames' => 'required|string|max:255',
      'email' => 'required|email|max:255|unique:user,email,' . $user->user_uuid . ',user_uuid',
      'dui' => 'required|string|max:10',
      'birthdate' => 'required|date',
    ]);

    $user->update($request->only(['names', 'surnames', 'email', 'dui', 'birthdate']));

    return back()->with('success', 'Administrador actualizado.');
  }

  /**
   * Eliminar administrador
   */
  public function destroy(User $user)
  {
    $user->delete();
    return back()->with('success', 'Administrador eliminado.');
  }

  public function store(Request $request)
  {
    $request->validate([
      'names' => 'required|string|max:255',
      'surnames' => 'required|string|max:255',
      'email' => 'required|email|unique:user,email|max:255',
      'dui' => 'required|string|max:10|regex:/^\d{8}-\d{1}$/',
      'birthdate' => 'required|date|before:-18 years',
      'password' => 'required|string|min:8|confirmed',
      'role_uuid' => 'required|uuid|exists:role,role_uuid',
    ]);

    $user = User::create([
      'names' => $request->names,
      'surnames' => $request->surnames,
      'email' => $request->email,
      'username' => $request->email,
      'dui' => $request->dui,
      'birthdate' => $request->birthdate,
      'password' => Hash::make($request->password),
      'role_uuid' => $request->role_uuid,
    ]);

    return redirect()
      ->route('admin.admins.index')
      ->with('success', 'Administrador creado correctamente.');
  }
}
