<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用行为扩展定义文件
return [
    // 应用结束
    'response_send'      => [
        //记录请求日志，传入当前响应对象
        'app\\common\\behavior\\ActionLog'
    ],
    // 登录成功
    'user_login'  => [
        'app\\admin\\behavior\\Login'
    ],
    // 退出登录
    'user_logout'  => [
        'app\\admin\\behavior\\Logout'
    ],
];
