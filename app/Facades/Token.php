<?php

namespace App\Facades;

use Hash;

class Token {

    /**
     * Valida se o token informado é valido
     *
     * @param $token
     * @param $keyTokenized
     * @return bool
     */
    public static function isValid($token, $keyTokenized) {
        $unbased64 = base64_decode($token);

        if (Hash::check($keyTokenized, $unbased64)) {
            return true;
        }

        return false;
    }

}