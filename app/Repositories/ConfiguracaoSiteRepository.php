<?php

namespace App\Repositories;

use App\Exceptions\NotFoundException;
use App\Model\ConfiguracaoSiteModel;

class ConfiguracaoSiteRepository extends AbstractRepository {

    protected $model = ConfiguracaoSiteModel::class;
    private $loaded = [];

    public function __construct()
    {
        parent::__construct();

        foreach ($this->all() as $configuracao) {
            $this->loaded[$configuracao->chave] = $configuracao->valor;
        }
    }

    /**
     * Retorna o valor de uma determinada chave
     *
     * @param string $chave
     * @return string
     */
    private function getChaveValor($chave) {
        if (!isset($this->loaded[$chave])) {
            throw new NotFoundException;
        }

        return $this->loaded[$chave];
    }

    /**
     * Retorna a taxa a ser cobrada pelo site
     *
     * @return mixed
     */
    public function getTaxaLMB() {
        return $this->getChaveValor('TAXA_SERVICO_LMB');
    }

    /**
     * Retorna a chave publica do moip
     *
     * @return mixed
     */
    public function getPublicKey() {
        return $this->getChaveValor('MOIP_PUBLIC_KEY');
    }

    /**
     * Retorna a chave de acesso ao moip
     *
     * @return mixed
     */
    public function getMoipAccessToken() {
        return $this->getChaveValor('MOIP_APP_ACCESS_TOKEN');
    }

    /**
     * Retorna a chave de segredo do app moip
     *
     * @return mixed
     */
    public function getMoipSecret() {
        return $this->getChaveValor('MOIP_APP_SECRET');
    }

    /**
     * Retorna a chave segredo da conta moip
     *
     * @return mixed
     */
    public function getMoipAccountSecret() {
        return $this->getChaveValor('MOIP_ACCOUNT_SECRET');
    }

    /**
     * Retorna o token da conta moip
     *
     * @return mixed
     */
    public function getMoipAccountToken() {
        return $this->getChaveValor('MOIP_ACCOUNT_TOKEN');
    }

    /**
     * Retorna o ID do app moip
     *
     * @return mixed
     */
    public function getMoipAppId() {
        return $this->getChaveValor('MOIP_APP_ID');
    }

    /**
     * Retorna a URL do site
     *
     * @return mixed
     */
    public function getWebsiteURL() {
        return $this->getChaveValor('WEBSITE_URL');
    }

    /**
     * Retorna a porcentagem do chef
     *
     * @return mixed
     */
    public function getPorcentagemChef() {
        return $this->getChaveValor('PORCENTAGEM_CHEF');
    }

    /**
     * Insere um novo registro
     *
     * @param $chave
     * @param $valor
     */
    public function inserir($chave, $valor) {
        return $this->create([
            'chave' => $chave,
            'valor' => $valor
        ]);
    }

    /**
     * Atualiza um registro
     *
     * @param $chave
     * @param $valor
     */
    public function atualizar($chave, $valor) {
        return $this->updateById($chave, [
            'valor' => $valor
        ]);
    }
}