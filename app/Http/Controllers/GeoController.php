<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\CidadeModel;

class GeoController extends Controller
{
    
    public function getCidadesEstados($codigoEstado) {
       return CidadeModel::select('id_cidade', 'nome_cidade')->where('fk_estado', $codigoEstado)->get();
    }

    public function getCidadesByName(Request $request) {
        if (!$request->has('cidade')) {
            throw new InvalidArgumentException;
        }

        $cidade = $request->input('cidade');
        $cidade = explode(",", $cidade)[0];

        return CidadeModel::where('nome_cidade', 'like', $cidade . '%')
                 ->select('nome_cidade', 'fk_estado')
                 ->orderBy('nome_cidade', 'asc')
                 ->take(5)
                 ->get()
                 ->toArray();
    }

}
