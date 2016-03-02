<?php

namespace App\Integracao\Moip\Resources;

use App\Constants\MoipConstants;
use App\Integracao\Moip\Services\RESTService;
use App\Integracao\Moip\Structures\Account;
use App\Integracao\Moip\Request;

class ContaTransparentResource extends AbstractResource
{

    /**
     * Cria uma nova reserva
     *
     * @param Order $order
     * @return mixed
     */
    public function criar(Account $order) {

        $service = new RESTService("v2/accounts", $order);
        $service->withAuthorization($this->getAccountOAuthAuthorization());

        $request = new Request($service);
        $response = $request->post();

        $this->log(MoipConstants::INTEGRACAO_CRIAR_CONTA_CHEF, $response);

        return $response;

    }

}