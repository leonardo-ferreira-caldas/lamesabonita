<?php

namespace App\Repositories;

use App\Facades\Query;
use App\Model\Saque;

class SaqueRepository extends AbstractRepository {

    protected $model = Saque::class;

    /**
     * Retorna os valores de saques sumarizados de um chef
     *
     * @param int $idChef
     * @return array Saques
     */
    public function getTotalSaquesChef($idChef) {
        return Query::fetchFirst('Chef/Saque/QrySumarizarSaques', [
            'id_chef' => $idChef
        ]);
    }

    /**
     * Retorna todos os saques de um chef
     *
     * @param int $idChef
     * @return array Saques
     */
    public function getSaquesChef($idChef) {
        return Query::fetch('Chef/Saque/QryBuscarSaques', [
            'id_chef' => $idChef
        ]);
    }

}