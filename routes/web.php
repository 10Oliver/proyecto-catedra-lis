<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\CompanyAuthController;
use App\Http\Controllers\CustomerAuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

/**
 * Login default endpoints
 */
Route::get('login', [CustomerAuthController::class, 'login'])->name('costumer.login');
Route::get('admin/login', [AdminAuthController::class, 'login'])->name('admin.login');
Route::get('empresa/login', [CompanyAuthController::class, 'login'])->name('company.login');

/**
 * Costumer endpoints
 */

Route::resource('auth', CustomerAuthController::class);



/**
 * Admin endpoints
 */
// ...

/**
 * Company endpoints
 */
  // ...