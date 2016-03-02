<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Access\UnauthorizedException;
use Illuminate\Http\Request;
use App\Business\ChefBO;
use App\Business\DegustadorBO;
use App\Helpers\AjaxResponse;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Mappers\BusinessMapper;
use App\Mappers\RepositoryMapper;
use App\Structures\ProximaRota;
use App\Utils\Alert;
use App\Formatters\Url;
use App\Facades\Token;

class ChefController extends Controller
{

    private $bo;
    private $repository;

    public function __construct(BusinessMapper $bmapper, RepositoryMapper $mapper)
    {
        parent::__construct();
        $this->bo = $bmapper;
        $this->repository = $mapper;
        $this->middleware("email_confirmacao", ['except' => ['getHorarioData']]);
        $this->middleware('chef', ['except' => ['getHorarioData']]);
    }

    /**
     * Carrega a view que exibe um resumo das informações da conta do chef
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getMinhaConta()
    {
        return view('chef.account.minha_conta', [
            'page'                        => 'minha_conta',
            'solicitou_aprovacao_perfil'  => $this->bo->chef->perfilAguardandoCadastro(),
            'perfil_em_analise'           => $this->bo->chef->perfilEmAnalise(),
            'perfil_reprovado'            => $this->bo->chef->perfilReprovado(),
            'dados'                       => $this->bo->chef->getDadosChef(),
            'quantidade_contas_bancarias' => $this->bo->conta_bancaria->getQuantidadeContasBancariasChefLogado(),
            'quantidade_menus'            => $this->bo->menu->getQuantidadeMenusChefLogado(),
            'quantidade_cursos'           => $this->bo->curso->getQuantidadeCursosChefLogado()
        ]);
    }

    /**
     * Carrega a view de agenda do chef
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getAgenda()
    {
        return view('chef.account.minha_agenda', [
            'page'      => 'agenda',
            'schedules' => json_encode($this->bo->chef->getAgendaCalendarioChefLogado()),
        ]);
    }

    /**
     * Carrega a view para salvar as informações pessoais do chef
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getInformacoesPessoais()
    {
        return view('chef.account.informacoes_pessoais', [
            'page'   => 'informacoes-pessoais',
            'dados'  => $this->bo->chef->getDadosChef(),
            'combos' => $this->bo->chef->buscarInformacoesDiscretas()
        ]);
    }

    /**
     * Carrega view que lista todas as reservas do chef logado
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getListarReservas()
    {
        return view('chef.account.minhas_reservas', [
            'page'           => 'reservas',
            'reservas_todas' => $this->bo->reserva->getReservasChefLogado()
        ]);
    }

    /**
     * Carrega a view que exibe os detalhes de uma reserva do chef
     *
     * @param $idReserva
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getReservaDetalhes($idReserva)
    {
        return view('chef.account.reserva_detalhes', [
            'page'    => 'reservas',
            'reserva' => $this->repository->reserva->getDadosReserva($idReserva)
        ]);
    }

    /**
     * Carrega a página de solicitação do selo la mesa bonita
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getSeloLMB()
    {
        return view('chef.account.selo_lamesabonita', [
            'page'           => 'selo_lmb',
            'solicitou_selo' => $this->bo->chef->jaSolicitouSeloLMB()
        ]);
    }

    /**
     * Carrega a view que lista todas as contas bancárias do chef logado
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getContaBancaria()
    {
        return view('chef.account.conta_bancaria', [
            'page'             => 'conta_bancaria',
            'contas_bancarias' => $this->bo->conta_bancaria->getContaBancariasChefLogado()
        ]);
    }

    /**
     * Carrega a view para criar uma nova conta bancária
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getContaBancariaNovo()
    {
        return view('chef.account.conta_bancaria_formulario', [
            'page'   => 'conta_bancaria',
            'modo'   => 'criar',
            'bancos' => $this->repository->banco->all()
        ]);
    }

    /**
     * Carrega a view para editar uma conta bancária
     *
     * @param $idContaBancaria
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getContaBancariaEditar($idContaBancaria)
    {
        return view('chef.account.conta_bancaria_formulario', [
            'page'           => 'conta_bancaria',
            'modo'           => 'editar',
            'bancos'         => $this->repository->banco->all(),
            'conta_bancaria' => $this->repository->conta_bancaria->findById($idContaBancaria)
        ]);
    }

    /**
     * Carrega a view que lista todas as avaliações que o chef recebeu
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getAvaliacoes()
    {
        return view('chef.account.minhas_avaliacoes', ['page' => 'avaliacoes']);
    }

    /**
     * Carrega a view de localização do chef logado
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getLocalizacao()
    {
        return view('chef.account.localizacao', [
            'page'   => 'localizacao',
            'dados'  => $this->bo->chef->getLocalizacao(),
            'combos' => $this->bo->chef->buscarInformacoesDiscretas()
        ]);
    }

    public function getPagamento()
    {
        return view('chef.pagamento', ['page' => 'pagamento']);
    }

    /**
     * Carrega a view para alterar a senha do chef lgoado
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getAlterarSenha()
    {
        return view('chef.account.alterar_senha', ['page' => 'alterar_senha']);
    }

    /**
     * Solicita a aprovação do perfil do chef logado
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\UnexpectedErrorException
     */
    public function getSolicitarAprovacaoPerfil()
    {

        if (!$this->bo->chef->podeSolicitarAprovacao()) {

            $listaPendencia = $this->bo->chef->obterListaPendenciasAprovacaoPerfil();
            return redirect('chef/minha-conta#content')->with('pendencias', $listaPendencia);

        } else if ($this->bo->chef->perfilEmAnalise()) {
            Alert::info('Informação', 'O seu perfil já está em análise para aprovação.');

        } else if ($this->bo->chef->perfilReprovado()) {
            Alert::info('Informação', 'O seu perfil não foi aprovado.');

        } else {

            $this->bo->chef->solicitarAprovacaoPerfil();
            Alert::success('Sucesso', 'Você solicitou a aprovação do seu perfil.\n\rAguarde enquanto a equipe do La Mesa Bonita analisa seu perfil.');

        }

        return redirect()->route('conta-chef');
    }

    /**
     * Solicita o selo la mesa bonita para o chef logado
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\UnexpectedErrorException
     */
    public function getSolicitacaoSelo()
    {
        if ($this->bo->chef->jaPossuiSeloLMB()) {
            return redirectWithAlertInfo('Você já possui o selo La Mesa Bonita.')->back();

        } else if ($this->bo->chef->jaSolicitouSeloLMB()) {
            return redirectWithAlertInfo('Você já solicitou o selo La Mesa Bonita.')->back();

        }

        $this->bo->chef->solicitarSeloLMB();

        return redirectWithAlertSuccess('Você solicitou o selo La Mesa Bonita com sucesso. \n\rNossa equipe irá entrar em contato com você.')
            ->back();
    }

    /**
     * Obtem os horarios disponíveis do chef em uma data inforamda
     *
     * @param $slugChef
     * @param Request $request
     * @return array
     */
    public function getHorarioData($slugChef, Request $request)
    {
        if (!$request->has('data')) {
            return [];
        }

        return $this->bo->chef->getHorariosAgendaPorData($slugChef, $request->get('data'));
    }

    /**
     * Altera a foto de capa do chef logado
     *
     * @param Requests\AlterarFotoCapaChefRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postAlterarFotoCapa(Requests\AlterarFotoCapaChefRequest $request)
    {
        $this->bo->chef->alterarFotoCapa($request->file('foto_capa'));

        $proximaRota = new ProximaRota('Sua foto de capa/fundo do seu perfil foi alterada com sucesso.');
        $proximaRota->setAjax($request->ajax());

        return $proximaRota->getResponse();
    }

    /**
     * Altera a foto de perfil do chef logado
     *
     * @param Requests\AlterarFotoPerfilChefRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\UnexpectedErrorException
     */
    public function postAlterarFotoPerfil(Requests\AlterarFotoPerfilChefRequest $request)
    {
        $this->bo->chef->alterarFotoPerfil($request->file('foto_perfil'));

        $proximaRota = new ProximaRota('Sua foto de perfil foi alterada com sucesso.');
        $proximaRota->setAjax($request->ajax());

        return $proximaRota->getResponse();
    }

    /**
     * Salva as informações de localização do chef logado
     *
     * @param Requests\LocalizacaoChefRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postAlterarLocalizacao(Requests\LocalizacaoChefRequest $request)
    {
        $this->bo->chef->atualizarLocalizacao($request->all());

        $proximaRota = new ProximaRota('Sua localização foi salva com sucesso.');
        $proximaRota->setAjax($request->ajax());

        return $proximaRota->getResponse();
    }

    /**
     * Salva as informações pessoas do chef logado
     *
     * @param Requests\InformacoesPessoaisChefRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postAlterarDados(Requests\InformacoesPessoaisChefRequest $request)
    {
        $this->bo->chef->atualizarInformacoesPessoais($request->all());

        $proximaRota = new ProximaRota('Suas informações foram salvas com sucesso.');
        $proximaRota->setAjax($request->ajax());

        return $proximaRota->getResponse();
    }

    /**
     * Insere os dados bancários do chef logado
     *
     * @param Requests\DadosBancariosChefRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\UnexpectedErrorException
     */
    public function postSalvarDadosBancarios(Requests\DadosBancariosChefRequest $request)
    {
        $this->bo->conta_bancaria->salvarContaBancaria($request->all());

        $proximaRota = new ProximaRota('Seus dados bancários foram salvos com sucesso.', 'chef.conta_bancaria');
        $proximaRota->setAjax($request->ajax());

        return $proximaRota->getResponse();
    }

    /**
     * Atualiza os dados bancários do chef logado
     *
     * @param Requests\DadosBancariosChefRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\UnexpectedErrorException
     */
    public function postAtualizarDadosBancarios(Requests\DadosBancariosChefRequest $request)
    {
        $this->bo->conta_bancaria->salvarContaBancaria($request->all());

        $proximaRota = new ProximaRota('Seus dados bancários foram salvos com sucesso.');
        $proximaRota->setAjax($request->ajax());

        return $proximaRota->getResponse();
    }

}
