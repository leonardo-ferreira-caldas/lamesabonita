<?php

namespace App\Utils;

/**
 * Classe helper para cria o HTML das stars
 *
 * @package App\Utils
 */
class Stars
{

    /**
     * Cria o html das stars
     *
     * @param $stars
     * @return string
     */
    public static function get($stars)
    {

        $html = [];
        $blank = (int)5 - $stars;
        $int = (int)$stars;

        for ($i = 1; $i <= $int; $i++) {
            $html[] = '<i class="fa fa-star"></i>';
        }

        if (($stars - $int) > 0) {
            $html[] = '<i class="fa fa-star-half-o"></i>';
        }

        for ($i = 1; $i <= $blank; $i++) {
            $html[] = '<i class="fa fa-star-o"></i>';
        }

        return implode(" ", $html);

    }

}