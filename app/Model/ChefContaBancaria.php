<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ChefContaBancaria extends Model
{
    protected $table = 'chef_conta_bancaria';
    protected $primaryKey = 'id_conta_bancaria';

    public function chef() {
        return $this->belongsTo('App\Model\ChefModel', 'fk_chef', 'id_chef');
    }

    public function banco() {
        return $this->belongsTo('App\Model\BancoModel', 'fk_banco', 'id_banco');
    }

}
