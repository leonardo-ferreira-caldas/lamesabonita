<?php

namespace App\Repositories;

use App\Model\MenuCulinariaModel;

class MenuCulinariaRepository extends AbstractRepository {

    protected $model = MenuCulinariaModel::class;

    /**
     * Deleta todos os tipos de culinária de um menu
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
     * @param $idTipoCulinaria
     */
    public function inserir($idMenu, $idTipoCulinaria) {
        $this->create([
            'fk_menu'      => $idMenu,
            'fk_culinaria' => $idTipoCulinaria
        ]);
    }

    /**
     * Verifica se existe algum menu cadastrado para uma culinaria especifica
     *
     * @param int $id
     * @return int
     */
    public function getPossuiMenus($id) {
        return $this->exists([
            'fk_culinaria' => $id
        ]);
    }

    /**
     * Retorna todas os tipos de culinária de um menu
     *
     * @param int $idMenu
     * @return array
     */
    public function getCulinarias($idMenu) {
        $registros = $this->find(['fk_menu' => $idMenu]);

        return array_map(function($value) {
            return $value->fk_culinaria;
        }, $registros->all());
    }

}