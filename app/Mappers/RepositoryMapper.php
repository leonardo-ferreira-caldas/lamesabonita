<?php

namespace App\Mappers;

use App\Model\MenuCulinariaModel;
use App\Model\MenuImagemModel;
use App\Repositories\AvaliacaoRepository;
use App\Repositories\BancoRepository;
use App\Repositories\ChefAgendaRepository;
use App\Repositories\ChefRepository;
use App\Repositories\ChefStatusRepository;
use App\Repositories\ChefStatusSeloRepository;
use App\Repositories\ConfiguracaoSiteRepository;
use App\Repositories\ContaBancariaRepository;
use App\Repositories\CulinariaRepository;
use App\Repositories\CursoCulinariaRepository;
use App\Repositories\CursoImagemRepository;
use App\Repositories\CursoPrecoRepository;
use App\Repositories\CursoRepository;
use App\Repositories\CursoTipoRefeicaoRepository;
use App\Repositories\DegustadorEnderecoRepository;
use App\Repositories\DegustadorRepository;
use App\Repositories\FavoritoRepository;
use App\Repositories\GeoRepository;
use App\Repositories\ImagemRepository;
use App\Repositories\InclusoPrecoRepository;
use App\Repositories\MenuCulinariaRepository;
use App\Repositories\MenuImagemRepository;
use App\Repositories\MenuPrecoRepository;
use App\Repositories\MenuRepository;
use App\Repositories\MenuTipoRefeicaoRepository;
use App\Repositories\PagamentoRepository;
use App\Repositories\ProdutoStatusRepository;
use App\Repositories\ReservaRepository;
use App\Repositories\ReservaStatusRepository;
use App\Repositories\SaqueRepository;
use App\Repositories\SexoRepository;
use App\Repositories\TipoRefeicaoRepository;
use App\Repositories\UserRepository;
use App\Repositories\FAQRepository;

class RepositoryMapper extends AbstractMapper {

    protected $map = [
        'saque'            => SaqueRepository::class,
        'conta_bancaria'   => ContaBancariaRepository::class,
        'menu'             => MenuRepository::class,
        'menu_imagem'      => MenuImagemRepository::class,
        'menu_refeicao'    => MenuTipoRefeicaoRepository::class,
        'menu_preco'       => MenuPrecoRepository::class,
        'menu_culinaria'   => MenuCulinariaRepository::class,
        'pagamento'        => PagamentoRepository::class,
        'reserva'          => ReservaRepository::class,
        'reserva_status'   => ReservaStatusRepository::class,
        'imagem'           => ImagemRepository::class,
        'geo'              => GeoRepository::class,
        'cliente'          => DegustadorRepository::class,
        'cliente_endereco' => DegustadorEnderecoRepository::class,
        'chef'             => ChefRepository::class,
        'avaliacao'        => AvaliacaoRepository::class,
        'banco'            => BancoRepository::class,
        'chef_status'      => ChefStatusRepository::class,
        'chef_status_selo' => ChefStatusSeloRepository::class,
        'chef_agenda'      => ChefAgendaRepository::class,
        'sexo'             => SexoRepository::class,
        'user'             => UserRepository::class,
        'favorito'         => FavoritoRepository::class,
        'configuracao'     => ConfiguracaoSiteRepository::class,
        'curso'            => CursoRepository::class,
        'curso_imagem'     => CursoImagemRepository::class,
        'curso_refeicao'   => CursoTipoRefeicaoRepository::class,
        'curso_culinaria'  => CursoCulinariaRepository::class,
        'curso_preco'      => CursoPrecoRepository::class,
        'tipo_refeicao'    => TipoRefeicaoRepository::class,
        'culinaria'        => CulinariaRepository::class,
        'faq'              => FAQRepository::class,
        'incluso_preco'    => InclusoPrecoRepository::class,
        'produto_status'   => ProdutoStatusRepository::class
    ];

}