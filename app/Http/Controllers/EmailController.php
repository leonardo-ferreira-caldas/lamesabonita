<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use App\Business\UserBO;
use App\Facades\Autenticacao;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Utils\Alert;

class EmailController extends Controller
{
    private $userBO;

    public function __construct(UserBO $user) {
        parent::__construct();
        $this->userBO = $user;
        $this->middleware("auth");
    }

    /**
     * Reenvia email de confirmação de conta para um usuário cadastrado
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getReenviarConfirmacaoEmail() {

        // Verifica se o usuario logado ja confirmou email
        if (Autenticacao::isEmailConfirmado()) {
            Alert::info("Aviso", "O seu e-mail já foi confirmado.");

            if (Autenticacao::isChef()) {
                return redirect()->route('conta-chef');
            }

            return redirect()->route('cliente.pagina_inicial');
        }

        $this->userBO->reenviarEmailConfirmacao();

        return redirectWithAlertSuccess("Um novo e-mail de confirmação foi enviado para você.")
            ->route('aguardando-confirmacao-email');
    }

    public function getConfirmarEmail($email, $token) {

        if (!$this->userBO->validarTokenConfirmacaoEmail($email, $token)) {
            Alert::error('Inválido', 'O token de confirmação de e-mail é inválido.');
            return redirect()->route('aguardando-confirmacao-email');
        }

        $this->userBO->confirmarEmail();

        Alert::success('Sucesso', 'Seu e-mail foi confirmado com sucesso.');

        if (Autenticacao::isChef()) {
            return redirect()->route('conta-chef');
        }

        return redirect()->route('cliente.pagina_inicial');

    }

    /**
     * Carrega a view informando que um email de confirmação foi enviado para o email cadastrado
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getAguardandoConfirmacaoEmail() {
        if (Autenticacao::isEmailConfirmado()) {

            if (Autenticacao::isChef()) {
                return redirect()->route('conta-chef');
            }

            return redirect()->route('cliente.pagina_inicial');
        }

        return view('aguardando_confirmacao_email');
    }

}
