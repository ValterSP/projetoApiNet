<?php

namespace App\Http\Requests;

use App\Models\Color;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ColorRequest extends FormRequest
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

    protected function prepareForValidation()
    {
        $this->merge([
            'code' => str_replace('#', '', $this->input('code')),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        return [
            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('colors')->ignore($this->route('color'))->where(function ($query) {
                    return $query->where('code', $this->input('code'));
                }),
            ],
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('colors')->ignore($this->route('color')),
            ],
        ];
    }




    public function messages(): array
    {
        return [
            'name.required' => 'O campo nome é obrigatório',
            'name.unique' => 'O campo nome tem de ser único',
            'code.unique' => 'A cor tem de ser unica',
            'code.required' => 'O codigo é obrigatório',
        ];
    }
}
