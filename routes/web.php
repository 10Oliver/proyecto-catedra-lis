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
Route::get('privada/iniciar-sesion', [CompanyAuthController::class, 'login'])->name('private.login');

/**
 * Register default endpoints
 */
Route::get('registro', [CustomerAuthController::class, 'register'])->name('customer.register');
Route::get('admin/registro', [AdminAuthController::class, 'register'])->name('admin.register');
Route::get('empresa/registro', [CompanyAuthController::class, 'register'])->name('company.register');


/**
 * Reset password endpoints
 */

Route::prefix('cliente')
    ->name('cliente.')
    ->middleware('guest')
    ->group(function() {
        require __DIR__.'/fortify-password-routes.php';
    });

Route::prefix('private')
    ->name('private.')
    ->middleware('guest')
    ->group(function() {
        require __DIR__.'/fortify-password-routes.php';
    });
/**
 * Costumer endpoints
 */

Route::resource('', CustomerController::class);


/**
 * Admin endpoints
 */
Route::resource('administrador', AdminController::class);

/**
 * Company endpoints
 */
Route::resource('empresa', CompanyController::class)->except('show');

Route::get('empresa/solicitud', [CompanyController::class, 'showApplyForm'])->name('empresa.apply');


Route::middleware(['auth'])->group(function () {
    Route::get('/admin/usuarios/crear', [App\Http\Controllers\AdminController::class, 'formCrearUsuario'])->name('admin.users.create');
    Route::post('/admin/usuarios', [App\Http\Controllers\AdminController::class, 'guardarNuevoUsuario'])->name('admin.users.store');
});

