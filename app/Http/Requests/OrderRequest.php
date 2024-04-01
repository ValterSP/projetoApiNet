<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderRequest extends FormRequest
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
            'status' => ['required', Rule::in(['pending', 'paid', 'closed','canceled'])],
            'total_price' => ['required','decimal:0,2'],
            'notes' => ['nullable', 'string'],
            'nif' => ['required','numeric','digits:9'],
            'address' => ['required', 'string'],
            'payment_type' =>['required',Rule::in(['VISA', 'MC', 'PAYPAL'])],
            'payment_ref' => ['required','string','max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'nif' => 'O nif tem de ser um valor numérico de tamanho 9',
            'address' => 'O campo é obrigatório',
            'payment_type.in' =>  'O metodo de pagamento tem de ser VISA, MC ou PAYPAL',
            'payment_ref' => 'O campo é obrigatório',
        ];
    }
}
