<?php

namespace App\Repositories;

use App\Constants\PagamentoConstants;
use App\Model\PagamentoCartaoModel;
use App\Model\PagamentoModel;
use App\Model\PagamentoTracking;
use App\Model\PagamentoTaxa;

class PagamentoRepository {

    private $pagamento;

    private $deParaStatus = [
        PagamentoConstants::STATUS_AGUARDANDO_APROVACAO => [
            PagamentoConstants::MOIP_STATUS_CREATED,
            PagamentoConstants::MOIP_STATUS_WAITING,
            PagamentoConstants::MOIP_STATUS_IN_ANALYSIS
        ],
        PagamentoConstants::STATUS_PAGAMENTO_APROVADO => [
            PagamentoConstants::MOIP_STATUS_PRE_AUTHORIZED,
            PagamentoConstants::MOIP_STATUS_AUTHORIZED
        ],
        PagamentoConstants::STATUS_PAGAMENTO_REPROVADO => [
            PagamentoConstants::MOIP_STATUS_CANCELLED
        ],
        PagamentoConstants::STATUS_PAGAMENTO_REEMBOLSADO => [
            PagamentoConstants::MOIP_STATUS_REFUNDED
        ],
        PagamentoConstants::STATUS_PAGAMENTO_ESTORNADO => [
            PagamentoConstants::MOIP_STATUS_REVERSED
        ]
    ];

    public function __construct(PagamentoModel $pagamento) {
        $this->pagamento = $pagamento;
    }

    /**
     * Cria um novo pagamento
     *
     * @param $idReserva
     * @param $idPagamentoMetodo
     * @param $idPagamentoStatus
     * @param null $informacoesAdicionais
     * @param null $pagamentoStatusInfo
     * @return PagamentoModel
     */
    public function criarPagamento($idReserva, $idPagamentoMetodo, $idPagamentoStatus, $informacoesAdicionais = null, $pagamentoStatusInfo = null) {
        $pagamento = $this->pagamento->create([
            'fk_reserva'             => $idReserva,
            'fk_pagamento_metodo'    => $idPagamentoMetodo,
            'fk_pagamento_status'    => $idPagamentoStatus
        ]);

        return $pagamento;
    }

    /**
     * Retorna um status de pedido de acordo com o status do MOIP
     *
     * @param $statusPagamento
     * @return int|string
     */
    public function getStatus($statusPagamento) {
        foreach ($this->deParaStatus as $status => $item) {
            if (in_array($statusPagamento, $item)) {
                return $status;
            }
        }
        throw new \Exception("Um erro ocorreu. Entre em contato com a equipe La Mesa Bonita.");
    }

    /**
     * Atualiza o pedido com os dados retornados pelo MOIP
     *
     * @param $idPagamento
     * @param $idMoipPagamento
     * @param $statusPagamento
     * @return NULL
     */
    public function atualizarIntegracaoMoip($idPagamento, $idMoipPagamento, $statusPagamento) {
        $this->pagamento->where('id_pagamento', $idPagamento)->update([
            'moip_id'     => $idMoipPagamento,
            'moip_status' => $statusPagamento,
            'fk_pagamento_status' => $this->getStatus($statusPagamento)
        ]);
    }

    /**
     * Encontra um pagamento pelo ID do MOIP
     *
     * @param $idMoipPagamento
     * @return PagamentoModel
     */
    public function findByMoipId($idMoipPagamento) {
        return $this->pagamento->where('moip_id', $idMoipPagamento)->firstOrFail();
    }

    /**
     * Atualiza o status de um pagamento
     *
     * @param $idPagamento
     * @param $statusPagamento
     * @param $statusMoip
     * @return NULL
     */
    public function atualizarStatusPagamento($idPagamento, $statusPagamento, $statusMoip) {
        $this->pagamento->where('id_pagamento', $idPagamento)->update([
            'fk_pagamento_status' => $statusPagamento,
            'moip_status' => $statusMoip
        ]);
    }

    /**
     * Atualiza os trackings de um pagamento
     *
     * @param $idPagamento
     * @param array $trackings
     * @return NULL
     */
    public function atualizarTracking($idPagamento, $trackings = []) {
        foreach ($trackings as $item) {
            $this->adicionarTracking($idPagamento, $item['id_pagamento_status'], $item['type'], $item['createdAt']);
        }
    }

    /**
     * Adiciona um novo tracking de pagamento
     *
     * @param $idPagamento
     * @param $idPagamentoStatus
     * @param $trackingMoipStatus
     * @param $data
     */
    public function adicionarTracking($idPagamento, $idPagamentoStatus, $trackingMoipStatus, $data) {
        $tracking = new PagamentoTracking();
        $tracking->fk_pagamento = $idPagamento;
        $tracking->fk_pagamento_status = $idPagamentoStatus;
        $tracking->tracking_descricao = $trackingMoipStatus;
        $tracking->tracking_data = $data;
        $tracking->save();
    }

    /**
     * Atualiza as taxas cobradas em um pedido
     *
     * @param $idPagamento
     * @param array $taxas
     * @return NULL
     */
    public function atualizarTaxas($idPagamento, $taxas = []) {
        foreach ($taxas as $item) {
            $taxa = new PagamentoTaxa();
            $taxa->fk_pagamento = $idPagamento;
            $taxa->tipo = $item['type'];
            $taxa->valor = $item['amount'];
            $taxa->save();
        }
    }

    /**
     * Insere os dados de cartão de crédito utilizados no pagamento
     *
     * @param $idPagamento
     * @param $cartaoCredito
     */
    public function inserirDadosCartao($idPagamento, $cartaoCredito) {
        $cartao = new PagamentoCartaoModel();
        $cartao->fk_pagamento = $idPagamento;
        $cartao->moip_id = $cartaoCredito['moip_id'];
        $cartao->bandeira = $cartaoCredito['bandeira'];
        $cartao->numero_cartao = $cartaoCredito['numero_cartao'];
        $cartao->titular_cartao = $cartaoCredito['titular_cartao'];
        $cartao->save();
    }

}