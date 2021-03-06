<?php

namespace App\Constants;

class PagamentoConstants {

    const METODO_CARTAO = 1;
    const METODO_BOLETO = 2;

    const STATUS_AGUARDANDO_APROVACAO  = 1;
    const STATUS_PAGAMENTO_APROVADO    = 2;
    const STATUS_PAGAMENTO_REPROVADO   = 3;
    const STATUS_PAGAMENTO_REEMBOLSADO = 4;
    const STATUS_PAGAMENTO_ESTORNADO   = 5;

    const MOIP_STATUS_CREATED        = "CREATED";
    const MOIP_STATUS_WAITING        = "WAITING";
    const MOIP_STATUS_IN_ANALYSIS    = "IN_ANALYSIS";
    const MOIP_STATUS_PRE_AUTHORIZED = "PRE_AUTHORIZED";
    const MOIP_STATUS_AUTHORIZED     = "AUTHORIZED";
    const MOIP_STATUS_CANCELLED      = "CANCELLED";
    const MOIP_STATUS_REFUNDED       = "REFUNDED";
    const MOIP_STATUS_REVERSED       = "REVERSED";

}