<?php

namespace App\Integracao\Moip\Structures;

use App\Constants\MoipConstants;
use App\Model\ChefContaBancaria;
use App\Model\ChefModel;
use JsonSerializable;

class Bank implements JsonSerializable {

    private $banco;
    private $chef;

    public function __construct(ChefContaBancaria $banco, ChefModel $chef) {
        $this->banco   = $banco;
        $this->chef    = $chef;
    }

    public function jsonSerialize() {
        $agenciaDigito = $this->banco->banco_agencia_digito;

        if (empty($agenciaDigito)) {
            $agenciaDigito = "0";
        }

        return [
            "bankNumber"         => $this->banco->fk_banco,
            "agencyNumber"       => $this->banco->banco_agencia,
            "agencyCheckNumber"  => $agenciaDigito,
            "accountNumber"      => $this->banco->banco_conta,
            "accountCheckNumber" => $this->banco->banco_conta_digito,
            "type" => "CHECKING",
            "holder" => [
                "taxDocument" => [
                    "type"   => MoipConstants::MOIP_TAX_DOCUMENT,
                    "number" => $this->chef->cpf
                ],
                "fullname" => $this->banco->banco_proprietario_conta
            ]
        ];
    }

}