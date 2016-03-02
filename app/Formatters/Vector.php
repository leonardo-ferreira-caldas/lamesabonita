<?php

namespace App\Formatters;

class Vector {

    /**
     * Join an array list by a specific string
     *
     * @param array|string st
     * @param string $joinBy
     * @return string
     */
    public static function joinBy($list, $joinBy) {
        if (!is_array($list)) {
            return $list;
        }

        return implode($joinBy, $list);
    }

    /**
     * Split a string and get the last position
     *
     * @param string $text
     * @param string $splitBy
     * @return string
     */
    public static function splitAndGetLast($text, $splitBy) {
        $splited = explode($splitBy, $text);

        return array_pop($splited);
    }

    /**
     * Convert a stdClass to an Array
     *
     * @param $stdClass
     * @return array
     */
    public static function stdClassToArray($stdClass) {
        return json_decode(json_encode($stdClass), true);
    }

}