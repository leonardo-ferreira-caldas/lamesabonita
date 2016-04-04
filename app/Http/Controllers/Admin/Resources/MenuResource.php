<?php

namespace App\Http\Controllers\Admin\Resources;

use Admin\Business\AdminBO;
use App\Business\MenuBO;
use App\Constants\ProdutoStatusContants;
use App\Facades\Upload;
use App\Mappers\RepositoryMapper;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class MenuResource extends Controller
{
    private $repository;
    private $admin;
    private $menu;

    public function __construct(AdminBO $bo, MenuBO $menu, RepositoryMapper $mapper)
    {
        $this->repository = $mapper;
        $this->admin = $bo;
        $this->menu = $menu;
        $this->middleware('guest_admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getListar()
    {
        return view('admin.menus.listar', [
            'status' => $this->repository->produto_status->all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getBuscarRegistros()
    {
        return $this->repository->menu->getTodosMenus();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postSalvar(Request $request)
    {
        if (!$request->has('id_menu')) {
            $menu = $this->menu->salvar($request->all(), $request->get('id_chef'));

            return redirectWithAlertSuccess('O menu foi criado com sucesso.')->route('backoffice.menu.editar', [
                'slug' => $menu->slug
            ]);
        }

        $this->menu->salvar($request->all());

        return redirectWithAlertSuccess('Os dados do menu foram salvos com sucesso.')->back();
    }

    public function getNovoRegistro() {
        $refeicoes = $this->repository->tipo_refeicao->all();
        $culinarias = $this->repository->culinaria->all();
        $status = $this->repository->produto_status->all();
        $chefs = $this->repository->chef->getTodosChefs();

        return view('admin.menus.novo_menu', [
            'refeicoes'       => $refeicoes,
            'culinarias'      => $culinarias,
            'status'          => $status,
            'chefs'           => $chefs
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getEditar($slug)
    {
        $menu = $this->repository->menu->findBySlug($slug, true);
        $imagens = $this->repository->menu_imagem->getImagens($menu->id_menu);
        $menuCulinaria = $this->repository->menu_culinaria->getCulinarias($menu->id_menu);
        $menuRefeicao = $this->repository->menu_refeicao->getRefeicoes($menu->id_menu);
        $menuPrecos = $this->repository->menu_preco->getPrecosPorConvidado($menu->id_menu);
        $refeicoes = $this->repository->tipo_refeicao->all();
        $culinarias = $this->repository->culinaria->all();
        $status = $this->repository->produto_status->all();

        return view('admin.menus.formulario', [
            'menu'            => $menu,
            'menu_culinarias' => $menuCulinaria,
            'menu_refeicoes'  => $menuRefeicao,
            'menu_preco'      => $menuPrecos,
            'imagens'         => $imagens,
            'refeicoes'       => $refeicoes,
            'culinarias'      => $culinarias,
            'status'          => $status
        ]);
    }

    /**
     * Aprova um menu
     *
     * @param string $slug
     * @return RedirectResponse
     */
    public function getAprovar($slug) {

        $this->repository->menu->atualizarStatusProduto($slug, ProdutoStatusContants::STATUS_APROVADO);

        return redirectWithAlertSuccess('Menu aprovado com sucesso!')->back();
    }

    /**
     * Reprova um menu
     *
     * @param string $slug
     * @return RedirectResponse
     */
    public function getReprovar($slug) {

        $this->repository->menu->atualizarStatusProduto($slug, ProdutoStatusContants::STATUS_REPROVADO);

        return redirectWithAlertSuccess('Menu reprovado com sucesso!')->back();
    }

    /**
     * Deleta uma imagem do menu
     *
     * @param int $idMenuImagem
     */
    public function getDeletarImagem($idMenuImagem) {

        $imagem = $this->repository->menu_imagem->findById($idMenuImagem);

        $this->repository->menu_imagem->deleteById($idMenuImagem);

        Upload::deletar($imagem->nome_imagem);

        $this->repository->menu_imagem->atualizarPrimeiraFotoComoCapa($imagem->fk_menu);

        return redirectWithAlertSuccess('Foto deletada com sucesso.')->back();
    }

    /**
     * Define uma imagem do menu como capa
     *
     * @param int $idMenuImagem
     */
    public function getDefinirCapa($idMenuImagem) {

        $imagem = $this->repository->menu_imagem->findById($idMenuImagem);

        $this->repository->menu_imagem->atualizarFotoCapa($imagem->fk_menu, $idMenuImagem);

        return redirectWithAlertSuccess('Foto definida como capa com sucesso.')->back();
    }

}
