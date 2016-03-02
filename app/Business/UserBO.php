<?php

namespace App\Business;

use App\Constants\AvaliacaoConstants;
use App\Exceptions\ErrorException;
use Illuminate\Support\Str;
use App\Facades\Autenticacao;
use App\Handlers\EmailHandler;
use App\Mappers\RepositoryMapper;
use Hash;
use DB;

class UserBO
{

    private $repository;
    private $email;
    private $moip;

    public function __construct(MoipBO $moip, RepositoryMapper $mapper, EmailHandler $email)
    {
        $this->repository = $mapper;
        $this->email = $email;
        $this->moip = $moip;
    }

    /**
     * Reenvia email de confirmação de cadastro para o usuario logado
     *
     * @return void
     */
    public function reenviarEmailConfirmacao()
    {
        $this->email->enviarEmailConfirmacao(Autenticacao::getNome(), Autenticacao::getEmail());
    }

    /**
     * Valida se o token de confirmação de email enviado para o usuário é válido
     *
     * @param $email
     * @param $token
     * @return bool
     */
    public function validarTokenConfirmacaoEmail($email, $token)
    {
        return Hash::check(strrev($email), base64_decode($token));
    }

    /**
     * Confirma o cadastro de um usuario pelo email
     *
     * @return void
     */
    public function confirmarEmail()
    {
        $this->repository->user->confirmarEmail(Autenticacao::getId());

        if (Autenticacao::isChef()) {
            return $this->email->enviarEmailBemVindoChef(Autenticacao::getNome(), Autenticacao::getEmail());
        }

        return $this->email->enviarEmailBemVindoDegustador(Autenticacao::getNome(), Autenticacao::getEmail());
    }

    /**
     * Insere uma nova avaliação para o usuário que está logado
     *
     * @param $dadosAvaliacao
     */
    public function salvarAvaliacao($dadosAvaliacao)
    {
        if (Autenticacao::isChef()) {
            throw new ErrorException("Chef's não podem enviar avaliações.");
        }

        if ($dadosAvaliacao['tipo'] == 'menu') {
            $dadosAvaliacao['fk_tipo_avaliacao'] = AvaliacaoConstants::TIPO_MENU;
        } else {
            $dadosAvaliacao['fk_tipo_avaliacao'] = AvaliacaoConstants::TIPO_CURSO;
        }

        $this->repository->avaliacao->salvar(Autenticacao::getId(), $dadosAvaliacao);
    }

    /**
     * Valida se a senha atual informada é valida
     *
     * @param $senhaAtualInformada
     * @return mixed
     */
    public function validarSenhaAtual($senhaAtualInformada)
    {
        return Hash::check($senhaAtualInformada, Autenticacao::getPassword());
    }

    /**
     * Altera a senha do usuario logado
     *
     * @param string $novaSenha
     * @return void
     */
    public function alterarSenha($senhaAtual, $novaSenha)
    {
        if (!$this->validarSenhaAtual($senhaAtual)) {
            throw new ErrorException("A senha atual informada está errada.");
        }

        $this->repository->user->alterarSenha(Autenticacao::getId(), $novaSenha);
    }

    /**
     * Cadastra um novo usuário no sistema
     *
     * @param $dados
     * @return static
     * @throws \Exception
     */
    public function cadastrar($dados)
    {
        DB::beginTransaction();

        try {

            $dados['ind_chef'] = isset($dados['ind_chef']) && $dados['ind_chef'];
            $usuario = $this->repository->user->cadastrar($dados);

            if ($dados['ind_chef']) {
                $moipResponse = $this->moip->efetuarCadastroChef($dados);
                $chef = $this->repository->chef->cadastrar($usuario, $dados, $moipResponse);

            } else {
                $cliente = $this->repository->cliente->cadastrar($usuario);
            }

            DB::commit();

            $this->email->enviarEmailConfirmacao($usuario->name, $usuario->email);

            return $usuario;

        } catch (\Exception $e) {
            DB::rollBack();

            throw $e;
        }

    }
}