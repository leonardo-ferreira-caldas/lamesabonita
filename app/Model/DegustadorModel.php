<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DegustadorModel extends Model
{
    
    protected $primaryKey = 'id_degustador';
    protected $table      = 'degustador';
    protected $fillable   = ['telefone', 'cpf', 'data_nascimento', 'fk_sexo', 'id_degustador', 'avatar'];

    private $enderecoPrincipal;

    public function user() {
        return $this->belongsTo('App\User', 'id_degustador', 'id');
    }

    public function sexo() {
        return $this->hasOne('App\Model\SexoModel', 'fk_sexo');
    }

    public function enderecos() {
        return $this->hasMany('App\Model\DegustadorEnderecoModel', 'fk_degustador');
    }

    public function favoritos() {
        return $this->hasMany('App\Model\FavoritoModel', 'fk_degustador', 'id_degustador');
    }

    public function enderecoPrincipal() {
        if (empty($this->enderecoPrincipal)) {
            $this->enderecoPrincipal = $this->enderecos()->where('ind_endereco_principal', '1')->first();
        }
        return $this->enderecoPrincipal;
    }

}
