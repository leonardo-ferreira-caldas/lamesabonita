<?php

namespace App\Business;

use App\Constants\PagamentoConstants;
use App\Integracao\Moip\Structures\Account;
use App\Integracao\Moip\Structures\Bank;
use App\Integracao\Moip\Structures\Payment;
use App\Integracao\Moip\Structures\Order;
use App\Integracao\Moip\Structures\Refund;
use App\Integracao\Moip\Resources\ContaBancariaResource;
use App\Integracao\Moip\Resources\ContaTransparentResource;
use App\Integracao\Moip\Resources\PagamentoResource;
use App\Integracao\Moip\Resources\ReservaResource;
use App\Model\ChefContaBancaria;
use App\Model\PagamentoReembolso;
use App\Model\ReservaModel;
use App\Repositories\ConfiguracaoSiteRepository;
use App\Repositories\GeoRepository;
use Log;

class MoipBO {

    private $configuracoesSite;
    private $geo;

    public function __construct(ConfiguracaoSiteRepository $configuracao, GeoRepository $geo) {
        $this->configuracoesSite = $configuracao;
        $this->geo               = $geo;
    }

    /**
     * Formata e ordena os eventos de pagamento retornados pelo MOIP
     *
     * @param $eventoPagamento
     * @return array
     */
    private function formatarEventosPagamento($eventoPagamento) {

        $eventos = array_map(function($arr) {
            $arr['id_pagamento_status'] = PagamentoConstants::STATUS_AGUARDANDO_APROVACAO;
            return $arr;
        }, $eventoPagamento);

        ksort($eventos);

        return $eventos;

    }

    /**
     * Formata os dados de cartão de credito retornados pelo MOIP
     *
     * @param $cartaoCredito
     * @return array
     */
    private function formatarCartao($cartaoCredito) {

        $numeroCartao = sprintf("%s%s%s",
            $cartaoCredito['first6'],
            str_repeat("#", 4),
            $cartaoCredito['last4']);

        $cartaoCredito = [
            'moip_id'        => $cartaoCredito['id'],
            'bandeira'       => $cartaoCredito['brand'],
            'titular_cartao' => $cartaoCredito['holder']['fullname'],
            'numero_cartao'  => $numeroCartao
        ];

        return $cartaoCredito;
    }

    /**
     * Responsavel por criar um pedido/reserva e efetuar seu pagamento
     *
     * @param ReservaModel $reserva
     * @param $hashCartao
     * @return array
     */
    public function realizarPagamento(ReservaModel $reserva, $hashCartao) {

        $cliente = $reserva->degustador;
        $endereco = $reserva->endereco;
        $chef = $reserva->chef;
        $usuario = $cliente->user;

        if (!empty($reserva->fk_menu)) {
            $recurso = $reserva->menu;
        } else {
            $recurso = $reserva->curso;
        }

        $resource = new ReservaResource();
        $responsePedido = $resource->criar(new Order($reserva, $chef, $usuario, $endereco, $cliente, $recurso));

        $pagamento = new PagamentoResource();
        $responsePagamento = $pagamento->pagar($responsePedido['id'], new Payment($usuario, $cliente, $hashCartao));

        $eventos = $this->formatarEventosPagamento($responsePagamento['events']);
        $cartaoCredito = $this->formatarCartao($responsePagamento['fundingInstrument']['creditCard']);

        return [
            'id_reserva'       => $responsePedido['id'],
            'id_pagamento'     => $responsePagamento['id'],
            'status_pagamento' => $responsePagamento['status'],
            'eventos'          => $eventos,
            'taxas'            => $responsePagamento['fees'],
            'cartao_credito'   => $cartaoCredito
        ];

    }

    /**
     * Cria uma nova conta transparente no MOIP para o chef
     *
     * @param $dados
     * @return array
     */
    public function efetuarCadastroChef($dados) {

        $account = new Account(
            $dados,
            $this->configuracoesSite->getWebsiteURL(),
            $this->geo->getCidade($dados['fk_cidade']));

        $conta = new ContaTransparentResource();
        $response = $conta->criar($account);

        return [
            "moip_id"           => $response['id'],
            "moip_access_token" => $response['accessToken'],
            "moip_login"        => $response['login'],
            "moip_created_at"   => $response['createdAt']
        ];

    }

    /**
     * Salva/Edita uma conta bancária
     *
     * @param ChefContaBancaria $contaBancaria
     */
    public function salvarContaBancaria(ChefContaBancaria $contaBancaria) {

        $chef = $contaBancaria->chef;

        $bank = new Bank($contaBancaria, $chef);
        $resource = new ContaBancariaResource();

        // Caso tenha MOIP ID, então é atualização
        if (!empty($contaBancaria->moip_id)) {
            $response = $resource->editar($contaBancaria->moip_id, $chef->moip_access_token, $bank);

        // Se não, cria uma nova conta
        } else {
            $response = $resource->criar($chef->moip_id, $chef->moip_access_token, $bank);
        }

        $contaBancaria->moip_id = $response['id'];
        $contaBancaria->moip_status = $response['status'];
        $contaBancaria->save();

    }

    /**
     * Deleta uma conta bancaria
     *
     * @param $moipIdContaBancaria
     * @param $accessToken
     */
    public function deletarContaBancaria($moipIdContaBancaria, $accessToken) {
        $contaBancaria = new ContaBancariaResource();
        $contaBancaria->deletar($moipIdContaBancaria, $accessToken);
    }

    /**
     * Solicita o reembolso de um pagamento
     *
     * @param $idMoipPagamento
     * @param $valorReembolso
     */
    public function reembolsarPagamento($idMoipPagamento, $valorReembolso) {
        $contaBancaria = new PagamentoResource();
        $response = $contaBancaria->reembolsar($idMoipPagamento, new Refund($valorReembolso));

        if ($response['status'] == PagamentoReembolso::STATUS_COMPLETED) {
            $reembolso = new PagamentoReembolso();
            $reembolso->moip_id = $response['id'];
            $reembolso->valor = $valorReembolso;
            $reembolso->save();
        }
    }


}