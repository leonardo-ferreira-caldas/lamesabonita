<?php

namespace App\Utils;

class Alert {

    public static function sweetAlert($type, $title, $message) {
        session()->flash('sweet_alert', [
            'title'   => $title,
            'message' => $message,
            'type'    => $type
        ]);
    }

    public static function success($title, $message) {
        static::sweetAlert('success', $title, $message);
    }

    public static function error($title, $message) {
        static::sweetAlert('error', $title, $message);
    }

    public static function info($title, $message) {
        static::sweetAlert('info', $title, $message);
    }

}