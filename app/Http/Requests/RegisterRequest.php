<?php

namespace App\Http\Requests;

use Illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password as PasswordRules;

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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        
        //Reglas de Validación
        return [
            'name' => ['required', 'string'], 
            'username' => ['required', 'string', 'unique:users,username'],
            'email' => ['required', 'email', 'unique:users,email'], 
            'password' => [
                'required',
                'confirmed', 
                PasswordRules::min(8)->letters()->symbols()->numbers()
            ]
        ];
    }
    public function messages()
    {
        return[
            'name' => 'El Nombre es Obligatorio', 
            'username' => 'El Nombre de Usuario es Obligatorio', 
            'username.unique' => 'El Nombre de Usuario ya esta en Uso', 
            'email.required' => 'El Email es Obligatorio',
            'email.email' => 'El Email no es Valido',
            'email.unique' => 'El Email ya esta Registrado', 
            'password' => 'El password debe contener al menos 8 caracteres, un simbolo y un número'
        ];
    }
    
    protected function prepareForValidation(): void
    {
        $this->merge([
            'username' => Str::slug($this->username),
        ]);
    }
}
