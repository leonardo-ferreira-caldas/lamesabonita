<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CursoImagemModel extends Model
{
    protected $table = 'curso_imagem';
    protected $primaryKey = 'id_curso_imagem';

    public function curso() {
        return $this->belongsTo('App\Model\CursoModel', 'fk_curso', 'id_curso');
    }
}
