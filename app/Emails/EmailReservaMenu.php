<?php

namespace App\Emails;

class EmailReservaMenu extends AbstractEmailReservaPagameto {

    public function getView() {
        return 'emails.reserva_efetuada';
    }

    public function getAssunto() {
        return 'Reserva concluída com sucesso e aguardando aprovação de pagamento!';
    }

}