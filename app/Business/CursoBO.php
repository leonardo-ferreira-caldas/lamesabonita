<?php

namespace App\Business;

use Exception;
use App\Constants\ChefConstants;
use App\Exceptions\UnexpectedErrorException;
use App\Facades\Autenticacao;
use App\Facades\Upload;
use App\Handlers\EmailHandler;
use App\Mappers\RepositoryMapper;
use Symfony\Component\HttpKernel\Exception\HttpException;
use DB;

class CursoBO {

    private $repository;
    private $email;

    public function __construct(RepositoryMapper $repository, EmailHandler $email)
    {
        $this->repository   = $repository;
        $this->email  = $email;
    }

    /**
     * Verifica se um curso especifico está ativo
     *
     * @param $slugCurso
     * @return bool
     */
    public function isCursoAtivo($slug) {
        return $this->repository->curso->getCursoStatusBySlug($slug);
    }

    /**
     * Altera o status de um curso para ativo
     *
     * @param string $slug
     * @return void
     */
    public function ativarCurso($slug) {
        $this->repository->curso->atualizarStatus($slug, true);
    }

    /**
     * Altera o status de um curso para inativo
     *
     * @param string $slug
     * @return void
     */
    public function inativarCurso($slug) {
        $this->repository->curso->atualizarStatus($slug, false);
    }

    /**
     * Retorna quantos cursos o chef logado tem cadastrado
     *
     * @return mixed
     */
    public function getQuantidadeCursosChefLogado() {
        return $this->repository->curso->getQuantidadeCursosByChefId(Autenticacao::getId());
    }

    /**
     * Retorna lista de itens incluso no preço para cursos
     *
     * @return array
     */
    public function getInclusoPreco() {
        return $this->repository->incluso_preco->getListaInclusoPreco(ChefConstants::INCLUSO_PRECO_CURSO);
    }

    /**
     * Retorna lista de combos para o formulário de inserção/edição de curso
     *
     * @return array
     */
    public function getCombosFormulario() {
        return [
            'culinarias'    => $this->repository->culinaria->getListaCulinarias(),
            'incluso_preco' => $this->getInclusoPreco(),
            'tipo_refeicao' => $this->repository->tipo_refeicao->getListaRefeicoes()
        ];
    }

    /**
     * Busca dados de um curso para edição
     *
     * @param int $idMenu
     * @return array
     */
    public function getDadosCursoFormulario($idMenu) {
        return $this->repository->curso->findById($idMenu, ['precos', 'culinarias', 'refeicoes', 'imagens']);
    }

    /**
     * Retorna todos os curso do chef logado
     *
     * @return collection of MenuModel
     */
    public function getCursosChefLogado() {
        return $this->repository->curso->getCursosByChefId(Autenticacao::getId());
    }

    /**
     * Insere/Atualiza um novo curso
     *
     * @param array $dados
     * @return void
     */
    public function salvar($dados) {

        DB::beginTransaction();

        try {

            if (empty($dados['id_curso'])) {
                $curso = $this->repository->curso->inserir(Autenticacao::getId(), $dados);
            } else {
                $curso = $this->repository->curso->atualizar($dados['id_curso'], $dados);
            }

            $this->repository->curso_refeicao->deletarByCursoId($curso->id_curso);
            $this->repository->curso_culinaria->deletarByCursoId($curso->id_curso);

            foreach ($dados['tipo_refeicao'] as $idTipoRefeicao) {
                $this->repository->curso_refeicao->inserir($curso->id_curso, $idTipoRefeicao);
            }

            foreach ($dados['tipo_culinaria'] as $idCulinaria) {
                $this->repository->curso_culinaria->inserir($curso->id_curso, $idCulinaria);
            }

            if (isset($dados['curso_foto'])) {
                foreach ($dados['curso_foto'] as $foto) {
                    if (!empty($foto)) {
                        $nomeArquivo = Upload::salvar($foto, 'foto_curso');
                        $imagemInserida = $this->repository->curso_imagem->inserir($curso->id_curso, $nomeArquivo);

                        if (!isset($primeiraImagemEnviada)) {
                            $primeiraImagemEnviada = clone $imagemInserida;
                        }
                    }
                }
            }

            if (isset($primeiraImagemEnviada) && !$this->repository->curso_imagem->possuiFotoCapa($curso->id_curso)) {
                $this->repository->curso_imagem->atualizarFotoCapa($curso->id_curso, $imagemInserida->id_curso_imagem);
            }

            DB::commit();

        } catch (Exception $e) {
            DB::rollBack();
            Upload::rollback();

            throw $e;

            throw new UnexpectedErrorException;
        }

    }

    /**
     * Deleta uma imagem de um curso
     *
     * @param int $idCurso
     * @param int $idCursoImagem
     * @return void
     */
    public function deletarImagem($idCurso, $idCursoImagem) {

        $curso = $this->repository->curso->findById($idCurso);

        if ($curso->fk_chef != Autenticacao::getId()) {
            throw new HttpException(403, 'Acesso negado.');
        }

        $imagem = $this->repository->curso_imagem->findById($idCursoImagem);
        $this->repository->curso_imagem->deleteById($idCursoImagem);

        Upload::deletar($imagem->nome_imagem);

    }

    /**
     * Define uma imagem do curso como capa
     *
     * @param $idCurso
     * @param $idCursoImagem
     * @throws HttpException
     */
    public function definirComoCapa($idCurso, $idCursoImagem) {

        $curso = $this->repository->curso->findById($idCurso);

        if ($curso->fk_chef != Autenticacao::getId()) {
            throw new HttpException(403, 'Acesso negado.');
        }

        $this->repository->curso_imagem->atualizarFotoCapa($idCurso, $idCursoImagem);

    }

}