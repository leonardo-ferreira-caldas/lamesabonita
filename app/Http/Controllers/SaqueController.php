<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Mappers\BusinessMapper;
use App\Mappers\RepositoryMapper;

class SaqueController extends Controller
{
    private $request;
    private $repository;
    private $business;

    public function __construct(Request $request, RepositoryMapper $repositoryMapper, BusinessMapper $business)
    {
        $this->request = $request;
        $this->repository = $repositoryMapper;
        $this->business = $business;
        parent::__construct();
    }

    /**
     * Lista todos os saques feitos
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getListar()
    {
        return view('chef.saque.listar', [
            'page'              => 'saque',
            'saldo'             => $this->business->chef->getSaldoChefLogado(),
            'saques_realizados' => $this->business->saque->getTotalSaquesChefLogado(),
            'saques'            => $this->business->saque->getSaquesChefLogado()
        ]);
    }

    /**
     * Carrega a view para solicitar um novo saque
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getSolicitarSaque()
    {
        return view('chef.saque.solicitar', [
            'page'             => 'saque',
            'contas_bancarias' => $this->business->conta_bancaria->getContaBancariasChefLogado()
        ]);
    }

    /**
     * Solicitação de novo saque
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postSolicitarSaque()
    {
        $this->business->saque->solicitarSaque($this->request->input('id_conta_bancaria'));

        return redirectWithAlertSuccess('Saque solicitado com sucesso.')->route('saque.listar');
    }

}
