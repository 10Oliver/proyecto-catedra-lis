<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\LoginUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use App\Http\Responses\CustomLoginResponse;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\URL;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use App\Http\Responses\CustomLoginViewResponse;
use Laravel\Fortify\Contracts\LoginViewResponse as LoginViewResponseContract;


class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(
            \Laravel\Fortify\Contracts\RegisterResponse::class,
            \App\Http\Responses\CustomRegisterResponse::class
        );
        $this->app->singleton(
            LoginResponseContract::class,
            CustomLoginResponse::class
        );
        $this->app->singleton(
            LoginViewResponseContract::class,
            CustomLoginViewResponse::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::authenticateUsing(app(LoginUser::class));
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        ResetPassword::createUrlUsing(function ($user, string $token) {
            $routeName = "cliente.password.reset";
            if ($user->role->name != 'Cliente') {
                $routeName = "private.password.reset";
            }

            return URL::route(
                $routeName,
                ['token' => $token, 'email' => $user->getEmailForPasswordReset()],
            );
        });

        Fortify::requestPasswordResetLinkView(function (Request $request) {
            if ($request->is('cliente/*')) {
                return view('costumer.forgot-password');
            }
            if ($request->is('private/*')) {
                return view('forgot-password');
            }
        });

        Fortify::resetPasswordView(function (Request $request) {
            if ($request->is('cliente/*')) {
                return view('costumer.reset-password', ['request' => $request]);
            }
            if ($request->is('private/*')) {
                return view('reset-password', ['request' => $request]);
            }
        });

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())) . '|' . $request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }
}
