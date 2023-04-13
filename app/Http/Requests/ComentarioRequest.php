<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ComentarioRequest extends FormRequest
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
            'comentario' =>  ['required', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [

            'comentario.required' => 'El Comentario es Obligatorio',
        ];
    }
}
