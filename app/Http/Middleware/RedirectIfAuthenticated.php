<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::user();

                if ($user->role) {
                    $roleName = $user->role->name;

                    //dd($roleName);

                    if ($roleName === 'Admin') {
                        return redirect()->route('admin.index');
                    }

                    if ($roleName === 'Empresa') {
                        return redirect()->route('empresa.index');
                    }

                    if ($roleName === 'Cliente') {
                        return redirect('/');
                    }
                }

                return redirect('/');
            }
        }

        return $next($request);
    }
}
