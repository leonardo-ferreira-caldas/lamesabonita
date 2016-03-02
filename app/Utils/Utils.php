<?php

namespace App\Utils;

use DateTime;

class Utils {

    public static function isValidDate($date) {
        $d = DateTime::createFromFormat('Y-m-d', $date);
        return $d && $d->format('Y-m-d') == $date;
    }

    public static function formatarDataEN($date) {
        $d = DateTime::createFromFormat('d/m/Y', $date);
        return $d->format('Y-m-d');
    }

    public static function formatarDataBR($date) {
        $d = DateTime::createFromFormat('Y-m-d', $date);
        return $d->format('d/m/Y');
    }

    public static function formatarDataHoraBR($date) {
        $d = DateTime::createFromFormat('Y-m-d H:i:s', $date);
        return $d->format('d/m/Y H:i:s');
    }

    public static function formatTime($time) {
        return sprintf('%s:00:00', str_pad($time, 2, '0', STR_PAD_LEFT));
    }

    public static function formatarHorario($horario) {
        $d = DateTime::createFromFormat('H:i:s', $horario);
        return $d->format('H:i');
    }

}