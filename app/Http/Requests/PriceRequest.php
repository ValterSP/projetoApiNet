<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PriceRequest extends FormRequest
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
            'unit_price_catalog' => ['required', 'decimal:2', 'min:1'],
            'unit_price_catalog_discount' => ['required', 'decimal:2', 'min:1'],
            'qty_discount' => ['required', 'integer', 'min:1'],
            'unit_price_own' => ['required', 'decimal:2', 'min:1'],
            'unit_price_own_discount' => ['required', 'numeric', 'min:1'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'unit_price_catalog.required' => 'O campo Preço Unitário do Catálogo é obrigatório.',
            'unit_price_catalog.decimal' => 'O campo Preço Unitário do Catálogo deve ser um valor numérico com 2 casas decimais.',
            'unit_price_catalog.min' => 'O campo Preço Unitário do Catálogo deve ser no mínimo :min.',

            'unit_price_catalog_discount.required' => 'O campo Preço Unitário do Catálogo com Desconto é obrigatório.',
            'unit_price_catalog_discount.decimal' => 'O campo Preço Unitário do Catálogo com Desconto deve ser um valor numérico com 2 casas decimais.',
            'unit_price_catalog_discount.min' => 'O campo Preço Unitário do Catálogo com Desconto deve ser no mínimo :min.',

            'qty_discount.required' => 'O campo Quantidade de Desconto é obrigatório.',
            'qty_discount.integer' => 'O campo Quantidade de Desconto deve ser um valor inteiro.',
            'qty_discount.min' => 'O campo Quantidade de Desconto deve ser no mínimo :min.',

            'unit_price_own.required' => 'O campo Preço Unitário de T-Shirts Próprias é obrigatório.',
            'unit_price_own.decimal' => 'O campo Preço Unitário de T-Shirts Próprias deve ser um valor numérico com 2 casas decimais.',
            'unit_price_own.min' => 'O campo Preço Unitário de T-Shirts Próprias deve ser no mínimo :min.',

            'unit_price_own_discount.required' => 'O campo Preço Unitário de T-Shirts Próprias com Desconto é obrigatório.',
            'unit_price_own_discount.numeric' => 'O campo Preço Unitário de T-Shirts Próprias com Desconto deve ser um valor numérico com 2 casas decimais.',
            'unit_price_own_discount.min' => 'O campo Preço Unitário de T-Shirts Próprias com Desconto deve ser no mínimo :min.',
        ];
    }
}
