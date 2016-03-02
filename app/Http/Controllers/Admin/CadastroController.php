<?php

namespace App\Http\Controllers\Admin;

use App\Mappers\RepositoryMapper;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class CadastroController extends Controller
{
    private $repository;

    public function __construct(RepositoryMapper $repositoryMapper)
    {
        $this->repository = $repositoryMapper;
        $this->middleware('guest_admin');
    }

    /**
     * Retorna o dashboard do admin
     *
     * @return int
     */
    public function getTipoCulinaria() {

    }



    /**
     * Carrega a view de login do admin
     *
     * @return
     */
    public function getLogin() {
        return view('admin.auth.login');
    }
}
