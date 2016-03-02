<?php

namespace App\Business;

use App\Constants\ChefConstants;
use App\Constants\CursoConstants;
use App\Constants\MenuConstants;
use App\Constants\ProdutoStatusContants;
use App\Model\ProdutoStatusModel;
use Illuminate\Support\Facades\Bus;
use App\Constants\BuscaConstants;
use App\Facades\Query;
use App\Mappers\RepositoryMapper;

class BuscaBO
{

    private $filtros = [];
    private $repository;
    private $lengthPaginacao = 10;
    private $paginas;

    private $produtos;

    public function __construct(RepositoryMapper $mapper)
    {
        $this->repository = $mapper;
    }

    /**
     * Seta os filtros que serao utilizados na busca
     *
     * @param $filtros
     */
    public function setFiltros($filtros)
    {
        $this->filtros = $filtros;
    }

    /**
     * Verifica se é para filtrar apenas menus
     *
     * @return bool
     */
    private function isFiltrarApenasMenus()
    {
        return isset($this->filtros['tipo'])
            && in_array(BuscaConstants::BUSCA_TIPO_MENU, $this->filtros['tipo'])
            && !in_array(BuscaConstants::BUSCA_TIPO_CURSO, $this->filtros['tipo']);
    }

    /**
     * Verifica se é para filtrar apenas cursos
     *
     * @return bool
     */
    private function isFiltrarApenasCursos()
    {
        return isset($this->filtros['tipo'])
            && !in_array(BuscaConstants::BUSCA_TIPO_MENU, $this->filtros['tipo'])
            && in_array(BuscaConstants::BUSCA_TIPO_CURSO, $this->filtros['tipo']);
    }

    /**
     * Verifica se o filtro de cidade foi informado
     *
     * @return bool
     */
    private function hasFiltroCidade()
    {
        return !empty($this->filtros['cidade']);
    }

    /**
     * Verifica se o filtro de culinaria foi informado
     *
     * @return bool
     */
    private function hasFiltroCulinaria()
    {
        return !empty($this->filtros['culinaria']);
    }

    /**
     * Verifica se o filtro de tipo de refeicao foi informado
     *
     * @return bool
     */
    private function hasFiltroTipoRefeicao()
    {
        return !empty($this->filtros['tipo_refeicao']);
    }

    /**
     * Verifica se o filtro de reputacao foi informado
     *
     * @return bool
     */
    private function hasFiltroReputacao()
    {
        return !empty($this->filtros['reputacao']);
    }

    /**
     * Verifica se o filtro de preco foi informado
     *
     * @return bool
     */
    private function hasFiltroPreco()
    {
        return !empty($this->filtros['precos']);
    }

    /**
     * Retorna o ID da cidade
     *
     * @return int
     */
    private function getFiltroCidade()
    {
        $nomeCidade = explode(',', $this->filtros['cidade'])[0];

        return $this->repository->geo->getIdCidadeByNome($nomeCidade);
    }

    /**
     * Retorna a lista de IDs de culinarias
     *
     * @return int
     */
    private function getFiltroCulinaria()
    {
        return (array)$this->filtros['culinaria'];
    }

    /**
     * Retorna a lista de IDs de culinarias
     *
     * @return int
     */
    private function getFiltroReputacao()
    {
        return (array)$this->filtros['reputacao'];
    }

    /**
     * Retorna filtros de preco
     *
     * @return int
     */
    private function getFiltroPreco()
    {
        return (array)$this->filtros['precos'];
    }

    /**
     * Retorna a lista de IDs dos tipos de refeicao
     *
     * @return int
     */
    private function getFiltroTiposRefeicao()
    {
        return (array) $this->filtros['tipo_refeicao'];
    }

    /**
     * Retorna a lista de IDs dos tipos de refeicao
     *
     * @return int
     */
    private function getLengthPaginacao()
    {
        return (int)$this->lengthPaginacao;
    }

    /**
     * Retorna a lista de IDs dos tipos de refeicao
     *
     * @return int
     */
    private function getOffsetPaginacao()
    {
        if (!isset($this->filtros['pagina']) || !is_numeric($this->filtros['pagina'])) {
            return 0;
        }

        return (int)($this->filtros['pagina'] * $this->getLengthPaginacao()) - $this->getLengthPaginacao();
    }

    /**
     * Retorna a quantiadde de pagians
     *
     * @return int
     */
    private function getQtdPaginas($qtdRegistrosEncontrados)
    {
        return ceil($qtdRegistrosEncontrados / $this->getLengthPaginacao());
    }

    /**
     * Carrega precos pro clientes dos produtos
     *
     * @param array $produtos
     * @return array
     */
    private function getPrecosPorClientes($produtos)
    {

        $menus = [];
        $cursos = [];
        $precosCurso = [];
        $precosMenus = [];

        foreach ($produtos as $produto) {
            if ($produto->produto_tipo == BuscaConstants::BUSCA_TIPO_MENU) {
                $menus[] = $produto->produto_id;
            } else {
                $cursos[] = $produto->produto_id;
            }
        }

        if (count($menus) > 0) {
            $precosMenus = Query::fetch('Busca/QryBuscarPrecosMenus', ['id_menu' => $menus]);
        }

        if (count($cursos) > 0) {
            $precosCurso = Query::fetch('Busca/QryBuscarPrecosCursos', ['id_curso' => $cursos]);
        }

        $agrupadoPorIdMenu = [];
        $agrupadoPorIdCurso = [];

        foreach ($precosMenus as $precoMenu) {
            $agrupadoPorIdMenu[$precoMenu->id_menu][$precoMenu->qtd_minima_clientes] = $precoMenu->preco;
        }

        foreach ($precosCurso as $precoCurso) {
            $agrupadoPorIdCurso[$precoCurso->id_curso][$precoCurso->qtd_minima_clientes] = $precoCurso->preco;
        }

        foreach ($produtos as &$produto) {
            $preco = $produto->produto_preco;
            $precosFinais = [];

            if ($produto->produto_tipo == BuscaConstants::BUSCA_TIPO_MENU) {
                for ($i = 1; $i <= $produto->produto_qtd_maxima_cliente; $i++) {
                    if (isset($agrupadoPorIdMenu[$produto->produto_id][$i]) && $agrupadoPorIdMenu[$produto->produto_id][$i] < $preco) {
                        $preco = $agrupadoPorIdMenu[$produto->produto_id][$i];
                    }
                    $precosFinais[] = ['preco' => $preco, 'qtd' => $i];
                }

            } else {
                for ($i = 1; $i <= $produto->produto_qtd_maxima_cliente; $i++) {
                    if (isset($agrupadoPorIdMenu[$produto->produto_id][$i]) && $agrupadoPorIdMenu[$produto->produto_id][$i] < $preco) {
                        $preco = $agrupadoPorIdMenu[$produto->produto_id][$i];
                    }
                    $precosFinais[] = ['preco' => $preco, 'qtd' => $i];
                }
            }

            $produto->precos = $precosFinais;

        }

        return $produtos;

    }

    /**
     * Busca todos os produtos do site (Menus e Cursos)
     *
     * @return NULL
     */
    public function excutarBuscar()
    {

        $queryParams = [
            'id_chef_status'    => ChefConstants::STATUS_ATIVO
        ];

        if ($this->isFiltrarApenasMenus()) {
            $queryParams['tipo'] = BuscaConstants::BUSCA_TIPO_MENU;
        } else if ($this->isFiltrarApenasCursos()) {
            $queryParams['tipo'] = BuscaConstants::BUSCA_TIPO_CURSO;
        }

        if ($this->hasFiltroCidade()) {
            $queryParams['id_cidade'] = $this->getFiltroCidade();
        }

        if ($this->hasFiltroCulinaria()) {
            $queryParams['id_culinaria'] = $this->getFiltroCulinaria();
        }

        if ($this->hasFiltroTipoRefeicao()) {
            $queryParams['id_tipo_refeicao'] = $this->getFiltroTiposRefeicao();
        }

        if ($this->hasFiltroReputacao()) {
            $queryParams['reputacao'] = $this->getFiltroReputacao();
        }

        if ($this->hasFiltroPreco()) {
            $queryParams['preco'] = $this->getFiltroPreco();
        }

        $this->paginas = $this->getQtdPaginas(Query::count('Busca/QryContarProdutos', $queryParams));

        $queryParams['offset'] = $this->getOffsetPaginacao();
        $queryParams['length'] = $this->getLengthPaginacao();
        $queryParams['menu_capa'] = MenuConstants::SEM_FOTO;
        $queryParams['curso_capa'] = CursoConstants::SEM_FOTO;
        $queryParams['chef_avatar'] = ChefConstants::DEFAULT_AVATAR;

        $produtos = Query::fetch('Busca/QryBuscarProdutos', $queryParams);

        $produtos = $this->getPrecosPorClientes($produtos);

        $this->produtos = $produtos;
    }

    /**
     * Responsavel por carregar os filtros que serao utilizados na busca
     *
     * @return stdClass
     */
    public function getFiltroPrecoMaximoMinimo()
    {
        return Query::fetchFirst('Busca/Filtros/QryBuscarPrecoMaximoMinimo');
    }

    /**
     * Busca a quantidade de produtos por avaliacao
     *
     * @return array of stdClass
     */
    public function getFiltroStars()
    {
        return Query::fetch('Busca/Filtros/QryBuscarQtdProdutosPorAvaliacao');
    }

    /**
     * Busca a quantidade de produtos por avaliacao
     *
     * @return array of stdClass
     */
    public function getFiltroPaginacao()
    {
        return $this->paginas;
    }

    /**
     * Retorna os produtos encontrados na busca
     *
     * @return array of stdClass
     */
    public function getProdutos()
    {
        return $this->produtos;
    }

    /**
     * Retorna lista de refeicoes com a quantidade de menus/curso
     *
     * @return array of stdClass
     */
    public function getFiltroRefeicoes()
    {
        return Query::fetch('Busca/Filtros/QryBuscarRefeicoesComQuantidades');
    }

    /**
     * Retorna lista de culinarias com a quantidade de menus/curso
     *
     * @return array of stdClass
     */
    public function getFiltroCulinarias()
    {
        return Query::fetch('Busca/Filtros/QryBuscarCulinariasComQuantidades');
    }

}