<?php

namespace App\Http\Controllers\Admin\Resources;

use Admin\Business\AdminBO;
use App\Repositories\TipoRefeicaoRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class TipoRefeicaoResource extends Controller
{
    private $tipo_refeicao;
    private $admin;

    public function __construct(AdminBO $bo, TipoRefeicaoRepository $tipoRefeicao)
    {
        $this->tipo_refeicao = $tipoRefeicao;
        $this->admin = $bo;
        $this->middleware('guest_admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getListar()
    {
        return view('admin.cadastros.tipo_refeicao.listar');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getBuscarRegistros()
    {
        return $this->tipo_refeicao->all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postSalvar(Request $request)
    {
        if ($request->has('id_tipo_refeicao')) {
            $registro = $this->tipo_refeicao->atualizar($request->get('id_tipo_refeicao'), $request->get('nome_tipo_refeicao'));
        } else {
            $registro = $this->tipo_refeicao->inserir($request->get('nome_tipo_refeicao'));
        }

        return redirectWithAlertSuccess('O evento foi salvo com sucesso.')
            ->route('cadastro.tipo_refeicao.editar', ['id' => $registro->id_tipo_refeicao]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getEditar(Request $request)
    {
        if (!$request->has('id')) {
            return $this->getListar();
        }

        $registro = $this->tipo_refeicao->findById($request->get('id'));

        if (empty($registro)) {
            return $this->getList();
        }

        return view('admin.cadastros.tipo_refeicao.formulario', [
            'registro' => $registro
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getInserir()
    {
        return view('admin.cadastros.tipo_refeicao.formulario');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getDeletar(Request $request)
    {
        if (!$request->has('id')) {
            return $this->getListar();
        }

        $this->admin->excluirTipoRefeicao($request->get('id'));

        return redirectWithAlertSuccess('O evento foi deletado com sucesso!')->route('cadastro.tipo_refeicao.listar');
    }
}
