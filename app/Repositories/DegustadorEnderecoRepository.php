<?php

namespace App\Repositories;

use App\Facades\Query;
use App\Model\DegustadorEnderecoModel;

class DegustadorEnderecoRepository extends AbstractRepository {

    protected $model = DegustadorEnderecoModel::class;

    /**
     * Retorna o endereço principal de um cliente
     *
     * @param $idCliente
     * @return mixed
     */
    public function getEnderecoPrincipal($idCliente) {
        return $this->findFirst([
            'fk_degustador' => $idCliente,
            'ind_endereco_principal' => true
        ]);
    }

    /**
     * Salva o endereço principal de um cliente
     *
     * @param $dadosEndereco
     * @return mixed
     */
    public function salvarEnderecoPrincipal($idCliente, $dadosEndereco) {
        $endereco = $this->getEnderecoPrincipal($idCliente);

        if (!empty($endereco)) {
            return $this->atualizarEndereco($endereco->id_degustador_endereco, $dadosEndereco);
        }

        $this->inserirEndereco($idCliente, $dadosEndereco, true);

    }

    /**
     * Atualiza os dados de um endereço
     *
     * @param $idEndereco
     * @param $dadosEndereco
     * @return void
     */
    public function inserirEndereco($idCliente, $dadosEndereco, $enderecoPrincipal = false) {
        $this->create([
            'fk_degustador'     => $idCliente,
            'fk_estado'         => $dadosEndereco['fk_estado'],
            'fk_pais'           => $dadosEndereco['fk_pais'],
            'fk_cidade'         => $dadosEndereco['fk_cidade'],
            'bairro'            => $dadosEndereco['bairro'],
            'logradouro'        => $dadosEndereco['logradouro'],
            'logradouro_numero' => $dadosEndereco['logradouro_numero'],
            'descricao'         => $dadosEndereco['descricao'],
            'complemento'       => $dadosEndereco['complemento'],
            'cep'               => $dadosEndereco['cep'],
            'ind_endereco_principal' => $enderecoPrincipal
        ]);
    }

    /**
     * Atualiza os dados de um endereço
     *
     * @param $idEndereco
     * @param $dadosEndereco
     * @return void
     */
    public function atualizarEndereco($idEndereco, $dadosEndereco) {
        $this->updateById($idEndereco, [
            'fk_estado'         => $dadosEndereco['fk_estado'],
            'fk_pais'           => $dadosEndereco['fk_pais'],
            'fk_cidade'         => $dadosEndereco['fk_cidade'],
            'bairro'            => $dadosEndereco['bairro'],
            'logradouro'        => $dadosEndereco['logradouro'],
            'logradouro_numero' => $dadosEndereco['logradouro_numero'],
            'descricao'         => $dadosEndereco['descricao'],
            'complemento'       => $dadosEndereco['complemento'],
            'cep'               => $dadosEndereco['cep']
        ]);
    }

    /**
     * Retorna os dados de um endereço de cliente
     *
     * @param $idEndereco
     * @return Model\DegustadorEnderecoModel
     */
    public function getDadosEndereco($idEndereco) {
        return $this->findById($idEndereco);
    }

    /**
     * Retorna os endereços de um cliente
     *
     * @param int $idCliente
     * @return mixed
     */
    public function getEnderecos($idCliente) {
        return Query::fetch('Clientes/Enderecos/QryBuscarEnderecosCliente', [
            'id_cliente' => $idCliente
        ]);
    }

}