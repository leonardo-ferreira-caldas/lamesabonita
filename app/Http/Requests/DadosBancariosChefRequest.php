<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class DadosBancariosChefRequest extends Request
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
            'fk_banco'                 => 'required',
            'banco_agencia'            => 'required',
            'banco_conta'              => 'required|min:4',
            'banco_proprietario_conta' => 'required|min:3'
        ];
    }
}
