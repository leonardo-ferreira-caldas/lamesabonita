<?php

namespace App\Http\Controllers\Admin\Resources;

use App\Repositories\FAQRepository;
use App\Repositories\FAQTipoRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class FAQResource extends Controller
{
    private $faq;
    private $tipo;

    public function __construct(FAQRepository $faq, FAQTipoRepository $tipo)
    {
        $this->faq = $faq;
        $this->tipo = $tipo;
        $this->middleware('guest_admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getListar()
    {
        return view('admin.cadastros.faq.listar');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getBuscarRegistros()
    {
        return $this->faq->all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postSalvar(Request $request)
    {
        if ($request->has('id_faq')) {
            $registro = $this->faq->atualizar(
                $request->get('id_faq'),
                $request->get('pergunta'),
                $request->get('resposta'),
                $request->get('fk_tipo'));
        } else {
            $registro = $this->faq->inserir(
                $request->get('pergunta'),
                $request->get('resposta'),
                $request->get('fk_tipo'));
        }

        return redirectWithAlertSuccess('O FAQ foi salvo com sucesso.')
            ->route('cadastro.faq.editar', ['id' => $registro->id_faq]);
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

        $registro = $this->faq->findById($request->get('id'));

        if (empty($registro)) {
            return $this->getList();
        }

        return view('admin.cadastros.faq.formulario', [
            'registro' => $registro,
            'tipos'    => $this->tipo->all()
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
        return view('admin.cadastros.faq.formulario', [
            'tipos'    => $this->tipo->all()
        ]);
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

        return redirectWithAlertSuccess('FAQ deletado com sucesso!')->route('cadastro.faq.listar');
    }
}
