<?php
/**
 * Created by PhpStorm.
 * User: leonardo
 * Date: 22/01/16
 * Time: 22:52
 */

namespace App\Business;

use App\Mappers\RepositoryMapper;
use App\Model\MoipIntegracaoLoggerModel;
use Log;

class IntegracaoBO
{
    private $repository;

    public function __construct(RepositoryMapper $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Salva log em banco e em arquivo
     *
     * @param $tipo
     * @param $log
     */
    public function registrar($tipo, $log) {
        if (is_array($log)) {
            $log = json_encode($log);
        }

        $logIntegracao = new MoipIntegracaoLoggerModel();
        $logIntegracao->tipo = $tipo;
        $logIntegracao->log = $log;
        $logIntegracao->save();

        Log::info("Tipo Resource: " . $tipo);
        Log::info("Log Resource: " . $log);
    }

}
