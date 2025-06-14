<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CompanyAuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PayController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('costumer.landing');
});



Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

/**
 * Login default endpoints
 */
Route::get('iniciar-sesion', [CustomerAuthController::class, 'login'])->middleware('alreadyAuthenticated')->name('customer.login');
Route::get('privada/iniciar-sesion', [CompanyAuthController::class, 'login'])->middleware('alreadyAuthenticated')->name(
    'private.login'
);

/**
 * Register default endpoints
 */
Route::get('registro', [CustomerAuthController::class, 'register'])->name('customer.register');
Route::get('admin/registro', [AdminAuthController::class, 'register'])->name('admin.register');
Route::get('empresa/registro', [CompanyAuthController::class, 'register'])->name(
    'company.register'
);

/**
 * Reset password endpoints
 */

Route::prefix('cliente')
    ->name('cliente.')
    ->middleware('guest')
    ->group(function () {
        require __DIR__ . '/fortify-password-routes.php';
    });

Route::prefix('private')
    ->name('private.')
    ->middleware('guest')
    ->group(function () {
        require __DIR__ . '/fortify-password-routes.php';
    });
/**
 * Costumer endpoints
 */

Route::resource('', CustomerController::class);

Route::get('detalle-cupon/{id}', [CustomerController::class, 'offerDetails'])->name('offer.detail.view');

Route::middleware(['auth', 'check.role:Cliente'])->group(function () {
    Route::post('/carrito-agregar', [CustomerController::class, 'addCart'])->name('cart.add');

    Route::post('/carrito-incrementar/{uuid}', [CustomerController::class, 'increaseQuantity'])->name('cart.increase');
    Route::post('/carrito-disminuir/{uuid}', [CustomerController::class, 'decreaseQuantity'])->name('cart.decrease');
    Route::post('/carrito-remover/{uuid}', [CustomerController::class, 'removeProduct'])->name('cart.remove');

    Route::get('carrito-compras', [CustomerController::class, 'cart'])->name('cart.view');

    Route::get('compra', [CustomerController::class, 'pay'])->name('pay.view');

    Route::post('pagar-pedido', [PayController::class, 'payCoupons'])->name('pay.request');

    Route::get('compra-completada', [PayController::class, 'purchaseCompleted'])->name('purchase.view');

    Route::get('factura/{billUuid}', [PayController::class, 'generateBill'])->name('bill.download');

    Route::get('historial-compras', [CustomerController::class, 'purchaseHistory'])->name('purchase-history.view');
});

/**
 * Admin endpoints
 */
Route::prefix('administrador')
    ->name('admin.')
    ->middleware(['auth', 'check.role:Admin'])
    ->group(function () {
        // Dashboard
        Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('index');

        // Gestión de empresas
        Route::get('/empresas', [AdminController::class, 'empresas'])->name('empresas');
        Route::post('/empresas/{company}/aprobar', [AdminController::class, 'aprobarEmpresa'])->name(
            'empresas.aprobar'
        );
        Route::post('/empresas/{company}/rechazar', [AdminController::class, 'rechazarEmpresa'])->name(
            'empresas.rechazar'
        );

        // Gestión de usuarios de empresas
        Route::post('/empresas/{company}/usuarios', [AdminController::class, 'storeCompanyUser'])->name(
            'empresas.users.store'
        );
        Route::put('/empresas/{company}/usuarios/{user}', [
            AdminController::class,
            'updateCompanyUser',
        ])->name('empresas.users.update');
        Route::delete('/empresas/{company}/usuarios/{user}', [
            AdminController::class,
            'destroyCompanyUser',
        ])->name('empresas.users.destroy');

        // Gestión de administradores
        Route::get('/admins', [AdminController::class, 'admins'])->name('admins.index');
        Route::post('/admins', [AdminController::class, 'store'])->name('admins.store');
        Route::put('/admins/{user}', [AdminController::class, 'update'])->name('admins.update');
        Route::delete('/admins/{user}', [AdminController::class, 'destroy'])->name('admins.destroy');
    });

/**
 * Company endpoints
 */

Route::get('empresa/solicitud', [CompanyController::class, 'showApplyForm'])->name('empresa.apply');

Route::middleware(['auth', 'check.role:Empresa'])->group(function () {
    Route::resource('empresa', CompanyController::class)->except('show');
    Route::get('cupones', [CompanyController::class, 'coupons'])->name('coupons.view');
    Route::post('guardar-oferta', [CompanyController::class, 'saveOffer'])->name('coupon.save.request');
    Route::put('editar-oferta/{offer}', [CompanyController::class, 'updateOffer'])->name('coupon.edit.request');
    Route::delete('eliminar-oferta/{offer}', [CompanyController::class, 'deleteOffer'])->name('coupon.delete.request');
});

Route::middleware(['auth', 'check.role:Admin'])->group(function () {
    Route::get('/admin/usuarios/crear', [
        App\Http\Controllers\AdminController::class,
        'formCrearUsuario',
    ])->name('admin.users.create');
    Route::post('/admin/usuarios', [
        App\Http\Controllers\AdminController::class,
        'guardarNuevoUsuario',
    ])->name('admin.users.store');
});
