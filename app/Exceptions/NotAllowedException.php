<?php

namespace App\Exceptions;

class NotAllowedException extends ApplicationException
{
    public function getType()
    {
        return 'error';
    }

    public function getTitle()
    {
        return 'Não permitido!';
    }
}