<?php

namespace App\Emails;

class EmailChefReservaCancelada extends AbstractEmailReservaPagameto {

    public function getView() {
        return 'emails.chef_reserva_cancelada';
    }

    public function getAssunto() {
        return 'Reserva cancelada!';
    }

}