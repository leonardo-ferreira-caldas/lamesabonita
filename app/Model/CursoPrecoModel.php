<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CursoPrecoModel extends Model
{
    protected $table = 'curso_preco';

    protected $fillable = ['fk_curso', 'preco', 'qtd_minima_clientes'];

}
