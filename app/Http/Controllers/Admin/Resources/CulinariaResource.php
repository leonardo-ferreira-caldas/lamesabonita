<?php

namespace App\Http\Controllers\Admin\Resources;

use Admin\Business\AdminBO;
use App\Repositories\CulinariaRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CulinariaResource extends Controller
{
    private $culinaria;
    private $admin;

    public function __construct(AdminBO $bo, CulinariaRepository $culinaria)
    {
        $this->culinaria = $culinaria;
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
        return view('admin.cadastros.tipo_culinaria.listar');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getBuscarRegistros()
    {
        return $this->culinaria->all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postSalvar(Request $request)
    {
        if ($request->has('id_culinaria')) {
            $registro = $this->culinaria->atualizar($request->get('id_culinaria'), $request->get('nome_culinaria'));
        } else {
            $registro = $this->culinaria->inserir($request->get('nome_culinaria'));
        }

        return redirectWithAlertSuccess('A culinária foi salva com sucesso.')->route('cadastro.tipo_culinaria.editar', ['id' => $registro->id_culinaria]);
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

        $registro = $this->culinaria->findById($request->get('id'));

        if (empty($registro)) {
            return $this->getList();
        }

        return view('admin.cadastros.tipo_culinaria.formulario', [
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
        return view('admin.cadastros.tipo_culinaria.formulario');
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

        $this->admin->excluirCulinaria($request->get('id'));

        return redirectWithAlertSuccess('Culinária deletada com sucesso!')->route('cadastro.tipo_culinaria.listar');
    }
}
