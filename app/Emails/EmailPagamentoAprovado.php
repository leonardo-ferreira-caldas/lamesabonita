<?php

namespace App\Emails;

class EmailPagamentoAprovado extends AbstractEmailReservaPagameto {

    public function getView() {
        return 'emails.pagamento_aprovado';
    }

    public function getAssunto() {
        return 'Pagamento aprovado com sucesso!';
    }

}