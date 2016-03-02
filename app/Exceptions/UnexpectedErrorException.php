<?php

namespace App\Exceptions;

class UnexpectedErrorException extends ApplicationException
{

    public function __construct()
    {
        parent::__construct("Um erro inesperado ocorreu. Por favor tente novamente ou entre em contato com a equipe La Mesa Bonita!");
    }

    public function getType()
    {
        return 'error';
    }

    public function getTitle()
    {
        return "Oops!";
    }

}