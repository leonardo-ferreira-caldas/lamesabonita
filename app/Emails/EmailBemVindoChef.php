<?php

namespace App\Emails;

use App\Emails\Email;

class EmailBemVindoChef extends Email {

    public function getView() {
        return 'emails.bemvindo_chef';
    }

    public function getAssunto() {
        return 'Parabéns! Você se cadastrou com sucesso na La Mesa Bonita.';
    }

    public function getAnexos() {
        return [
            storage_path('app/pdfs/informacoes_ao_chef_parceiro_lmb.pdf')
        ];
    }

}