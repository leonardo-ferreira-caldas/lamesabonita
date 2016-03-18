<?php

namespace App\Queues;

interface QueueInterface {

    /**
     * Adiciona um novo item na fila
     *
     * @return void
     */
    public static function enfilerar($queueItem);

    /**
     * Processa a fila atual
     *
     * @return void
     */
    public static function processar($length);

}