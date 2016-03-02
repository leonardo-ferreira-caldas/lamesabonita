<?php

namespace App\Exceptions;

abstract class ApplicationException extends \Exception {

    public abstract function getType();
    public abstract function getTitle();

}