<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class InscripcionStoreRequest extends Request
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
            'representante_id'=> 'required',
            'modulo_id'=> 'required',
            'escenario_id'=> 'required',
            'disciplina_id'=> 'required',
            'dia_id'=> 'required',
            'horario_id'=> 'required',
            'nivel'=> 'required',
            'fpago_id'=> 'required',
            'valor'=> 'required',
        ];
    }

    public function messages()
    {
        return [
            'representante_id.required' => 'Seleccione un Representante',
            'modulo_id.required' => 'El modulo es requerido',
            'escenario_id.required'=> 'El escenario es requerido',
            'disciplina_id.required'=> 'La disciplina es requerida',
            'dia_id.required'=> 'El dia es requerido',
            'horario_id.required'=> 'El horario es requerido',
            'nivel.required'=> 'El nivel es requerido',
            'fpago_id.required'=> 'Seleccione una forma de pago',
            'valor.required'=> 'El precio es requerido',
        ];
    }
}
