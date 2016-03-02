<?php

namespace App\Repositories;

use App\Model\MenuRefeicaoModel;

class MenuTipoRefeicaoRepository extends AbstractRepository {

    protected $model = MenuRefeicaoModel::class;

    /**
     * Deleta todos os tipos de refeições de um menu
     *
     * @param int $idMenu
     * @return void
     */
    public function deletarByMenuId($idMenu) {
        $this->delete([
            'fk_menu' => $idMenu
        ]);
    }

    /**
     * Salva tipos de refeição para um menu
     *
     * @param $idMenu
     * @param $idTipoRefeicao
     */
    public function inserir($idMenu, $idTipoRefeicao) {
        $this->create([
            'fk_menu'          => $idMenu,
            'fk_tipo_refeicao' => $idTipoRefeicao
        ]);
    }

    /**
     * Verifica se existe algum menu cadastrado para um tipo de refeição especifico
     *
     * @param int $id
     * @return int
     */
    public function getPossuiMenus($id) {
        return $this->exists([
            'fk_tipo_refeicao' => $id
        ]);
    }

    /**
     * Retorna todas os tipos de refeição de um menu
     *
     * @param int $idMenu
     * @return array
     */
    public function getRefeicoes($idMenu) {
        $registros = $this->find(['fk_menu' => $idMenu]);

        return array_map(function($value) {
            return $value->fk_tipo_refeicao;
        }, $registros->all());
    }

}