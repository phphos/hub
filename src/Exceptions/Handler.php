<?php

namespace PHPHos\Laravel\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use PHPHos\Laravel\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response as Http;

abstract class Handler extends ExceptionHandler
{
    /**
     * @inheritdoc
     */
    public function render($request, \Throwable $e)
    {
        $status = Http::HTTP_INTERNAL_SERVER_ERROR;
        $code = $e->getCode();
        $message = $e->getMessage();

        if ($e instanceof ValidationException) {
            $status = $e->status;
            $code = $e->status;
            $errors = $e->errors();
            $messages = reset($errors);
            $message = reset($messages);
        } else if ($e instanceof ModelNotFoundException) {
            $status = Http::HTTP_BAD_REQUEST;
            $code = Http::HTTP_BAD_REQUEST;
            $message = '数据不存在.';
        } else if ($e instanceof Exception) {
            $status = $e->getStatusCode();
        } else if ($code == 0) {
            $code = Http::HTTP_INTERNAL_SERVER_ERROR;
        }

        $message or $message = Http::$statusTexts[$status];

        $res['code'] = $code;
        $res['message'] = $message;
        config('app.debug') and $res['trace'] = $e->getTrace();

        return response($res)->setStatusCode($status);
    }
}
