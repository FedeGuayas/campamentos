<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CalendarStoreRequest extends Request
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
            'program_id'=> 'required',
            'dia_id'=> 'required',
            'horario_id'=> 'required',
            'nivel'=> 'required',
            'cupos' => 'numeric|min:1',
            'mensualidad'=>'numeric|required',
            'profesor_id'=> 'required',
        ];
    }
}
