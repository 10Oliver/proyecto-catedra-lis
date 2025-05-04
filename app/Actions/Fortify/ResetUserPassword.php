<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\ResetsUserPasswords;
use Illuminate\Validation\Rules\Password;

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
        'password' => ['required', 'confirmed', 'regex:/^(?=.*[a-z])(?=.*[A-Z]).+$/', Password::min(8)->numbers()->symbols()->uncompromised()],
        ], $this->messages())->validate();

        $user->forceFill([
            'password' => Hash::make($input['password']),
        ])->save();
    }

    public function messages(): array
    {
        return [
            'password.required' => 'Campo obligatorio.',
            'password.min' => 'Mínimo 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.regex' => 'Debe incluir mayúsculas y minúsculas.',
            'password.numbers' => 'Debe incluir al menos 1 número.',
            'password.symbols' => 'Debe incluir al menos 1 símbolo.',
            'password.uncompromised' => 'Contraseña comprometida, intenta otra.',
        ];
    }
}
