<?php

namespace App\Formatters;

class Email {

    /**
     * Normaliza um endereço de email
     *
     * @param string $email
     * @return string
     */
    public static function normalize($email) {
        $email = trim($email);
        $exploded = explode("@", $email);
        $address = explode("+", $exploded[0])[0];
        return trim($address . "@" . $exploded[1]);
    }

}