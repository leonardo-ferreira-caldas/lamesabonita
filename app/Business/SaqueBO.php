<?php

namespace App\Business;

use App\Constants\SaqueConstants;
use App\Exceptions\UnexpectedErrorException;
use App\Facades\Autenticacao;
use App\Integracao\Moip\Resources\SaqueResource;
use App\Integracao\Moip\Structures\Withdraw;
use App\Mappers\RepositoryMapper;
use App\Facades\Query;
use DB;
use Exception;

class SaqueBO
{
    private $repository;

    public function __construct(RepositoryMapper $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Cria um novo registro de saque
     *
     * @param $idContaBancaria
     * @return Model/Saque
     */
    private function registrarNovoSaque($idContaBancaria) {
        $chef = $this->repository->chef->findById(Autenticacao::getId());

        $this->repository->chef->updateById($chef->id_chef, [
            'saldo' => 0.00
        ]);

        return $this->repository->saque->create([
            'valor_saque'       => $chef->saldo,
            'valor_taxa'        => 0,
            'fk_conta_bancaria' => $idContaBancaria,
            'fk_saque_status'   => SaqueConstants::STATUS_AGUARDANDO,
            'fk_chef'           => $chef->id_chef
        ]);
    }

    /**
     * Realiza a solicitação de saque
     *
     * @param int $idContaBancaria
     * @return void
     */
    public function solicitarSaque($idContaBancaria)
    {

        DB::beginTransaction();

        try {

            $saque = $this->registrarNovoSaque($idContaBancaria);

            $integracao = $this->solicitarTransferenciaMoip($saque, $idContaBancaria);

            $this->repository->saque->updateById($saque->id_saque, [
                'moip_id'         => $integracao['id'],
                'moip_status'     => $integracao['status'],
                'fk_saque_status' => SaqueConstants::getStatusByMoipStatus($integracao['status']),
                'valor_taxa'      => $integracao['fee'],
                'valor_saque'     => $integracao['amount']
            ]);

            DB::commit();

        } catch (Exception $e) {
            DB::rollBack();

            throw new UnexpectedErrorException;
        }

    }

    /**
     * Realiza integração com o MOIP
     *
     * @param float $saque
     * @param int $idContaBancaria
     * @return mixed
     */
    private function solicitarTransferenciaMoip($saque, $idContaBancaria) {

        $moipIdContaBancaria = $this->repository->conta_bancaria->getMoipIdById($idContaBancaria);

        $withdraw = new Withdraw($saque->valor_saque, $moipIdContaBancaria);

        return SaqueResource::getInstance()->sacar($withdraw, $this->repository->chef->getAccessToken(Autenticacao::getId()));

    }

    /**
     * Busca todos os saques do chef logado
     *
     * @return array Saques
     */
    public function getSaquesChefLogado() {
        return $this->repository->saque->getSaquesChef(Autenticacao::getId());
    }

    /**
     * Busca valores totais de saques do chef logado
     *
     * @return array Saques
     */
    public function getTotalSaquesChefLogado() {
        return $this->repository->saque->getTotalSaquesChef(Autenticacao::getId());
    }

}
