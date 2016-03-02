<?php

namespace App\Emails;

use App\Emails\Email;

class EmailRecuperarSenha extends Email {

    private $token;

    public function setToken($token) {
        $this->token = $token;
    }

    public function getVariavies() {
        return [
            'token' => $this->token,
            'email' => $this->getEmail()
        ];
    }

    public function getView() {
        return 'emails.recuperar_senha';
    }

    public function getAssunto() {
        return 'Recuperação de Senha';
    }

}