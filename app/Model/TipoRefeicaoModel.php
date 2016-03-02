<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TipoRefeicaoModel extends Model
{
    protected $table = 'tipo_refeicao';
    protected $primaryKey = 'id_tipo_refeicao';

    private function menus() {
        return $this->belongsToMany("App\MenuModel", "menu_refeicao", "fk_tipo_refeicao", "fk_menu");
    }

}
