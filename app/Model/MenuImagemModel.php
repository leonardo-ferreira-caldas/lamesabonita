<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MenuImagemModel extends Model
{
    protected $table = 'menu_imagem';
    protected $primaryKey = 'id_menu_imagem';

    public function menu() {
        return $this->belongsTo('App\Model\MenuModel', 'fk_menu', 'id_menu');
    }
}
