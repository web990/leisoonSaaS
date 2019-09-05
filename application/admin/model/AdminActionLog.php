<?php
// +----------------------------------------------------------------
// | LeisoonCMF V5.0
// +----------------------------------------------------------------
// | Copyright (c) 2016 http://www.leisoon.com All rights reserved.
// +----------------------------------------------------------------
// | Author: websky <web88@qq.com>
// +----------------------------------------------------------------

namespace app\admin\model;

use app\admin\library\Auth;
use think\facade\Request;

/**
 * 行为日志模型
 */
class AdminActionLog extends BaseAdminModel {

    protected $autoWriteTimestamp = true;
    protected $updateTime = false;

    protected function getIpAttr($value){
        return long2ip($value);
    }
    protected function getContentAttr($value){
        return json_decode($value,true);
    }
    public static function setRefererAttr($value)
    {
        return empty($value) ? '':$value;
    }

    /**
     * 日志记录
     * Author: websky
     * @param string $object 接收app_end标签位响应对象实例
     */
    public static function record($object = null)
    {
        //return false;

        //过滤无需记录日志
        $filterAction=['index','modelCount','categorycount','getmenu','datacount','session','getserverinfo','getcategorylist','getstatus','verify'];
        if (in_array(Request::action(),$filterAction) && Request::method() == 'GET'){
            return ;
        }

        //响应对象实例
        $response_content = $response_code = $response_type = $title = '';
        if (is_object($object)){
            $response_content = $object->getContent();
            $response_code = $object->getCode();
            $response_type = $object->getHeader();
            $response_type = $response_type['Content-Type'];
        }

        //获取数据表名
        $datatable = Request::controller();
        $datatable = strtolower($datatable)=='index'? Request::module():$datatable;

        //获取登录信息
        $auth = new Auth(Request::param('accessToken'));
        $uid = $auth->uid;
        $tenant_id = $auth->tenant_id;

        //获取请求参数并过滤
        $filterParam=['password','v','access_token','accessToken','pathAuth'];
        $content = Request::param();
        foreach ($content as $k => $v)
        {
            if (in_array($k,$filterParam))
            {
                unset($content[$k]);
            }elseif (is_string($v) && strlen(strip_tags($v)) > 200){
                //$content[$k] = substr(strip_tags($v),0,500);
                $content[$k] = strip_tags($v);
            }
        }

        $data = [
            'title'     => $title,
            'tenant_id' => $tenant_id,
            'uid'       => $uid,
            'method'    => Request::method(true),
            'content'   => !is_scalar($content) ? json_encode($content) : $content,
            'url'       => Request::url(),
            'module'     => Request::module(),
            'controller'     => Request::controller(),
            'action'     => Request::action(),
            'datatable'     => $datatable,
            'path' => Request::path(),
            'response_code' => $response_code ? $response_code:'',
            'response_type' => $response_type ? $response_type:'',
            'response_content' => $response_content ? $response_content:'',
            'useragent' => Request::server('HTTP_USER_AGENT'),
            'referer'    => Request::server('HTTP_REFERER'),
            'ip'        => Request::ip(1)
        ];

        self::create($data);
    }

}