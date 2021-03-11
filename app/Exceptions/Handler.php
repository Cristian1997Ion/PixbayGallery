<?php

namespace App\Exceptions;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if ($e instanceof NotFoundHttpException || $e instanceof MethodNotAllowedHttpException) {
            return parent::render($request, $e);
        }

        if ($e instanceof ValidationException) {
            return response()->json(['errors' => $e->errors()]);
        }

        if ($e instanceof GuzzleException) {
            return response()->json(['error' => 'Something went wrong with guzzle, please check the logs!']);
        }

        return response()->json(['error' => $e->getMessage()]);
    }
}
