<?php

namespace App\Http\Controllers\Auth;

use App\Facades\Email;
use Illuminate\Auth\Passwords\TokenRepositoryInterface;
use App\Emails\RecuperarSenha;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use App\User;
use App\Utils\Alert;
use App\Http\Requests;
use Illuminate\Http\Request;

class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    protected $redirectTo = '/minha-conta';

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware("guest");
        parent::__construct();
    }

    public function getFormRecuperarSenha() {
        return view('recuperar_senha');
    }

    public function getFormAlterarSenha($email, $token) {
        return view('alterar_senha', compact('email', 'token'));
    }

    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postRecuperarSenha(Request $request) {
        $this->validate($request, ['email' => 'required|email']);

        $email = $request->input('email');

        $user = User::where("email", $email)->first();

        if (empty($user)) {
            $request->flash();
            Alert::error('Erro', 'O email informado não existe.');
            return redirect()->back();
        }

        $token = $this->tokens->create($user);

        Email::enviarEmailRecuperarSenha($user->name, $user->email, $token);

        Alert::success('Enviado', 'Um email foi enviado para você com instruções para alterar sua senha.');

        return redirect()->back();

    }

}
