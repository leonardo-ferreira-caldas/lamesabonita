<?php

namespace App\Http\Controllers\Admin;

use App\Constants\ChefConstants;
use App\Constants\CursoConstants;
use App\Constants\MenuConstants;
use App\Mappers\RepositoryMapper;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    private $repository;

    public function __construct(RepositoryMapper $mapper)
    {
        $this->repository = $mapper;
        $this->middleware('guest_admin', ['except' => ['getLogin']]);
    }

    /**
     * Retorna o dashboard do admin
     *
     * @return int
     */
    public function getDashboard() {
        return view('admin.dashboard', [
            'chefs'      => $this->repository->chef->getChsfsByStatus(ChefConstants::STATUS_AGUARDANDO_APROVACAO),
            'menus'      => $this->repository->menu->getMenusPorStatus(MenuConstants::STATUS_AGUARANDO_APROVACAO),
            'cursos'     => $this->repository->curso->getCursosPorStatus(CursoConstants::STATUS_AGUARANDO_APROVACAO),
            'avaliacoes' => $this->repository->avaliacao->getAvaliacaoesPendentes()
        ]);
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
