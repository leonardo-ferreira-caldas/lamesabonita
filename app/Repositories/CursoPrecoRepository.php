<?php

namespace App\Repositories;

use App\Model\CursoPrecoModel;

class CursoPrecoRepository extends AbstractRepository {

    protected $model = CursoPrecoModel::class;

    /**
     * Insere um novo preço por convidado
     *
     * @param int $idCurso Código do curso (PK)
     * @param decimal $preco
     * @param int $qtdClientes
     * @return array
     */
    public function inserir($idCurso, $preco, $qtdClientes) {
        return $this->create([
            'fk_curso' => $idCurso,
            'preco'   => $preco,
            'qtd_minima_clientes' => $qtdClientes
        ]);
    }

    /**
     * Deleta todos os preços por convidados de um curso
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
     * Retorna todos os preços de um curso
     *
     * @param int $idCurso
     * @return array
     */
    public function getPrecosPorConvidado($idCurso) {
        return $this->find([
           'fk_curso' => $idCurso
        ]);
    }

}