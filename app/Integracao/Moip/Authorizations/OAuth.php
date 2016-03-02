<?php

namespace App\Integracao\Moip\Authorizations;

class OAuth implements AuthorizationInterface {

    private $token;

    public function __construct($token)
    {
        return $this->token = $token;
    }

    public function getAuthorization()
    {
        return sprintf("OAuth %s", $this->token);
    }

}