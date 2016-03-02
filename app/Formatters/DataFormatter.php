<?php

namespace App\Formatters;

use Carbon\Carbon;

class DataFormatter {

    /**
     * Formata uma data para o padrão brasileiro
     *
     * @param $data
     * @return bool|string
     */
    public static function formatarDataBR($data) {
        return date('d/m/Y', strtotime($data));
    }

    /**
     * Formata uma data para o padrão ingles
     *
     * @param $data
     * @return string
     */
    public static function formatarDataEN($data) {
        return Carbon::createFromFormat('d/m/Y', $data)->toDateString();
    }

    /**
     * Obtem a data e hora atual
     *
     * @return string
     */
    public static function getDataHoraAtual() {
        return Carbon::now()->toDateTimeString();
    }

    /**
     * Obtem a data atual
     *
     * @return string
     */
    public static function getDataAtual() {
        return Carbon::now()->toDateString();
    }

}