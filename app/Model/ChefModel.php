<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Utils\Stars;
use App\Model\AvaliacaoModel;

class ChefModel extends Model
{
    protected $primaryKey = 'id_chef';
    protected $table      = 'chef';
    protected $fillable   = [
        'avatar', 'foto_capa', 'sobre_chef', 'data_nascimento', 'sobrenome', 'rg',
        'fk_cidade', 'telefone', 'slug', 'ind_toda_cidade', 'fk_status', 'cpf',
        'distancia_aceita', 'logradouro', 'logradouro_numero', 'cep', 'fk_selo_status',
        'id_chef', 'fk_pais', 'fk_estado', 'avatar', 'fk_sexo', 'ind_status',
        'moip_id', 'moip_access_token', 'moip_login', 'moip_created_at', 'bairro',
        'fk_banco', 'banco_agencia', 'banco_conta', 'banco_proprietario_conta'];
    private $galeriaArray = null;

    public function menus() {
        return $this->hasMany('App\Model\MenuModel', 'fk_chef', 'id_chef');
    }

    public function cursos() {
        return $this->hasMany('App\Model\CursoModel', 'fk_chef', 'id_chef');
    }

    public function agenda() {
        return $this->hasMany('App\Model\ChefAgendaModel', 'fk_chef', 'id_chef');
    }

    public function conta_bancarias() {
        return $this->hasMany('App\Model\ChefContaBancaria', 'fk_chef', 'id_chef');
    }

    public function avaliacoes() {
        return $this->hasMany('App\Model\AvaliacaoModel', 'fk_chef', 'id_chef');
    }

    public function status() {
        return $this->belongsTo('App\Model\ChefStatusModel', 'fk_status', 'id_chef_status');
    }

    public function user() {
        return $this->belongsTo('App\User', 'id_chef', 'id');
    }

    public function estado() {
        return $this->belongsTo('App\Model\EstadoModel', 'fk_estado', 'id_estado');
    }

    public function pais() {
        return $this->belongsTo('App\Model\PaisModel', 'fk_pais', 'id_pais');
    }

    public function cidade() {
        return $this->belongsTo('App\Model\CidadeModel', 'fk_cidade', 'id_cidade');
    }

    public function banco() {
        return $this->belongsTo('App\Model\BancoModel', 'fk_banco', 'id_banco');
    }

    public function sexo() {
        return $this->belongsTo('App\Model\SexoModel', 'fk_sexo', 'id_sexo');
    }

    public function galeriaMenu() {
        return $this->hasManyThrough('App\Model\MenuImagemModel', 'App\Model\MenuModel', 'fk_chef', 'fk_menu', 'id_chef');
    }

    public function galeriaCurso() {
        return $this->hasManyThrough('App\Model\CursoImagemModel', 'App\Model\CursoModel', 'fk_chef', 'fk_curso', 'id_chef');
    }

    public function getReputacaoMedia() {
        return Stars::get(AvaliacaoModel::where('fk_chef', $this->id_chef)->avg('nota'));
    }

    public function galeria() {
        if (is_null($this->galeriaArray)) {
            $this->galeriaArray = array_merge($this->galeriaMenu->toArray(), $this->galeriaCurso->toArray());
        }
        return $this->galeriaArray;
    }

    public function getAvaliacaoMedia() {
        return number_format(AvaliacaoModel::where('fk_chef', $this->id_chef)->avg('nota'), 1);
    }
}
