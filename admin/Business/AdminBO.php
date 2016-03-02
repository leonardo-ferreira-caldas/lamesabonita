<?php

namespace Admin\Business;

use App\Constants\ChefConstants;
use App\Exceptions\NotAllowedException;
use App\Exceptions\NotFoundException;
use App\Mappers\RepositoryMapper;
use DB;

class AdminBO
{

    private $repository;

    public function __construct(RepositoryMapper $repositoryMapper)
    {
        $this->repository = $repositoryMapper;
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
            throw new NotAllowedException("Não é possível deletar a refeição informada pois ela já está vinculada a outros registros.");
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
}