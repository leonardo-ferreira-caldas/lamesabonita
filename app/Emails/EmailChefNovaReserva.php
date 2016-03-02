<?php

namespace App\Emails;

class EmailChefNovaReserva extends AbstractEmailReservaPagameto {

    public function getView() {
        return 'emails.chef_nova_reserva';
    }

    public function getAssunto() {
        return 'Você tem uma nova reserva!';
    }

}