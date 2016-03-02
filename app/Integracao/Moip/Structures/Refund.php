<?php

namespace App\Integracao\Moip\Structures;

use JsonSerializable;

class Refund implements JsonSerializable {

    private $valorReembolso;

    public function __construct($valorReembolso) {
        $this->valorReembolso = $valorReembolso;
    }

    public function jsonSerialize() {
        return [
            'amount' => $this->valorReembolso
        ];
    }

}