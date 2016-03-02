<?php

namespace App\Emails;

use App\Emails\Email;

class EmailSolicitacaoSeloLMB extends Email {

    public function getVariavies() {
        return [];
    }

    public function getView() {
        return 'emails.solicitar_selo_qualidade';
    }

    public function getAssunto() {
        return 'Solicitação Selo La Mesa Bonita';
    }

}