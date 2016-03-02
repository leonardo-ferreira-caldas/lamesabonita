<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SexoModel extends Model
{
    protected $primaryKey = 'id_sexo';
    protected $table      = 'sexo';

    public function degustador() {
        return $this->belongsTo('App\Model\DegustadorModel', 'fk_sexo');
    }
}
