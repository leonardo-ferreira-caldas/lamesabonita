<?php

namespace App\Constants;

use Exception;

class SaqueConstants {

    const STATUS_AGUARDANDO = 1;
    const STATUS_CONCLUIDO = 2;
    const STATUS_ERRO = 3;
    const STATUS_REVERTIDO = 4;

    const MOIP_STATUS_REQUESTED = "REQUESTED";
    const MOIP_STATUS_COMPLETED = "COMPLETED";
    const MOIP_STATUS_FAILED    = "FAILED";
    const MOIP_STATUS_REVERSED  = "REVERSED";

    public static function getStatusByMoipStatus($moipStatus) {
        switch ($moipStatus) {
            case self::MOIP_STATUS_REQUESTED:
                return self::STATUS_AGUARDANDO;

            case self::MOIP_STATUS_COMPLETED:
                return self::STATUS_CONCLUIDO;

            case self::MOIP_STATUS_FAILED:
                return self::STATUS_ERRO;

            case self::MOIP_STATUS_REVERSED:
                return self::STATUS_REVERTIDO;

        }

        throw new Exception;
    }

}