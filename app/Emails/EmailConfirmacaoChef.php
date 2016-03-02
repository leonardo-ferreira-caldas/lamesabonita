<?php

namespace App\Emails;

use App\Emails\Email;

class EmailConfirmacaoChef extends Email {

    private function getUrlConfirmacao() {
        $crypted = base64_encode(bcrypt(strrev($this->getEmail())));

        $uri = route('confirmacao-email', [
            'email' => $this->getEmail(),
            'token' => $crypted
        ]);

        return url($uri);
    }

    public function getVariavies() {
        return [
            "url_confirmacao" => $this->getUrlConfirmacao()
        ];
    }

    public function getView() {
        return 'emails.confirmar_email_chef';
    }

    public function getAssunto() {
        return 'Confirmação de Email';
    }

}