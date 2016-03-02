<?php

namespace App\Integracao\Moip\Resources;

use App\Constants\MoipConstants;
use App\Integracao\Moip\Services\RESTService;
use App\Integracao\Moip\Structures\Order;
use App\Integracao\Moip\Request;

class ReservaResource extends AbstractResource
{

    /**
     * Cria uma nova reserva
     *
     * @param Order $order
     * @return mixed
     */
    public function criar(Order $order) {

        $service = new RESTService("v2/orders", $order);
        $service->withAuthorization($this->getAccountBasicAuthorization());

        $request = new Request($service);
        $response = $request->post();

        $this->log(MoipConstants::INTEGRACAO_CRIAR_PEDIDO, $response);

        return $response;

    }

}