<?php

namespace App\Integracao\Moip\Structures;

use JsonSerializable;

class Withdraw implements JsonSerializable {

    private $valorSaque;
    private $moipIdContaBancaria;

    const METHOD_BANK_ACCOUNT = 'BANK_ACCOUNT';
    const METHOD_MOIP_ACCOUNT = 'MOIP_ACCOUNT';

    public function __construct($valorSaque, $moipIdContaBancaria) {
        $this->valorSaque = $valorSaque;
        $this->moipIdContaBancaria = $moipIdContaBancaria;
    }

    public function jsonSerialize() {
        return [
            'amount' => (float) $this->valorSaque,
            'transferInstrument' => [
                'method' => self::METHOD_BANK_ACCOUNT,
                'bankAccount' => [
                    'id' => $this->moipIdContaBancaria
                ]
            ]
        ];
    }

}