<?php

namespace App\Exceptions;

class InfoException extends ApplicationException
{
    public function getType()
    {
        return 'info';
    }

    public function getTitle()
    {
        return 'Informação!';
    }
}