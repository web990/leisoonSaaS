<?php
/**
 * Created by Leisoon.
 * User: websky <web88@qq.com>
 * Date: 2018/12/12 11:11
 */
namespace lib;

/**
 * 错误码统一维护
 * @package util
 */
class ReturnCode {

    const SUCCESS = 0; //操作成功

    const ERROR = 999; //请求错误
    const UNKNOWN = 998;  //未知错误
    const INVALID = 997; //无效操作
    const EMPTY_PARAMS = 996; //参数为空
    const EXCEPTION = 995;// 参数无效
    const CURL_ERROR = 994; //curl请求错误

    const NOT_LOGIN = 1010; //未登录
    const NOT_AUTH = 1011; //无权限

    const LOGIN_OUT = 1001; //退出登录
    const LOGIN_ERROR = 1002; //登录错误
    const USER_NOT_EXISTS = 1003; //用户名不存在
    const VALIDATE_ERROR = 1004; //验证码错误
    const OTHER_LOGIN = 1005; //其他人登录
    const ACCESS_TOKEN_TIMEOUT = 1006;//token超时
    const SESSION_TIMEOUT = 1007; //session会话超时

    const DELETE_FAILED = 900; // 删除失败
    const ADD_FAILED = 901; //添加记录失败
    const UPDATE_FAILED = 902; //更新记录失败
    const DATA_EXISTS = 903;//数据已存在
    const DATA_NOT_EXISTS = 904; //数据不存在
    const SELECT_ERROR = 905; //查询列表数据错误

    const DB_SAVE_ERROR = 910; //数据库错误
    const DB_READ_ERROR = 911; //Read错误
    const CACHE_SAVE_ERROR = 912; //缓存错误
    const CACHE_READ_ERROR = 913; //Read缓存错误
    const FILE_SAVE_ERROR = 914; //文件保存错误

    const JSON_PARSE_FAIL = 920; //JSON解析失败
    const TYPE_ERROR = 912; //类型错误
    const NUMBER_MATCH_ERROR = 923;//数字匹配误差
    const VERSION_INVALID = 924; //版本无效
    const RECORD_NOT_FOUND = 925; // 记录未找到

    const UPLOAD_FAILED = 1050; // 上传失败
    const UPLOAD_ERROR = 1051; // 上传错误

    /**
     * 错误代码
     * @var array
     */
    static public $returnCode = [
        '0' => '操作成功',
        '999' => '请求错误',
        '998' => '未知错误',
        '997' => '无效操作',
        '996' => '参数为空',
        '995' => '参数无效',
        '994' => 'curl请求错误',
        '1010' => '未登录',
        '1011' => '无权限',
        '1001' => '退出登录',
        '1002' => '登录错误',
        '1003' => '用户名不存在',
        '1004' => '验证码错误',
        '1005' => '其他人登录',
        '1006' => 'token超时',
        '1007' => 'session会话超时',
        '900' => '删除失败',
        '901' => '添加记录失败',
        '902' => '更新记录失败',
        '903' => '数据已存在',
        '904' => '数据不存在',
        '905' => '查询列表数据失败',
        '910' => '数据库错误',
        '911' => 'Read错误',
        '912' => '缓存错误',
        '913' => 'Read缓存错误',
        '914' => '文件保存错误',
        '1050' => '上传失败',
        '1051' => '上传错误',
    ];

    static public function getConstants() {
        $oClass = new \ReflectionClass(__CLASS__);
        return $oClass->getConstants();
    }

}