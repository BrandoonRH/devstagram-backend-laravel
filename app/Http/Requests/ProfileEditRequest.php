<?php

namespace App\Http\Requests;

use Illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;

class ProfileEditRequest extends FormRequest
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
        return [
            'username' => ['required', 'unique:users,username,'.auth()->user()->id, 'min:3', 'max:20', 'not_in:edit-profile']
        ];
    }

    public function messages()
    {
        return[
           
            'username' => 'El Nombre de Usuario es Obligatorio', 
            'username.unique' => 'El Nombre de Usuario ya esta en Uso', 
            'username.not_in' => 'El Nombre de Usuario es Invalido'
        ];
        
    }
    
    protected function prepareForValidation(): void
    {
        $this->merge([
            'username' => Str::slug($this->username),
        ]);
    }

}
