<?php

namespace App\Integracao\Moip\Resources;

use App\Business\IntegracaoBO;
use App\Integracao\Moip\Authorizations\OAuth;
use App\Model\MoipIntegracaoLoggerModel;
use App\Integracao\Moip\Authorizations\Basic;
use App\Repositories\ConfiguracaoSiteRepository;
use App\Traits\Patterns\Singleton;
use Log;

abstract class AbstractResource
{
    use Singleton;

    private $config;
    private $integracao;

    public function __construct()
    {
        $this->config = app(ConfiguracaoSiteRepository::class);
        $this->integracao = app(IntegracaoBO::class);
    }

    /**
     * Salva log em banco e em arquivo
     *
     * @param $tipo
     * @param $log
     */
    protected function log($tipo, $log) {
        $this->integracao->registrar($tipo, $log);
    }

    /**
     * Retorna uma nova autorização Basic utilizando as credencias da conta
     * cadastradas no MOIP
     *
     * @return Basic
     */
    protected function getAccountBasicAuthorization() {
        return new Basic($this->config->getMoipAccountSecret(), $this->config->getMoipAccountToken());
    }

    /**
     * Retorna uma nova autorização OAuth utilizando as credencias do APP
     * cadastrado no MOIP
     *
     * @return Basic
     */
    protected function getAccountOAuthAuthorization() {
        return new OAuth($this->config->getMoipAccessToken());
    }

}