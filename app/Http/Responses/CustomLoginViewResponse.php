<?php

namespace App\Http\Responses;

use Illuminate\Http\Request;
use Laravel\Fortify\Contracts\LoginViewResponse as LoginViewResponseContract;
use Illuminate\Http\RedirectResponse;

class CustomLoginViewResponse implements LoginViewResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request): RedirectResponse
    {
        $intendedUrl = $request->session()->get('url.intended', url('/'));
        $privateKeywords = ['privada', 'administrador', 'empresa', 'admin', 'dashboard', 'private'];

        foreach ($privateKeywords as $keyword) {
            if (str_contains($intendedUrl, $keyword)) {
                return redirect()->route('private.login');
            }
        }

        return redirect()->route('customer.login');
    }
}
