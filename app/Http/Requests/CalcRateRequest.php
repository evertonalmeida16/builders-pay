<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CalcRateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'bar_code' => 'required|string|min:44|max:44',
            'payment_date' => 'required|string'
        ];
    }

    public function messages(): array
    {
        return [
            'bar_code.required' => 'Informe o código de barras.',
            'payment_date.required' => 'Informe a data de pagamento.',
            'bar_code.min' => 'Código de barras inválido.',
            'bar_code.max' => 'Código de barras inválido.'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['errors' => $validator->errors()], 422));
    }
}
