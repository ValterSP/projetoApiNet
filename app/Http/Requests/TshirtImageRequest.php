<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TshirtImageRequest extends FormRequest
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
            'name' =>  'required|string|max:255',
            'image' => 'required',
            'description' => 'nullable|string',
            'category_id' => 'nullable|integer',
            'customer_id' => 'nullable|integer',
        ];
    }

    public function messages(): array
    {
        return [
            'name' => 'O campo nome é obrigatório',
            'image.required' => 'O campo é obrigatório',
            'category_id' => 'Categoria inválida',
        ];
    }
}
