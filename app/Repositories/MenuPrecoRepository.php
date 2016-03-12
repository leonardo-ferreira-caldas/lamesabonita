<?php

namespace App\Repositories;

use App\Model\MenuPrecoModel;

class MenuPrecoRepository extends AbstractRepository {

    protected $model = MenuPrecoModel::class;

    /**
     * Insere um novo preço por convidado
     *
     * @param int $idMenu Código do menu (PK)
     * @param decimal $preco
     * @param int $qtdClientes
     * @return array
     */
    public function inserir($idMenu, $preco, $qtdClientes) {
        return $this->create([
            'fk_menu' => $idMenu,
            'preco'   => $preco,
            'qtd_minima_clientes' => $qtdClientes
        ]);
    }

    /**
     * Deleta todos os preços por convidados de um menu
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
     * Retorna todos os preços de um menu
     *
     * @param int $idMenu
     * @return array
     */
    public function getPrecosPorConvidado($idMenu) {
        return $this->find([
           'fk_menu' => $idMenu
        ]);
    }

}