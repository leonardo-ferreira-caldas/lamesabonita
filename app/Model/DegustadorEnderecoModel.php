<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DegustadorEnderecoModel extends Model {
    protected $primaryKey = 'id_degustador_endereco';

    protected $table      = 'degustador_endereco';
    protected $fillable   = ['fk_degustador', 'fk_cidade', 'fk_estado', 'fk_pais', 'ind_endereco_principal', 'cep',
                             'logradouro', 'descricao', 'bairro', 'logradouro_numero', 'complemento'];

    public function user() {
        return $this->belongsTo('App\User', 'id_degustador');
    }

    public function cidade() {
        return $this->hasOne('App\Model\CidadeModel', 'id_cidade', 'fk_cidade');
    }

    public function estado() {
        return $this->hasOne('App\Model\EstadoModel', 'id_estado', 'fk_estado');
    }

    public function pais() {
        return $this->hasOne('App\Model\PaisModel', 'id_pais', 'fk_pais');
    }

}
        