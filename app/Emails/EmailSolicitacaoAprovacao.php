<?php

namespace App\Emails;

use App\Emails\Email;

class EmailSolicitacaoAprovacao extends Email {

    public function getVariavies() {
        return [];
    }

    public function getView() {
        return 'emails.solicitar_aprovacao_perfil';
    }

    public function getAssunto() {
        return 'Solicitação Aprovação Perfil';
    }

}