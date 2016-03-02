<?php

namespace App\Exceptions;

class NotFoundException extends ApplicationException
{

    public function __construct($id)
    {
        parent::__construct(sprintf("Não foi possível localizar o registro de código '%s'.", $id));
    }

    public function getType()
    {
        return 'error';
    }

    public function getTitle()
    {
        return "Registro não encontrado!";
    }

}