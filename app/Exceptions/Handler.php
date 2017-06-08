<?php

namespace App\Exceptions;

use ApiResponse;
use Exception;
use GrahamCampbell\Exceptions\NewExceptionHandler; //TODO Stop using NewExceptionHandler until find a way to resolve redirect problem
use GuzzleHttp\Exception\ClientException as GuzzleClientException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException as LaravelValidatorException;
use Prettus\Validator\Exceptions\ValidatorException as PrettusValidatorException;
use App\Libraries\Validator\ValidatiorException as AppValidatorException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {

        // Handler for Validation exception
        if ($exception instanceof LaravelValidatorException
            || $exception instanceof PrettusValidatorException
            || $exception instanceof AppValidatorException) {

            switch(true) {
                case $exception instanceof LaravelValidatorException:
                    $errorMessages = $exception->validator->getMessageBag()->messages();
                    break;
                case $exception instanceof PrettusValidatorException:
                case $exception instanceof AppValidatorException:
                    $errorMessages = $exception->getMessageBag();
                    break;
                default:
                    $errorMessages = json_decode($exception->response->getContent());
            }

            if ($request->ajax() || $request->wantsJson())
                return ApiResponse::errorValidation($errorMessages);

            return redirect()->back()->withErrors($errorMessages)
                             ->withInput()->with('error', \Lang::get('response.validation.fail'));
        }

        // Handler for Authentication exception
        if ($exception instanceof AuthenticationException) {
            if ($request->ajax() || $request->wantsJson())
                return ApiResponse::error($exception->getMessage(), [], 401);
        }

        // Handler for Guzzle Exception
        if ($exception instanceof GuzzleClientException) {
            $exceptionResonse = json_decode($exception->getResponse()->getBody());

            if ($request->ajax() || $request->wantsJson())
                return ApiResponse::error($exception->getMessage(), [], $exception->getCode());
        }

        return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest('/admin/login');
    }
}
