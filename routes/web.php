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
Route::get('registro', [CustomerAuthController::class, 'register'])->name('customer.register');
Route::get('admin/registro', [AdminAuthController::class, 'register'])->name('admin.register');
Route::get('empresa/registro', [CompanyAuthController::class, 'register'])->name('company.register');

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
Route::resource('empresa', CompanyController::class);
