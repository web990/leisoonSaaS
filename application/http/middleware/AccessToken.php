<?php
/**
 * Created by Leisoon.
 * User: websky <web88@qq.com>
 * Date: 2018/12/12 15:55
 */

namespace app\http\middleware;

/**
 * 获取AccessToken
 */
class AccessToken
{
    public function handle($request, \Closure $next)
    {
        $token = $request->header('access_token');
        $token = $token ? $token:$request->header('access-token');
        $request->accessToken = $token ? $token:$request->param('access_token/s');

        $path = $request->module().'/'.str_replace('.', '/', $request->controller()) . '/' . $request->action();
        $request->pathAuth = strtolower($path);
        return $next($request);
    }
}