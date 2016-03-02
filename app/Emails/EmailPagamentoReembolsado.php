<?php

namespace App\Emails;

class EmailPagamentoReembolsado extends AbstractEmailReservaPagameto {

    public function getView() {
        return 'emails.pagamento_reembolsado';
    }

    public function getAssunto() {
        return 'O seu pagamento foi reembolsado!';
    }

}