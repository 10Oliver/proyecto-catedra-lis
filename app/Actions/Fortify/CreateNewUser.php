<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique(User::class)],
            'password' => $this->passwordRules(),
            'names' => ['required', 'string', 'max:255'],
            'surnames' => ['required', 'string', 'max:255'],
            'dui' => ['required', 'string', 'max:10', 'regex:/^\d{8}-\d{1}$/'],
            'birthdate' => ['required', 'date'],
            'role_uuid' => ['required', 'uuid'],
        ])->validate();

        return User::create([
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'username' => $input['email'],
            'names' => $input['names'],
            'surnames' => $input['surnames'],
            'dui' => $input['dui'],
            'birthdate' => $input['birthdate'],
            'role_uuid' => $input['role_uuid'],
        ]);
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Campo requerido',
            'email.string' => 'Campo de tipo texto',
            'email.email' => 'Correo inválido',
            'email.max' => 'Máximo 255 caracteres',
            'email.unique' => 'Correo ya registrado',

            'password.required' => 'Campo requerido',
            'password.string' => 'Campo de tipo texto',
            'password.min' => 'Mínimo 8 caracteres',
            'password.confirmed' => 'Confirmación no coincide',

            'names.required' => 'Campo requerido',
            'names.string' => 'Campo de tipo texto',
            'names.max' => 'Máximo 255 caracteres',

            'surnames.required' => 'Campo requerido',
            'surnames.string' => 'Campo de tipo texto',
            'surnames.max' => 'Máximo 255 caracteres',

            'dui.required' => 'Campo requerido',
            'dui.string' => 'Campo de tipo texto',
            'dui.max' => 'Máximo 10 caracteres',
            'dui.regex' => 'Formato inválido (########-#)',

            'birthdate.required' => 'Campo requerido',
            'birthdate.date' => 'Fecha inválida',

            'role_uuid.required' => 'Campo requerido',
            'role_uuid.uuid' => 'UUID inválido',
        ];
    }
}
