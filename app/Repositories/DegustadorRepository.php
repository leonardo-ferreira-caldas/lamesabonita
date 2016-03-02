<?php

namespace App\Repositories;

use App\Constants\ClienteConstants;
use App\Facades\Query;
use App\Formatters\DataFormatter;
use App\Model\DegustadorModel;

class DegustadorRepository extends AbstractRepository
{

    protected $model = DegustadorModel::class;

    /**
     * Altera a foto de perfil de um cliente
     *
     * @param $id
     * @param $avatarName
     */
    public function alterarAvatar($id, $avatar)
    {
        $this->updateById($id, [
            'avatar' => $avatar
        ]);
    }

    /**
     * Atualiza os dados de um cliente
     *
     * @param $idCliente
     * @param $dados
     */
    public function atualizarDados($idCliente, $dados)
    {
        $this->updateById($idCliente, [
            'cpf' => $dados['cpf'],
            'telefone' => $dados['telefone'],
            'fk_sexo' => $dados['fk_sexo'],
            'data_nascimento' => DataFormatter::formatarDataEN($dados['data_nascimento'])
        ]);
    }

    /**
     * Verifica se o newsletter de um cliente está habilitado
     *
     * @return mixed
     */
    public function getNewsletterStatus($idCliente)
    {
        return (bool)$this->findById($idCliente)->ind_newsletter;
    }

    /**
     * Atualiza o status de newsletter de um cliente
     *
     * @param int $idCliente
     * @param bool $status
     * @return void
     */
    public function atualizarNewsletter($idCliente, $status)
    {
        $this->updateById($idCliente, [
            'ind_newsletter' => $status
        ]);
    }

    /**
     * Cadastra um novo cliente
     *
     * @param int $id Código do usuário (PK)
     * @return Model/Degustador
     */
    public function cadastrar(User $usuario)
    {
        $cliente = $this->create([
            'id_degustador' => $usuario->id,
            'avatar' => ClienteConstants::DEFAULT_AVATAR
        ]);

        return $cliente;
    }

    /**
     * Retorna os dados de um cliente
     *
     * @param int $idCliente
     * @return stdClass
     */
    public function getDadosCliente($idCliente) {
        return Query::fetchFirst('Clientes/Geral/QryBuscarDadosCliente', [
           'id_cliente' => $idCliente
        ]);
    }
}