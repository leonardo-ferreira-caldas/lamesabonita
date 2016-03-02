<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class FavoritoModel extends Model
{
    protected $table = 'favorito';

    protected $fillable = ['fk_degustador', 'fk_menu', 'fk_curso'];

    public function menu() {
        return $this->belongsTo('App\Model\MenuModel', 'fk_menu', 'id_menu');
    }

    public function curso() {
        return $this->belongsTo('App\Model\CursoModel', 'fk_curso', 'id_curso');
    }

    public function degustador() {
        return $this->belongsTo('App\Model\DegustadorModel', 'fk_degustador', 'id_degustador');
    }
}
