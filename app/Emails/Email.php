<?php

namespace App\Emails;

abstract class Email {

    protected $paraEmail;
    protected $paraEmailNome;

    public function __construct($nome, $email) {
        $this->paraEmail = $email;
        $this->paraEmailNome = $nome;
    }

    public function getEmail() {
        return $this->paraEmail;
    }

    public function getNome() {
        return $this->paraEmailNome;
    }

    public function getAnexos() {
        return [];
    }

    public function getVariavies() {
        return [];
    }

    public abstract function getView();
    public abstract function getAssunto();

}