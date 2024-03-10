<?php

namespace App\Exceptions;

use App\Enums\Api\HttpResponseCodes;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
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
        });
    }

    /**
     * Render the exception into an HTTP response.
     */
    public function render($request, Throwable $exception): Response|JsonResponse|RedirectResponse|\Symfony\Component\HttpFoundation\Response
    {
        if ($exception instanceof ValidationException) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $exception->errors(),
            ], HttpResponseCodes::HttpUnprocessableEntity->value);
        }

        if ($exception instanceof AuthenticationException) {
            return response()->json([
                'message' => 'Authentication Failed',
            ], HttpResponseCodes::HttpUnauthorized->value);
        }

        if ($exception instanceof AuthorizationException) {
            return response()->json([
                'message' => __('app.unauthorized'),
            ], HttpResponseCodes::HttpForbidden->value);
        }

        if ($exception instanceof HttpException) {
            return response()->json([
                'message' => "Resource not found",
            ], $exception->getStatusCode());
        }

        if ($exception instanceof ModelNotFoundException) {
            return response()->json([
                'message' => __('app.model_not_found'),
            ], HttpResponseCodes::HttpNotFound->value);
        }

        return parent::render($request, $exception);
    }
}
