<?php
/**
 * Created by Leisoon.
 * User: websky <web88@qq.com>
 * Date: 2018/12/12 11:11
 */
namespace lib;

use com\Tree;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Parser;
use think\Db;
use think\facade\Cache;
use think\facade\Config;
use think\facade\Hook;
use think\facade\Request;

/**
 * 用户登录权限验证类
 * JWT Token + Cache（Redis） 方式
 */
class Auth extends \com\Auth
{
    protected $token;       //access_token
    public $uid;           //User ID
    public $tenant_id;     //租户id

    /**
     * 错误信息
     * @var mixed
     */
    protected $error;

    /* 权限配置信息，如果配置信息有则覆盖此信息 */
    protected $config = [
        'auth_on'           => 1, // 权限开关
        'auth_type'         => 1, // 认证方式，1为实时认证；2为登录认证。
        'auth_group'        => 'auth_group', // 用户组数据表名
        'auth_group_access' => 'auth_group_access', // 用户-用户组关系表
        'auth_rule'         => 'auth_rule', // 权限规则表
        'auth_user'         => 'admin', // 用户信息表

        /* 用户相关设置 */
        'user_max_cache'     => 100,   //最大缓存用户数
        'user_administrator' => 1, //超级管理员
        'user_key'           => 'b{<=^B-nR`[@6rqd?H,iN+o>UgCF}7(9m1!|YL.P',

        'token_issuer'         => 'leisoon', // iss (issuer) 请求实体，可以是发起请求的用户的信息，也可是jwt的签发者
        'token_subject'        => 'login', // subject	设置主题，类似于发邮件时的主题
        'token_audience'       => 'vehicle', // audience	接收jwt的一方
        'token_expire'         => 36000, // token过期时间
        'token_time'           => 0, // 生成token的时间
        'token_not_before'     => 0 ,   //当前时间在not_before设定时间之前，该token无法使用
        'token_key'            => 'yksbew@{Noosiel!', // 秘钥签名
    ];

    /**
     * Auth 类架构函数.
     * @param array $options
     */
    public function __construct($options=[])
    {
        //parent::__construct($options);
        if ($config = Cache::get('auth_config_data')){
            $this->config = $config;
        }else{
            if ($auth = Config::get('auth.')){
                $this->config = array_merge($this->config, (array)$auth);
                Cache::set('auth_config_data',$this->config);
            }
        }

        if (!empty($options) && is_array($options))
        {
            $this->config = array_merge($this->config, $options);
        }

        //如果是字符串则认为是token
        if (!empty($options) && is_string($options))
        {
            $this->token=$options;
            $this->getUid();//实例化时就验证token
        }
    }

    /**
     * 检查权限
     * @param       $name   string|array    需要验证的规则列表,支持逗号分隔的权限规则或索引数组
     * @param       $uid    int             认证用户的id
     * @param       string  $relation       如果为 'or' 表示满足任一条规则即通过验证;如果为 'and'则表示需满足所有规则才能通过验证
     * @param       string  $mode           执行验证的模式,可分为url,normal
     * @return bool               通过验证返回true;失败返回false
     */
    public function check($name, $uid=0, $relation = 'or', $mode = 'url'){
        return parent::check($name, $this->uid, $relation, $mode);
    }

    /**
     * getUid
     * Author: websky
     * @param null $token
     * @return array|bool|mixed
     */
    public function getUid($token=null){
        if ($this->uid){
            return $this->uid;
        }
        $this->setToken($token);
        $uid = $this->checkToken($this->token);
        if ($uid){
            $this->uid=$uid;
            $this->tenant_id=9;
            return $uid;
        }
        return false;
    }

    /**
     * 设置token
     * Author: websky
     * @param $token
     */
    public function setToken($token){
        if (!empty($token) && is_string($token)){
            $this->token=$token;
        }
    }

    /**
     * 根据UID生成 accessToken
     * Author: websky
     * @param int $uid
     * @param null $tokenKey
     * @param null $tokenExpire
     * @return bool|string
     */
    public function getToken($uid=0){
        if (empty($uid)){
            return false;
        }

        try{
            $Builder = new Builder();
            $Builder->setIssuer($this->config['token_issuer']);// 设置发行人
            $Builder->setAudience($this->config['token_audience']);// 设置接收人
            $Builder->setSubject($this->config['token_subject']);// 主题
            $Builder->setId($uid);// 设置id
            $Builder->setIssuedAt(empty($this->config['token_time'])===false ? $this->config['token_time']:time());// 设置生成token的时间
            $Builder->setNotBefore(time()+$this->config['token_not_before']);// 设置在60秒内该token无法使用
            $Builder->setExpiration(time()+$this->config['token_expire']);// 设置过期时间

            $sha256 = new Sha256();
            $Builder->sign($sha256, $this->config['token_key']);
            $token = $Builder->getToken();
            return (string)$token;
        }catch (\Exception $e){
            return false;
        }
    }

    /**
     * 验证Token
     * Author: websky
     * @param string $token
     * @param string $key
     * @param bool $isArray
     * @return array|bool|mixed
     */
    public function checkToken($token='',$isArray=false){
        if (empty($token)){
            return false;
        }
        try{
            $par = new Parser();
            $sha256 = new Sha256();

            $parse = $par->parse($token);
            if (!$parse->verify($sha256,$this->config['token_key'])){
                return false;
            }
            if ($parse->getClaim('exp') < time()){
                return false;
            }
            if ($isArray){
                $data = $parse->getClaims();
                $new=[];
                foreach ($data as $k=>$v){
                    $new[$k]=(string)$v;
                }
                return $new;
            }
            return $parse->getClaim('jti');
        }catch (\Exception $e){
            return false;
        }
    }

    /**
     * 验证是否登录
     * Author: websky
     * @param string $token 验证token
     * @return array|bool|mixed
     */
    public function isLogin($token=''){
        $this->setToken($token);
        $uid = $this->checkToken($this->token);
        if (empty($uid)){
            return false;
        }

        $user = Cache::get('user_auth_'.$uid);
        if ($user && isset($user['expire_time'])) {
            if ($user['expire_time'] > time()){
                return true;
            }
        }
        return false;
    }

    /**
     * 是否超级管理员
     * Author: websky
     * @return bool
     */
    public function isSuperAdmin()
    {
        if (in_array('*', $this->getRuleIds())){
            return true;
        }
        $uid=$this->uid;
        $administrator=$this->config['user_administrator'];
        if (is_array($administrator)){
            return in_array(intval($uid),$administrator,true);
        }else{
            return $uid && (intval($uid) === $administrator);
        }
    }

    /**
     * 用户登录认证
     * Author: websky
     * @param $username 用户名
     * @param $password 用户密码
     * @param int $type 用户名类型 （1-用户名，2-邮箱，3-手机，4-UID）
     * @return bool|string|array 失败返回false 成功返回包含access_token的数组
     */
    public function login($username, $password, $type = 1){
        $map = [];
        if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
            $type = 2;
        }elseif (preg_match("/^1[34578]{1}\d{9}$/",$username)) {
            $type = 3;
        }
        switch ($type) {
            case 1:
                $map['username'] = $username;
                break;
            case 2:
                $map['email'] = $username;
                break;
            case 3:
                $map['mobile'] = $username;
                break;
            case 4:
                $map['id'] = $username;
                break;
            default:
                return 0; //参数错误
        }

        /* 获取用户数据 */
        $user = Db::name($this->config['auth_user'])->where($map)->where('delete_time IS NULL')->find();
        if($user && $user['status']){
            if (strlen($password) > 64) {
                openssl_private_decrypt(base64_decode($password),$decrypted,$this->rsaPrivateKey());
                if(!empty($decrypted)) {
                    $arr = json_decode($decrypted, true);
                    if(array_key_exists("encrypt",$arr)) {
                        if($arr['encrypt']=="yes" && $arr['password']) {
                            $password=$arr['password'];//赋值解密后密码
                        }
                    }
                }
            }
            /* 验证用户密码 */
            if(think_ucenter_md5($password, $this->config['user_key']) === $user['password']){
                /* 更新登录信息 */
                $data = array(
                    'id'             => $user['id'],
                    'login'           => ['inc',1],
                    'login_time' => time(),
                    'login_ip'   => Request::ip(1),
                );
                Db::name($this->config['auth_user'])->update($data);

                return $this->autoLogin($user);
            } else {
                $this->error='密码错误';
                return false;
            }
        } else {
            $this->error='用户不存在或被禁用';
            return false;
        }
    }
    /**
     * 自动登录用户
     * Author: websky
     * @param $user
     * @return array
     */
    private function autoLogin($user){

        //获取生成token
        $token = $this->getToken($user['id']);

        /* 记录登录Redis */
        $auth = array(
            'uid'             => $user['id'],
            'username'        => $user['username'],
            'expire_time' => time()+$this->config['token_expire']
        );

        Cache::set('user_auth_'.$user['id'], $auth,$this->config['token_expire']);

        //登录成功标签位（回传用户信息参数）
        Hook::listen('user_login',$user);

        return ['access_token'=>$token];
    }

    /**
     * 注销当前用户
     * Author: websky
     * @param string|integer $token|uid
     * @return bool
     */
    public function logout($token=''){
        $this->setToken($token);
        $uid = $this->getUid();

        if ($uid){
            Cache::rm('user_auth_'.$uid);

            //退出登录标签位（传回一个UID参数）
            Hook::listen('user_logout',$uid);
            return true;
        }
        return false;
    }

    /**
     * 获取用户数据
     * Author: websky
     * @param string|int $field
     * @return bool|null|array
     */
    public function getUser($field=null){
        $uid = is_numeric($field) ? $field : $this->getUid();

        $user_info = Cache::get('auth_user_data');
        $user = Db::name($this->config['auth_user']);
        $_pk = is_string($user->getPk()) ? $user->getPk() : 'uid';
        if (!isset($user_info[$uid]))
        {
            $user_info[$uid] = $user->where($_pk, $uid)->find();

            //超过最大缓存数自动移除最早信息
            $count = count($user_info);
            $max   = $this->config['user_max_cache'];
            while ($count-- > $max) {
                array_shift($user_info);
            }

            Cache::set('auth_user_data',$user_info);
        }

        if ($user_info[$uid]){
            if ($field && is_string($field) && isset($user_info[$uid][$field])){
                return $user_info[$uid][$field];
            }
            return $user_info[$uid];
        }
        return false;
    }

    /**
     * 返回权限菜单
     * Author: websky
     * @return mixed
     */
    public function getMenu(){
        try{
            $data = Cache::get('auth_rule_menu_'.$this->uid);
            if (!$data){
                $list = Db::name($this->config['auth_rule'])->where('is_menu',1)->order('sort asc')->field('id,name,title,jump,pid,icon')->where('delete_time IS NULL')->select();

                $menu=[];
                foreach ($list as $k=>$v){
                    //判断权限
                    if (!$this->check($v['name'])){
                        continue;
                    }
                    $menu[$k]['name']=$v['name'];
                    $menu[$k]['title']=$v['title'];
                    $menu[$k]['icon']=$v['icon'];
                    $menu[$k]['jump']=$v['jump']?$v['jump']:$v['name'];
                    $menu[$k]['pid']=$v['pid'];
                    $menu[$k]['id']=$v['id'];
                }

                $data = Tree::toTree($menu,'id','pid','list');
                Cache::set('auth_rule_menu_'.$this->uid,$data,3600);
            }
            return $data;
        }catch (\think\exception\PDOException $e){
            $this->error=$e->getMessage();
        }catch (\think\Exception $e){
            $this->error=$e->getMessage();
        }
        return false;
    }

    /**
     * 检测当前控制器和方法是否匹配传递的数组
     * Author: websky
     * @param array $arr 需要验证权限的数组
     * @return bool
     */
    public function match($arr = [])
    {
        $arr = is_array($arr) ? $arr : explode(',', $arr);
        if (!$arr) {
            return FALSE;
        }

        $arr = array_map('strtolower', $arr);
        // 是否存在
        if (in_array(strtolower(Request::action()), $arr) || in_array('*', $arr)) {
            return TRUE;
        }

        // 没找到匹配
        return FALSE;
    }

    /**
     * 获取错误信息
     * @access public
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * RSA私钥
     * @return string
     */
    protected function rsaPrivateKey(){
        $private_key='-----BEGIN RSA PRIVATE KEY-----
MIICWwIBAAKBgQC9TV0PFokn9EDyP5P/dwhkoaJYnecuCLn6qrFkvAmr5JY1oR22
ck1UaQGQaNcwOxd9eGVcPbkT62LIXj4XWlJNYjYmNB4wh5cKu68Y0UR55ZuOsKXY
tBRyC6nVt9WmF/aKtwj13lotl5M6Jg/Vng76fBaxu1npkqcw4qAohFT4IwIDAQAB
AoGAew+L638O8rZKcjD6mRxcjG63Bzy/SKHLpTTJ1V6YOvKC46I1mqF7u9/3cFV3
bpc7kglueyR06Iog0XjSjIPe8+iwaMHC6h/axoiV24xYpp0Y8WBTG/fqDFEI7G33
ootLLj77bGf/xut3PTlvLu2dWIUX0kN++1AqrnXRyV+LIeECQQDpHXL3K/gOTk+k
B5JN+TkiePtz2ewAc/nwKWe0YYX3PG121jGYeXnlaAwvY+rT6ifgARDPqBS//0js
AZPwCVPPAkEAz+LUDqf56tJLZ3kpGTNws8FQPlT43pDYRzblnqxXS5h6yH4Srfk5
dPxg8DpGq/pW6M2ZQe0DbrSCRFkfixxnbQJAWQG8hrGMGfI+qFOXwhvZe9cTs21O
lfGySceVaCMgYoD5DrnD4ALpzvTGSkXtQJKUPQxLHe6AVbqkXjBQCwOUswJAQQlO
nFMy3aLy0ilWkTrFnIby6r08qqyX7RegmJaELPNEHmtKvsDEl/PJA/7HU1BbVjPU
KYrT0xOH2YgkVSoKtQJANjjTQmRF7DvXpgeEyMRpPAPJMTIE0XqwunMhDmsWUKvi
qYZpm/uRVBZAZJLr10xSq7eSgKu6J2N9uJ0CAOjXsw==
-----END RSA PRIVATE KEY-----';
        return $private_key;
    }

}