<?php

namespace App\Business;

use App\Facades\Autenticacao;
use App\Mappers\RepositoryMapper;
use DB;

class ContaBancariaBO
{
    private $repository;
    private $moip;

    /**
     * ContaBancariaBO constructor.
     * @param RepositoryMapper $repository
     * @param MoipBO $
     */
    public function __construct(RepositoryMapper $repository, MoipBO $moip)
    {
        $this->repository = $repository;
        $this->moip = $moip;
    }

    /**
     * Busca as acontas bancarias do chef logado
     *
     * @return mixed
     */
    public function getContaBancariasChefLogado() {
        return $this->repository->conta_bancaria->getChefContasBancarias(Autenticacao::getId());
    }

    /**
     * Retorna quantas contas bancarias o chef logado tem cadastrado
     *
     * @return int
     */
    public function getQuantidadeContasBancariasChefLogado() {
        return $this->repository->conta_bancaria->getQuantidadeContasBancariasByChefId(Autenticacao::getId());
    }

    /**
     * Insere/Edita os dados bancarios do chef logado
     *
     * @param $dadosBancarios
     * @return bool
     */
    public function salvarContaBancaria($dadosBancarios) {
        DB::beginTransaction();

        try {

            if (!empty($dadosBancarios['id_conta_bancaria'])) {
                $contaBancaria = $this->repository->conta_bancaria->atualizarContaBancaria($dadosBancarios['id_conta_bancaria'], $dadosBancarios);
            } else {
                $contaBancaria = $this->repository->conta_bancaria->inserirContaBancaria(Autenticacao::getId(), $dadosBancarios);
            }

            $this->moip->salvarContaBancaria($contaBancaria);

            DB::commit();

        } catch (Exception $excpt) {
            DB::rollBack();
            throw new UnexpectedErrorException;
        }

    }
}