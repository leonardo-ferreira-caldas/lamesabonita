<?php

namespace App\Integracao\Moip\Resources;

use App\Constants\MoipConstants;
use App\Integracao\Moip\Authorizations\OAuth;
use App\Integracao\Moip\Services\RESTService;
use App\Integracao\Moip\Structures\Bank;
use App\Integracao\Moip\Request;

class ContaBancariaResource extends AbstractResource
{

    /**
     * Cria uma nova conta bancaria
     *
     * @param $moipMarketplaceAccountID
     * @param $moipMarketplaceAccountToken
     * @param Bank $bank
     */
    public function criar($moipMarketplaceAccountID, $moipMarketplaceAccountToken, Bank $bank) {

        $url = sprintf("v2/accounts/%s/bankaccounts", $moipMarketplaceAccountID);

        $service = new RESTService($url, $bank);
        $service->withAuthorization(new OAuth($moipMarketplaceAccountToken));

        $request = new Request($service);
        $response = $request->post();

        $this->log(MoipConstants::INTEGRACAO_CONTA_BANCARIA_CRIAR, $response);

        return $response;

    }

    /**
     * Edita uma conta bancaria
     *
     * @param $moipBankAccountID
     * @param $moipMarketplaceAccountToken
     * @param Bank $bank
     */
    public function editar($moipBankAccountID, $moipMarketplaceAccountToken, Bank $bank) {

        $url = sprintf("v2/bankaccounts/%s", $moipBankAccountID);

        $service = new RESTService($url, $bank);
        $service->withAuthorization(new OAuth($moipMarketplaceAccountToken));

        $request = new Request($service);
        $response = $request->put();

        $this->log(MoipConstants::INTEGRACAO_CONTA_BANCARIA_EDITAR, $response);

        return $response;

    }

    /**
     * Deleta uma conta bancaria
     *
     * @param $moipBankAccountID
     * @param $moipMarketplaceAccountToken
     */
    public function deletar($moipBankAccountID, $moipMarketplaceAccountToken) {

        $url = sprintf("v2/bankaccounts/%s", $moipBankAccountID);

        $service = new RESTService($url, null);
        $service->withAuthorization(new OAuth($moipMarketplaceAccountToken));

        $request = new Request($service);
        $response = $request->delete();

        $this->log(MoipConstants::INTEGRACAO_CONTA_BANCARIA_EXCLUIR, $response);

    }

    public function listar() {}

}