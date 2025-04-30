<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CompanyAuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CostumerController;
use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('costumer.landing');
});

/**
 * Login default endpoints
 */
Route::get('iniciar-sesion', [CustomerAuthController::class, 'login'])->name('customer.login');
Route::get('admin/iniciar-sesion', [AdminAuthController::class, 'login'])->name('admin.login');
Route::get('empresa/iniciar-sesion', [CompanyAuthController::class, 'login'])->name('company.login');

/**
 * Register default endpoints
 */
Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('administrador', [AdminController::class, 'index'])->name('admin.index');

    //Empresas
    Route::get('administrador/empresas', [AdminController::class, 'empresas'])->name('admin.empresas');
    Route::post('administrador/empresas/{company}/aprobar', [AdminController::class, 'aprobarEmpresa'])->name('admin.empresas.aprobar');
    Route::post('administrador/empresas/{company}/rechazar', [AdminController::class, 'rechazarEmpresa'])->name('admin.empresas.rechazar');

    //Nuevos administradores
    Route::get('administrador/registrar-admin', [AdminController::class, 'create'])->name('admin.admins.create');
    Route::post('administrador/registrar-admin', [AdminController::class, 'store'])->name('admin.admins.store');
});

/**
 * Costumer endpoints
 */

Route::resource('', CustomerController::class);


/**
 * Admin endpoints
 */
Route::resource('administrador', AdminController::class);

Route::get('administrador/empresas', [AdminController::class, 'empresas'])->name('admin.empresas');
Route::post('administrador/empresas/{company}/aprobar', [AdminController::class, 'aprobarEmpresa'])->name('admin.empresas.aprobar');
Route::post('administrador/empresas/{company}/rechazar', [AdminController::class, 'rechazarEmpresa'])->name('admin.empresas.rechazar');

/**
 * Company endpoints
 */
Route::resource('empresa', CompanyController::class);
