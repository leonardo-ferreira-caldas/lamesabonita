<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CulinariaModel extends Model
{
    
    protected $table = 'culinaria';
    protected $primaryKey = 'id_culinaria';

    private function menus() {
        return $this->belongsToMany("App\MenuModel", "menu_culinaria", "fk_culinaria", "fk_menu");
    }

}
