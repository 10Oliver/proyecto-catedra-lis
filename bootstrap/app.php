<?php

use App\Http\Middleware\CheckUserRole;
use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'check.role' => CheckUserRole::class,
            'alreadyAuthenticated' => RedirectIfAuthenticated::class
        ]);

        $middleware->redirectUsersTo(function (Request $request) {
            if (! $request->expectsJson()) {
                $path = $request->path();
                $intended = $request->session()->get('url.intended', $request->url());

                $privateKeywords = ['privada', 'administrador', 'empresa', 'admin', 'dashboard'];

                $isPrivateRoute = false;
                foreach ($privateKeywords as $keyword) {
                    if (str_contains($path, $keyword) || str_contains($intended, $keyword)) {
                        $isPrivateRoute = true;
                        break;
                    }
                }

                return $isPrivateRoute
                    ? route('private.login')
                    : route('customer.login');
            }
        });
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
