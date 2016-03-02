<?php

namespace App\Repositories;

use App\Model\TipoRefeicaoModel;

class TipoRefeicaoRepository extends AbstractRepository {

    protected $model = TipoRefeicaoModel::class;

    /**
     * Retorna todas os tipos de refeições ordenados por id crescente
     *
     * @return array
     */
    public function getListaRefeicoes() {
        return $this->instance->orderBy('id_tipo_refeicao', 'asc')->get();
    }

    /**
     * Insere uma nova refeição
     *
     * @param string $nomeRefeicao
     * @return Model/TipoRefeicaoModel
     */
    public function inserir($nomeRefeicao) {
        return $this->create([
            'nome_tipo_refeicao' => $nomeRefeicao
        ]);
    }

    /**
     * Atualiza uma refeição
     *
     * @param int $idTipoRefeicao
     * @param string $nomeRefeicao
     * @return Model/TipoRefeicaoModel
     */
    public function atualizar($idTipoRefeicao, $nomeRefeicao) {
        return $this->updateById($idTipoRefeicao, [
            'nome_tipo_refeicao' => $nomeRefeicao
        ]);
    }
}