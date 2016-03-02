<?php

namespace App\Emails;

class EmailPagamentoEstornado extends AbstractEmailReservaPagameto {

    public function getView() {
        return 'emails.pagamento_estornado';
    }

    public function getAssunto() {
        return 'O seu pagamento foi estornado!';
    }

}