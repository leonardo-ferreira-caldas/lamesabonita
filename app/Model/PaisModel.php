<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PaisModel extends Model
{
    protected $primaryKey = "id_pais";
    protected $table      = "pais";
    public $incrementing = false;
}
