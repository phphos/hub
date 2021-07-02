<?php

namespace PHPHos\Laravel\Http\Middleware;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as Http;

abstract class FormaterResponse
{
    /**
     * @inheritdoc
     */
    public function handle($request, \Closure $next)
    {
        $response = $next($request);

        if ($response instanceof JsonResponse) {
            $content = $response->getOriginalContent();

            $res['code'] = Http::HTTP_OK;
            $res['message'] = Http::$statusTexts[Http::HTTP_OK];
            is_null($content) or $res['data'] = $content;

            return response()->json($res);
        } else if ($response instanceof Response) {
            $content = $response->getOriginalContent();

            if (is_null($content)) {
                $res['code'] = Http::HTTP_OK;
                $res['message'] = Http::$statusTexts[Http::HTTP_OK];

                return response()->json($res);
            }
        }

        return $response;
    }
}
