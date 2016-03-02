<?php

namespace App\Validators;

class UploadValidator {

    public static function validarMime($mimeType) {
        $mimesPermitidos = ['image/jpeg', 'image/png'];

        return in_array($mimeType, $mimesPermitidos);
    }

}