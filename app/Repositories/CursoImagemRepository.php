<?php

namespace App\Repositories;

use App\Model\CursoImagemModel;

class CursoImagemRepository extends AbstractRepository {

    protected $model = CursoImagemModel::class;

    /**
     * Insere uma nova imagem
     *
     * @param int $idCurso Código do curso (PK)
     * @param string $nomeImagem
     * @return void
     */
    public function inserir($idCurso, $nomeImagem) {
        return $this->create([
            'fk_curso'     => $idCurso,
            'nome_imagem' => $nomeImagem
        ]);
    }

    /**
     * Atualiza uma foto do curso como capa
     *
     * @param int $idCurso
     * @param int $idCursoImagem
     * @return void
     */
    public function atualizarFotoCapa($idCurso, $idCursoImagem) {
        $this->update(['fk_curso' => $idCurso], ['ind_capa' => false]);
        $this->updateById($idCursoImagem, ['ind_capa' => true]);
    }

    /**
     * Retorna a quantidade de imagens que um curso possui
     *
     * @param int $idCurso
     * @return int
     */
    public function getQuantidadeImagensCurso($idCurso) {
        return $this->count([
            'fk_curso' => $idCurso
        ]);
    }

    /**
     * Retorna a quantidade de imagens que um curso possui
     *
     * @param int $idCurso
     * @return int
     */
    public function getImagens($idCurso) {
        return $this->find([
            'fk_curso' => $idCurso
        ]);
    }

    /**
     * Verifica se o curso possui alguma foto definida como capa
     *
     * @param int $idCurso
     * @return int
     */
    public function possuiFotoCapa($idCurso) {
        return $this->exists([
            'fk_curso' => $idCurso,
            'ind_capa' => true
        ]);
    }
}