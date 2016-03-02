<?php

namespace App\Integracao\Moip\Services;

interface ServiceInterface {

    public function getUrl();
    public function getBody();
    public function getHeaders();

}