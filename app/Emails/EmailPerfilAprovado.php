<?php

namespace App\Emails;

use App\Emails\Email;

class EmailPerfilAprovado extends Email {

    public function getVariavies() {
        return [];
    }

    public function getView() {
        return 'emails.perfil_aprovado';
    }

    public function getAssunto() {
        return 'Perfil Aprovado';
    }

}