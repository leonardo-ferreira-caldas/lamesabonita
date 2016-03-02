<?php

namespace App\Http\Controllers\Admin\Resources;

use App\Mappers\RepositoryMapper;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ContaBancariaResource extends Controller
{
    private $repository;

    public function __construct(RepositoryMapper $repositoryMapper)
    {
        $this->repository = $repositoryMapper;
        $this->middleware('guest_admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getListar()
    {
        return view('admin.conta_bancaria.listar', [
            'bancos' => $this->repository->banco->all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getBuscarRegistros()
    {
        return $this->repository->conta_bancaria->getTodasContasBancarias();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postSalvar(Request $request)
    {
        if (!$request->has('id_conta_bancaria')) {
            return redirectWithAlertError("Código da conta bancária não informado.")->back();
        }

        $this->repository->conta_bancaria->atualizarContaBancaria($request->get('id_conta_bancaria'), $request->all());

        return redirectWithAlertSuccess('Os dados da conta bancária foram salvos com sucesso.')
            ->route('backoffice.conta_bancaria.editar', ['id' => $request->get('id_conta_bancaria')]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getEditar($idContaBancaria)
    {
        $registro = $this->repository->conta_bancaria->findById($idContaBancaria);
        $bancos = $this->repository->banco->all();

        return view('admin.conta_bancaria.formulario', [
            'registro' => $registro,
            'bancos' => $bancos
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
        return view('admin.cadastros.faq.formulario');
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

        $this->faq->deleteById($request->get('id'));

        return redirectWithAlertSuccess('FAQ deletado com sucesso!')->back();
    }
}
