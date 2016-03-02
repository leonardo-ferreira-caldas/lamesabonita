<?php

namespace App\Facades;

use DB;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class Query {

    /**
     * Load a new file based query
     *
     * @param $queryName
     * @param $params
     * @throws FileNotFoundException
     * @return array
     */
    private static function load($queryName, $params = []) {

        $queryName = rtrim(ltrim($queryName, '/'), '/');

        $path = app_path('Queries' . DIRECTORY_SEPARATOR . $queryName . ".php");

        if (!file_exists($path)) {
            throw new FileNotFoundException(sprintf("Query file '%s' not found.", $path));
        }

        include $path;

        if (!isset($path)) {
            throw new ResourceNotFoundException("The query resource variable was not found.");
        }

        if (!isset($bindings)) {
            $bindings = $params;
        }

        return [$query, $bindings];

    }

    /**
     * Execute a new select based on a file query
     *
     * @param $query
     * @param array $params
     * @return mixed
     */
    public static function fetch($query, $params = []) {

        list($sql, $bindings) = self::load($query, $params);

        return DB::select($sql, $bindings);

    }

    /**
     * Execute a new select based on a file query and return only the first row
     *
     * @param $query
     * @param array $params
     * @return mixed
     */
    public static function fetchFirst($query, $params = []) {

        $result = self::fetch($query, $params);

        if (empty($result) || count($result) == 0) {
            return null;
        }

        return $result[0];

    }


    /**
     * Execute a new select based on a file query
     *
     * @param $query
     * @param array $params
     * @return mixed
     */
    public static function update($query, $params = []) {

        list($sql, $bindings) = self::load($query, $params);

        return DB::update($sql, $bindings);

    }

    /**
     * Execute a new count query
     *
     * @param $query
     * @param array $params
     * @return mixed
     */
    public static function count($query, $params = []) {

        $result = self::fetchFirst($query, $params);

        return $result->aggregate;

    }

}