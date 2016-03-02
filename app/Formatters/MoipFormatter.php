<?php

namespace App\Formatters;

use Carbon\Carbon;

class MoipFormatter {

    public static function formatTelefone($telefone) {
        $telefoneSplit = explode(")", $telefone);
        $ddd = ltrim($telefoneSplit[0], "(");
        $telefone = rtrim(trim($telefoneSplit[1]), "_");

        return [$ddd, $telefone];
    }

    public static function formatCPF($cpf) {
        return str_replace([".","-"], "", $cpf);
    }

    public static function formatCEP($cep) {
        return str_replace([".","-"], "", $cep);
    }

    public static function formatDataNascimento($dataNascimento) {
        return Carbon::createFromFormat('d/m/Y', $dataNascimento)->toDateString();
    }

}