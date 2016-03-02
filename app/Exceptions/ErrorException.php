<?php

namespace App\Exceptions;

class ErrorException extends ApplicationException
{
    public function getType()
    {
        return 'error';
    }

    public function getTitle()
    {
        return 'Erro!';
    }
}