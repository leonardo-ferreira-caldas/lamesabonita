<?php

namespace App\Repositories;

use Illuminate\Support\Str;
use App\Constants\MenuConstants;
use App\Facades\Query;
use App\Model\MenuModel;
use Symfony\Component\HttpKernel\Exception\HttpException;

class MenuRepository extends AbstractRepository {

    protected $model = MenuModel::class;

    /**
     * Retorna um menu filtrado pelo slug
     *
     * @param string $slug
     * @param bool $throwNotFoundException
     * @return Model/MenuModel
     */
    public function findBySlug($slug, $throwNotFoundException = false) {
        $menu = $this->findFirst([
            'slug' => $slug
        ]);

        if ($throwNotFoundException && empty($menu)) {
            throw new HttpException(404);
        }

        return $menu;
    }

    /**
     * Atualiza os dados de um menu usando o slug
     *
     * @param string $slug
     * @return void
     */
    public function updateBySlug($slug, $dados) {
        $menu = $this->findBySlug($slug);

        $this->updateById($menu->id_menu, $dados);
    }

    /**
     * Insere um novo menu
     *
     * @param array $dados
     * @param int $idChef
     * @return Model/MenuModel
     */
    public function inserir($idChef, $dados) {
        $menu = $this->create([
            'fk_chef'            => $idChef,
            'slug'               => Str::slug(sprintf("%s-%s", time(), $dados['titulo'])),
            'titulo'             => $dados['titulo'],
            'aperitivo'          => $dados['aperitivo'],
            'entrada'            => $dados['entrada'],
            'sobremesa'          => $dados['sobremesa'],
            'prato_principal'    => $dados['prato_principal'],
            'qtd_maxima_cliente' => $dados['qtd_maxima_cliente'],
            'preco'              => $dados['preco'],
            'ind_ativo'          => true,
            'fk_status'          => MenuConstants::STATUS_AGUARANDO_APROVACAO
        ]);

        $slug = Str::slug(sprintf('%s-%s', $menu->id_menu, $dados['titulo']));
        $slug = rtrim($slug, '-');

        $this->updateById($menu->id_menu, [
            'slug' => $slug
        ]);

        $menu->slug = $slug;

        return $menu;
    }

    /**
     * Atualiza os dados de um menu
     *
     * @param int $idMenu
     * @param array $dados
     * @return Model/MenuModel
     */
    public function atualizar($idMenu, $dados) {
        $dadosAtualizar = [
            'titulo'             => $dados['titulo'],
            'aperitivo'          => $dados['aperitivo'],
            'entrada'            => $dados['entrada'],
            'sobremesa'          => $dados['sobremesa'],
            'prato_principal'    => $dados['prato_principal'],
            'qtd_maxima_cliente' => $dados['qtd_maxima_cliente'],
            'preco'              => $dados['preco']
        ];

        if (isset($dados['ind_ativo'])) {
            $dadosAtualizar['ind_ativo'] = $dados['ind_ativo'];
        }

        if (isset($dados['fk_status'])) {
            $dadosAtualizar['fk_status'] = $dados['fk_status'];
        }

        $this->updateById($idMenu, $dadosAtualizar);

        return $this->findById($idMenu);
    }

    /**
     * Retorna todos os menus de um chef
     *
     * @param $idChef
     * @return mixed
     */
    public function getMenusByChefId($idChef) {
        return Query::fetch('Chef/Menu/QryBuscarListaMenusChef', [
            'id_chef' => $idChef,
            'sem_foto' => MenuConstants::SEM_FOTO
        ]);
    }

    /**
     * Retorna os dados de um menu
     *
     * @param $idMenu
     * @return mixed
     */
    public function getDadosMenu($idMenu) {
        return Query::fetchFirst('Chef/Menu/QryBuscarDadosMenu', [
            'id_menu' => $idMenu,
            'sem_foto' => MenuConstants::SEM_FOTO
        ]);
    }

    /**
     * Retorna todos cadastrados
     *
     * @return mixed
     */
    public function getTodosMenus() {
        return Query::fetch('Chef/Menu/QryBuscarTodosMenus');
    }

    /**
     * Retorna todos os mensu de um situação
     *
     * @param int $status
     * @return mixed
     */
    public function getMenusPorStatus($status) {
        return Query::fetch('Chef/Menu/QryBuscarMenusPorSituacao', [
            'id_status' => $status
        ]);
    }

    /**
     * Retorna o status do menu (Ativo|Inativo);
     *
     * @param $slug
     * @return mixed
     */
    public function getMenuStatusBySlug($slug) {
        return (bool) $this->findBySlug($slug)->ind_ativo;
    }

    /**
     * Atualiza o status de um menu (Ativo|Inativo)
     *
     * @param string $slug
     * @param bool $status
     * @return void
     */
    public function atualizarStatus($slug, $status) {
        $this->updateBySlug($slug, [
            'ind_ativo' => $status
        ]);
    }

    /**
     * Atualiza o status de produto de um menu
     *
     * @param string $slug
     * @param int $status
     * @return void
     */
    public function atualizarStatusProduto($slug, $status) {
        $this->updateBySlug($slug, [
            'fk_status' => $status
        ]);
    }

    /**
     * Retorna a quantidade de menus de um chef
     *
     * @param int $id Código do Chef (PK)
     * @return int
     */
    public function getQuantidadeMenusByChefId($id) {
        return $this->count([
            'fk_chef' => $id
        ]);
    }

    /**
     * Retorna uma lista de menus
     *
     * @param $listaIds
     * @return collection
     */
    public function getMenusInicio($listaIds) {
        return Query::fetch('Chef/Menu/QryBuscarDadosMenu', [
            'id_menu' => $listaIds,
            'sem_foto' => MenuConstants::SEM_FOTO
        ]);
    }

}