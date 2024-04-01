<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'nif' => ['nullable','numeric','digits:9'],
            'address' => ['nullable','string'],
            'default_payment_type' =>['nullable',Rule::in(['VISA', 'MC', 'PAYPAL'])],
            'default_payment_ref' => ['nullable','string','max:255']
        ];
    }


    public function messages(): array
    {
        return [
            'nif' => 'O nif tem de ser um valor numérico de tamanho 9',
            'default.payment.in' =>  'O metodo de pagamento tem de ser VISA, MC ou PAYPAL',
        ];
    }

}
