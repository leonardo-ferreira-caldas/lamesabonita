<?php

namespace App\Http\Controllers;

use App\Facades\Email;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Mappers\BusinessMapper;
use App\Mappers\RepositoryMapper;
use Symfony\Component\HttpKernel\Exception\HttpException;

class PaginasController extends Controller
{
    private $request;
    private $repository;
    private $bo;

    public function __construct(Request $request, BusinessMapper $bmapper, RepositoryMapper $mapper)
    {
        $this->request = $request;
        $this->repository = $mapper;
        $this->bo = $bmapper;

        $this->middleware('guest', ['only' => ['getLogin', 'getRegistrar']]);
        parent::__construct();
    }

    /**
     * Carrega a página inicial
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getHome()
    {
        return view('home');
    }

    /**
     * Carrega a view de contato
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getContato()
    {
        return view('contato');
    }

    /**
     * Carrega a view de FAQ
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getFaq()
    {
        return view('faq', [
            'cliente' => $this->bo->faq->getFAQCliente(),
            'chef'    => $this->bo->faq->getFAQChef()
        ]);
    }

    /**
     * Carrega a view de login de usuário
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getLogin()
    {
        return view('login');
    }

    /**
     * Carrega view que lista todos os produtos (Menus e Cursos)
     *
     * @param Request $request
     * @param MenuRepository $menu
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getProdutos()
    {
        $this->bo->busca->setFiltros($this->request->all());
        $this->bo->busca->excutarBuscar();

        if ($this->request->ajax()) {
            return view('busca_menus_cursos.menus_e_cursos', [
                'produtos' => $this->bo->busca->getProdutos(),
                'filtros'  => $this->request->all(),
                'paginas'  => $this->bo->busca->getFiltroPaginacao()
            ]);
        }

        return view('busca_menus_cursos.listar', [
            'produtos'   => $this->bo->busca->getProdutos(),
            'refeicoes'  => $this->bo->busca->getFiltroRefeicoes(),
            'culinarias' => $this->bo->busca->getFiltroCulinarias(),
            'preco'      => $this->bo->busca->getFiltroPrecoMaximoMinimo(),
            'stars'      => $this->bo->busca->getFiltroStars(),
            'filtros'    => array_merge($this->request->all(), ['pagina' => 1]),
            'paginas'    => $this->bo->busca->getFiltroPaginacao()
        ]);
    }

    /**
     * Carrega a view de cadastro de cliente
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getRegistrar()
    {
        return view('registrar');
    }

    /**
     * Carrega a view sobre nós
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getSobreNos()
    {
        return view('sobre_nos');
    }

    /**
     * Carrega a view "sou chef"
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getSouChef()
    {
        return view('sou_chef');
    }

    /**
     * Carrega a agenda de um chef
     *
     * @param $slug
     * @param ChefBO $chefBO
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function getChefAgenda($slug)
    {
        $chef = $this->repository->chef->findBySlug($slug, true);

        return view('chef.perfil.agenda', [
            'chef'      => $chef,
            'schedules' => $this->repository->chef_agenda->getAgendaCalendario($chef->id_chef)
        ]);
    }

    /**
     * Carrega o perfil do chef
     *
     * @param string $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function getChefPerfil($slug)
    {
        return view('chef.perfil.sobre_chef', [
            'chef' => $this->repository->chef->findBySlug($slug, true)
        ]);
    }

    /**
     * Carrega a view com os detalhes de um menu de um chef
     *
     * @param string $slugChef
     * @param string $slugMenu
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function getMenuDetalhes($slugChef, $slugMenu)
    {
        $chef = $this->repository->chef->findBySlug($slugChef, true);
        $menu = $this->repository->menu->findBySlug($slugMenu, true);

        return view('chef.perfil.menu_detalhes', [
            'chef'          => $chef,
            'menu'          => $menu,
            'avaliacoes'    => $this->repository->avaliacao->getAvaliacaoesMenu($menu->id_menu),
            'datas_reserva' => json_encode($this->repository->chef_agenda->getAgendaDisponivel($chef->id_chef)),
            'incluso_preco' => $this->bo->menu->getInclusoPreco()
        ]);
    }

    /**
     * Carrega a view com os detalhes de um curso de um chef
     *
     * @param string $slugChef
     * @param string $slugCurso
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function getCursoDetalhes($slugChef, $slugCurso)
    {
        $chef = $this->repository->chef->findBySlug($slugChef, true);
        $curso = $this->repository->curso->findBySlug($slugCurso, true);

        return view('chef.perfil.curso_detalhes', [
            'chef'          => $chef,
            'curso'         => $curso,
            'avaliacoes'    => $this->repository->avaliacao->getAvaliacaoesCurso($curso->id_curso),
            'datas_reserva' => json_encode($this->repository->chef_agenda->getAgendaDisponivel($chef->id_chef)),
            'incluso_preco' => $this->bo->curso->getInclusoPreco()
        ]);
    }

    /**
     * Carrega a view que lista todas as fotos dos menus e cursos do chef
     *
     * @param string $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function getChefGaleriaFotos($slug)
    {
        return view('chef.perfil.galeria', [
            'chef' => $this->repository->chef->findBySlug($slug, true)
        ]);
    }

    /**
     * Carrega a view que lista todos os menus do perfil do chef
     *
     * @param string $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getChefPerfilMenus($slug)
    {
        return view('chef.perfil.listar_menus', [
            'chef' => $this->repository->chef->findBySlug($slug, true)
        ]);
    }

    /**
     * Carrega a view que lista todos os cursos do perfil do chef
     *
     * @param string $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getChefPerfilCursos($slug)
    {
        return view('chef.perfil.listar_cursos', [
            'chef' => $this->repository->chef->findBySlug($slug, true)
        ]);
    }


    /**
     * Carrega a view que lista todas as avalições do perfil do chef
     *
     * @param string $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getChefPerfilAvaliacoes($slug)
    {
        return view('chef.perfil.avaliacoes', [
            'chef' => $this->repository->chef->findBySlug($slug, true)
        ]);
    }

    /**
     * Envia formulário de contato
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postFormularioContato(Requests\FormularioContatoRequest $request)
    {
        Email::enviarEmailFormularioContato($request->get('name'), $request->get('email'));

        return redirectWithAlertSuccess('Sua mensagem foi enviada com sucesso.\nAguarde enquanto nossa equipe entra em contato com você.')->back();
    }

    /**
     * Carrega view que lista os termos de uso do chef
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getTermosChef()
    {
        return view('termos_chef');
    }

    /**
     * Carrega view que lista os termos de uso do cliente
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getTermosCliente()
    {
        return view('termos_degustador');
    }

    /**
     * Carrega view que lista todos os chefs ativos
     *
     * @param ChefRepository $chef
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getNossosChefs()
    {
        return view('nossos_chefs', [
            'chefs' => $this->repository->chef->all()
        ]);
    }

    /**
     * Carrega o formulario de cadastro de chef
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getSouChefCadastrar()
    {
        return view('sou_chef_formulario', [
            'estados' => $this->repository->geo->listarEstados()
        ]);
    }

}
