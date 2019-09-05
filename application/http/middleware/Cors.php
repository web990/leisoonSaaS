<?php
/**
 * Created by Leisoon.
 * User: websky <web88@qq.com>
 * Date: 2018/12/12 15:55
 */

namespace app\http\middleware;

use think\facade\Request;

/**
 * 跨域请求
 */
class Cors
{
    public function handle($request,\Closure $next)
    {
        $origin = Request::header('origin');
        $origin = empty($origin) ? 'http://c.com':$origin;

        // 指定允许其他域名访问
        header('Access-Control-Allow-Origin:'.$origin);
        // 响应类型
        header('Access-Control-Allow-Methods:POST,GET');
        // 响应头设置
        header('Access-Control-Allow-Headers:access_token,access-token,Authorization,Content-Type,If-Match,If-Modified-Since,If-None-Match,If-Unmodified-Since,X-Requested-With,X_Requested_With,x_requested_with');

        //发送Cookie和HTTP认证信息(Access-Control-Allow-Origin就不能设为星号)
        header('Access-Control-Allow-Credentials:true');

        //预检请求的有效期，单位为秒
        //header('Access-Control-Max-Age: 3600');

        //预检option请求不返回信息
        if ($request->isOptions()){
            exit();
        }

        return $next($request);
    }
}