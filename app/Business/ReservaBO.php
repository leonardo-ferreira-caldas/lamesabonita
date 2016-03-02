<?php

namespace App\Business;

use Illuminate\Support\Facades\Auth;
use App\Constants\ReservaConstants;
use App\Facades\Autenticacao;
use App\Formatters\DataFormatter;
use App\Handlers\EmailHandler;
use App\Mappers\RepositoryMapper;
use App\Repositories\ConfiguracaoSiteRepository;
use App\Repositories\MenuRepository;
use App\Repositories\PagamentoRepository;
use App\Repositories\ReservaRepository;
use App\Utils\Alert;
use App\Constants\PagamentoConstants;
use DB;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Inacho\CreditCard;
use Symfony\Component\Routing\Exception\MissingMandatoryParametersException;

class ReservaBO {

    private $user;
    private $email;
    private $moipBO;
    private $repository;

    public function __construct(MoipBO $moipBO, EmailHandler $email, RepositoryMapper $mapper) {
        $this->moipBO       = $moipBO;
        $this->repository   = $mapper;
        $this->email        = $email;
    }

    /**
     * Valida se todos os dados obrigatórios para a criação da reserva foram informados
     *
     * @param $dadosReserva
     * @return bool
     */
    private function validarDadosReserva($dadosReserva) {
        $camposObrigatorios = ['id_degustador_endereco', 'id_chef', 'qtd_clientes', 'data_reserva', 'horario_reserva',
                               'observacao', 'cartao_credito', 'titular_cartao', 'hash_cartao'];

        foreach ($camposObrigatorios as $campo) {
            if (!isset($dadosReserva[$campo])) {
                return false;
            }
        }

        return true;
    }

    /**
     * Cria uma nova reserva de acordo com os dados informados pelo usuário
     *
     * @param $dadosReserva
     * @return static
     */
    private function criarNovaReserva($dadosReserva) {

        $idMenu = $idCurso = null;

        if (!empty($dadosReserva['id_menu'])) {
            $dadosRecurso = $this->repository->menu->findById($dadosReserva['id_menu']);
            $idMenu = $dadosReserva['id_menu'];

        } else if (!empty($dadosReserva['id_curso'])) {
            $dadosRecurso = $this->repository->curso->findById($dadosReserva['id_curso']);
            $idCurso = $dadosReserva['id_curso'];

        } else {
            throw new MissingMandatoryParametersException;
        }

        $taxaServicoLMB = $this->repository->configuracao->getTaxaLMB();
        $porcentagemChef = $this->repository->configuracao->getPorcentagemChef();
        $precoTotal = ($dadosRecurso->preco * $dadosReserva['qtd_clientes']) + $taxaServicoLMB;
        $vlrDivisaoChef = round(($precoTotal / 100) * $porcentagemChef, 2);
        $vlrDivisaoLMB  = $precoTotal -  $vlrDivisaoChef;

        return $this->repository->reserva->create([
            'fk_degustador'          => Autenticacao::getId(),
            'fk_degustador_endereco' => $dadosReserva['id_degustador_endereco'],
            'fk_chef'                => $dadosReserva['id_chef'],
            'fk_status'              => ReservaConstants::STATUS_ATIVA,
            'fk_menu'                => $idMenu,
            'fk_curso'               => $idCurso,
            'data_reserva'           => DataFormatter::formatarDataEN($dadosReserva['data_reserva']),
            'horario_reserva'        => $dadosReserva['horario_reserva'],
            'qtd_clientes'           => $dadosReserva['qtd_clientes'],
            'preco_por_cliente'      => $dadosRecurso->preco,
            'taxa_lmb'               => $taxaServicoLMB,
            'preco_total'            => $precoTotal,
            'observacao'             => $dadosReserva['observacao'],
            'porcentagem_chef'       => $porcentagemChef,
            'vlr_divisao_chef'       => $vlrDivisaoChef,
            'vlr_divisao_lmb'        => $vlrDivisaoLMB
        ]);

    }

    /**
     * Insere trackings e atualiza status de acordo com o retorno da integração
     *
     * @param $idReserva
     * @param $idPagamento
     * @param $retornoIntegracao
     */
    private function inserirTrackings($idReserva, $idPagamento, $retornoIntegracao) {
        $this->repository->reserva->atualizarIntegracaoMoip($idReserva, $retornoIntegracao['id_reserva']);
        $this->repository->pagamento->atualizarIntegracaoMoip($idPagamento, $retornoIntegracao['id_pagamento'], $retornoIntegracao['status_pagamento']);
        $this->repository->pagamento->atualizarTracking($idPagamento, $retornoIntegracao['eventos']);
        $this->repository->pagamento->atualizarTaxas($idPagamento, $retornoIntegracao['taxas']);
        $this->repository->pagamento->inserirDadosCartao($idPagamento, $retornoIntegracao['cartao_credito']);
    }

    /**
     * Responsável por efetuar uma nova reserva e solicitar ao MOIP a criação deste
     * Uma vez que a reserva foi criada, uma nova integração para o pagamento da mesma
     * é solicitada, e com os retornos dessas integrações, são salvos trackings/históricos
     *
     * @param $dadosReserva
     * @return \Illuminate\Http\RedirectResponse
     */
    public function finalizarReserva($dadosReserva) {

        DB::beginTransaction();

        try {

            // Caso algum dado esteja inválido
            if (!$this->validarDadosReserva($dadosReserva)) {
                throw new Exception("Informe todos os campos obrigatórios.");
            }

            // Cria uma nova reserva e retorna a instancia do model App\Model\ReservaModel
            $reserva = $this->criarNovaReserva($dadosReserva);

            // Cria um novo pagamento e retorna a instancia do model App\Model\PagamentoModel
            $pagamento = $this->repository->pagamento->criarPagamento(
                $reserva->id_reserva,
                PagamentoConstants::METODO_CARTAO,
                PagamentoConstants::STATUS_AGUARDANDO_APROVACAO);

            // Inicia a integração de pedido e pagamento com o MOIP
            $retornoIntegracao = $this->moipBO->realizarPagamento($reserva, $dadosReserva['hash_cartao']);

            // Se a integração ocorreu com sucesso, é salvo vários trackings utilizando essas informações
            $this->inserirTrackings($reserva->id_reserva, $pagamento->id_pagamento, $retornoIntegracao);

            // Verifica se o status do pagamento após integração é Reprovado/Recusado/Cancelado
            $pagamentoRecusado = $this->repository->pagamento->getStatus($retornoIntegracao['status_pagamento']) == PagamentoConstants::STATUS_PAGAMENTO_REPROVADO;

            // Caso o pedido esteja cancelado, algum erro ocorreu e a reserva será cancelada
            if ($pagamentoRecusado) {
                $this->repository->reserva->alterarStatusReserva($reserva->id_reserva, ReservaConstants::STATUS_CANCELADA);
            }

            try {
                // Caso tudo tenha ocorrido bem, então envia um email de confirmaçao para o usuario
                if (!$pagamentoRecusado) {
                    $this->email->enviarEmailMenuReservado(Autenticacao::getNome(), Autenticacao::getEmail(), $reserva);
                }
            } catch (Exception $e) {
                Log::info($e->getTraceAsString());
            }

            DB::commit();

            return redirect()->route(!$pagamentoRecusado ? 'reservar.sucesso': 'reservar.reprovado', [
                'reserva' => $reserva->id_reserva
            ]);

        } catch (Exception $e) {
            DB::rollBack();
            Alert::error("Atenção!", "Algo inesperado ocorreu e não foi possível finalizar a sua reserva. Por favor tente novamente ou entre em contato com a nossa equipe.");
            return redirect()->back();
        }

    }

    /**
     * Responsavel por cancelar a reserva e solicitar ao MOIP o reembolso do valor pago
     *
     * @param $idReserva
     * @return NULL
     */
    public function cancelarReserva($idReserva) {

        DB::beginTransaction();

        try {

            $this->repository->reserva->alterarStatusReserva($idReserva, ReservaConstants::STATUS_CANCELADA);

            $this->moipBO->reembolsarPagamento();


        } catch (Exception $e) {
            DB::rollBack();
            Alert::error("Atenção!", "Algo inesperado ocorreu e não foi possível cancelar a sua reserva. Por favor tente novamente ou entre em contato com a nossa equipe.");
            return redirect()->back();
        }
    }

    /**
     * Obtem os dados de uma reserva
     *
     * @param $idReserva
     * @return \stdClass
     */
    public function obterReserva($idReserva) {
        return $this->repository->reserva->findById($idReserva);
    }

    /**
     * Busca todas as reservas ativas
     * Caso um ID de cliente não seja informado, irá buscar do cliente logado
     *
     * @param null $idDegustador
     * @return array|int
     */
    public function buscarReservasAtivas() {
        return $this->repository->reserva->getReservasPorStatus(Autenticacao::getId(), ReservaConstants::STATUS_ATIVA);
    }

    /**
     * Busca todas as reservas realizadas/efetuadas/executadas
     * Caso um ID de cliente não seja informado, irá buscar do cliente logado
     *
     * @param null $idDegustador
     * @return array|int
     */
    public function buscarReservasRealizadas() {
        return $this->repository->reserva->getReservasPorStatus(Autenticacao::getId(), ReservaConstants::STATUS_RELIZADA);
    }

    /**
     * Busca todas as reservas canceladas
     * Caso um ID de cliente não seja informado, irá buscar do cliente logado
     *
     * @param null $idDegustador
     * @return array|int
     */
    public function buscarReservasCanceladas() {
        return $this->repository->reserva->getReservasPorStatus(Autenticacao::getId(), ReservaConstants::STATUS_CANCELADA);
    }

    /**
     * Busca todas as reservas do chef logado
     *
     * @return array of stdClass
     */
    public function getReservasChefLogado() {
        return $this->repository->reserva->getReservasByChefId(Autenticacao::getId());
    }

}