<?php

// +----------------------------------------------------------------------
// | 权限配置信息
// +----------------------------------------------------------------------

return [
    /* 权限类配置 */
    'auth_on'           => 1, // 权限开关
    'auth_type'         => 1, // 认证方式，1为实时认证；2为登录认证。
    'auth_group'        => 'admin_role', // 用户组数据表名
    'auth_group_access' => 'admin_role_access', // 用户-用户组关系表
    'auth_group_extend' => 'admin_role_extend', // 用户组扩展关系表
    'auth_category'     => 'admin_category', // 栏目分类信息表
    'auth_rule'         => 'admin_menu', // 权限规则表
    'auth_user'         => 'user', // 用户信息表

    /* 用户相关设置 */
    'user_max_cache'     => 100,   //最大缓存用户数
    'user_administrator' => 1, //超级管理员
    'user_key'           => 'b{<=^B-nR`[@6rqd?H,iN+o>UgWCF}7(9m1!|YL.P',

    /* Token配置 */
    'token_issuer'         => 'leisoon', // iss (issuer) 请求实体，可以是发起请求的用户的信息，也可是jwt的签发者
    'token_subject'        => 'login', // subject	设置主题，类似于发邮件时的主题
    'token_audience'       => 'leisoonsaas', // audience	接收jwt的一方
    'token_expire'         => 36000, // token过期时间
    'token_time'           => time(), // 生成token的时间
    'token_not_before'     => 0 ,   //当前时间在not_before设定时间之前，该token无法使用
    'token_key'            => 'websky@#leisoon', // 秘钥签名
];
