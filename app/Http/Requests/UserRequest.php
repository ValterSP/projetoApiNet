<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
        $userID = $this->route('user')->id ?? 0;
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($userID)],
            'password' => ['required', 'string','min:8'],
            'user_type' => ['required', Rule::in(['C','E', 'A'])],
            'blocked' => [Rule::in([0, 1])],
        ];

        if ($this->isMethod('put')) {
            unset($rules['password']);
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name' => 'O campo nome é obrigatório',
            'user_type.in' =>  'O tipo de utilizador só pode ser Empregado e Admin',
            'email.unique' => 'O campo email tem de ser unico',
            'password.min' => 'A password tem de ter no minimo 8 caractéres',
        ];
    }


}
