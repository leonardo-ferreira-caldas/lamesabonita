<?php

namespace App\Emails;

class EmailPagamentoReprovado extends AbstractEmailReservaPagameto {

    public function getView() {
        return 'emails.pagamento_reprovado';
    }

    public function getAssunto() {
        return 'Pagamento reprovado!';
    }

}