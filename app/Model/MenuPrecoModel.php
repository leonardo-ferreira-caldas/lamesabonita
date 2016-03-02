<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MenuPrecoModel extends Model
{
    protected $table = 'menu_preco';

    protected $fillable = ['fk_menu', 'preco', 'qtd_minima_clientes'];
    
}
