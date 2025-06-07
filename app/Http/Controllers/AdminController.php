<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\CompanyUser;
use App\Models\User;
use App\Models\Role;
use App\Models\Offer;
use App\Models\Coupon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AdminController extends Controller
{
  public function index(Request $request)
  {
    // Rango de fechas o de últimos 6 meses por defecto
    $startDate = $request->get('start_date')
      ? Carbon::parse($request->get('start_date'))->startOfDay()
      : Carbon::now()->subMonths(6)->startOfMonth();
    $endDate = $request->get('end_date')
      ? Carbon::parse($request->get('end_date'))->endOfDay()
      : Carbon::now()->endOfMonth();

    $totalEmpresas = Company::count();
    $empresasAprobadas = Company::where('status', 'aprobada')->count();
    $empresasPendientes = Company::where('status', 'pendiente')->count();

    $totalUsuarios = User::count();
    // Usuarios creados en el periodo
    $usuariosNuevos = User::whereBetween('created_at', [$startDate, $endDate])->count();

    $totalOfertas = Offer::count();

    // Cupones vendidos en el periodo
    $cuponesVendidos = Coupon::whereHas(
      'bill',
      fn($q) => $q->whereBetween('created_at', [$startDate, $endDate])
    )->count();

    // Ingresos y ganancias en el periodo
    $totalIngresos = DB::table('bill')
      ->join('coupon', 'bill.bill_uuid', '=', 'coupon.bill_uuid')
      ->whereBetween('bill.created_at', [$startDate, $endDate])
      ->sum('coupon.cost');

    $totalGananciasObj = DB::table('bill')
      ->join('coupon', 'bill.bill_uuid', '=', 'coupon.bill_uuid')
      ->join('offer_coupon', 'coupon.coupon_uuid', '=', 'offer_coupon.coupon_uuid')
      ->join('offer', 'offer_coupon.offer_uuid', '=', 'offer.offer_uuid')
      ->join('company_offer', 'offer.offer_uuid', '=', 'company_offer.offer_uuid')
      ->join('company', 'company_offer.company_uuid', '=', 'company.company_uuid')
      ->whereBetween('bill.created_at', [$startDate, $endDate])
      ->select(DB::raw('SUM(coupon.cost * company.percentage / 100) as total'))
      ->first();
    $totalGanancias = $totalGananciasObj->total ?? 0;

    $meses = collect();
    $ingresos = collect();
    $ganancias = collect();

    $cursor = $startDate->copy()->startOfMonth();
    $last = $endDate->copy()->endOfMonth();

    while ($cursor->lte($last)) {
      $meses->push(ucfirst($cursor->locale('es')->isoFormat('MMM YYYY')));

      $mesInicio = $cursor->copy()->startOfMonth();
      $mesFin = $cursor->copy()->endOfMonth();

      // Ingresos mes
      $inc = DB::table('bill')
        ->join('coupon', 'bill.bill_uuid', '=', 'coupon.bill_uuid')
        ->whereBetween('bill.created_at', [$mesInicio, $mesFin])
        ->sum('coupon.cost');

      // Ganancias mes
      $gan =
        DB::table('bill')
          ->join('coupon', 'bill.bill_uuid', '=', 'coupon.bill_uuid')
          ->join('offer_coupon', 'coupon.coupon_uuid', '=', 'offer_coupon.coupon_uuid')
          ->join('offer', 'offer_coupon.offer_uuid', '=', 'offer.offer_uuid')
          ->join('company_offer', 'offer.offer_uuid', '=', 'company_offer.offer_uuid')
          ->join('company', 'company_offer.company_uuid', '=', 'company.company_uuid')
          ->whereBetween('bill.created_at', [$mesInicio, $mesFin])
          ->select(DB::raw('SUM(coupon.cost * company.percentage / 100) as total'))
          ->first()->total ?? 0;

      $ingresos->push(round($inc / 100, 2));
      $ganancias->push(round($gan / 100, 2));

      $cursor->addMonth();
    }

    // Detalle por empresa
    $detallePorEmpresa = DB::table('company')
      ->where('company.status', 'aprobada')
      ->join('company_offer', 'company.company_uuid', '=', 'company_offer.company_uuid')
      ->join('offer', 'company_offer.offer_uuid', '=', 'offer.offer_uuid')
      ->join('offer_coupon', 'offer.offer_uuid', '=', 'offer_coupon.offer_uuid')
      ->join('coupon', 'offer_coupon.coupon_uuid', '=', 'coupon.coupon_uuid')
      ->join('bill', 'coupon.bill_uuid', '=', 'bill.bill_uuid')
      ->whereBetween('bill.created_at', [$startDate, $endDate])
      ->select([
        'company.name as company_name',
        DB::raw('COUNT(coupon.coupon_uuid) as total_coupons_sold'),
        DB::raw('ROUND(SUM(coupon.cost)/100,2) as total_sales'),
        DB::raw('ROUND(SUM(coupon.cost*company.percentage/100)/100,2) as total_earnings'),
      ])
      ->groupBy('company.company_uuid', 'company.name')
      ->orderByDesc('total_sales')
      ->get();

    return view(
      'admin.dashboard',
      compact(
        'startDate',
        'endDate',
        'totalEmpresas',
        'empresasAprobadas',
        'empresasPendientes',
        'totalUsuarios',
        'usuariosNuevos',
        'totalOfertas',
        'cuponesVendidos',
        'totalIngresos',
        'totalGanancias',
        'meses',
        'ingresos',
        'ganancias',
        'detallePorEmpresa'
      )
    );
  }

  public function formCrearUsuario()
  {
    return view('admin.crear-usuario');
  }

  public function guardarNuevoUsuario(Request $request)
  {
    $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|email|unique:users,email',
      'password' => 'required|min:6',
      'role' => 'required|in:admin,cliente,empresa',
    ]);

    $roleId = match ($request->role) {
      'admin' => 1,
      'empresa' => 2,
      'cliente' => 3,
    };

    User::create([
      'name' => $request->name,
      'email' => $request->email,
      'password' => Hash::make($request->password),
      'role_id' => $roleId,
      'uuid' => Str::uuid(),
    ]);

    return redirect()->route('admin.dashboard')->with('success', 'Usuario creado correctamente.');
  }

  public function empresas()
  {
    $toApprove = Company::where('status', 'pendiente')->get();
    $forUsers = Company::where('status', 'aprobada')->with('users')->get();
    return view('admin.empresas', compact('toApprove', 'forUsers'));
  }

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

  public function rechazarEmpresa(Company $company)
  {
    $company->update(['status' => 'rechazada']);
    return redirect()->route('admin.empresas')->with('success', 'Empresa rechazada correctamente.');
  }

  public function storeCompanyUser(Request $request, Company $company)
  {
    $data = $request->validate(
      [
        'email' => ['required', 'email', 'max:255', 'unique:user,email'],
        'password' => ['required', 'confirmed', 'min:8'],
        'names' => ['required', 'string', 'max:255', 'regex:/^[\pL\s\-]+$/u'],
        'surnames' => ['required', 'string', 'max:255', 'regex:/^[\pL\s\-]+$/u'],
        'dui' => ['required', 'string', 'max:10', 'regex:/^\d{8}-\d{1}$/'],
        'birthdate' => ['required', 'date', 'before:-18 years'],
      ],
      [
        'names.regex' => 'Los nombres solo pueden contener letras, espacios y guiones',
        'surnames.regex' => 'Los apellidos solo pueden contener letras, espacios y guiones',
        'dui.regex' => 'El DUI debe tener formato 00000000-0',
        'birthdate.before' => 'El usuario debe ser mayor de 18 años',
      ]
    );

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

    if ($request->ajax()) {
      return response()->json(['success' => true]);
    }

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
      'names' => ['required', 'string', 'max:255', 'regex:/^[\pL\s\-]+$/u'],
      'surnames' => ['required', 'string', 'max:255', 'regex:/^[\pL\s\-]+$/u'],
      'dui' => ['required', 'string', 'max:10', 'regex:/^\d{8}-\d{1}$/'],
      'birthdate' => ['required', 'date', 'before:-18 years'],
    ];

    if ($request->filled('password')) {
      $rules['password'] = ['required', 'string', 'min:8', 'confirmed'];
    }

    $data = $request->validate($rules, [
      'names.regex' => 'Los nombres solo pueden contener letras, espacios y guiones',
      'surnames.regex' => 'Los apellidos solo pueden contener letras, espacios y guiones',
      'dui.regex' => 'El DUI debe tener formato 00000000-0',
      'birthdate.before' => 'El usuario debe ser mayor de 18 años',
    ]);

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

    if ($request->ajax()) {
      return response()->json(['success' => true]);
    }

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

  public function admins()
  {
    $admins = User::whereHas('role', fn($q) => $q->where('name', 'Admin'))->get();
    $roleUuid = Role::where('name', 'Admin')->first()->role_uuid;
    return view('admin.admins', compact('admins', 'roleUuid'));
  }

  public function update(Request $request, User $user)
  {
    $request->validate(
      [
        'names' => 'required|string|max:255|regex:/^[\pL\s\-]+$/u',
        'surnames' => 'required|string|max:255|regex:/^[\pL\s\-]+$/u',
        'email' => 'required|email|max:255|unique:user,email,' . $user->user_uuid . ',user_uuid',
        'dui' => 'required|string|max:10|regex:/^\d{8}-\d{1}$/',
        'birthdate' => 'required|date|before:-18 years',
        'password' => 'nullable|string|min:8|confirmed',
      ],
      [
        'names.regex' => 'Los nombres solo pueden contener letras, espacios y guiones',
        'surnames.regex' => 'Los apellidos solo pueden contener letras, espacios y guiones',
        'dui.regex' => 'El DUI debe tener formato 00000000-0',
        'birthdate.before' => 'El usuario debe ser mayor de 18 años',
      ]
    );

    $updateData = [
      'names' => $request->names,
      'surnames' => $request->surnames,
      'email' => $request->email,
      'dui' => $request->dui,
      'birthdate' => $request->birthdate,
    ];

    if ($request->filled('password')) {
      $updateData['password'] = Hash::make($request->password);
    }

    $user->update($updateData);

    return back()->with('success', 'Administrador actualizado.');
  }

  public function destroy(User $user)
  {
    $user->delete();
    return back()->with('success', 'Administrador eliminado.');
  }

  public function store(Request $request)
  {
    $request->validate(
      [
        'names' => 'required|string|max:255|regex:/^[\pL\s\-]+$/u',
        'surnames' => 'required|string|max:255|regex:/^[\pL\s\-]+$/u',
        'email' => 'required|email|unique:user,email|max:255',
        'dui' => 'required|string|max:10|regex:/^\d{8}-\d{1}$/',
        'birthdate' => 'required|date|before:-18 years',
        'password' => 'required|string|min:8|confirmed',
        'role_uuid' => 'required|uuid|exists:role,role_uuid',
      ],
      [
        'names.regex' => 'Los nombres solo pueden contener letras, espacios y guiones',
        'surnames.regex' => 'Los apellidos solo pueden contener letras, espacios y guiones',
        'dui.regex' => 'El DUI debe tener formato 00000000-0',
        'birthdate.before' => 'El usuario debe ser mayor de 18 años',
      ]
    );

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
