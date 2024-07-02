<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    // public function register()
    // {
    //     $this->reportable(function (Throwable $e) {
    //         //
    //     });
    // }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof \Illuminate\Session\TokenMismatchException) {
            return redirect('/');
        }
        if ($exception instanceof TokenMismatchException && $request->getRequestUri() === '/logout') {
            return redirect('/');
        }
        return parent::render($request, $exception);
    }
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
    protected function unauthenticated($request, AuthenticationException $exception)
    {

        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }
        return redirect()->route('auth.signin');
    }
}
