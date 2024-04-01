<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderItemRequest extends FormRequest
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
            'tshirt_image_id' => ['required','int'],
            'color_code' => ['required'],
            'size' => ['required', Rule::in(['XS', 'S', 'M','L','XL'])],
            'qty' => ['required','int'],
        ];
    }

    public function messages(): array
    {
        return [
            'color_code' => 'O campo é obrigatório',
            'size' => 'Campo obrigatorio',
            'qty' => 'Campo obrigatório',
        ];
    }
}
