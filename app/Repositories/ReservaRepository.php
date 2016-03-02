<?php

namespace App\Repositories;

use App\Facades\Query;
use App\Model\ReservaModel;
use App\Constants\ReservaConstants;
use InvalidArgumentException;

class ReservaRepository extends AbstractRepository {

    protected $model = ReservaModel::class;

    public function atualizarIntegracaoMoip($idReserva, $idMoipOrder) {
        $this->updateById($idReserva, ['moip_id' => $idMoipOrder]);
    }

    /**
     * Atualiza o status da reserva
     *
     * @param $idReserva
     * @param $idStatus
     * @see Constants/ReservaConstants
     */
    public function alterarStatusReserva($idReserva, $idStatus) {
        $this->updateById($idReserva, ['fk_status' => $idStatus]);
    }

    /**
     * Busca todas as informacoes referentes a reserva
     *
     * @param $idReserva
     * @return stdClass
     */
    public function getDadosReserva($idReserva) {
        return Query::fetchFirst('Reservas/QryBuscarDadosReserva', [
            'id_reserva' => $idReserva
        ]);
    }

    /**
     * Realiza a busca de reservas por status
     *
     * @param $idDegustador
     * @param $idStatus
     * @return array of stdClass
     */
    public function getReservasPorStatus($idCliente, $idStatus) {
        return Query::fetch('Reservas/QryBuscarReservasCliente', [
           'id_cliente' => $idCliente,
           'id_status'  => $idStatus
        ]);
    }

    /**
     * Busca todas as reservas de um chef
     *
     * @param int $idChef
     */
    public function getReservasByChefId($idChef) {
        return Query::fetch('Reservas/QryBuscarReservasChef', [
            'id_chef' => $idChef
        ]);
    }

}