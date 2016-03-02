<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Business\IntegracaoBO;
use App\Business\PagamentoBO;
use App\Constants\MoipConstants;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Log;

class IntegracaoController extends Controller
{

    /**
     * Responsavel por receber webhooks de mudanças de status do MOIP
     *
     * @param IntegracaoBO $integracaoBO
     * @param PagamentoBO $pagamento
     * @param Request $request
     * @throws \App\Business\Exception
     */
    public function postAtualizarIntegracaoPagamento(IntegracaoBO $integracaoBO, PagamentoBO $pagamento, Request $request) {
        $integracaoBO->registrar(MoipConstants::INTEGRACAO_WEBHOOK, $request->all());

        if ($pagamento->ehStatusPagamento($request->input("resource.payment.status"))) {
            $pagamento->atualizarStatusPagamento($request->input("resource.payment.id"), $request->input("resource.payment.status"));
        }
    }
}
