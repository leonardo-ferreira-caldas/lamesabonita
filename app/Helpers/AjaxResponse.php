<?php

namespace App\Helpers;

use App\Formatters\Vector;

class AjaxResponse {

    /**
     * Create a new success ajax JSON response
     *
     * @param $message
     * @return \Illuminate\Http\JsonResponse
     */
    public static function success($message) {
        return response()->json([
            'type'    => 'success',
            'message' => Vector::joinBy($message, '\n\n')
        ]);
    }

    /**
     * Create a new success ajax JSON response with a redirect
     *
     * @param $message
     * @return \Illuminate\Http\JsonResponse
     */
    public static function successWithRedirect($message, $redirectText, $redirectRoute) {
        return response()->json([
            'type'     => 'success',
            'message'  => Vector::joinBy($message, '\n\n'),
            'redirect' => [
                'text' => $redirectText,
                'route' => $redirectRoute
            ]
        ]);
    }


}