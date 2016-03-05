<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Contracts\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if ($this->isHttpException($e)) {
            return view('errors.404');

        } else if ($e instanceof UnauthorizedException) {
            return redirect()->to('login');

        } if ($e instanceof ApplicationException) {
            if ($request->ajax()) {
                return response()->json([
                    'type' => $e->getType(),
                    'message' => $e->getMessage()
                ]);
            }

            session()->flash('sweet_alert', [
                'title'   => $e->getTitle(),
                'message' => $e->getMessage(),
                'type'    => $e->getType()
            ]);

            return redirect()->back();
        }

        return parent::render($request, $e);
    }
}
