<?php
/**
 * Created by Leisoon.
 * User: websky <web88@qq.com>
 * Date: 2019-8-16 11:35:13
 */

namespace app\http\middleware;

/**
 * Request扩展中间件
 */
class RequestExtend
{
    public function handle($request, \Closure $next)
    {
        $token = $request->header('access-token');
        if (empty($token)){
            $token = $request->param('access_token/s');
        }

        $request->accesstoken=$token;

        $request->path='999';
        $request->test999='999';
        return $next($request);
    }
}