<?php

namespace App\Emails;

use App\Emails\Email;

class EmailContato extends Email {

    public function getVariavies() {
        return [];
    }

    public function getView() {
        return 'emails.contato';
    }

    public function getAssunto() {
        return 'Formulário de Contato La Mesa Bonita';
    }

}