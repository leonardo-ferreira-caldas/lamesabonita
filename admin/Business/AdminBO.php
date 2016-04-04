<?php

namespace Admin\Business;

use App\Business\MoipBO;
use App\Constants\ChefConstants;
use App\Exceptions\ErrorException;
use App\Exceptions\NotAllowedException;
use App\Exceptions\NotFoundException;
use App\Mappers\RepositoryMapper;
use DB;

class AdminBO
{

    private $repository;
    private $moip;

    public function __construct(RepositoryMapper $repositoryMapper, MoipBO $moip)
    {
        $this->repository = $repositoryMapper;
        $this->moip = $moip;
    }

    /**
     * Valida se é possível excluir uma culinária
     *
     * @param int $idCulinaria
     * @return bool
     */
    public function excluirCulinaria($idCulinaria)
    {
        if (!$this->repository->culinaria->existsById($idCulinaria)) {
            throw new NotFoundException($idCulinaria);
        }

        if ($this->repository->menu_culinaria->getPossuiMenus($idCulinaria) || $this->repository->curso_culinaria->getPossuiCursos($idCulinaria)) {
            throw new NotAllowedException("Não é possível deletar a culinária informada pois ela já está vinculada a outros registros.");
        }

        $this->repository->culinaria->deleteById($idCulinaria);
    }

    /**
     * Valida se é possível excluir um tipo de refeição
     *
     * @param int $idCulinaria
     * @return bool
     */
    public function excluirTipoRefeicao($idCulinaria)
    {
        if (!$this->repository->tipo_refeicao->existsById($idCulinaria)) {
            throw new NotFoundException($idCulinaria);
        }

        if ($this->repository->menu_refeicao->getPossuiMenus($idCulinaria) || $this->repository->curso_refeicao->getPossuiCursos($idCulinaria)) {
            throw new NotAllowedException("Não é possível deletar o evento informado pois ele já está vinculado a outros registros.");
        }

        $this->repository->tipo_refeicao->deleteById($idCulinaria);
    }

    /**
     * Atualiza os dados do Perfil do Chef
     *
     * @param array $dados
     * @throws \Exception
     */
    public function atualizarDadosChef($dados) {
        DB::beginTransaction();

        try {

            $this->repository->chef->atualizarInformacoesPessoais($dados['id_chef'], $dados);
            $this->repository->chef->atualizarLocalizacao($dados['id_chef'], $dados);
            $this->repository->user->atualizarNome($dados['id_chef'], $dados['name']);
            $this->repository->user->atualizarEmail($dados['id_chef'], $dados['email']);

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();

            throw $e;
        }

    }

    /**
     * Insere um novo chef
     *
     * @param array $dados
     * @return null
     */
    public function salvarNovoChef($dados) {
        DB::beginTransaction();

        try {

            if ($this->repository->user->emailExiste($dados['email'])) {
                throw new ErrorException("O email informado para o chef já está sendo usado.");
            }

            $usuario = $this->repository->user->cadastrar([
                'name'     => $dados['name'],
                'email'    => $dados['email'],
                'password' => bcrypt($dados['password']),
                'ind_chef' => true
            ]);

            $moipResponse = $this->moip->efetuarCadastroChef($dados);
            $chef = $this->repository->chef->cadastrar($usuario, $dados, $moipResponse);

            DB::commit();

            return $chef;

        } catch (\Exception $e) {
            DB::rollBack();

            throw $e;
        }

    }
}