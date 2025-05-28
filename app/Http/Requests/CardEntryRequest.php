<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CardEntryRequest extends FormRequest
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
            'card_number' => 'required|string|regex:/^\d{13,19}$/',
            'card_holder_name' => 'required|string|min:3',
            'expiration_month' => 'required|integer|between:1,12',
            'expiration_year' => 'required|integer|min:' . date('Y') . '|max:' . (date('Y') + 10),
            'cvv' => 'required|string|regex:/^\d{3,4}$/',
        ];
    }

    public function messages(): array
    {
        return [
            'card_number.required' => 'El número de tarjeta es obligatorio.',
            'card_number.regex' => 'El número de tarjeta no tiene un formato válido.',
            'card_holder_name.required' => 'El nombre del titular es obligatorio.',
            'card_holder_name.min' => 'El nombre del titular debe tener al menos 3 caracteres.',
            'expiration_month.required' => 'El mes de vencimiento es obligatorio.',
            'expiration_month.integer' => 'El mes de vencimiento debe ser un número.',
            'expiration_month.between' => 'El mes de vencimiento debe estar entre 1 y 12.',
            'expiration_year.required' => 'El año de vencimiento es obligatorio.',
            'expiration_year.integer' => 'El año de vencimiento debe ser un número.',
            'expiration_year.min' => 'El año de vencimiento no puede ser anterior al año actual.',
            'expiration_year.max' => 'El año de vencimiento es demasiado lejano.',
            'cvv.required' => 'El CVV es obligatorio.',
            'cvv.regex' => 'El CVV no tiene un formato válido.',
        ];
    }
}
