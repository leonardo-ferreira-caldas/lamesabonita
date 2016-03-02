<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class EstadoModel extends Model
{
    protected $primaryKey = "id_estado";
    protected $table      = "estado";
    public $incrementing = false;
}
