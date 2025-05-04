<?php
 
namespace App\Http\Requests;
 
use Illuminate\Foundation\Http\FormRequest;
 
class StoreCompanyApplyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
 
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'nit' => ['required', 'regex:/^\d{4}-\d{6}-\d{3}-\d{1}$/','unique:company'],
            'address' => ['required', 'string', 'min:3', 'max:510'],
            'phone' => ['required', 'regex:/^\d{4}-\d{4}$/'],
            'email' => ['required', 'email']
        ];
    }
 
    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser texto.',
            'name.min' => 'El nombre debe tener al menos 3 caracteres.',
            'name.max' => 'El nombre no debe exceder 255 caracteres.',
 
            'nit.required' => 'El NIT es obligatorio.',
            'nit.regex' => 'El NIT debe tener el formato 0000-000000-000-0.',
            'nit.unique'=> 'El NIT ya se encuentra registrado',
 
            'address.required' => 'La dirección es obligatoria.',
            'address.string' => 'La dirección debe ser texto.',
            'address.min' => 'La dirección debe tener al menos 3 caracteres.',
            'address.max' => 'La dirección no debe exceder 510 caracteres.',
 
            'phone.required' => 'El teléfono es obligatorio.',
            'phone.regex' => 'El teléfono debe tener el formato 0000-0000.',
 
            'email.required' => 'El correo es obligatorio.',
            'email.email' => 'El correo debe ser válido.',
        ];
    }
}
 