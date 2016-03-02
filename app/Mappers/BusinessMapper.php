<?php

namespace App\Mappers;

use App\Business\BuscaBO;
use App\Business\ChefBO;
use App\Business\ContaBancariaBO;
use App\Business\CursoBO;
use App\Business\DegustadorBO;
use App\Business\FAQBO;
use App\Business\MenuBO;
use App\Business\MoipBO;
use App\Business\PagamentoBO;
use App\Business\ReservaBO;
use App\Business\SaqueBO;
use App\Business\UserBO;

class BusinessMapper extends AbstractMapper {

    protected $map = [
        'saque'          => SaqueBO::class,
        'chef'           => ChefBO::class,
        'busca'          => BuscaBO::class,
        'reserva'        => ReservaBO::class,
        'menu'           => MenuBO::class,
        'curso'          => CursoBO::class,
        'pagamento'      => PagamentoBO::class,
        'moip'           => MoipBO::class,
        'cliente'        => DegustadorBO::class,
        'user'           => UserBO::class,
        'faq'            => FAQBO::class,
        'conta_bancaria' => ContaBancariaBO::class
    ];

}