<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpFoundation\Response;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ServerException;

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
        switch ($e) {
            case ($e instanceof ConnectException) :
                return response()->json(
                    [
                        'error' => 'connection_error',
                        'code'  => '123'
                    ],
                    Response::HTTP_SERVICE_UNAVAILABLE
                );
                break;

            default :
                return parent::render($request, $e);
                break;
        }
    }
}
