<?php

namespace App\Http\Controllers\Admin\Resources;

use Admin\Business\AdminBO;
use App\Business\CursoBO;
use App\Constants\ProdutoStatusContants;
use App\Facades\Upload;
use App\Mappers\RepositoryMapper;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CursoResource extends Controller
{
    private $repository;
    private $admin;
    private $curso;

    public function __construct(AdminBO $bo, CursoBO $curso, RepositoryMapper $mapper)
    {
        $this->repository = $mapper;
        $this->admin = $bo;
        $this->curso = $curso;
        $this->middleware('guest_admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getListar()
    {
        return view('admin.cursos.listar', [
            'status' => $this->repository->produto_status->all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getBuscarRegistros()
    {
        return $this->repository->curso->getTodosCursos();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postSalvar(Request $request)
    {
        if (!$request->has('id_curso')) {
            return redirectWithAlertError("Código do curso não informado.");
        }

        $this->curso->salvar($request->all());

        return redirectWithAlertSuccess('Os dados do curso foram salvos com sucesso.')->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getEditar($slug)
    {
        $curso = $this->repository->curso->findBySlug($slug, true);
        $imagens = $this->repository->curso_imagem->getImagens($curso->id_curso);
        $cursoCulinaria = $this->repository->curso_culinaria->getCulinarias($curso->id_curso);
        $cursoRefeicao = $this->repository->curso_refeicao->getRefeicoes($curso->id_curso);
        $cursoPreco = $this->repository->curso_preco->getPrecosPorConvidado($curso->id_curso);
        $refeicoes = $this->repository->tipo_refeicao->all();
        $culinarias = $this->repository->culinaria->all();
        $status = $this->repository->produto_status->all();

        return view('admin.cursos.formulario', [
            'curso'             => $curso,
            'curso_culinarias'  => $cursoCulinaria,
            'curso_refeicoes'   => $cursoRefeicao,
            'curso_preco'       => $cursoPreco,
            'imagens'           => $imagens,
            'refeicoes'         => $refeicoes,
            'culinarias'        => $culinarias,
            'status'            => $status
        ]);
    }

    /**
     * Aprova um curso
     *
     * @param string $slug
     * @return RedirectResponse
     */
    public function getAprovar($slug) {

        $this->repository->curso->atualizarStatusProduto($slug, ProdutoStatusContants::STATUS_APROVADO);

        return redirectWithAlertSuccess('Curso aprovado com sucesso!')->back();
    }

    /**
     * Reprova um curso
     *
     * @param string $slug
     * @return RedirectResponse
     */
    public function getReprovar($slug) {

        $this->repository->curso->atualizarStatusProduto($slug, ProdutoStatusContants::STATUS_REPROVADO);

        return redirectWithAlertSuccess('Curso reprovado com sucesso!')->back();
    }

    /**
     * Deleta uma imagem do curso
     *
     * @param int $idCursoImagem
     */
    public function getDeletarImagem($idCursoImagem) {

        $imagem = $this->repository->curso_imagem->findById($idCursoImagem);

        $this->repository->curso_imagem->deleteById($idCursoImagem);

        Upload::deletar($imagem->nome_imagem);

        $this->repository->curso_imagem->atualizarPrimeiraFotoComoCapa($imagem->fk_curso);

        return redirectWithAlertSuccess('Foto deletada com sucesso.')->back();
    }

    /**
     * Define uma imagem do curso como capa
     *
     * @param int $idCursoImagem
     */
    public function getDefinirCapa($idCursoImagem) {

        $imagem = $this->repository->curso_imagem->findById($idCursoImagem);

        $this->repository->curso_imagem->atualizarFotoCapa($imagem->fk_curso, $idCursoImagem);

        return redirectWithAlertSuccess('Foto definida como capa com sucesso.')->back();
    }

}
