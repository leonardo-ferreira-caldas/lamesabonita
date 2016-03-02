<?php

namespace App\Emails;

use App\Model\ReservaModel;

abstract class AbstractEmailReservaPagameto extends Email {

    protected $reserva;

    public function setReserva(ReservaModel $reserva) {
        $this->reserva = $reserva;
    }

    public function getVariavies() {

        $dataReserva = date('d/m/Y', strtotime($this->reserva->data_reserva));

        return [
            // Dados da Reserva
            "nome_cliente"      => $this->getNome(),
            "codigo_reserva"    => $this->reserva->id_reserva,
            "data_reserva"      => $dataReserva,
            "horario_reserva"   => $this->reserva->horario_reserva,
            "qtd_clientes"      => $this->reserva->qtd_clientes,
            "observacao"        => $this->reserva->observacao,
            "titulo_menu"       => $this->reserva->menu->titulo,
            "nome_chef"         => $this->reserva->user->name,

            // Dados Endereço
            "cep"               => $this->reserva->endereco->cep,
            "logradouro"        => $this->reserva->endereco->logradouro,
            "logradouro_numero" => $this->reserva->endereco->logradouro_numero,
            "bairro"            => $this->reserva->endereco->bairro,
            "nome_cidade"       => $this->reserva->endereco->cidade->nome_cidade,
            "nome_estado"       => $this->reserva->endereco->estado->nome_estado,
            "nome_pais"         => $this->reserva->endereco->pais->nome_pais,

            // Dados Pagamento
            "preco_por_cliente" => $this->reserva->preco_por_cliente,
            "taxa_lmb"          => $this->reserva->taxa_lmb,
            "preco_total"       => $this->reserva->preco_total
        ];
    }

}