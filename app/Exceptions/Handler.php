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
        $this->reportable(function (Throwable $e) {
            return false;
        });
    }
    public function render($request, Throwable $e)
    {
        // Xử lý lỗi ValidationException (trả về phản hồi cho người dùng)
        if ($e instanceof ValidationException) {
            $message = 'Đăng ký không thành công.';
            return response()->json([
                'message' => $message,
            ], 422);
        }
    }
}
