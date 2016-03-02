<?php

namespace App\Repositories;

use App\Constants\ChefConstants;
use App\Constants\MenuConstants;
use Exception;
use Illuminate\Contracts\Auth\Guard;
use App\Facades\Query;
use App\Model\CursoModel;
use App\Model\FavoritoModel;
use App\Model\MenuModel;
use App\Utils\Alert;

class FavoritoRepository extends AbstractRepository {

    protected $model = FavoritoModel::class;

    private $auth;
    private $user;
    private $favorito;
    private $menu;
    private $curso;

    public function __construct(Guard $auth, FavoritoModel $favorito, MenuModel $menu, CursoModel $curso) {
        $this->auth = $auth;
        $this->user = $this->auth->user();
        $this->curso = $curso;
        $this->menu = $menu;
        $this->favorito = $favorito;
    }

    public function salvar($slug, $tipo) {
        if ($tipo == self::MENU) {
            $this->salvarMenu($slug);
        } else if ($tipo == self::CURSO) {
            $this->salvarCurso($slug);
        } else {
            throw new Exception('Tipo informado inválido.');
        }
    }

    /**
     * Remove um favorito
     *
     * @param $slug
     * @param $tipo
     * @throws Exception
     */
    public function deletar($slug, $tipo) {
        if ($tipo == self::MENU) {
            $this->deletarMenu($slug);
        } else if ($tipo == self::CURSO) {
            $this->deletarCurso($slug);
        } else {
            throw new Exception('Tipo informado inválido.');
        }
    }

    /**
     * Adiciona um menu a lista de favorito
     *
     * @param int $idCliente
     * @param int $idMenu
     * @return void
     */
    public function adicionarMenu($idCliente, $idMenu) {
        $this->create([
            'fk_degustador' => $idCliente,
            'fk_menu' => $idMenu,
        ]);
    }

    /**
     * Adiciona um curso a lista de favorito
     *
     * @param int $idCliente
     * @param int $idCurso
     * @return void
     */
    public function adicionarCurso($idCliente, $idCurso) {
        $this->create([
            'fk_degustador' => $idCliente,
            'fk_curso'      => $idCurso,
        ]);
    }

    /**
     * Verifica se um menu já está adicionado como favorito
     *
     * @param int $idCliente
     * @param int $idMenu
     * @return bool
     */
    public function verificaMenuJaAdicionado($idCliente, $idMenu) {
        return $this->exists([
            'fk_menu'       => $idMenu,
            'fk_degustador' => $idCliente
        ]);
    }

    /**
     * Verifica se um curso já está adicionado como favorito
     *
     * @param int $idCliente
     * @param int $idCurso
     * @return bool
     */
    public function verificaCursoJaAdicionado($idCliente, $idCurso) {
        return $this->exists([
            'fk_curso'      => $idCurso,
            'fk_degustador' => $idCliente
        ]);
    }

    /**
     * Deleta um menu da lista de favoritos de um cliente
     *
     * @param int $idCliente
     * @param int $idMenu
     * @return void
     */
    public function deletarMenu($idCliente, $idMenu) {
        $this->delete([
            'fk_menu'       => $idMenu,
            'fk_degustador' => $idCliente
        ]);
    }

    /**
     * Deleta um curso da lista de favoritos de um cliente
     *
     * @param int $idCliente
     * @param int $idCurso
     * @return void
     */
    public function deletarCurso($idCliente, $idCurso) {
        $this->delete([
            'fk_curso'      => $idCurso,
            'fk_degustador' => $idCliente
        ]);
    }

    public function filtrarDegustador($idDegustador) {
        return $this->favorito->where('fk_degustador', $idDegustador)->get();
    }

    /**
     * Busca todos os favoritos de um cliente
     *
     * @param int $idCliente Código do cliente (PK)
     * @return array of stdClass
     */
    public function getFavoritosByClienteId($idCliente) {
        return Query::fetch('Clientes/Favoritos/QryBuscarFavoritos', [
            'id_cliente' => $idCliente,
            'foto_capa'  => MenuConstants::SEM_FOTO,
            'avatar'     => ChefConstants::DEFAULT_AVATAR
        ]);
    }

}