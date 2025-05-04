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
// routes/web.php
Route::prefix('administrador')
    ->name('admin.')
    //->middleware(['auth','is_admin'])
    ->group(function(){
        // Dashboard
        Route::get('/', [AdminController::class,'index'])->name('index');

        // Solicitudes de empresa
        Route::get('/empresas', [AdminController::class,'empresas'])->name('empresas');
        Route::post('/empresas/{company}/aprobar', [AdminController::class,'aprobarEmpresa'])->name('empresas.aprobar');
        Route::post('/empresas/{company}/rechazar', [AdminController::class,'rechazarEmpresa'])->name('empresas.rechazar');
        // routes/web.php
Route::get('/empresas/{company}/editar-usuario/{user}', [AdminController::class, 'editCompanyUser'])
     ->name('empresas.users.edit');
Route::put('/empresas/{company}/actualizar-usuario/{user}', [AdminController::class, 'updateCompanyUser'])
     ->name('empresas.users.update');

        // Crear usuario tras aprobar
        Route::get('/empresas/{company}/crear-usuario', [AdminController::class,'showCreateCompanyUserForm'])
             ->name('empresas.users.create');
        Route::post('/empresas/{company}/crear-usuario', [AdminController::class,'storeCompanyUser'])
             ->name('empresas.users.store');

        // CRUD de administradores
        Route::get('/admins', [AdminController::class,'admins'])->name('admins.index');
         Route::post('/admins', [AdminController::class,'store'])->name('admins.store');
        Route::put('/admins/{user}', [AdminController::class,'update'])->name('admins.update');
        Route::delete('/admins/{user}', [AdminController::class,'destroy'])->name('admins.destroy');
    });



/**
 * Company endpoints
 */
Route::resource('empresa', CompanyController::class)->except('show');

Route::get('empresa/solicitud', [CompanyController::class, 'showApplyForm'])->name('empresa.apply');
