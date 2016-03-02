<?php

namespace App\Http\Controllers\Admin\Resources;

use Admin\Business\AdminBO;
use App\Repositories\InclusoPrecoRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class InclusoPrecoResource extends Controller
{
    private $incluso_preco;
    private $admin;

    public function __construct(AdminBO $bo, InclusoPrecoRepository $incluso)
    {
        $this->incluso_preco = $incluso;
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
        return view('admin.cadastros.incluso_preco.listar');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getBuscarRegistros()
    {
        return $this->incluso_preco->getListarTodos();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postSalvar(Request $request)
    {
        if ($request->has('id_incluso_preco')) {
            $registro = $this->incluso_preco->atualizar(
                $request->get('id_incluso_preco'),
                $request->get('descricao'),
                $request->get('fk_tipo'));
        } else {
            $registro = $this->incluso_preco->inserir($request->get('descricao'), $request->get('fk_tipo'));
        }

        return redirectWithAlertSuccess('O item incluso no preço foi salvo com sucesso.')
            ->route('cadastro.incluso_preco.editar', ['id' => $registro->id_incluso_preco]);
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

        $registro = $this->incluso_preco->findById($request->get('id'));

        if (empty($registro)) {
            return $this->getList();
        }

        return view('admin.cadastros.incluso_preco.formulario', [
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
        return view('admin.cadastros.incluso_preco.formulario');
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

        $this->incluso_preco->deleteById($request->get('id'));

        return redirectWithAlertSuccess('Item deletado com sucesso!')->back();
    }
}
