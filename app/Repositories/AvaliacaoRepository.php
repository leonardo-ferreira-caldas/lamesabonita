<?php

namespace App\Repositories;

use App\Constants\AvaliacaoConstants;
use App\Constants\ClienteConstants;
use App\Constants\MenuConstants;
use App\Facades\Query;
use App\Model\AvaliacaoModel;

class AvaliacaoRepository extends AbstractRepository
{

    protected $model = AvaliacaoModel::class;

    /**
     * Insere uma nova avaliação feita pelo usuário
     *
     * @param int $idUsuario
     * @param array $dadosAvaliacao
     * @return void
     */
    public function salvar($idUsuario, $dadosAvaliacao)
    {
        $this->create([
            'fk_degustador' => $idUsuario,
            'texto'         => $dadosAvaliacao['texto'],
            'nota'          => $dadosAvaliacao['nota'],
            'fk_chef'       => $dadosAvaliacao['id_chef'],
            'fk_produto'    => $dadosAvaliacao['id_produto'],
            'fk_tipo_avaliacao' => $dadosAvaliacao['fk_tipo_avaliacao'],
            'ind_aprovado'  => 0
        ]);
    }

    /**
     * Aprova uma avaliação
     *
     * @param int $idAvaliacao
     * @return void
     */
    public function aprovar($idAvaliacao) {
        $this->updateById($idAvaliacao, [
            'ind_aprovado'  => true
        ]);
    }

    /**
     * Reprova uma avaliação
     *
     * @param int $idAvaliacao
     * @return void
     */
    public function reprovar($idAvaliacao) {
        $this->deleteById($idAvaliacao);
    }

    /**
     * Retorna os avaliações que estão pendentes
     *
     * @return Model
     */
    public function getAvaliacaoesPendentes()
    {
        return Query::fetch("Chef/Avaliacao/QryBuscarAvaliacoes", [
            'ind_aprovado' => false
        ]);
    }

    /**
     * Retorna os avaliações de um menu
     *
     * @return Model
     */
    public function getAvaliacaoesMenu($idMenu)
    {
        return Query::fetch("Chef/Avaliacao/QryBuscarAvaliacoesMenu", [
            'id_menu' => $idMenu,
            'id_tipo' => AvaliacaoConstants::TIPO_MENU,
            'avatar'  => ClienteConstants::DEFAULT_AVATAR
        ]);
    }

    /**
     * Retorna os avaliações de um curso
     *
     * @return Model
     */
    public function getAvaliacaoesCurso($idCurso)
    {
        return Query::fetch("Chef/Avaliacao/QryBuscarAvaliacoesCurso", [
            'id_curso' => $idCurso,
            'id_tipo' => AvaliacaoConstants::TIPO_CURSO,
            'avatar'  => ClienteConstants::DEFAULT_AVATAR
        ]);
    }

}