<?php

use App\Models\Role;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\PasswordResetLinkController;
use Laravel\Fortify\Http\Controllers\NewPasswordController;
use App\Http\Controllers\CustomNewPasswordController;


Route::get('olvide-contrasena', [PasswordResetLinkController::class, 'create'])
    ->middleware(['guest'])
    ->name('password.request');

Route::post('olvide-contrasena', [PasswordResetLinkController::class, 'store'])
    ->middleware(['guest'])
    ->name('password.email');

Route::get('restablecer-contrasena/{token}', [NewPasswordController::class, 'create'])
    ->middleware(['guest'])
    ->name('password.reset');

Route::post('restablecer-contrasena', [CustomNewPasswordController::class, 'store'])
    ->middleware(['guest'])
    ->name('password.update');