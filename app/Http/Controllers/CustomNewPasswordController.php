<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Routing\Controller;

class CustomNewPasswordController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => ['required','email'],
            'password' => ['required','confirmed','min:8'],
        ]);

        $status = Password::reset(
            $request->only('email','password','password_confirmation','token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password'       => Hash::make($request->password),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            $prefix  = $request->segment(1);
            $loginRoute = 'customer.login';
            if ($prefix == 'private') {
                $loginRoute = "private.login";
            }


            return redirect()
                ->route($loginRoute)
                ->with('status', __($status));
        }

        return back()->withErrors([
            'email' => [__($status)]
        ]);
    }
}
