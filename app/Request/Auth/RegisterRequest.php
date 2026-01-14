<?php

namespace App\Request\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'nombres' => 'required|string|max:50',
            'apellidos' => 'required|string|max:50',
            'birthdate' => 'required|string|max:10',
            'celular' => 'required|string|max:10',
            'genero' => 'nullable|string|max:10',
            'photo' => 'nullable|string|max:255',
            'email' => 'required|email|max:100|unique:clientes',
            'password' => 'required|string|min:8|max:15',
        ];
    }

    /**
     * Get custom validation messages.
     *
     * @return array
     */
    public function messages(){
        return [
            'email.unique' => 'Este correo electrónico ya se encuentra registrado.',
        ];
    }
}
