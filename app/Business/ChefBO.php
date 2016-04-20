<?php

namespace App\Business;

use App\Facades\Email;
use DB;
use App\Constants\ChefConstants;
use App\Exceptions\UnexpectedErrorException;
use App\Facades\Autenticacao;
use App\Facades\Upload;
use App\Formatters\DataFormatter;
use App\Formatters\Vector;
use App\Mappers\RepositoryMapper;
use App\Utils\Alert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Carbon\Carbon;
use Hash;
use Exception;
use App\Facades\Query;

class ChefBO {

    private $repository;

    public function __construct(RepositoryMapper $mapper)
    {
        $this->repository = $mapper;
    }

    /**
     * Altera a foto de perfil do chef logado
     *
     * @param UploadedFile $file
     * @param int $idChef
     * @throws UnexpectedErrorException
     * @return void
     */
    public function alterarFotoCapa(UploadedFile $file, $idChef = null) {

        try {

            $idChef = $idChef ?: Autenticacao::getId();

            $chef = $this->repository->chef->findById($idChef);

            $fotoCapa = Upload::salvar($file, 'foto-capa');

            $this->repository->chef->updateById($idChef, [
                'foto_capa' => $fotoCapa
            ]);

            Upload::deletar($chef->foto_capa);

        } catch (Exception $e) {
            throw new UnexpectedErrorException;
        }

    }

    /**
     * Altera foto de perfil do chef logado
     *
     * @param UploadedFile $file
     * @param int $idChef
     * @throws UnexpectedErrorException
     * @return void
     */
    public function alterarFotoPerfil(UploadedFile $file, $idChef = null) {

        try {

            $idChef = $idChef ?: Autenticacao::getId();

            $chef = $this->repository->chef->findById($idChef);

            $fotoPerfil = Upload::salvar($file, 'foto-perfil');

            $this->repository->chef->updateById($idChef, [
                'avatar' => $fotoPerfil
            ]);

            Upload::deletar($chef->avatar);

        } catch (Exception $e) {
            throw new UnexpectedErrorException;
        }

    }

    /**
     * Atualiza os dados de localização do chef logado
     *
     * @param $dadosLocalizacao
     * @throws UnexpectedErrorException
     */
    public function atualizarLocalizacao($dadosLocalizacao) {

        try {
            $this->repository->chef->atualizarLocalizacao(Autenticacao::getId(), $dadosLocalizacao);
        } catch (Exception $e) {
            throw new UnexpectedErrorException;
        }

    }

    /**
     * Atualiza informaçoes pessoais do chef logado
     *
     * @param $dadosRequisicao
     * @throws UnexpectedErrorException
     */
    public function atualizarInformacoesPessoais($dadosRequisicao) {

        DB::beginTransaction();

        try {

            $this->repository->user->atualizarNome(Autenticacao::getId(), $dadosRequisicao['name']);

            $this->repository->chef->atualizarInformacoesPessoais(Autenticacao::getId(), $dadosRequisicao);

            DB::commit();

        } catch (Exception $excpt) {
            DB::rollBack();
            throw new UnexpectedErrorException;
        }

    }
    
    /**
     * Retorna o saldo disponivel do chef logado
     *
     * @return float
     */
    public function getSaldoChefLogado() {
        return $this->repository->chef->getSaldo(Autenticacao::getId());
    }

    /**
     * Retorna as informações de agenda do chef logado
     *
     * @return array
     */
    public function getAgendaCalendarioChefLogado() {
        return $this->repository->chef_agenda->getAgendaCalendario(Autenticacao::getId());
    }


    public function obterListaPendenciasAprovacaoPerfil() {
        $pendencias = [];

        if (!$this->repository->chef_status->cadastrouAvatar()) {
            $pendencias[] = "Altere sua foto de perfil.";
        }

        if (!$this->repository->chef_status->cadastrouFotoCapa()) {
            $pendencias[] = "Altere sua foto de capa/fundo do perfil.";
        }

        if (!$this->repository->chef_status->cadastrouInformacoesPessoais()) {
            $pendencias[] = "Preencha suas informações pessoais.";
        }

        if (!$this->repository->chef_status->cadastrouDadosBancarios()) {
            $pendencias[] = "Preencha seus dados bancários.";
        }

        if (!$this->repository->chef_status->cadastrouLocalizacao()) {
            $pendencias[] = "Preencha os dados da sua localização.";
        }

        if (!$this->repository->chef_status->cadastrouMenuOuCurso()) {
            $pendencias[] = "Castastre pelo menos dois menus e/ou dois cursos).";
        }

        return $pendencias;

    }

    /**
     * Verifica se o chef logado já pode solicitar a aprovação do perfil
     *
     * @return bool
     */
    public function podeSolicitarAprovacao() {
        return $this->repository->chef_status->finalizouCadastroPerfil();
    }

    /**
     * Verifica se o status de perfil do chef logado está aguardando finalização do perfil
     *
     * @return bool
     */
    public function perfilAguardandoCadastro() {
        return $this->repository->chef->getStatusPerfil(Autenticacao::getId()) == ChefConstants::STATUS_AGUARDANDO_FINALIZACAO_PERFIL;
    }

    /**
     * Verifica se o status de perfil do chef logado está em analise
     *
     * @return bool
     */
    public function perfilEmAnalise() {
        return $this->repository->chef->getStatusPerfil(Autenticacao::getId()) == ChefConstants::STATUS_AGUARDANDO_APROVACAO;
    }

    /**
     * Verifica se o status de perfil do chef logado está reprovado
     *
     * @return bool
     */
    public function perfilReprovado() {
        return $this->repository->chef->getStatusPerfil(Autenticacao::getId()) == ChefConstants::STATUS_REPROVADO;
    }

    /**
     * Verifica se o status de perfil do chef logado está aprovado
     *
     * @return bool
     */
    public function perfilAprovado() {
        return $this->repository->chef->getStatusPerfil(Autenticacao::getId()) == ChefConstants::STATUS_ATIVO;
    }

    /**
     * Verifica se o chef logado já possui o selo LMB
     *
     * @return bool
     */
    public function jaPossuiSeloLMB() {
        return $this->repository->chef->getStatusSeloLMB(Autenticacao::getId()) == ChefConstants::SELO_APROVADO;
    }

    /**
     * Verifica se o chef logado já solicitou o selo LMB
     *
     * @return bool
     */
    public function jaSolicitouSeloLMB() {
        return $this->repository->chef->getStatusSeloLMB(Autenticacao::getId()) != ChefConstants::SELO_NAO_POSSUI;
    }

    /**
     * Aprova o perfil de um chef
     *
     * @param string $slug
     * @throws Exception
     * @return bool
     */
    public function aprovarPerfil($slug) {
        DB::beginTransaction();

        try {

            $chef = $this->repository->chef->findBySlug($slug);

            // Caso o status do chef seja diferente de aguardando aprovação
            if ($chef->fk_status != ChefConstants::STATUS_AGUARDANDO_APROVACAO) {
                return false;
            }

            $this->repository->chef->atualizarStatusPerfil($chef->id_chef, ChefConstants::STATUS_ATIVO);
            Email::enviarEmailPerfilAprovado($chef->user->name, $chef->user->email);

            DB::commit();

        } catch (Exception $e) {

            DB::rollBack();

            throw new UnexpectedErrorException;

        }

    }

    /**
     * Reprova o perfil de um chef
     *
     * @param $slug
     * @return bool
     */
    public function reprovarPerfil($slug) {
        DB::beginTransaction();

        try {

            $chef = $this->repository->chef->findBySlug($slug);

            // Caso o status do chef seja diferente de aguardando aprovação
            if ($chef->fk_status != ChefConstants::STATUS_AGUARDANDO_APROVACAO) {
                return false;
            }

            $this->repository->chef->atualizarStatusPerfil($chef->id_chef, ChefConstants::STATUS_REPROVADO);
            Email::enviarEmailPerfilReprovado($chef->user->name, $chef->user->email);

            DB::commit();

        } catch (Exception $e) {

            DB::rollBack();

            throw new UnexpectedErrorException;

        }

    }

    /**
     * Solicita a aprovação do perfil do chef logado
     *
     * @throws UnexpectedErrorException
     * @return void
     */
    public function solicitarAprovacaoPerfil() {
        DB::beginTransaction();

        try {

            $this->repository->chef->atualizarStatusPerfil(Autenticacao::getId(), ChefConstants::STATUS_AGUARDANDO_APROVACAO);
            Email::enviarEmailSolicitacaoAprovacao(Autenticacao::getNome(), Autenticacao::getEmail());
            DB::commit();

        } catch (Exception $e) {

            DB::rollBack();
            throw new UnexpectedErrorException;

        }

    }

    /**
     * Solicita o selo LMB para o chef logado
     *
     * @throws UnexpectedErrorException
     * @return void
     */
    public function solicitarSeloLMB() {
        DB::beginTransaction();

        try {

            $this->repository->chef->atualizarStatusSeloLMB(Autenticacao::getId(), ChefConstants::SELO_SOLICITOU);
            Email::enviarEmailSolicitacaoSeloLMB(Autenticacao::getNome(), Autenticacao::getEmail());

            DB::commit();

        } catch (Exception $e) {
            DB::rollBack();
            throw new UnexpectedErrorException;
        }

    }

    /**
     * Obtem as informações pessoais do chef logado
     *
     * @return array
     */
    public function getDadosChef() {
        return Vector::stdClassToArray($this->repository->chef->getDadosVisaoGeral(Autenticacao::getId()));
    }

    /**
     * Obtem os dados de localizacao do chef logado
     *
     * @return array
     */
    public function getLocalizacao() {
        $dadosChef = $this->repository->chef->findById(Autenticacao::getId());

        return [
            'pais'              => $dadosChef->fk_pais,
            'estado'            => $dadosChef->fk_estado,
            'bairro'            => $dadosChef->bairro,
            'cidade'            => $dadosChef->fk_cidade,
            'logradouro'        => $dadosChef->logradouro,
            'logradouro_numero' => $dadosChef->logradouro_numero,
            'cep'               => $dadosChef->cep
        ];
    }

    /**
     * Obtem array com informações discretas para preenchimento de comboboxes
     *
     * @return array
     */
    public function buscarInformacoesDiscretas() {

        $cidades = [];
        $dadosChef = $this->repository->chef->findById(Autenticacao::getId());

        if (!empty($dadosChef)) {
            $cidades = $this->repository->geo->filtrarCidades($dadosChef->fk_estado);
        }

        return [
            'paises'  => $this->repository->geo->listarPaises(),
            'estados' => $this->repository->geo->listarEstados(),
            'cidades' => $cidades,
            'sexos'   => $this->repository->sexo->all()
        ];
    }

    /**
     * Retorna horário disponível para reserva do chef em uma data especifica
     *
     * @param $slugChef
     * @param $data
     * @return array
     */
    public function getHorariosAgendaPorData($slug, $data) {
        $chef = $this->repository->chef->findBySlug($slug);

        if (empty($chef)) {
            return [];
        }

        $horario = $this->repository->chef_agenda->getHorarioPorData($chef->id_chef, DataFormatter::formatarDataEN($data));

        if (empty($horario)) {
            return [];
        }

        $horarios = [];
        $horaDe = Carbon::createFromFormat('H:i:s', $horario->hora_de);
        $horaAte = Carbon::createFromFormat('H:i:s', $horario->hora_ate);

        do {
            $horarios[] = $horaDe->format('H:i');
            $horaDe->addMinutes(30);
        } while($horaDe->toTimeString() <= $horaAte->toTimeString());

        return $horarios;
    }

    /**
     * Adiciona saldo a conta do chef
     *
     * @param int $idChef
     * @param float $valor
     *
     * @return NULL
     */
    public function adicionarSaldo($idChef, $valor) {
        $this->repository->chef->adicionarSaldo($idChef, $valor);

    }

    /**
     * Busca os status do que ja foi preenchido no perfil do chef
     *
     * @return array
     */
    public function getStatusPreenchimentoPerfilChefLogado() {
        $chef   = $this->repository->chef->findById(Autenticacao::getId());
        $menus  = $this->repository->menu->getMenusByChefId(Autenticacao::getId());
        $cursos = $this->repository->curso->getCursosByChefId(Autenticacao::getId());
        $contas = $this->repository->conta_bancaria->getQuantidadeContasBancariasByChefId(Autenticacao::getId());

        return [

            'informacoes_pessoais' => !empty($chef->fk_estado)
                && !empty($chef->fk_pais)
                && !empty($chef->fk_cidade)
                && !empty($chef->bairro)
                && !empty($chef->cep)
                && !empty($chef->logradouro)
                && !empty($chef->logradouro_numero),

            'localizacao' => !empty($chef->data_nascimento)
                && !empty($chef->rg)
                && !empty($chef->cpf)
                && !empty($chef->telefone)
                && !empty($chef->sobre_chef)
                && !empty($chef->fk_sexo),

            'avatar' => $chef->avatar != ChefConstants::DEFAULT_AVATAR,

            'foto_capa' => $chef->foto_capa != ChefConstants::DEFAULT_CAPA,

            'menu' => count($menus),

            'curso' => count($cursos),

            'contas_bancarias' => $contas > 0

        ];


    }

}