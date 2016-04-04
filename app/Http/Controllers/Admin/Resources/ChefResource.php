<?php

namespace App\Http\Controllers\Admin\Resources;

use Admin\Business\AdminBO;
use App\Business\ChefBO;
use App\Constants\ChefConstants;
use App\Mappers\RepositoryMapper;
use App\Model\EstadoModel;
use App\Utils\Utils;
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
     * Adicionar novo chef
     *
     * @return \Illuminate\Http\Response
     */
    public function getNovoRegistro()
    {
        return view('admin.chefs.novo_chef', [
            'sexos'   => $this->repository->sexo->all(),
            'status'  => $this->repository->chef_status->all(),
            'selo'    => $this->repository->chef_status_selo->all(),
            'estados' => $this->repository->geo->listarEstados(),
            'avatar'  => ChefConstants::DEFAULT_AVATAR,
            'capa'    => ChefConstants::DEFAULT_CAPA,
            'cidades' => []
        ]);
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
            $chef = $this->admin->salvarNovoChef($request->all());
            return redirectWithAlertSuccess('O chef foi cadastrado com sucesso.')->route('backoffice.chef.detalhes', ['slug' => $chef->slug]);
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
            'agenda'                => json_encode($this->repository->chef_agenda->getAgendaCalendario($chef->id_chef)),
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

    private function getDate($post) {
        $month = str_pad($post['month'], 2, '0', STR_PAD_LEFT);
        $day   = str_pad($post['day'], 2, '0', STR_PAD_LEFT);

        return sprintf('%s-%s-%s', $post['year'], $month, $day);
    }

    public function getSalvarAgenda($idChef, Request $request) {

        $post = $request->all();
        $date = $this->getDate($post);

        if (!Utils::isValidDate($date) || $post['time_from'] >= $post['time_to'] || $date <= date('Y-m-d')) {
            abort(404, 'Não permitido');
        }

        $agenda = $this->repository->chef_agenda->getAgendaPorData($idChef, $date);

        if (!empty($agenda)) {
            return $this->update($idChef, $agenda->id_chef_agenda, $request);
        }

        $ChefAgendaModel = $this->repository->chef_agenda->create([
            'fk_chef'  => $idChef,
            'data'     => $date,
            'hora_de'  => Utils::formatTime($post['time_from']),
            'hora_ate' => Utils::formatTime($post['time_to'])
        ]);

        return $ChefAgendaModel->id_chef_agenda;

    }

    public function getAtualizarAgenda($idChef, $idAgenda, Request $request) {

        $post = $request->all();

        $agenda = $this->repository->chef_agenda->getAgenda($idAgenda);

        if ($agenda->fk_chef != $idChef || $post['time_from'] >= $post['time_to'] || $agenda->data <= date('Y-m-d')) {
            abort(403, 'Não permitido.');
        }

        $agenda->hora_de = Utils::formatTime($post['time_from']);
        $agenda->hora_ate   = Utils::formatTime($post['time_to']);
        $agenda->restore();
        $agenda->save();

        return $agenda->id_chef_agenda;

    }

    public function getDeletarAgenda($idChef, $idAgenda) {

        $agenda = $this->repository->chef_agenda->findById($idAgenda);

        if ($agenda->fk_chef != $idChef) {
            abort(403, 'Não permitido.');
        }

        $agenda->delete();

    }

    public function getAlterarFotos($slug) {
        $chef = $this->repository->chef->findBySlug($slug, true);

        return view('admin.chefs.fotos', [
            'foto_perfil' => $chef->avatar ?: ChefConstants::DEFAULT_AVATAR,
            'foto_capa' => $chef->foto_capa ?: ChefConstants::DEFAULT_CAPA,
            'slug'      => $chef->slug
        ]);
    }

    /**
     * @param Request $request
     * @throws \App\Exceptions\UnexpectedErrorException
     */
    public function getAlterarFotoPerfil($slug, Request $request) {
        $chef = $this->repository->chef->findBySlug($slug, true);
        $this->chef->alterarFotoPerfil($request->file('foto_perfil'), $chef->id_chef);

        return redirectWithAlertSuccess('A foto de perfil foi alterada com sucesso.')->back();
    }

    /**
     * @param Request $request
     * @throws \App\Exceptions\UnexpectedErrorException
     */
    public function getAlterarFotoCapa($slug, Request $request) {
        $chef = $this->repository->chef->findBySlug($slug, true);
        $this->chef->alterarFotoCapa($request->file('foto_capa'), $chef->id_chef);

        return redirectWithAlertSuccess('A foto de capa foi alterada com sucesso.')->back();
    }
}
