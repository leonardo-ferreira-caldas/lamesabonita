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
     * Verifica se o usuário logado ja reservou um menu
     *
     * @param int $idUsuario
     * @param int $idMenu
     * @return bool
     */
    public function jaReservouMenu($idUsuario, $idMenu) {
        return $this->exists([
            'fk_degustador' => $idUsuario,
            'fk_menu'       => $idMenu,
            'fk_status'     => ReservaConstants::STATUS_RELIZADA
        ]);
    }

    /**
     * Verifica se o usuário logado ja reservou um curso
     *
     * @param int $idUsuario
     * @param int $idCurso
     * @return bool
     */
    public function jaReservouCurso($idUsuario, $idCurso) {
        return $this->exists([
            'fk_degustador' => $idUsuario,
            'fk_curso'      => $idCurso,
            'fk_status'     => ReservaConstants::STATUS_RELIZADA
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
     * @return array
     */
    public function getReservasByChefId($idChef) {
        return Query::fetch('Reservas/QryBuscarReservasChef', [
            'id_chef' => $idChef
        ]);
    }

    /**
     * Busca todas as reservas
     *
     * @param int $idChef
     * @return array
     */
    public function getTodasReservas() {
        return Query::fetch('Reservas/QryBuscarTodasReservas');
    }


    /**
     * Verifica se ja existe uma reserva para um chef e uma data
     *
     * @param $idChef
     * @param $dataReserva
     * @return bool
     */
        public function jaPossuiReservaEmData($idChef, $dataReserva) {
        return $this->exists([
            'fk_chef'      => $idChef,
            'data_reserva' => $dataReserva,
            'fk_status'    => ReservaConstants::STATUS_ATIVA
        ]);
    }
}