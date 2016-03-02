<?php

namespace App\Integracao\Moip\Structures;

use JsonSerializable;
use App\Model\ChefModel;
use App\Model\DegustadorEnderecoModel;
use App\Model\DegustadorModel;
use App\Model\ReservaModel;
use App\User;

class Order implements JsonSerializable {

    private $reserva;
    private $chef;
    private $endereco;
    private $cliente;
    private $menuOuCurso;
    private $usuario;

    public function __construct(ReservaModel $reserva, ChefModel $chef, User $usuario, DegustadorEnderecoModel $endereco, DegustadorModel $degustador, $menuOuCurso) {
        $this->reserva     = $reserva;
        $this->chef        = $chef;
        $this->endereco    = $endereco;
        $this->usuario     = $usuario;
        $this->cliente     = $degustador;
        $this->menuOuCurso = $menuOuCurso;
    }

    private function getCurrency() {
        return "BRL";
    }

    private function getChefPorcentagem() {
        return 80;
    }

    private function getTelefoneDDD() {
        return substr($this->cliente->telefone, 0, 2);
    }

    private function getTelefone() {
        return substr($this->cliente->telefone, 2, 12);
    }

    public function jsonSerialize() {

        return [
            "ownId" => $this->reserva->id_reserva,
            "amount" => [
                "currency" => $this->getCurrency()
            ],
            "items" => [
                [
                    "product"   => $this->menuOuCurso->titulo,
                    "detail"    => $this->menuOuCurso->titulo,
                    "quantity"  => $this->reserva->qtd_clientes,
                    "price"     => $this->reserva->preco_por_cliente
                ],
                [
                    "product"   => 'Taxa de Serviço La Mesa Bonita',
                    "quantity"  => 1,
                    "detail"    => "Taxa cobrada pela utilização do serviço prestado pela empresa La Mesa Bonita na contratação de chef's.",
                    "price"     => $this->reserva->taxa_lmb
                ]
            ],
            "receivers" => [
                [
                    "moipAccount" => [
                        "id" => $this->chef->moip_id
                    ],
                    "type" => "SECONDARY",
                    "amount" => [
                        "percentual" => $this->getChefPorcentagem()
                    ]
                ]
            ],
            "customer" => [
                "ownId"       => $this->usuario->id,
                "fullname"    => $this->usuario->name,
                "email"       => $this->usuario->email,
                "birthDate"   => $this->cliente->data_nascimento,
                "taxDocument" => [
                    "type"   => "CPF",
                    "number" => $this->cliente->cpf
                ],
                "phone" => [
                    "countryCode" => "55",
                    "areaCode"    => $this->getTelefoneDDD(),
                    "number"      => $this->getTelefone()
                ],
                "shippingAddress" => [
                    "street"       => $this->endereco->logradouro,
                    "streetNumber" => $this->endereco->logradouro_numero,
                    "complement"   => $this->endereco->complemento ?: null,
                    "district"     => $this->endereco->bairro,
                    "city"         => $this->endereco->cidade->nome_cidade,
                    "state"        => $this->endereco->cidade->fk_estado,
                    "country"      => "BRA",
                    "zipCode"      => $this->endereco->cep
                ]
            ]
        ];

    }

}