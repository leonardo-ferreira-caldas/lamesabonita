<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class InformacoesPessoaisChefRequest extends Request
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
            'name'            => 'required|min:3|max:255',
            'sobrenome'       => 'required|min:3|max:255',
            'sobre_chef'      => 'required|min:20|max:1500',
            'telefone'        => 'required|min:6|max:20',
            'cpf'             => 'required|min:14',
            'rg'              => 'required|min:7',
            'fk_sexo'         => 'required',
            'data_nascimento' => 'required|date_format:d/m/Y'
        ];
    }
}
