<?php

namespace App\Business;

use Exception;
use App\Constants\ChefConstants;
use App\Exceptions\UnexpectedErrorException;
use App\Facades\Autenticacao;
use App\Facades\Upload;
use App\Handlers\EmailHandler;
use App\Mappers\RepositoryMapper;
use DB;
use Symfony\Comenmponent\HttpKernel\Exception\HttpException;

class MenuBO {

    private $email;
    private $repository;

    public function __construct(RepositoryMapper $repository, EmailHandler $email)
    {
        $this->repository = $repository;
        $this->email  = $email;
    }

    /**
     * Verifica se um menu está ativo
     *
     * @param $slugMenu
     * @return mixed
     */
    public function isMenuAtivo($slug) {
        return $this->repository->menu->getMenuStatusBySlug($slug);
    }

    /**
     * Altera o status de um menu para ativo
     *
     * @param string $slug
     * @return void
     */
    public function ativarMenu($slug) {
        $this->repository->menu->atualizarStatus($slug, true);
    }

    /**
     * Altera o status de um menu para inativo
     *
     * @param string $slug
     * @return void
     */
    public function inativarMenu($slug) {
        $this->repository->menu->atualizarStatus($slug, false);
    }

    /**
     * Retorna quantos menus o chef logado tem cadastrado
     *
     * @return mixed
     */
    public function getQuantidadeMenusChefLogado() {
        return $this->repository->menu->getQuantidadeMenusByChefId(Autenticacao::getId());
    }

    /**
     * Retorna lista de itens incluso no preço para menus
     *
     * @return array
     */
    public function getInclusoPreco() {
        return $this->repository->incluso_preco->getListaInclusoPreco(ChefConstants::INCLUSO_PRECO_MENU);
    }

    /**
     * Retorna lista de combos para o formulário de inserção/edição de menus
     *
     * @return array
     */
    public function getCombosFormulario() {
        return [
            'culinarias'    => $this->repository->culinaria->getListaCulinarias(),
            'incluso_preco' => $this->getInclusoPreco(),
            'tipo_refeicao' => $this->repository->tipo_refeicao->getListaRefeicoes()
        ];
    }

    /**
     * Busca dados de um menu para edição
     *
     * @param int $idMenu
     * @return array
     */
    public function getDadosMenuFormulario($idMenu) {
        return $this->repository->menu->findById($idMenu, ['precos', 'culinarias', 'refeicoes', 'imagens']);
    }

    /**
     * Retorna todos os menus do chef logado
     *
     * @return collection of MenuModel
     */
    public function getMenusChefLogado() {
        return $this->repository->menu->getMenusByChefId(Autenticacao::getId());
    }

    /**
     * Insere/Atualiza um menu
     *
     * @param array $dados
     * @return void
     */
    public function salvar($dados) {

        DB::beginTransaction();

        try {

            if (empty($dados['id_menu'])) {
                $menu = $this->repository->menu->inserir(Autenticacao::getId(), $dados);
            } else {
                $menu = $this->repository->menu->atualizar($dados['id_menu'], $dados);
            }

            $this->repository->menu_refeicao->deletarByMenuId($menu->id_menu);
            $this->repository->menu_culinaria->deletarByMenuId($menu->id_menu);

            foreach ($dados['tipo_refeicao'] as $idTipoRefeicao) {
                $this->repository->menu_refeicao->inserir($menu->id_menu, $idTipoRefeicao);
            }

            foreach ($dados['tipo_culinaria'] as $idCulinaria) {
                $this->repository->menu_culinaria->inserir($menu->id_menu, $idCulinaria);
            }

            if (isset($dados['menu_foto'])) {
                foreach ($dados['menu_foto'] as $foto) {
                    if (!empty($foto)) {
                        $nomeArquivo = Upload::salvar($foto, 'foto_menu');
                        $imagemInserida = $this->repository->menu_imagem->inserir($menu->id_menu, $nomeArquivo);

                        if (!isset($primeiraImagemEnviada)) {
                            $primeiraImagemEnviada = clone $imagemInserida;
                        }
                    }
                }
            }

            if (isset($primeiraImagemEnviada) && !$this->repository->menu_imagem->possuiFotoCapa($menu->id_menu)) {
                $this->repository->menu_imagem->atualizarFotoCapa($menu->id_menu, $imagemInserida->id_menu_imagem);
            }

            DB::commit();

        } catch (Exception $e) {
            DB::rollBack();
            Upload::rollback();

            throw new UnexpectedErrorException;
        }

    }

    /**
     * Deleta uma imagem de um menu
     *
     * @param int $idMenuImagem
     * @return void
     */
    public function deletarImagem($idMenu, $idMenuImagem) {

        $menu = $this->repository->menu->findById($idMenu);

        if ($menu->fk_chef != Autenticacao::getId()) {
            throw new HttpException(403, 'Acesso negado.');
        }

        $imagem = $this->repository->menu_imagem->findById($idMenuImagem);
        $this->repository->menu_imagem->deleteById($idMenuImagem);

        Upload::deletar($imagem->nome_imagem);

    }

    /**
     * Define uma imagem do menu como capa
     *
     * @param $idMenuImagem
     * @throws Exception
     */
    public function definirComoCapa($idMenu, $idMenuImagem) {

        $menu = $this->repository->menu->findById($idMenu);

        if ($menu->fk_chef != Autenticacao::getId()) {
            throw new HttpException(403, 'Acesso negado.');
        }

        $this->repository->menu_imagem->atualizarFotoCapa($idMenu, $idMenuImagem);

    }
}