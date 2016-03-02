<?php

namespace App\Repositories;

use App\Model\CursoRefeicaoModel;

class CursoTipoRefeicaoRepository extends AbstractRepository {

    protected $model = CursoRefeicaoModel::class;

    /**
     * Deleta todos os tipos de refeições de um curso
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
     * @param int $idTipoRefeicao
     */
    public function inserir($idCurso, $idTipoRefeicao) {
        $this->create([
            'fk_curso'          => $idCurso,
            'fk_tipo_refeicao' => $idTipoRefeicao
        ]);
    }

    /**
     * Verifica se existe algum curso cadastrado para um tipo de refeição especifico
     *
     * @param int $id
     * @return int
     */
    public function getPossuiCursos($id) {
        return $this->exists([
            'fk_tipo_refeicao' => $id
        ]);
    }

    /**
     * Retorna todas os tipos de refeição de um curso
     *
     * @param int $idCurso
     * @return array
     */
    public function getRefeicoes($idCurso) {
        $registros = $this->find(['fk_curso' => $idCurso]);

        return array_map(function($value) {
            return $value->fk_tipo_refeicao;
        }, $registros->all());
    }

}