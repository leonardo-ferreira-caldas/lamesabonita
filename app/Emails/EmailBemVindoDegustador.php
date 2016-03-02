<?php

namespace App\Emails;

use App\Emails\Email;

class EmailBemVindoDegustador extends Email {

    public function getVariavies() {
        return [];
    }

    public function getView() {
        return 'emails.bemvindo_degustador';
    }

    public function getAssunto() {
        return 'Seja bem vindo degustador';
    }

}