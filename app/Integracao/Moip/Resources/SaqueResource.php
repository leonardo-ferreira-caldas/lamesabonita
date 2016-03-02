<?php

namespace App\Integracao\Moip\Resources;

use App\Constants\MoipConstants;
use App\Integracao\Moip\Authorizations\OAuth;
use App\Integracao\Moip\Services\RESTService;
use App\Integracao\Moip\Request;
use App\Integracao\Moip\Structures\Withdraw;

class SaqueResource extends AbstractResource
{

    /**
     * Solicita um novo saque/transferencia
     *
     * @param Order $order
     * @return mixed
     */
    public function sacar(Withdraw $withdraw, $accessToken) {

        $service = new RESTService("v2/transfers", $withdraw);
        $service->withAuthorization(new OAuth($accessToken));

        $request = new Request($service);
        $response = $request->post();

        $this->log(MoipConstants::INTEGRACAO_SOLICITACAO_SAQUE, $response);

        return $response;

    }

}