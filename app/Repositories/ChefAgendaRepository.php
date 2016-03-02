<?php

namespace App\Repositories;

use App\Constants\ReservaConstants;
use App\Facades\Query;
use App\Model\ChefAgendaModel;
use DB;

class ChefAgendaRepository extends AbstractRepository {

    protected $model = ChefAgendaModel::class;

    /**
     * Retorna os dados de agenda de um chef
     *
     * @param $idChef
     * @return mixed
     */
    public function getAgendaCalendario($idChef) {
        return Query::fetch('Chef/Agenda/QryBuscarAgendaChef', [
           'id_chef' => $idChef
        ]);
    }

    /**
     * Busca os dados de um registro de agenda
     *
     * @return model
     */
    public function getAgenda($idAgenda) {
        return $this->instance->withTrashed()->findOrFail($idAgenda);
    }

    /**
     * Busca os dados de um registro de agenda
     *
     * @return model
     */
    public function getAgendaPorData($idChef, $data) {
        return $this->instance->withTrashed()
            ->where('fk_chef', '=', $idChef)
            ->where('data', '=', $data)
            ->first();
    }

    /**
     * Retorna a agenda disponível de um chef
     *
     * @param $idChef
     * @return mixed
     */
    public function getAgendaDisponivel($idChef) {
        $agenda = Query::fetch('Chef/Agenda/QryBuscarAgendaDisponivelChef', [
            'id_chef'   => $idChef,
            'id_status' => ReservaConstants::STATUS_ATIVA
        ]);

        return array_map(function($value) {
            return $value->data;
        }, $agenda);
    }

    /**
     * Retorna o horario de uma data
     *
     * @param $idChef
     * @param $data
     * @return mixed
     */
    public function getHorarioPorData($idChef, $data) {
        return $this->findFirst([
            'fk_chef' => $idChef,
            'data' => $data
        ]);
    }

}