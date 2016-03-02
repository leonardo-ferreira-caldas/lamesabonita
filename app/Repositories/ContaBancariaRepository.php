<?php

namespace App\Repositories;

use App\Facades\Query;
use App\Model\ChefContaBancaria;

class ContaBancariaRepository extends AbstractRepository {

    protected $model = ChefContaBancaria::class;

    /**
     * Retorna o MOIP ID de uma conta bancaria
     *
     * @param $idContaBancaria
     * @return mixed
     */
    public function getMoipIdById($idContaBancaria) {
        return $this->findById($idContaBancaria)->moip_id;
    }

    /**
     * Retorna as contas bancarias de um chef
     *
     * @param $id
     * @return mixed
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function getChefContasBancarias($id) {
        return Query::fetch('Chef/Banco/QryBuscarContasBancarias', [
            'id_chef' => $id
        ]);
    }

    /**
     * Retorna as contas bancarias de um chef
     *
     * @param $id
     * @return mixed
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function getTodasContasBancarias() {
        return Query::fetch('Chef/Banco/QryBuscarTodasContasBancarias');
    }

    /**
     * Insere uma nova conta bancária para um chef
     *
     * @param $idChef
     * @param $dadosBancarios
     * @return mixed
     */
    public function inserirContaBancaria($idChef, $dadosBancarios) {
        $insert = [
            'fk_chef'                  => $idChef,
            'fk_banco'                 => $dadosBancarios['fk_banco'],
            'banco_agencia'            => $dadosBancarios['banco_agencia'],
            'banco_conta'              => $dadosBancarios['banco_conta'],
            'banco_conta_digito'       => $dadosBancarios['banco_conta_digito'],
            'banco_proprietario_conta' => $dadosBancarios['banco_proprietario_conta']
        ];

        if (!empty($dadosBancarios['banco_agencia_digito']) || $dadosBancarios['banco_agencia_digito'] == "0") {
            $insert['banco_agencia_digito'] = $dadosBancarios['banco_agencia_digito'];
        }

        return $this->create($insert);
    }

    /**
     * Atualiza uma conta bancária de um chef
     *
     * @param $idContaBancaria
     * @param $dadosBancarios
     * @return mixed
     */
    public function atualizarContaBancaria($idContaBancaria, $dadosBancarios) {
        $update = [
            'fk_banco'                 => $dadosBancarios['fk_banco'],
            'banco_agencia'            => $dadosBancarios['banco_agencia'],
            'banco_conta'              => $dadosBancarios['banco_conta'],
            'banco_conta_digito'       => $dadosBancarios['banco_conta_digito'],
            'banco_proprietario_conta' => $dadosBancarios['banco_proprietario_conta']
        ];

        if (!empty($dadosBancarios['banco_agencia_digito']) || $dadosBancarios['banco_agencia_digito'] == "0") {
            $update['banco_agencia_digito'] = $dadosBancarios['banco_agencia_digito'];
        } else {
            $update['banco_agencia_digito'] = null;
        }

        $this->updateById($idContaBancaria, $update);

        return $this->findById($idContaBancaria);
    }

    /**
     * Retorna a quantidade de contas bancarias de um chef
     *
     * @param int $id Código do Chef (PK)
     * @return int
     */
    public function getQuantidadeContasBancariasByChefId($id) {
        return $this->count([
            'fk_chef' => $id
        ]);
    }

}