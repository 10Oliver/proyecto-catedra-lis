<?php

use App\Http\Controllers\CostumerAuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

/**
 * Costumer endpoints
 */
Route::resource('auth', CostumerAuthController::class);

/**
 * Admin endpoints
 */
// ...

/**
 * Company endpoints
 */
  // ...