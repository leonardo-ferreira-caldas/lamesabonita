<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class SalvarMenuRequest extends Request
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
            'titulo'          => 'required',
            'prato_principal' => 'required',
            'preco'           => 'required|min:3',
            'tipo_refeicao'   => 'required|array',
            'tipo_culinaria'  => 'required|array',
            'qtd_maxima_cliente' => 'required'
        ];
    }
}
