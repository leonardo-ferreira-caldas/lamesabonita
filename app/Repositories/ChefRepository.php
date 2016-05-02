<?php

namespace App\Repositories;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Str;
use App\Constants\ChefConstants;
use App\Facades\Autenticacao;
use App\Facades\Query;
use App\Formatters\DataFormatter;
use App\Formatters\String;
use App\Model\ChefContaBancaria;
use App\Model\ChefModel;
use DB;
use App\User;
use App\Utils\Utils;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Exception\MissingMandatoryParametersException;

class ChefRepository extends AbstractRepository {

    protected $model = ChefModel::class;

    private $status;
    private $chef;
    private $contaBancaria;

    public function __construct(ChefModel $chef, ChefStatusRepository $status, ChefContaBancaria $contaBancaria) {
        $this->status  = $status;
        $this->contaBancaria  = $contaBancaria;
        $this->chef    = $chef;
        parent::__construct();
    }

    /**
     * Cadastra um novo chef
     *
     * @param User $usuario
     * @param array $dados
     * @param array $moip
     *
     * @return ChefModel
     */
    public function cadastrar(User $usuario, $dados, $moip) {
        $slug = Str::slug(sprintf("%s-%s", $usuario->id, $usuario->name));
        $slug = rtrim($slug, '-');

        return $this->create([
            'id_chef'           => $usuario->id,
            'telefone'          => $dados['telefone'],
            'cep'               => String::removerMascaraCEP($dados['cep']),
            'cpf'               => String::removerMascaraCPF($dados['cpf']),
            'fk_sexo'           => $dados['fk_sexo'],
            'fk_estado'         => $dados['fk_estado'],
            'fk_cidade'         => $dados['fk_cidade'],
            'fk_pais'           => "BR",
            'logradouro'        => $dados['logradouro'],
            'logradouro_numero' => $dados['logradouro_numero'],
            'bairro'            => $dados['bairro'],
            'data_nascimento'   => DataFormatter::formatarDataEN($dados['data_nascimento']),
            'sobrenome'         => $dados['sobrenome'],
            'fk_status'         => ChefConstants::STATUS_AGUARDANDO_FINALIZACAO_PERFIL,
            'fk_selo_status'    => ChefConstants::SELO_NAO_POSSUI,
            'slug'              => $slug,
            'avatar'            => ChefConstants::DEFAULT_AVATAR,
            'foto_capa'         => ChefConstants::DEFAULT_CAPA,
            "moip_id"           => $moip['moip_id'],
            "moip_access_token" => $moip['moip_access_token'],
            "moip_login"        => $moip['moip_login'],
            "moip_created_at"   => $moip['moip_created_at']
        ]);
    }

    /**
     * Atualiza as informações pessoais do chef
     *
     * @param array $dados
     * @return void
     */
    public function atualizarInformacoesPessoais($idChef, $dados) {
        $this->updateById($idChef, [
            'telefone'          => $dados['telefone'],
            'data_nascimento'   => DataFormatter::formatarDataEN($dados['data_nascimento']),
            'sobrenome'         => $dados['sobrenome'],
            'fk_sexo'           => $dados['fk_sexo'],
            'rg'                => $dados['rg'],
            'sobre_chef'        => $dados['sobre_chef'],
            'cpf'               => String::removerMascaraCPF($dados['cpf'])
        ]);
    }

    /**
     * Atualiza as informações de localização do chef
     *
     * @param array $dados
     * @return void
     */
    public function atualizarLocalizacao($idChef, $dados) {
        $this->updateById($idChef, [
            'cep'               => String::removerMascaraCEP($dados['cep']),
            'fk_estado'         => $dados['fk_estado'],
            'fk_cidade'         => $dados['fk_cidade'],
            'fk_pais'           => "BR",
            'logradouro'        => $dados['logradouro'],
            'logradouro_numero' => $dados['logradouro_numero'],
            'bairro'            => $dados['bairro']
        ]);
    }

    /**
     * Retorna os daods de um chef usando o slug como filtro
     *
     * @param string $slug
     * @param bool $throwNotFoundException
     * @return Model/ChefModel
     */
    public function findBySlug($slug, $throwNotFoundException = false) {
        $chef = $this->findFirst([
            'slug' => $slug
        ]);

        if ($throwNotFoundException && empty($chef)) {
            throw new HttpException(404);
        }

        return $chef;
    }

    /**
     * Atualiza o status do selo LMB de um chef
     *
     * @param $id
     * @param $status
     * @retorn void
     */
    public function atualizarStatusSeloLMB($id, $status) {
        $this->updateById($id, [
            'fk_selo_status' => $status
        ]);
    }

    /**
     * Atualiza o status de um chef
     *
     * @param $id
     * @param $status
     * @return void
     */
    public function atualizarStatusPerfil($id, $status) {
        $this->updateById($id, [
            'fk_status' => $status
        ]);
    }

    /**
     * Retorna o status do selo lmb de um chef
     *
     * @param int $id Código do Chef (PK)
     * @return int
     */
    public function getStatusSeloLMB($id) {
        return $this->findById($id)->fk_selo_status;
    }

    /**
     * Retrna o status do perfil de um chef
     *
     * @param int $id Código do Chef (PK)
     * @return int
     */
    public function getStatusPerfil($id) {
        return $this->findById($id)->fk_status;
    }


    /**
     * Busca o saldo de um chef
     *
     * @param int $idChef
     * @return float
     */
    public function getSaldo($idChef) {
        return $this->findById($idChef)->saldo;
    }

    /**
     * Retorna o access token de um chef
     *
     * @param int $idChef
     * @return string
     */
    public function getAccessToken($idChef) {
        return $this->findById($idChef)->moip_access_token;
    }

    /**
     * Retorna os dados de visão geral de umchef
     *
     * @param int $id Código do Chef (PK)
     * @return stdClass
     */
    public function getDadosVisaoGeral($id) {
        return Query::fetchFirst("Chef/VisaoGeral/QryBuscarDadosVisaoGeral", [
            'avatar' => ChefConstants::DEFAULT_AVATAR,
            'foto_capa' => ChefConstants::DEFAULT_CAPA,
            'id' => $id
        ]);
    }

    /**
     * Retorna todos os chefs cadastrados
     *
     * @param int $id Código do Chef (PK)
     * @return stdClass
     */
    public function getTodosChefs() {
        return Query::fetch("Chef/VisaoGeral/QryListarTodosChefs", [
            'avatar' => ChefConstants::DEFAULT_AVATAR
        ]);
    }

    /**
     * Retorna todos os chefs de um status
     *
     * @param int $id Código do Chef (PK)
     * @return stdClass
     */
    public function getChsfsByStatus($status) {
        return Query::fetch("Chef/VisaoGeral/QryListarTodosChefs", [
            'avatar' => ChefConstants::DEFAULT_AVATAR,
            'id_status' => $status
        ]);
    }

    /**
     * Adiciona saldo em uma conta de chef
     *
     * @param $id
     * @param $saldo
     */
    public function adicionarSaldo($id, $saldo) {
        Query::update("Chef/Saque/UpdAdicionarSaldo", [
            'id'    => $id,
            'saldo' => $saldo
        ]);
    }

}