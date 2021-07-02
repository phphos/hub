<?php

namespace PHPHos\Laravel\Exceptions;

use Symfony\Component\HttpFoundation\Response as Http;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Exception extends HttpException
{
    /**
     * 异常信息: 默认错误信息.
     */
    const FAIL = '操作失败.';

    /**
     * 失败.
     * 
     * @param string $message 错误信息.
     * @param int $code 错误编码.
     * @param int $status 状态编码.
     * @return void
     */
    public static function fail(
        string $message,
        int $code = Http::HTTP_BAD_REQUEST,
        int $status = Http::HTTP_BAD_REQUEST
    ): void {
        $statuses = array_keys(Http::$statusTexts);

        if (!in_array($status, $statuses)) {
            $status = Http::HTTP_INTERNAL_SERVER_ERROR;
            $code = Http::HTTP_INTERNAL_SERVER_ERROR;
            $message = Http::$statusTexts[Http::HTTP_INTERNAL_SERVER_ERROR];
        }

        throw new static($status, $message, null, [], $code);
    }
}
