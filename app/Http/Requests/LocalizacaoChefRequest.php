<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class LocalizacaoChefRequest extends Request
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
            'fk_pais'           => 'required',
            'fk_cidade'         => 'required',
            'fk_estado'         => 'required',
            'logradouro'        => 'required',
            'logradouro_numero' => 'required'
        ];
    }
}
