<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Utils\Stars;

class AvaliacaoModel extends Model
{
    protected $table = 'avaliacao';
    protected $primaryKey = 'id_avaliacao';

    protected $fillable = ['texto', 'nota', 'fk_chef', 'ind_aprovado', 'fk_produto', 'fk_tipo_avaliacao', 'fk_degustador'];

    public function degustador() {
        return $this->belongsTo('App\Model\DegustadorModel', 'fk_degustador', 'id_degustador');
    }

    public function getStars() {
        return Stars::get($this->nota);
    }
    
}
