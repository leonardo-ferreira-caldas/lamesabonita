<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Business\DegustadorBO;
use App\Business\ReservaBO;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Mappers\RepositoryMapper;
use App\Utils\Alert;

class ClienteController extends Controller {

    private $degustadorBO;
    private $reservaBO;

    public function __construct(DegustadorBO $degustadorBO, ReservaBO $reservaBO) {
        parent::__construct();
        $this->middleware("email_confirmacao");
        $this->middleware('degustador');
        $this->degustadorBO = $degustadorBO;
        $this->reservaBO = $reservaBO;
    }
    
    public function visaoGeral() {
        return view('usuario.visao_geral', [
            'page' => 'visao_geral',
            'newsletter' => $this->degustadorBO->getNewsletterHabilitado()
        ]);
    }

    public function cartoes() {
        return view('usuario.cartoes', ['page' => 'cartoes']);
    }

    public function informacoesPessoais() {
        return view('usuario.informacoes_pessoais', [
            'page'   => 'informacoes_pessoais',
            'combos' => $this->degustadorBO->buscarInformacoesDiscretas(),
            'dados'  => $this->degustadorBO->getDadosClienteLogado()
        ]);
    }

    /**
     * Carrega a view que lista todas os favoritos do cliente
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getListarFavoritos() {
        return view('usuario.favoritos', [
            'page'      => 'favoritos',
            'favoritos' => $this->degustadorBO->getListaFavoritos()
        ]);
    }

    public function alterarSenha() {
        return view('usuario.alterar_senha', ['page' => 'alterar_senha']);
    }

    public function salvarNovoEndereco(Request $request) {
        $this->degustadorBO->salvarNovoEndereco($request->all());
        return redirect()->back();
    }

    public function alterarFoto(Requests\AlterarFotoPerfilDegustadorRequest $request) {
        $this->degustadorBO->alterarFotoPerfil($request->file('user_avatar'));

        return redirect()->back();
    }

    /**
     * Altera as informações pessoais do cliente
     *
     * @param Requests\AlterarDadosDegustadorRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\UnexpectedErrorException
     */
    public function postAlterarDados(Requests\AlterarDadosDegustadorRequest $request) {
        $this->degustadorBO->alterarDados($request->all());

        $sucesso = "Suas informações pessoais foram salvas com sucesso.";

        if (session()->has('redirect')) {
            $redirectUrl = session('redirect');

            session()->forget('redirect');

            return redirectWithAlertSuccess($sucesso)->to($redirectUrl);
        }

        return redirectWithAlertSuccess($sucesso)->route('degustador.informacoes_pessoais');
    }

    public function getNewsletter() {
        $this->degustadorBO->atualizarStatusNewsletter();
        return redirectWithAlertSuccess('Sua inscrição no nosso newsletter foi alterada com sucesso.')->back();
    }

}
