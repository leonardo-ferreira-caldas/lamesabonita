<?php

use App\Utils\Stars;

class Helpers {

    /**
     * Cria o HTML das stars
     *
     * @param $numStars
     * @return string html
     */
    public static function getStars($numStars) {
        return Stars::get($numStars);
    }

    /**
     * Retorna a pagina incial da paginacao
     *
     * @param $current
     * @param $max
     * @return int
     */
    public static function getInitialPage($current, $max) {
        if ($current <= 4) {
            return 1;
        } else if ($current > 7 && $current > ($max - 4)) {
            return $max - 6;
        } else {
            return $current - 3;
        }
    }

    /**
     * Retorna a pagina final da paginacao
     *
     * @param $current
     * @param $max
     * @return int
     */
    public static function getFinalPage($current, $max) {
        if ($max <= 7) {
            return $max;
        } else if ($current <= 4) {
            return 7;
        } else if ($current > ($max - 3)) {
            return $max;
        } else {
            return $current + 3;
        }
    }

    /**
     * Retorna o valor do produto de acordo com a qtd de clientes selecionados
     *
     * @return float
     */
    public static function getPrecoQtdCliente($precos, $qtdClientes)
    {
        foreach ($precos as $preco) {
            if ($preco['qtd'] == $qtdClientes) {
                return formatar_monetario($preco['preco']);
            }
        }

        return $precos[0]['preco'];
    }

}