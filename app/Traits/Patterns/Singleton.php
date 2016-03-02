<?php

namespace App\Traits\Patterns;

trait Singleton {

    private static $_self;

    public static function getInstance() {
        if (!empty($_self)) {
            return self::$_self;
        }

        return self::$_self = new static();
    }

}