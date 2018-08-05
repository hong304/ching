<?php

namespace App\Exceptions;

use App\Notifications\ErrorNotification;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Notifications\Notifiable;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    use Notifiable;
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
    public function render($request, Exception $e)
    {

        if ($e instanceof ModelNotFoundException) {
            return parent::render($request, new NotFoundHttpException());
        }elseif ($e instanceof AuthenticationException) {
            return $this->unauthenticated($request, $e);
        }elseif ($e instanceof ValidationException) {
            return $this->convertValidationExceptionToResponse($e, $request);
        }

        if ( env('APP_SLACK_ERROR') && !$this->isHttpException($e)) {
            if ($e->getCode() > 0) {
                if (env('APP_SLACK_ERROR')){
                    $this->notify(new ErrorNotification($e, $request->url()));
                };

                return response()->view('errors.500', ['message'=>$e->getMessage(), 'code'=>$e->getCode()], 500);
            } else {
                if (get_class($e) == 'Illuminate\Session\TokenMismatchException') {
                    //$this->notify(new ErrorNotification($e, $request->url()));
                    return response()->view('errors.500', ['message'=>'Sorry your session has expired, please go back and press refresh on your web browser.'], 500);
                }
                if (env('APP_SLACK_ERROR')){
                    $this->notify(new ErrorNotification($e, $request->url()));
                }
                return response()->view('errors.500', ['message'=>'('.get_class($e).')'], 500);
            }
        }

        return parent::render($request, $e);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *we
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->route('login');
    }

    public function routeNotificationForSlack() {
        return env('SLACK_WEBHOOK_URL');
    }
}
