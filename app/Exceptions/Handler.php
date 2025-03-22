<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
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
        $this->renderable(function (\Illuminate\Auth\AuthenticationException $e, $request) {
            return response()->json(['error' => 'Unauthorized - Custom Handler'], 401);
        });
    
        $this->renderable(function (\Tymon\JWTAuth\Exceptions\JWTException $e, $request) {
            return response()->json(['error' => 'JWT Error: ' . $e->getMessage()], 401);
        });
    
        $this->renderable(function (\Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException $e, $request) {
            return response()->json(['error' => 'Forbidden - You do not have permission'], 403);
        });
    }
}
