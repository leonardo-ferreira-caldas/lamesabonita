<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facades\Autenticacao;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Mappers\BusinessMapper;
use App\Mappers\RepositoryMapper;
use Auth;

class ReservaController extends Controller {

    private $request;
    private $repository;
    private $bo;

    const TIPO_MENU = 'menu';
    const TIPO_CURSO = 'curso';

    public function __construct(Request $request, BusinessMapper $bmapper, RepositoryMapper $mapper) {
        if (!Autenticacao::isLogado() && $request->is("reservar/*")) {
            session(['redirect' => $request->fullUrl()]);
        }

        $this->middleware("auth");
        $this->middleware("degustador");

        $this->request    = $request;
        $this->repository = $mapper;
        $this->bo         = $bmapper;

        parent::__construct();
    }

    /**
     * Carrega a view onde será escolhido o endereço em que a reserva acontecerá
     *
     * @param $slugChef
     * @param $tipo
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function getEnderecoReserva($slugChef, $tipo, $slug) {
        if (Autenticacao::isChef()) {
            return redirectWithAlertError('Não é possível reservar menus logado como chef.')->back();
        } else if (!$this->request->has(['qtd_clientes', 'data_reserva', 'horario_reserva'  ])) {
            return redirectWithAlertWarning('Um erro ocorreu. Por favor tente novamente ou entre em contato com a equipe La Mesa Bonita.')->back();
        }

        $chef = $this->repository->chef->findBySlug($slugChef, true);
            
        if ($tipo == self::TIPO_MENU) {
            $menu = $this->repository->menu->findBySlug($slug, true);
            $produto = $this->repository->menu->getDadosMenu($menu->id_menu);
        } else {
            $curso = $this->repository->curso->findBySlug($slug, true);
            $produto = $this->repository->curso->getDadosCurso($curso->id_curso);
        }

        $enderecos = $this->bo->cliente->buscarEnderecosUsuarioLogado();

        if (count($enderecos) == 0) {
            return redirectWithAlertWarning("Antes de reserva um chef você precisa terminar de preencher suas informações pessoais.")
                ->route('degustador.informacoes_pessoais');
        }

        return view('reservar.escolher_endereco', [
            'chef'              => $chef,
            'tipo'              => $tipo,
            'produto'           => $produto,
            'estados'           => $this->repository->geo->listarEstados(),
            'enderecos'         => $enderecos,
            'qtd_clientes'      => $this->request->get('qtd_clientes'),
            'data_reserva'      => $this->request->get('data_reserva'),
            'horario_reserva'   => $this->request->get('horario_reserva'),
            'observacao'        => $this->request->get('observacao'),
            'taxa_lmb'          => $this->repository->configuracao->getTaxaLMB()
        ]);
    }

    /**
     * Carrega a view para preenchimento dos dados de cartão de crédito para
     * realizar o pagamento da reserva
     *
     * @param $slugChef
     * @param $tipo
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function getPagamento($slugChef, $tipo, $slug) {
        if (Autenticacao::isChef()) {
            return redirectWithAlertError('Não é possível reservar menus logado como chef.')->back();
        } else if (!$this->request->has(['qtd_clientes', 'data_reserva', 'horario_reserva'  ])) {
            return redirectWithAlertWarning('Um erro ocorreu. Por favor tente novamente ou entre em contato com a equipe La Mesa Bonita.')->back();
        }

        $chef = $this->repository->chef->findBySlug($slugChef, true);

        if ($tipo == self::TIPO_MENU) {
            $menu = $this->repository->menu->findBySlug($slug, true);
            $produto = $this->repository->menu->getDadosMenu($menu->id_menu);
        } else {
            $curso = $this->repository->curso->findBySlug($slug, true);
            $produto = $this->repository->curso->getDadosCurso($curso->id_curso);
        }

        return view('reservar.efetuar_pagamento', [
            'chef'              => $chef,
            'tipo'              => $tipo,
            'produto'           => $produto,
            'chave_publica'     => $this->repository->configuracao->getPublicKey(),
            'estados'           => $this->repository->geo->listarEstados(),
            'endereco'          => $this->bo->cliente->buscarDadosEndereco($this->request->get('id_degustador_endereco')),
            'qtd_clientes'      => $this->request->get('qtd_clientes'),
            'data_reserva'      => $this->request->get('data_reserva'),
            'horario_reserva'   => $this->request->get('horario_reserva'),
            'observacao'        => $this->request->get('observacao'),
            'taxa_lmb'          => $this->repository->configuracao->getTaxaLMB()
        ]);
    }

    /**
     * Realiza a criação da reserva e a integração de pagamento com o MOIP
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postFinalizarReserva() {
        return $this->bo->reserva->finalizarReserva($this->request->all());
    }

    /**
     * Carrega a view que informa ao usuario que seu pagamento foi efetuado
     * com suscesso e sua reserva concluida
     *
     * @param $reserva
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getReservaFinalizada($idReserva) {
        $reserva = $this->repository->reserva->getDadosReserva($idReserva);

        return view('reservar.reserva_efetuada', [
            'reserva'  => $reserva
        ]);
    }

    /**
     * Carrega a view que informa ao usuário que seu pagamento foi recusado e
     * consequentemente sua reserva foi cancelada
     *
     * @param $reserva
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getReservaReprovada($idReserva) {
        $reserva = $this->repository->reserva->getDadosReserva($idReserva);

        return view('reservar.reserva_reprovada', [
            'reserva'  => $reserva
        ]);
    }

    /**
     * Carrega a view de solicitação de cancelamento de uma reserva
     *
     * @param $idReserva
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCancelarReserva($idReserva) {
        return view('usuario.cancelar_reserva', [
            'page' => 'reservas',
            'id_reserva' => $idReserva
        ]);
    }

    /**
     * Carrega a view que exibe os detalhes de uma reserva
     *
     * @param $idReserva
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getReservaDetalhes($idReserva) {
        $reserva = $this->repository->reserva->getDadosReserva($idReserva);

        if (empty($reserva)) {
            return redirect()->back();
        }

        return view('usuario.reserva_detalhes', [
            'page' => 'reservas',
            'reserva' => $reserva
        ]);
    }

    /**
     * Carrega a view que lista todas as reservas do usuário logado
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getListarReservas() {
        return view('usuario.reservas', [
            'page' => 'reservas',
            'reservas_ativas'     => $this->bo->reserva->buscarReservasAtivas(),
            'reservas_realizadas' => $this->bo->reserva->buscarReservasRealizadas(),
            'reservas_canceladas' => $this->bo->reserva->buscarReservasCanceladas()
        ]);
    }

    /**
     * Realiza o cancelamento da reserva e solicita o reembolso do valor ao MOIP
     *
     * @param $idReserva
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getEfetuarCancelamentoReserva($idReserva) {
        $this->bo->reserva->cancelarReserva($idReserva);
        return redirectWithAlertSuccess("Reserva cancelada com sucesso.")->route('degustador.reservas');
    }
}
