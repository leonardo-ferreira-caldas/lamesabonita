<?php

namespace App\Repositories;

use App\Facades\Query;
use App\Model\InclusoPrecoModel;

class InclusoPrecoRepository extends AbstractRepository {

    protected $model = InclusoPrecoModel::class;

    /**
     * Retorna a lista de inclusos no preço por tipo
     *
     * @param int $tipo
     * @return collection of Model/InclusoPrecoModel
     */
    public function getListaInclusoPreco($idTipo) {
        return $this->find([
            'fk_tipo' => $idTipo
        ]);
    }

    /**
     * Retorna todos os registros
     *
     * @param int $tipo
     * @return collection of Model/InclusoPrecoModel
     */
    public function getListarTodos() {
        return Query::fetch('Chef/InclusoPreco/QryBuscarRegistrosInclusoPreco');
    }

    /**
     * Insere um item incluso no preço
     *
     * @param string $descricao
     * @param int $idTipo
     * @return Model/InclusoPrecoModel
     */
    public function inserir($descricao, $idTipo) {
        return $this->create([
            'descricao' => $descricao,
            'fk_tipo' => $idTipo
        ]);
    }

    /**
     * Atualiza um item incluso no preço
     *
     * @param int $idInclusoPreco
     * @param string $descricao
     * @param int $idTipo
     * @return Model/InclusoPrecoModel
     */
    public function atualizar($idInclusoPreco, $descricao, $idTipo) {
        return $this->updateById($idInclusoPreco, [
            'descricao' => $descricao,
            'fk_tipo' => $idTipo
        ]);
    }

}