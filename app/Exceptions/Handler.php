<?php

namespace App\Exceptions;

use App\Helper\ResponseHelper;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        ThrottleRequestsException::class
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            if(request()->is('api/*')) {
                return response()->json(ResponseHelper::failed('Server error!'));
            }
        });

        $this->renderable(function (ThrottleRequestsException $e, $request) {
            if($request->is('api/*')) {
                return response()->json(ResponseHelper::failed('Too many requests.'));
            }
        });
    }
}
