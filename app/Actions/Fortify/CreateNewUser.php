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
            'dui' => ['required', 'string', 'max:10'],
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
}
