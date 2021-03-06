<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
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
        if ($e instanceof AuthorizationException) {
            return response()->json([
                'error' => class_basename(AuthorizationException::class),
                'message' => 'This action is unauthorized'
            ]);
        } else if ($e instanceof ModelNotFoundException) {
            $modelName = class_basename($e->getModel());
            $apiErrorCode = $modelName . 'NotFoundException';
            $message = $modelName . ' not found.';

            return response()->json([
                'error' => $apiErrorCode,
                'message' => $message
            ], 404);
        }

        return parent::render($request, $e);
    }
}
