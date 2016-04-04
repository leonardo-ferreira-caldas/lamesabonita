<?php

namespace App\Repositories;

use App\User;

class UserRepository extends AbstractRepository {

    protected $model = User::class;

    /**
     * Busca um usuario pelo email
     *
     * @param $email
     * @return LaMesaBonita/User
     */
    public function findByEmail($email) {
        return $this->findFirst([
            'email' => $email
        ]);
    }

    /**
     * Verifica se ja existe um chef com o email informado
     *
     * @param string $email
     * @return string
     */
    public function emailExiste($email) {
        return $this->exists([
            'email' => $email
        ]);
    }

    /**
     * Insere um novo usuário
     *
     * @param $data
     * @return App\User
     */
    public function cadastrar($data) {
        return $this->create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => bcrypt($data['password']),
            'ind_chef' => $data['ind_chef']
        ]);
    }

    /**
     * Altera a senha de um usuário
     *
     * @param int $idUsuario
     * @param string $novaSenha
     * @return void
     */
    public function alterarSenha($idUsuario, $novaSenha) {
        $this->updateById($idUsuario, [
            'password' => bcrypt($novaSenha)
        ]);
    }

    /**
     * Confirma o email de um usuário
     *
     * @param int $idUsuario
     * @return void
     */
    public function confirmarEmail($idUsuario) {
        $this->updateById($idUsuario, [
            'ind_email_confirmado' => true
        ]);
    }

    /**
     * Atualiza o nome de um usuário
     *
     * @param $idUsuario Código do Usuario (PK)
     * @param $nome
     * @return void
     */
    public function atualizarNome($idUsuario, $nome) {
        $this->updateById($idUsuario, [
            'name' => $nome
        ]);
    }

    /**
     * Atualiza o email de um usuário
     *
     * @param $idUsuario Código do Usuario (PK)
     * @param $email
     * @return void
     */
    public function atualizarEmail($idUsuario, $email) {
        $this->updateById($idUsuario, [
            'email' => $email
        ]);
    }
}