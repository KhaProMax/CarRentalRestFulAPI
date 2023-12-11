<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ValidationException) {
            return $this->convertValidationExceptionToResponse($exception, $request);
        }

        if ($exception instanceof ModelNotFoundException) {
            $modelname = (class_basename($exception->getModel()));

            return response()->json(['error' => "{$modelname} not found", 'statusCode' => 404], 404);
        }

        if ($exception instanceof AuthenticationException) {
            return $this->unauthenticated($request, $exception);
        }

        if ($exception instanceof MethodNotAllowedHttpException) {
            return response()->json(['error' => "Invalid request", 'statusCode' => 405], 405);
        }

        if ($exception instanceof HttpException) {
            return response()->json(['error' => $exception->getMessage(), 'statusCode' => $exception->getStatusCode()]);
        }

        if($exception instanceof QueryException) {
            $errorCode = $exception->errorInfo[1];

            if($errorCode == 1451) {
                return response()->json(['error' => "Cannot remove this resource permanently. It is related with any other resource.", 'statusCode' => 409], 409);
            }
        }

        // if ($exception instanceof AuthenticationException) { 
        //     return $this->convertAuthenticationExceptionToResponse($exception, $request);
        // } No need now

        if ($exception instanceof NotFoundHttpException) {
            return response()->json(['error' => "The specific URL cannot be found", 'statusCode' => 404], 404);
        }

        if($exception instanceof QueryException) {
            return response()->json(['error'=> "Query data failed!", 'exception' => $exception->errorInfo[2], 'statusCode'=> 23000], 404);

        }

        return parent::render($request, $exception);
    }

    /**
     * Create a response object from the given validation exception.
     *
     * @param  \Illuminate\Validation\ValidationException  $e
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        $error = $e->validator->errors()->messages();

        return response()->json(['error' => $error, 'statusCode' => 422], 422);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return response()->json(['error' => 'Unauthenticated.', 'statusCode' => 401], 401);
    }
}
