<?php

namespace App\Integracao\Moip\Authorizations;

class Basic implements AuthorizationInterface {

    private $basicBase64;

    public function __construct($username, $password)
    {
        return $this->basicBase64 = base64_encode($username . ":" . $password);
    }

    public function getAuthorization()
    {
        return sprintf("Basic %s", $this->basicBase64);
    }

}