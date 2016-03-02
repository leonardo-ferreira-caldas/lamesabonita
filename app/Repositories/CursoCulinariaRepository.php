<?php

namespace App\Repositories;

use App\Model\CursoCulinariaModel;

class CursoCulinariaRepository extends AbstractRepository {

    protected $model = CursoCulinariaModel::class;

    /**
     * Deleta todos os tipos de culinária de um curso
     *
     * @param int $idCurso
     * @return void
     */
    public function deletarByCursoId($idCurso) {
        $this->delete([
            'fk_curso' => $idCurso
        ]);
    }

    /**
     * Salva tipos de refeição para um curso
     *
     * @param int $idCurso
     * @param int $idTipoCulinaria
     */
    public function inserir($idCurso, $idTipoCulinaria) {
        $this->create([
            'fk_curso'     => $idCurso,
            'fk_culinaria' => $idTipoCulinaria
        ]);
    }

    /**
     * Verifica se existe algum curso cadastrado para uma culinaria especifica
     *
     * @param int $id
     * @return int
     */
    public function getPossuiCursos($id) {
        return $this->exists([
            'fk_culinaria' => $id
        ]);
    }

    /**
     * Retorna todas os tipos de culinária de um curso
     *
     * @param int $idCurso
     * @return array
     */
    public function getCulinarias($idCurso) {
        $registros = $this->find(['fk_curso' => $idCurso]);

        return array_map(function($value) {
            return $value->fk_culinaria;
        }, $registros->all());
    }


}