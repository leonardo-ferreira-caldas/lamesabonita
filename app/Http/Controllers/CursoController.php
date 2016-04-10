<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Mappers\BusinessMapper;
use App\Mappers\RepositoryMapper;
use Exception;
use App\Structures\ProximaRota;

class CursoController extends Controller
{

    private $repository;
    private $bo;

    public function __construct(RepositoryMapper $mapper, BusinessMapper $businessMapper) {
        parent::__construct();
        $this->middleware('chef');
        $this->middleware("email_confirmacao");

        $this->repository = $mapper;
        $this->bo = $businessMapper;
    }

    /**
     * Carrega view que lista todos os cursos do chef logado
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getListagemCursos() {
        return view('chef.cursos.listar', [
            'page'   => 'cursos',
            'cursos' => $this->bo->curso->getCursosChefLogado()
        ]);
    }

    /**
     * Carrega view para inserir um novo curso
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getNovoCurso() {
        return view('chef.cursos.formulario_inserir', [
            'page' => 'cursos',
            'combos' => $this->bo->curso->getCombosFormulario()
        ]);
    }

    /**
     * Carrega view para editar um curso
     *
     * @param $idCurso
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getEditarCurso($idCurso) {
        return view('chef.cursos.formulario', [
            'page'   => 'cursos',
            'curso'  => $this->bo->curso->getDadosCursoFormulario($idCurso),
            'combos' => $this->bo->curso->getCombosFormulario()
        ]);
    }

    public function getInativarCurso($slug) {
        if (!$this->bo->cursoBO->isCursoAtivo($slug)) {
            Alert::info("Informação", "O curso já está inativo.");
            return redirect()->back();
        }
        $this->bo->cursoBO->inativarCurso($slug);
        Alert::success("Sucesso", "O curso foi inativado.");
        return redirect()->back();
    }

    public function getAtivarCurso($slug) {
        if ($this->bo->cursoBO->isCursoAtivo($slug)) {
            Alert::info("Informação", "O curso já está ativo.");
            return redirect()->back();
        }
        $this->bo->cursoBO->ativarCurso($slug);
        Alert::success("Sucesso", "O curso foi ativado.");
        return redirect()->back();
    }

    /**
     * Deleta uma imagem do curso informado
     *
     * @param int $idCurso
     * @param int $idImagemCurso
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getDeletarFotoCurso($idCurso, $idImagemCurso) {
        $this->bo->curso->deletarImagem($idCurso, $idImagemCurso);
        return redirectWithAlertSuccess('A foto/imagem do curso foi removida.')->back();
    }

    /**
     * Define a imagem informada como capa
     *
     * @param int $idCurso
     * @param int $idImagemCurso
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getDefinirComoCapa($idCurso, $idImagemCurso) {
        $this->bo->curso->definirComoCapa($idCurso, $idImagemCurso);
        return redirectWithAlertSuccess('A foto/imagem do curso foi definida como capa.')->back();
    }

    /**
     * Salva os dados do curso
     *
     * @param Requests\SalvarCursoRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postSalvar(Requests\SalvarCursoRequest $request) {
        try {

            $result = $this->bo->curso->salvar($request->all());

            $proximaRota = new ProximaRota('O curso foi salvo com sucesso.', 'cursos.listar');
            $proximaRota->setAjax($request->ajax());

            return $proximaRota->getResponse();

        } catch (Exception $e) {
            $request->flash();

            return redirectWithAlertError($e->getMessage())->back();
        }
    }

}

