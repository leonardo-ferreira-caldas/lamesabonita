<?php

namespace App\Integracao\Moip\Structures;

use App\Model\DegustadorModel;
use App\User;
use JsonSerializable;

class Payment implements JsonSerializable {

    private $cliente;
    private $usuario;
    private $hashCartaoCredito;

    public function __construct(User $usuario, DegustadorModel $degustador, $hashCartaoCredito) {
        $this->usuario           = $usuario;
        $this->cliente           = $degustador;
        $this->hashCartaoCredito = $hashCartaoCredito;
    }

    private function getTelefoneDDD() {
        return substr($this->cliente->telefone, 0, 2);
    }

    private function getTelefone() {
        return substr($this->cliente->telefone, 2, 12);
    }

    private function getCreditCardHash() {
        return $this->hashCartaoCredito;
    }

    private function getParcelas() {
        return 1;
    }

    public function jsonSerialize() {
        return [
            "installmentCount"  => $this->getParcelas(),
            "fundingInstrument" => [
                "method" => "CREDIT_CARD",
                "creditCard" => [
                    "hash"   => $this->getCreditCardHash(),
                    "holder" => [
                        "fullname"    => $this->usuario->name,
                        "birthdate"   => $this->cliente->data_nascimento,
                        "taxDocument" => [
                            "type"   => "CPF",
                            "number" => $this->cliente->cpf
                        ],
                        "phone"       => [
                            "countryCode" => "55",
                            "areaCode"    => $this->getTelefoneDDD(),
                            "number"      => $this->getTelefone()
                        ]
                    ]
                ]
            ]
        ];
    }

}