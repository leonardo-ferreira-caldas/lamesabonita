<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AlterarDadosDegustadorRequest extends Request
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
            'name'              => 'required|min:3|max:255',
            'email'             => 'required|email|max:255',
            'cpf'               => 'required|min:8|max:20',
            'telefone'          => 'required|min:6|max:20',
            'cep'               => 'required|min:5|max:15',
            'data_nascimento'   => 'required',
            'fk_pais'           => 'required',
            'fk_sexo'           => 'required',
            'fk_estado'         => 'required',
            'fk_cidade'         => 'required',
            'bairro'            => 'required',
            'logradouro'        => 'required|min:3|max:100',
            'logradouro_numero' => 'required|max:10'
        ];
    }
}
