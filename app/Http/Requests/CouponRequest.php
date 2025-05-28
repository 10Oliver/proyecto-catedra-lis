<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
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
            'title' => ['required', 'min:3', 'max:255'],
            'regular_price' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
            'offer_price' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'description' => ['required', 'string', 'min:10'],
            'open_amount' => ['required', 'boolean'],
            'amount' => ['nullable', 'numeric', 'min:1', 'required_if:open_amount,0'],
            'state' => ['required', 'boolean']
        ];
    }

    public function messages(): array
{
    return [
        'title.required' => 'El nombre es obligatorio.',
        'title.min' => 'Debe tener al menos 3 caracteres.',
        'title.max' => 'No puede superar los 255 caracteres.',

        'regular_price.required' => 'El precio regular es obligatorio.',
        'regular_price.regex' => 'Formato de precio inválido.',

        'offer_price.required' => 'El precio de oferta es obligatorio.',
        'offer_price.regex' => 'Formato de precio inválido.',

        'start_date.required' => 'La fecha de inicio es obligatoria.',
        'start_date.date' => 'La fecha de inicio no es válida.',

        'end_date.required' => 'La fecha de fin es obligatoria.',
        'end_date.date' => 'La fecha de fin no es válida.',
        'end_date.after_or_equal' => 'Debe ser igual o después de la fecha de inicio.',

        'description.required' => 'La descripción es obligatoria.',
        'description.min' => 'Debe tener al menos 10 caracteres.',

        'open-amount.required' => 'Debe indicar si el monto es abierto.',
        'open-amount.boolean' => 'Valor inválido para monto abierto.',

        'amount.numeric' => 'El monto debe ser numérico.',
        'amount.min' => 'El monto debe ser al menos 1.',
        'amount.required_if' => 'El monto es obligatorio si los cupones no serán ilimitados.',

        'state.required' => 'El estado es obligatorio.',
        'state.boolean' => 'Valor inválido para estado.',
    ];
}

}
