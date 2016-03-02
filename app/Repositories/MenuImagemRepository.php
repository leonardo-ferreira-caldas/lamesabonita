<?php

namespace App\Repositories;

use App\Model\MenuImagemModel;

class MenuImagemRepository extends AbstractRepository {

    protected $model = MenuImagemModel::class;

    /**
     * Insere uma nova imagem
     *
     * @param int $idMenu Código do menu (PK)
     * @param string $nomeImagem
     * @return void
     */
    public function inserir($idMenu, $nomeImagem) {
        return $this->create([
            'fk_menu'     => $idMenu,
            'nome_imagem' => $nomeImagem
        ]);
    }

    /**
     * Atualiza uma foto do menu como capa
     *
     * @param int $idMenu
     * @param int $idMenuImagem
     * @return void
     */
    public function atualizarFotoCapa($idMenu, $idMenuImagem) {
        $this->update(['fk_menu' => $idMenu], ['ind_capa' => false]);
        $this->updateById($idMenuImagem, ['ind_capa' => true]);
    }

    /**
     * Atualiza a primeira foto do menu como capa
     *
     * @param int $idMenu
     * @return void
     */
    public function atualizarPrimeiraFotoComoCapa($idMenu) {
        $this->update(['fk_menu' => $idMenu], ['ind_capa' => false]);

        $foto = $this->findFirst([
           'fk_menu' => $idMenu
        ]);

        if (empty($foto)) {
            return;
        }

        $this->updateById($foto->id_menu_imagem, ['ind_capa' => true]);
    }

    /**
     * Retorna todas as imagens de um menu
     *
     * @param int $idMenu
     * @return int
     */
    public function getQuantidadeImagensMenu($idMenu) {
        return $this->count([
            'fk_menu' => $idMenu
        ]);
    }

    /**
     * Retorna a quantidade de imagens que um menu possui
     *
     * @param int $idMenu
     * @return int
     */
    public function getImagens($idMenu) {
        return $this->find([
            'fk_menu' => $idMenu
        ]);
    }

    /**
     * Verifica se o menu possui alguma foto definida como capa
     *
     * @param int $idMenu
     * @return int
     */
    public function possuiFotoCapa($idMenu) {
        return $this->exists([
            'fk_menu' => $idMenu,
            'ind_capa' => true
        ]);
    }
}