<?php

namespace App\Repositories;

use Illuminate\Support\Str;
use App\Constants\CursoConstants;
use App\Facades\Query;
use App\Model\CursoModel;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CursoRepository extends AbstractRepository {

    protected $model = CursoModel::class;

    /**
     * Retorna um curso filtrado pelo slug
     *
     * @param string $slug
     * @param bool $throwNotFoundException
     * @return Model/MenuModel
     */
    public function findBySlug($slug, $throwNotFoundException = false) {
        $curso = $this->findFirst([
            'slug' => $slug
        ]);

        if ($throwNotFoundException && empty($curso)) {
            throw new HttpException(404);
        }

        return $curso;
    }

    /**
     * Atualiza os dados de um curso usando o slug
     *
     * @param string $slug
     * @return void
     */
    public function updateBySlug($slug, $dados) {
        $curso = $this->findBySlug($slug);

        $this->updateById($curso->id_curso, $dados);
    }

    /**
     * Insere um novo curso
     *
     * @param array $dados
     * @param int $idChef
     * @return Model/CursoModel
     */
    public function inserir($idChef, $dados) {
        $curso = $this->create([
            'fk_chef'            => $idChef,
            'slug'               => Str::slug(sprintf("%s-%s", time(), $dados['titulo'])),
            'titulo'             => $dados['titulo'],
            'descricao'          => $dados['descricao'],
            'qtd_maxima_cliente' => $dados['qtd_maxima_cliente'],
            'preco'              => $dados['preco'],
            'ind_ativo'          => true,
            'ind_aguardando_aprovacao' => true
        ]);

        $this->updateById($curso->id_curso, [
            'slug' => Str::slug(sprintf('%s-%s', $curso->id_curso, $dados['titulo']))
        ]);

        return $curso;
    }

    /**
     * Atualiza os dados de um curso
     *
     * @param int $idMenu
     * @param array $dados
     * @return Model/CursoModel
     */
    public function atualizar($idCurso, $dados) {
        $dadosAtualizar = [
            'titulo'             => $dados['titulo'],
            'descricao'          => $dados['descricao'],
            'qtd_maxima_cliente' => $dados['qtd_maxima_cliente'],
            'preco'              => $dados['preco']
        ];

        if (isset($dados['ind_ativo'])) {
            $dadosAtualizar['ind_ativo'] = $dados['ind_ativo'];
        }

        if (isset($dados['fk_status'])) {
            $dadosAtualizar['fk_status'] = $dados['fk_status'];
        }

        $this->updateById($idCurso, $dadosAtualizar);

        return $this->findById($idCurso);
    }

    /**
     * Retorna o status do menu (Ativo|Inativo);
     *
     * @param $slug
     * @return mixed
     */
    public function getCursoStatusBySlug($slug) {
        return (bool) $this->findBySlug($slug)->ind_ativo;
    }

    /**
     * Retorna todos os cursos de um chef
     *
     * @param $idChef
     * @return mixed
     */
    public function getCursosByChefId($idChef) {
        return Query::fetch('Chef/Curso/QryBuscarListaCursosChef', [
            'id_chef' => $idChef,
            'sem_foto' => CursoConstants::SEM_FOTO
        ]);
    }


    /**
     * Retorna os dados de um curso
     *
     * @param $idCurso
     * @return mixed
     */
    public function getDadosCurso($idMenu) {
        return Query::fetchFirst('Chef/Curso/QryBuscarDadosCurso', [
            'id_curso' => $idMenu,
            'sem_foto' => CursoConstants::SEM_FOTO
        ]);
    }

    /**
     * Atualiza o status de um curso (Ativo|Inativo)
     *
     * @param string $slug
     * @param bool $status
     * @return void
     */
    public function atualizarStatus($slug, $status) {
        $this->updateBySlug($slug, [
            'ind_ativo' => $status
        ]);
    }

    /**
     * Atualiza o status de produto de um curso
     *
     * @param string $slug
     * @param int $status
     * @return void
     */
    public function atualizarStatusProduto($slug, $status) {
        $this->updateBySlug($slug, [
            'fk_status' => $status
        ]);
    }

    /**
     * Retorna a quantidade de cursos de um chef
     *
     * @param int $id Código do Chef (PK)
     * @return int
     */
    public function getQuantidadeCursosByChefId($id) {
        return $this->count([
            'fk_chef' => $id
        ]);
    }

    /**
     * Retorna todos os cursos aguardando aprovação
     *
     * @return array
     */
    public function getCursosPorStatus($status) {
        return Query::fetch('Chef/Curso/QryBuscarCursosPorSituacao', [
            'id_status' => $status
        ]);
    }


    /**
     * Retorna todos cursos cadastrados
     *
     * @return array
     */
    public function getTodosCursos() {
        return Query::fetch('Chef/Curso/QryBuscarTodosCursos');
    }

}