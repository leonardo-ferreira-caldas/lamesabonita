<?php

namespace App\Formatters;

class String {

    /**
     * Remove mascara do CEP
     *
     * @param string $cep
     * @return string
     */
    public static function removerMascaraCEP($cep) {
        return str_replace([".","-"], "", $cep);
    }

    /**
     * Remove mascara do CPF
     *
     * @param string $cpf
     * @return string
     */
    public static function removerMascaraCPF($cpf) {
        return str_replace([".","-"], "", $cpf);
    }

}