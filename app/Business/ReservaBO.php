<?php

namespace App\Business;

use App\Constants\ProdutoConstants;
use App\Exceptions\ApplicationException;
use App\Exceptions\ErrorException;
use App\Facades\Email;
use App\Constants\ReservaConstants;
use App\Facades\Autenticacao;
use App\Formatters\DataFormatter;
use App\Mappers\BusinessMapper;
use App\Mappers\RepositoryMapper;
use App\Utils\Alert;
use App\Constants\PagamentoConstants;
use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Routing\Exception\MissingMandatoryParametersException;

class ReservaBO {

    private $moipBO;
    private $repository;
    private $bo;

    public function __construct(MoipBO $moipBO, BusinessMapper $bo, RepositoryMapper $mapper) {
        $this->moipBO       = $moipBO;
        $this->repository   = $mapper;
        $this->bo           = $bo;
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
            $preco = $this->getValorPorPessoa($idMenu, $dadosRecurso->preco, $dadosReserva['qtd_clientes'], ProdutoConstants::PRODUTO_MENU);

        } else if (!empty($dadosReserva['id_curso'])) {
            $dadosRecurso = $this->repository->curso->findById($dadosReserva['id_curso']);
            $idCurso = $dadosReserva['id_curso'];
            $preco = $this->getValorPorPessoa($idCurso, $dadosRecurso->preco, $dadosReserva['qtd_clientes'], ProdutoConstants::PRODUTO_CURSO);

        } else {
            throw new MissingMandatoryParametersException;
        }

        $porcentagemChef = $this->repository->configuracao->getPorcentagemChef();
        $precoTotal = $preco * $dadosReserva['qtd_clientes'];
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
            'preco_por_cliente'      => $preco,
            'taxa_lmb'               => 0,
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
     * Verifica se a data em que o cliente está reservando está disponivel de acordo
     * com a agenda do chef
     *
     * @param $idChef Código da Chef
     * @param $dataReserva Data da Reserva
     * @param $horarioReserva Horario da Reserva
     * @return bool
     */
    public function validaDataReservaDisponivel($idChef, $dataReserva, $horarioReserva) {
        $dataReserva = DataFormatter::formatarDataEN($dataReserva);

        if ($dataReserva <= Carbon::now()->toDateString() || $this->repository->reserva->jaPossuiReservaEmData($idChef, $dataReserva)) {
            return false;
        }
        
        $horarioPorData = $this->repository->chef_agenda->getHorarioPorData($idChef, $dataReserva);

        if (empty($horarioPorData)) {
            return false;
        }

        $normalizarParaValidacao = intval(str_replace(':', '', $horarioReserva));
        $horarioDe = intval(str_replace(':', '', substr($horarioPorData->hora_de, 0, 5)));
        $horarioAte = intval(str_replace(':', '', substr($horarioPorData->hora_ate, 0, 5)));

        return $horarioDe <= $normalizarParaValidacao && $normalizarParaValidacao <= $horarioAte;
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

            // Verifica se a data de reserva está disponivel
            if (!$this->validaDataReservaDisponivel($dadosReserva['id_chef'], $dadosReserva['data_reserva'], $dadosReserva['horario_reserva'])) {
                throw new ErrorException('O chef não está disponível para reserva na data escolhida. Por favor escolha um dia e hora em que o chef esteja disponível para reserva.');
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
                    Email::enviarEmailMenuReservado(Autenticacao::getNome(), Autenticacao::getEmail(), $reserva);
                }
            } catch (Exception $e) {
                Log::info($e->getTraceAsString());
            }

            DB::commit();

            return redirect()->route(!$pagamentoRecusado ? 'reservar.sucesso' : 'reservar.reprovado', [
                'reserva' => $reserva->id_reserva
            ]);


        } catch (ApplicationException $appExcpt) {
            DB::rollBack();

            throw $appExcpt;
        } catch (Exception $e) {
            DB::rollBack();

            return redirectWithAlertError("Algo inesperado ocorreu e não foi possível finalizar a sua reserva. Por favor tente novamente ou entre em contato com a nossa equipe.")
                ->back();
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

    /**
     * Busca o valor de acordo com a quantidade de pessoas
     *
     * @param $idMenu
     * @param float $preco
     * @param $qtdPessoas
     * @param int $tipoProduto
     *
     * @return float
     */
    public function getValorPorPessoa($idProduto, $precoProduto, $qtdPessoas, $tipoProduto) {
        if ($tipoProduto == ProdutoConstants::PRODUTO_MENU) {
            $precosPorConvidados = $this->repository->menu_preco->getPrecosPorConvidado($idProduto);
        } else {
            $precosPorConvidados = $this->repository->curso_preco->getPrecosPorConvidado($idProduto);
        }

        if (empty($precosPorConvidados)) {
            return $precoProduto;
        }

        $precosPorConvidados = $precosPorConvidados->all();

        usort($precosPorConvidados, function($a, $b) {
            if ($a->qtd_minima_clientes == $b->qtd_minima_clientes) {
                return 0;
            }

            return $a->qtd_minima_clientes < $b->qtd_minima_clientes ? -1 : 1;
        });

        foreach ($precosPorConvidados as $loop) {
            if ($qtdPessoas <= $loop->qtd_minima_clientes) {
                $precoProduto = $loop->preco;
                break;
            }
        }

        return $precoProduto;
    }


    /**
     * Busca os dados do produto que esta sendo reservado
     *
     * @param $tipo
     * @param $slug
     * @return array
     */
    public function getDadosProduto($tipo, $slug, $qtdClientes) {

        if ($tipo == strtolower(ReservaConstants::RESERVA_TIPO_MENU)) {
            $menu = $this->repository->menu->findBySlug($slug, true);
            $produto = $this->repository->menu->getDadosMenu($menu->id_menu);
            $vlrPessoa = $this->getValorPorPessoa($menu->id_menu, $menu->preco, $qtdClientes, ProdutoConstants::PRODUTO_MENU);
        } else {
            $curso = $this->repository->curso->findBySlug($slug, true);
            $produto = $this->repository->curso->getDadosCurso($curso->id_curso);
            $vlrPessoa = $this->getValorPorPessoa($curso->id_curso, $curso->preco, $qtdClientes, ProdutoConstants::PRODUTO_CURSO);
        }

        return [$produto, $vlrPessoa];
    }

}