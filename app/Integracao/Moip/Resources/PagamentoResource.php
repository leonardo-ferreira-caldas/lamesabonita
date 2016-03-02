<?php

namespace App\Integracao\Moip\Resources;

use App\Constants\MoipConstants;
use App\Integracao\Moip\Services\RESTService;
use App\Integracao\Moip\Structures\Payment;
use App\Integracao\Moip\Request;
use App\Integracao\Moip\Structures\Refund;

class PagamentoResource extends AbstractResource
{

    /**
     * Realiza um novo pagamento para o pedido recem criado
     *
     * @param $moipPedidoID
     * @param Payment $payment
     * @return mixed
     */
    public function pagar($moipPedidoID, Payment $payment) {

        $url = sprintf("v2/orders/%s/payments", $moipPedidoID);

        $service = new RESTService($url, $payment);
        $service->withAuthorization($this->getAccountBasicAuthorization());

        $request = new Request($service);
        $response = $request->post();

        $this->log(MoipConstants::INTEGRACAO_REALIZAR_PAGAMENTO, $response);

        return $response;

    }

    /**
     * Solicita o reembolso de um pagamento
     *
     * @param $moipPagamentoID
     * @param Refund $refund
     * @return mixed
     */
    public function reembolsar($moipPagamentoID, Refund $refund) {

        $url = sprintf("v2/payments/%s/refunds", $moipPagamentoID);

        $service = new RESTService($url, $refund);
        $service->withAuthorization($this->getAccountBasicAuthorization());

        $request = new Request($service);
        $response = $request->post();

        $this->log(MoipConstants::INTEGRACAO_SOLICITACAO_REEMBOLSO, $response);

        return $response;

    }

}