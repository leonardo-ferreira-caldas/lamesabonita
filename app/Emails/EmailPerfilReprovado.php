<?php

namespace App\Emails;

use App\Emails\Email;

class EmailPerfilReprovado extends Email {

    public function getVariavies() {
        return [];
    }

    public function getView() {
        return 'emails.perfil_reprovado';
    }

    public function getAssunto() {
        return 'Perfil Reprovado';
    }

}