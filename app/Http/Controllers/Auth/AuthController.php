<?php

namespace App\Http\Controllers\Auth;

use App\Facades\Autenticacao;
use App\User;
use App\Business\UserBO;
use Validator;
use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Exception\HttpResponseException;
use Log;

class AuthController extends Controller
{

    const USER_TYPE_TASTER = 'degustador';
    const USER_TYPE_CHEF   = 'chef';

    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    protected $redirectPath = '/minha-conta';
    protected $redirectAfterLogout = '/';
    protected $loginPath = '/login';

    private $userBO;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(UserBO $user)
    {
        $this->userBO = $user;
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Caso o usuário tenha logado com sucesso, redireciona para a página correta
     *
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function authenticated(Request $request, User $user) {
        if ($user->ind_chef) {
            return redirect()->route('chef.visao_geral');
        }

        if (session()->has('redirect')) {
            $redirectUrl = session('redirect');

            session()->forget('redirect');

            return redirect($redirectUrl);
        }

        return redirect()->route('cliente.pagina_inicial');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        if (isset($dados['ind_chef']) && $dados['ind_chef']) {
            return Validator::make($data, [
                'name'              => 'required|max:255',
                'email'             => 'required|email|max:255|unique:users',
                'password'          => 'required|confirmed|min:6',
                'telefone'          => 'required|min:8',
                'logradouro'        => 'required',
                'logradouro_numero' => 'required',
                'fk_estado'         => 'required',
                'bairro'            => 'required',
                'fk_cidade'         => 'required',
                'cep'               => 'required',
                'cpf'               => 'required'
            ]);
        } else {
            return Validator::make($data, [
                'name'      => 'required|max:255',
                'email'     => 'required|email|max:255|unique:users',
                'password'  => 'required|confirmed|min:6'
            ]);
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data) {
        return $this->userBO->cadastrar($data);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postCadastrar(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                "checkbox-terms" => "required|accepted"
            ]);

            if ($validator->fails()) {
                $route = isset($dados['ind_chef']) ? route('cadastrar.cliente') : route('cadastrar.cliente');
                return redirect($route)->withErrors($validator);
            }

            return $this->postRegister($request);

        } catch (HttpResponseException $httpExcpt) {
            throw $httpExcpt;

        } catch (Exception $e) {
            Log::error($e->getMessage());

            return redirectWithAlertError("Não foi possível concluir o seu cadastro. Por favor tente novamente ou entre em contato com a equipe La Mesa Bonita.")
                ->back();
        }
    }
}
