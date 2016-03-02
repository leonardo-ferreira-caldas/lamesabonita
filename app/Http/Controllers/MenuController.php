<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Mappers\BusinessMapper;
use App\Mappers\RepositoryMapper;
use App\Structures\ProximaRota;
use Exception;

class MenuController extends Controller
{

    private $repository;
    private $bo;

    public function __construct(RepositoryMapper $mapper, BusinessMapper $businessMapper) {
        parent::__construct();
        $this->middleware('chef');

        $this->repository = $mapper;
        $this->bo = $businessMapper;
    }

    /**
     * Carrega a view que lista os menus cadastrados do chef logado
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getListagemMenus() {
        return view('chef.menus.listar', [
            'page'  => 'menus',
            'menus' => $this->bo->menu->getMenusChefLogado()
        ]);
    }

    /**
     * Carrega a view para inserir um menu
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getNovoMenu() {
        return view('chef.menus.formulario_inserir', [
            'page'   => 'menus',
            'combos' => $this->bo->menu->getCombosFormulario()
        ]);
    }

    /**
     * Carrega a view para editar um menu
     *
     * @param int $idMenu
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getEditarMenu($idMenu) {
        return view('chef.menus.formulario', [
            'page'   => 'menus',
            'menu'   => $this->bo->menu->getDadosMenuFormulario($idMenu),
            'combos' => $this->bo->menu->getCombosFormulario()
        ]);
    }

    /**
     * Action que inativa o menu informado
     *
     * @param $slug
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getInativarMenu($slug) {
        if (!$this->bo->menu->isMenuAtivo($slug)) {
            return redirectWithAlertInfo("O menu já está inativo.")->back();
        }

        $this->bo->menu->inativarMenu($slug);

        return redirectWithAlertSuccess("O menu foi inativado.")->back();
    }

    /**
     * Action que ativa o menu informado
     *
     * @param $slug
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getAtivarMenu($slug) {
        if ($this->bo->menu->isMenuAtivo($slug)) {
            return redirectWithAlertInfo("O menu já está ativo.")->back();
        }

        $this->bo->menu->ativarMenu($slug);

        return redirectWithAlertSuccess("O menu foi ativado.")->back();
    }

    /**
     * Deleta a imagem do menu informado
     *
     * @param $idPictureMenu
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getDeletarFotoMenu($idMenu, $idMenuImagem) {
        $this->bo->menu->deletarImagem($idMenu, $idMenuImagem);
        return redirectWithAlertSuccess('A foto/imagem do menu foi removida.')->back();
    }

    /**
     * Define a imagem informada como capa
     *
     * @param $idMenu
     * @param $idImagemMenu
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getDefinirComoCapa($idMenu, $idImagemMenu) {
        $this->bo->menu->definirComoCapa($idMenu, $idImagemMenu);
        return redirectWithAlertSuccess('A foto/imagem do menu foi definida como capa.')->back();
    }

    /**
     * Salva os dados do menu
     *
     * @param Requests\SalvarMenuRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postSalvar(Requests\SalvarMenuRequest $request) {
        try {

            $result = $this->bo->menu->salvar($request->all());

            $proximaRota = new ProximaRota('O menu foi salvo com sucesso.', 'menus.listar');
            $proximaRota->setAjax($request->ajax());

            return $proximaRota->getResponse();

        } catch (Exception $e) {
            $request->flash();

            return redirectWithAlertError($e->getMessage())->back();
        }
    }

}

