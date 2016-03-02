<?php

namespace App\Http\Controllers\Admin\Resources;

use Admin\Business\AdminBO;
use App\Business\ChefBO;
use App\Constants\ChefConstants;
use App\Mappers\RepositoryMapper;
use App\Model\EstadoModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ChefResource extends Controller
{
    private $repository;
    private $admin;
    private $chef;

    public function __construct(AdminBO $bo, ChefBO $chef, RepositoryMapper $mapper)
    {
        $this->repository = $mapper;
        $this->admin = $bo;
        $this->chef = $chef;
        $this->middleware('guest_admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getListar()
    {
        return view('admin.chefs.listar');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getBuscarRegistros()
    {
        return $this->repository->chef->getTodosChefs();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postSalvar(Request $request)
    {
        if (!$request->has('id_chef')) {
            return redirectWithAlertError('O código do chef não foi informado.');
        }

        $this->admin->atualizarDadosChef($request->all());

        return redirectWithAlertSuccess('Os dados do chef foram salvos com sucesso.')->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getEditar($slug)
    {
        $chef  = $this->repository->chef->findBySlug($slug, true);
        $dados = $this->repository->chef->getDadosVisaoGeral($chef->id_chef);

        return view('admin.chefs.formulario', [
            'chef'                  => $dados,
            'sexos'                 => $this->repository->sexo->all(),
            'status'                => $this->repository->chef_status->all(),
            'selo'                  => $this->repository->chef_status_selo->all(),
            'estados'               => $this->repository->geo->listarEstados(),
            'cidades'               => $this->repository->geo->filtrarCidades($dados->fk_estado)
        ]);
    }

    /**
     * Retorna todas as cidades de um estado
     *
     * @param int $idEstado
     * @return array
     */
    public function getCidadesEstado($idEstado) {
        return $this->repository->geo->filtrarCidades($idEstado);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param string $slug
     * @return \Illuminate\Http\Response
     */
    public function getDetalhes($slug)
    {
        $chef = $this->repository->chef->findBySlug($slug, true);
        $dados = $this->repository->chef->getDadosVisaoGeral($chef->id_chef);
        $menus = $this->repository->menu->getMenusByChefId($chef->id_chef);
        $cursos = $this->repository->curso->getCursosByChefId($chef->id_chef);
        $contasBancarias = $this->repository->conta_bancaria->getChefContasBancarias($chef->id_chef);

        return view('admin.chefs.detalhes', [
            'chef'                  => $dados,
            'menus'                 => $menus,
            'cursos'                => $cursos,
            'contas_bancarias'      => $contasBancarias,
            'aguardando_aprovacao'  => $chef->fk_status == ChefConstants::STATUS_AGUARDANDO_APROVACAO
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getDeletar(Request $request)
    {
        if (!$request->has('id')) {
            return $this->getListar();
        }

        $this->admin->excluirCulinaria($request->get('id'));

        return redirectWithAlertSuccess('Culinária deletada com sucesso!')->back();
    }

    /**
     * Aprova o perfil de um chef
     *
     * @param $slug
     */
    public function getAprovarPerfil($slug) {
        $this->chef->aprovarPerfil($slug);

        return redirectWithAlertSuccess("Perfil aprovado com sucesso.")->back();
    }

    /**
     * Reprova o perfil de um chef
     *
     * @param $slug
     */
    public function getReprovarPerfil($slug) {
        $this->chef->reprovarPerfil($slug);

        return redirectWithAlertSuccess("Perfil reprovado com sucesso.")->back();
    }
}
