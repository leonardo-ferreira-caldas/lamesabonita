<?php

namespace App\Http\Controllers\Admin\Resources;

use App\Repositories\ConfiguracaoSiteRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ConfiguracoesResource extends Controller
{
    private $config;

    public function __construct(ConfiguracaoSiteRepository $config)
    {
        $this->config = $config;
        $this->middleware('guest_admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getListar()
    {
        return view('admin.configuracoes.listar');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getBuscarRegistros()
    {
        return $this->config->all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postSalvar(Request $request)
    {
        try {

            if ($request->has('chave_original')) {
                $this->config->deleteById($request->get('chave_original'));
            }

            $this->config->inserir($request->get('chave'), $request->get('valor'));

            return redirectWithAlertSuccess('A configuração foi salva com sucesso.')
                ->route('backoffice.configuracao.listar');

        } catch (\Exception $e) {

            return redirectWithAlertError('Já existe um registro com a chave informada.')->back();
        }
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

        $registro = $this->config->findById($request->get('id'));

        if (empty($registro)) {
            return $this->getList();
        }

        return view('admin.configuracoes.formulario', [
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
        return view('admin.configuracoes.formulario');
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

        $this->config->deleteById($request->get('id'));

        return redirectWithAlertSuccess('Configuração deletada com sucesso!')->route('backoffice.configuracao.listar');
    }
}
