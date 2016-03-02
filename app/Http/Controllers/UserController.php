<?php

namespace App\Http\Controllers;

use App\Facades\Autenticacao;
use App\Mappers\BusinessMapper;
use Illuminate\Http\Request;

use App\Business\UserBO;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\FavoritoRepository;

class UserController extends Controller
{
    private $bo;

    public function __construct(BusinessMapper $mapper)
    {
        $this->middleware("email_confirmacao");
        $this->bo = $mapper;
    }

    /**
     * Adiciona uma nova avaliação para um chef
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postSalvarAvaliacao(Request $request)
    {
        $this->bo->user->salvarAvaliacao($request->all());
        return redirectWithAlertSuccess('Sua avaliação foi enviada com sucesso.')->back();
    }

    /**
     * Adiciona um menu/curso da lista de favorito do usuário
     *
     * @param string $slug
     * @param string $tipo
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getSalvarFavorito($slug, $tipo)
    {
        $this->bo->cliente->adicionarFavorito($slug, $tipo);
        return redirectWithAlertSuccess('A sua lista de favoritos foi atualizada com sucesso.')->back();
    }

    /**
     * Remove um menu/curso da lista de favorito do usuário
     *
     * @param string $slug
     * @param string $tipo
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getRemoverFavorito($slug, $tipo)
    {
        $this->bo->cliente->removerFavorito($slug, $tipo);
        return redirectWithAlertSuccess('A sua lista de favoritos foi atualizada com sucesso.')->back();
    }

    /**
     * Atualiza a senha do usuario logado
     *
     * @param Requests\ResetarPasswordRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function alterarSenha(Requests\ResetarPasswordRequest $request)
    {
        $this->user->alterarSenha($request->input('current_password'), $request->input("password"));
        return redirectWithAlertSuccess("Sua senha foi alterada com sucesso.")->back();
    }

}
