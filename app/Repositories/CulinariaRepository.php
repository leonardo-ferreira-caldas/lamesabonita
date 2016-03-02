<?php

namespace App\Repositories;

use App\Model\CulinariaModel;

class CulinariaRepository extends AbstractRepository {

    protected $model = CulinariaModel::class;

    /**
     * Retorna todas os tipos de culinária ordenados por nome crescente
     *
     * @return array
     */
    public function getListaCulinarias() {
        return $this->instance->orderBy('nome_culinaria', 'asc')->get();
    }

    /**
     * Insere uma nova culinária
     *
     * @param string $nomeCulinaria
     * @return Model/CulinariaModel
     */
    public function inserir($nomeCulinaria) {
        return $this->create([
            'nome_culinaria' => $nomeCulinaria
        ]);
    }

    /**
     * Atualiza uma culinária
     *
     * @param string $nomeCulinaria
     * @return Model/CulinariaModel
     */
    public function atualizar($idCulinaria, $nomeCulinaria) {
        return $this->updateById($idCulinaria, [
            'nome_culinaria' => $nomeCulinaria
        ]);
    }

}