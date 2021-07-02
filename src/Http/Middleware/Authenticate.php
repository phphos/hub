<?php

namespace PHPHos\Laravel\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use PHPHos\Laravel\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response as Http;

abstract class Authenticate extends Middleware
{
    /**
     * @inheritdoc
     */
    protected function redirectTo($request)
    {
    }

    /**
     * @inheritdoc
     */
    protected function unauthenticated($request, array $guards)
    {
        Exception::fail('请登录.', Http::HTTP_UNAUTHORIZED, Http::HTTP_UNAUTHORIZED);
    }
}
