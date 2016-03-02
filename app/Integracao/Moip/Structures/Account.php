<?php

namespace App\Integracao\Moip\Structures;

use App\Constants\MoipConstants;
use JsonSerializable;
use App\Formatters\MoipFormatter;
use App\Model\CidadeModel;

class Account implements JsonSerializable {

    private $dados;
    private $websiteUrl;
    private $cidade;

    public function __construct($dados, $websiteUrl, CidadeModel $cidade) {
        $this->dados = $dados;
        $this->websiteUrl = $websiteUrl;
        $this->cidade = $cidade;
    }

    private function getDataNascimento() {
        return MoipFormatter::formatDataNascimento($this->dados['data_nascimento']);
    }

    private function getTelefone() {
        list($ddd, $telefone) = MoipFormatter::formatTelefone($this->dados['telefone']);

        return [
            'countryCode' => MoipConstants::MOIP_COUNTRY_CODE,
            'areaCode'    => $ddd,
            'number'      => $telefone
        ];
    }

    private function getTaxDocument() {
        return [
            'type'   => MoipConstants::MOIP_TAX_DOCUMENT,
            "number" => MoipFormatter::formatCPF($this->dados['cpf'])
        ];
    }

    private function getAddress() {
        return [
            "street"       => $this->dados['logradouro'],
            "streetNumber" => $this->dados['logradouro_numero'],
            "complement"   => "",
            "district"     => $this->dados['bairro'],
            "zipcode"      => MoipFormatter::formatCEP($this->dados['cep']),
            "city"         => $this->cidade->nome_cidade,
            "state"        => $this->dados['fk_estado'],
            "country"      => MoipConstants::MOIP_COUNTRY_ABBR
        ];
    }

    private function getNomeCompleto() {
        return sprintf("%s %s", $this->dados['name'], $this->dados['sobrenome']);
    }

    public function jsonSerialize() {

        return [
            'email' => [
                'address' => $this->dados['email']
            ],
            'person' => [
                'name'        => $this->getNomeCompleto(),
                'taxDocument' => $this->getTaxDocument(),
                'birthDate'   => $this->getDataNascimento(),
                'nationality' => MoipConstants::MOIP_COUNTRY_NATIONALITY,
                'phone'       => $this->getTelefone(),
                'address'     => $this->getAddress()
            ],
            'businessSegment'    => ['id' => MoipConstants::MOIP_SEGMENT],
            'site'               => $this->websiteUrl,
            'type'               => MoipConstants::MOIP_ACCOUNT_TYPE,
            'transparentAccount' => true
        ];
    }

}