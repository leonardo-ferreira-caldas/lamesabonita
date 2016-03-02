<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\CidadeModel;
use DB;
use Cloudder;

class MenuModel extends Model
{
    protected $table = 'menu';
    protected $primaryKey = 'id_menu';

    protected $fillable = ['id_menu', 'entrada', 'prato_principal', 'fk_chef', 'qtd_maxima_cliente',
    'titulo', 'slug', 'fk_culinaria', 'ind_ativo', 'fk_status', 'sobremesa', 'preco', 'aperitivo'];

    public function culinarias() {
        return $this->belongsToMany("App\Model\CulinariaModel", "menu_culinaria", "fk_menu", "fk_culinaria");
    }

    public function refeicoes() {
        return $this->belongsToMany("App\Model\TipoRefeicaoModel", "menu_refeicao", "fk_menu", "fk_tipo_refeicao");
    }

    public function incluso_preco() {
        return $this->belongsToMany("App\Model\InclusoPrecoModel", "menu_incluso_preco", "fk_menu", "fk_incluso_preco");
    }

    public function chef() {
        return $this->belongsTo('App\Model\ChefModel', 'fk_chef', 'id_chef');
    }

    public function precos() {
        return $this->hasMany('App\Model\MenuPrecoModel', 'fk_menu', 'id_menu');
    }

    public function imagens() {
        return $this->hasMany('App\Model\MenuImagemModel', 'fk_menu', 'id_menu');
    }

}
