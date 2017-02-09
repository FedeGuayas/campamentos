<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UserUpdateOnlineRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required | max:50',
            'last_name' => 'required | max:100',
            'avatar'=>'mimes:jpeg,png,jpeg|max:150'
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'El nombre es requerida',
            'first_name.max' => 'El nombre es demasiado extenso, no supere los 50 caracteres',
            'last_name.required' => 'Los apellidos son requeridos',
            'last_name.max' => 'Los apellidos son demasiado extenso, no supere los 100 caracteres',
            'avatar.image' => 'El avatar debe ser una imagen de tipo jpeg,png,jpeg',
            'avatar.max' => 'Seleccione una imagen inferior a los 150Kb',

        ];
    }
}
