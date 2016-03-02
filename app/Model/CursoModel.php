<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

use DB;

class CursoModel extends Model
{
    protected $table = 'curso';
    protected $primaryKey = 'id_curso';

    protected $fillable = ['id_curso', 'fk_chef', 'qtd_maxima_cliente',
        'titulo', 'slug', 'fk_culinaria', 'ind_ativo', 'fk_status', 'descricao','preco'];

    public function culinarias() {
        return $this->belongsToMany("App\Model\CulinariaModel", "curso_culinaria", "fk_curso", "fk_culinaria");
    }

    public function refeicoes() {
        return $this->belongsToMany("App\Model\TipoRefeicaoModel", "curso_refeicao", "fk_curso", "fk_tipo_refeicao");
    }

    public function incluso_preco() {
        return $this->belongsToMany("App\Model\InclusoPrecoModel", "curso_incluso_preco", "fk_curso", "fk_incluso_preco");
    }

    public function chef() {
        return $this->belongsTo('App\Model\ChefModel', 'fk_chef', 'id_chef');
    }

    public function precos() {
        return $this->hasMany('App\Model\CursoPrecoModel', 'fk_curso', 'id_curso');
    }

    public function imagens() {
        return $this->hasMany('App\Model\CursoImagemModel', 'fk_curso', 'id_curso');
    }

    public function fotoCapa() {
        if ($this->imagens()->count() >= 1) {
            return $this->imagens()->where('ind_capa', '1')->first()->nome_imagem;
        }
        return config('constants.sem_foto');
    }

    public static function getListagemBusca($get) {

        $query = DB::table('curso')
            ->select(DB::raw('curso.slug'))
            ->addSelect(DB::raw('curso.titulo'))
            ->addSelect(DB::raw('curso.preco'))
            ->addSelect(DB::raw('0 as ind_menu'))
            ->addSelect(DB::raw('1 as ind_curso'))
            ->addSelect(DB::raw('curso.id_curso as id'))
            ->addSelect('chef.id_chef')
            ->addSelect('curso_imagem.nome_imagem as capa')
            ->addSelect('chef.slug as slug_chef')
            ->addSelect('users.name', 'chef.avatar')
            ->join('chef', 'chef.id_chef', '=', 'curso.fk_chef')
            ->join('curso_imagem', function ($join) {
                $join->on('curso_imagem.fk_curso', '=', 'curso.id_curso')
                     ->on('curso_imagem.ind_capa', '=', DB::raw(1));
            })
            ->join('curso_culinaria', 'curso_culinaria.fk_curso', '=', 'curso.id_curso')
            ->join('curso_refeicao', 'curso_refeicao.fk_curso', '=', 'curso.id_curso')
            ->join('users', 'users.id', '=', 'chef.id_chef');

        if (!empty($get['cidade'])) {

            $cidade = explode(',', $get['cidade'])[0];
            $cidade = CidadeModel::where('nome_cidade', $cidade)->first();

            if (!empty($cidade->id_cidade)) {
                $query->where('chef.fk_cidade', $cidade->id_cidade);
            }

        }

        if (!empty($get['culinaria'])) {
            $query->whereIn('curso_culinaria.fk_culinaria', $get['culinaria']);
        }

        if (!empty($get['tipo_refeicao'])) {
            $query->whereIn('curso_refeicao.fk_tipo_refeicao', $get['tipo_refeicao']);
        }

        if (!empty($get['reputacao'])) {

            $query->addSelect(DB::raw('(select round(avg(nota), 0) from avaliacao r where r.fk_chef = curso.fk_chef) as reputacao'));
            $query->havingRaw(sprintf('reputacao in (%s)', implode(',', $get['reputacao'])));

        }

        if (!empty($get['precos'])) {
            $query->whereBetween('curso.preco', $get['precos']);
        }

        $query->groupBy('curso.id_curso');

        return $query;

    }

}
