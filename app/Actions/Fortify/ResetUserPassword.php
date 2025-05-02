<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\ResetsUserPasswords;

class ResetUserPassword implements ResetsUserPasswords
{
    use PasswordValidationRules;

    /**
     * Validate and reset the user's forgotten password.
     *
     * @param  array<string, string>  $input
     */
    public function reset(User $user, array $input): void
    {
        Validator::make($input, [
            'password' => $this->passwordRules(),
        ], $this->messages())->validate();

        $user->forceFill([
            'password' => Hash::make($input['password']),
        ])->save();
    }

    public function messages(): array
    {
        return [
            'password.required'   => 'Campo obligatorio',
            'password.string'     => 'Campo debe ser texto',
            'password.confirmed'  => 'Las contraseñas no coinciden',
            'password.min'        => 'La contraseña debe tener al menos :min caracteres.',
            'password.mixed'      => 'La contraseña debe contener mayúsculas, minúsculas y números.',
            'password.letters'    => 'La contraseña debe contener al menos una letra.',
            'password.symbols'    => 'La contraseña debe contener al menos un símbolo.',
        ];
    }
}
