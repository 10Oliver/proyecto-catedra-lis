<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    protected $restrictedPaths = [
        'private',
        'privada',
        'administrador',
        'empresa',
        'admin',
        'dashboard'
    ];
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $roleName): Response
    {
        $user = Auth::user();

        $path = strtolower($request->getPathInfo());
        if (!$user || ($user->role->name ?? '') !== $roleName) {
            foreach ($this->restrictedPaths as $keyword) {
                if (str_contains($path, $keyword)) {
                    return redirect()->route('private.login');
                }
            }
            return redirect()->route('customer.login');
        }
        return $next($request);
    }
}
