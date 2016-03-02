<?php

namespace App\Formatters;

class Url {

    /**
     * Cria uma nova URL formatada com parametros
     *
     * @param $url
     * @param array $query
     * @return string
     */
    public static function formatWithQuery($url, $query = []) {

        $url = explode("?", $url);

        return sprintf("%s?%s", $url[0], http_build_query($query));

    }

}