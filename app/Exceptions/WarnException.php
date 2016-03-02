<?php

namespace App\Exceptions;

class WarnException extends ApplicationException
{
    public function getType()
    {
        return 'warn';
    }

    public function getTitle()
    {
        return "Atenção!";
    }
}