<?php

namespace App\Mappers;

use Symfony\Component\Debug\Exception\ClassNotFoundException;

abstract class AbstractMapper {

    private $loaded = [];

    public function __get($name)
    {
        if (isset($this->loaded[$name])) {
            return $this->loaded[$name];
        }

        if (!isset($this->map[$name])) {
            throw new ClassNotFoundException(sprintf("Mapped class '%s' not found.", $name));
        }

        return $this->loaded[$name] = app($this->map[$name]);
    }

}