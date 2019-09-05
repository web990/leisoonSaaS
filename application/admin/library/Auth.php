<?php
/**
 * Created by Leisoon.
 * User: websky <web88@qq.com>
 * Date: 2018/12/12 11:11
 */
namespace app\admin\library;

use com\Encrypt;
use org\Tree;
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
    protected $token='';       //access_token
    public $uid=0;           //User ID
    public $tenant_id=0;     //租户id

    /**
     * 错误信息
     * @var mixed
     */
    protected $error;

    /* 权限配置信息，如果配置信息有则覆盖此信息*/
    protected $config = [
        'auth_on'           => 1, // 权限开关
        'auth_type'         => 1, // 认证方式，1为实时认证；2为登录认证。
        'auth_group'        => 'auth_group', // 用户组数据表名
        'auth_group_access' => 'auth_group_access', // 用户-用户组关系表
        'auth_group_extend' => 'admin_role_extend', // 用户组扩展关系表
        'auth_category'     => 'admin_category', // 栏目分类信息表
        'auth_rule'         => 'auth_rule', // 权限规则表
        'auth_user'         => 'admin', // 用户信息表

        'user_max_cache'     => 100,   //最大缓存用户数
        'user_administrator' => 1, //超级管理员
        'user_key'           => 'b{<=^B-nR`[@6rqd?H,iN+o>UgWCF}7(9m1!|YL.P',

        'token_issuer'         => 'leisoon', // iss (issuer) 请求实体，可以是发起请求的用户的信息，也可是jwt的签发者
        'token_subject'        => 'login', // subject	设置主题，类似于发邮件时的主题
        'token_audience'       => 'vehicle', // audience	接收jwt的一方
        'token_expire'         => 36000, // token过期时间
        'token_time'           => 0, // 生成token的时间
        'token_not_before'     => 0 ,   //当前时间在not_before设定时间之前，该token无法使用
        'token_key'            => 'websky@#leisoon', // 秘钥签名
    ];

    /**
     * Auth 类架构函数.
     * @param array $options
     */
    public function __construct($options=[])
    {
        //parent::__construct($options);
        $auth = Config::get('auth.');
        if ($auth){
            $this->config = array_merge($this->config, (array)$auth);
        }

        if (!empty($options)){
            //如果是字符串则认为是token
            if (is_string($options)){
                $this->token=$options;
            }elseif (is_array($options)){
                $this->config = array_merge($this->config, $options);
            }
        }

        $this->getUid();
    }

    /**
     * 初始化
     * @access public
     * @param array $options 参数
     * @return \com\Auth
     */
    public static function instance($options = [])
    {
        if (is_null(self::$instance))
        {
            self::$instance = new static($options);
        }

        return self::$instance;
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
        return parent::check($name, $uid ? $uid:$this->uid, $relation, $mode);
    }

    /**
     * getUid
     * Author: websky
     * @param null $token
     * @return array|bool|mixed
     */
    public function getUid($token=null){
        if ($this->uid && $this->tenant_id){
            return $this->uid;
        }

        $token = $token ? $token:$this->token;
        if ($token){
            $this->setToken($token);
            $tokenInfo = $this->checkToken($token,true);
            if ($tokenInfo && isset($tokenInfo['jti'])){
                $this->uid=$tokenInfo['jti'];
                $this->tenant_id = isset($tokenInfo['tenant_id']) ? $tokenInfo['tenant_id']:0;
            }
        }else{
            //session验证
            $user = session('user_auth');
            if (!empty($user) && session('user_auth_sign') ==  Encrypt::data_auth_sign($user)){
                $this->uid = $user['uid'];
                $this->tenant_id = isset($user['tenant_id']) ? $user['tenant_id']:0;
            }
        }
        return $this->uid;
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
    public function getToken($uid=0,$tenant_id=0){
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
            $Builder->set('tenant_id',$tenant_id);//租户id

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
     * 验证是否登录（session、token双验证，同时满足一个条件即可登录）
     * Author: websky
     * @param string $token 验证token
     * @return array|bool|mixed
     */
    public function isLogin($token=''){
        $token = $token ? $token:$this->token;
        if ($token){
            //token验证
            $uid = $this->checkToken($token);
            if (empty($uid)){
                return false;
            }

            $user = Cache::get('user_auth_'.$uid);
            if ($user && isset($user['expire_time'])) {
                if ($user['expire_time'] > time()){
                    return $uid;
                }
            }
            return false;
        }else{
            //session验证
            $user = session('user_auth');
            if (!empty($user)) {
                return session('user_auth_sign') ==  Encrypt::data_auth_sign($user) ? $user['uid'] : 0;
            }
        }
        return false;
    }

    /**
     * 是否超级管理员
     * Author: websky
     * @return bool
     */
    public function isSuperAdmin($uid=0)
    {
        /*if (in_array('*', $this->getRuleIds($uid))){
            return true;
        }*/
        $uid = $uid ? $uid:$this->uid;
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
        $user = Db::name($this->config['auth_user'])->where($map)->whereNull('delete_time')->find();
        if($user && $user['status']){
            /* 验证用户密码 */
            $password = $this->passwordMd5($password);
            if($password === $user['password']){
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
        $token = $this->getToken($user['id'],$user['tenant_id']);

        /* 记录登录Redis */
        $auth = array(
            'uid'             => $user['id'],
            'tenant_id'       => $user['tenant_id'],
            'username'        => $user['username'],
            'expire_time' => time()+$this->config['token_expire']
        );

        //临时解决关联模型等无法关闭和获取到tenant_id问题（websky201905241715）
        session('tenant_id',$user['tenant_id']);

        //session 登录
        session('user_auth',$auth);
        session('user_auth_sign', Encrypt::data_auth_sign($auth));

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
        $uid = $this->isLogin($token);

        //退出登录标签位（传回一个UID参数）
        Hook::listen('user_logout',9);

        if (!$uid){
           return false;
        }

        session('user_auth',null);
        session('user_auth_sign', null);

        //临时解决关联模型等无法关闭和获取到tenant_id问题（websky201905241715）
        session('tenant_id',null);

        Cache::rm('user_auth_'.$uid);
        return true;
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
        if (!isset($user_info[$uid]))
        {
            $user = Db::name($this->config['auth_user']);
            $_pk = is_string($user->getPk()) ? $user->getPk() : 'id';
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
    public function getMenu($uid=0,$tenant_id=0){
        $uid = $uid ? $uid:$this->uid;
        $tenant_id = $tenant_id ? $tenant_id:($this->tenant_id ? $this->tenant_id:0);

        try{
            $data = Cache::get('auth_rule_menu_'.$uid);
            if ($data && config('app_debug')==false){
                return $data;
            }

            //$list = Db::name($this->config['auth_rule'])->where('is_menu',1)->where('tenant_id',$tenant_id)->whereNull('delete_time')->field('id,name,title,jump,pid,icon')->order('sort asc')->select();
            $list = Db::name($this->config['auth_rule'])->where('is_menu',1)->whereNull('delete_time')->field('id,name,title,jump,pid,icon')->order('sort asc')->select();
            $menu=[];
            foreach ($list as $k=>$v){
                //判断权限
                if (!$this->check($v['name'],$uid)){
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
            Cache::set('auth_rule_menu_'.$uid,$data,3600);

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
     * MD5非常规加密
     * @param $password
     * @return string
     */
    public function passwordMd5($password){
        if ($password){
            //RSA加密密码解密后md5
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
            $password = Encrypt::md5($password,$this->config['user_key']);
        }
        return $password;
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

    /**
     * 返回用户拥有管理权限的扩展数据id列表
     * @param int     $uid  用户id
     * @param int     $type 扩展数据标识
     * @param int     $session  结果缓存标识
     * @return array
     * @author Websky <web88@qq.com>
     */
    public function getAuthExtend($uid,$type=0){
        if (!$type) {
            return false;
        }
        if (2 == $this->config['auth_type'] && Cache::has('_extend_list_' . $uid))
        {
            $result = Cache::get('_extend_list_' . $uid);
        }
        if ( $uid == $this->uid && !empty($result) ) {
            return $result;
        }

        if ($this->isSuperAdmin($uid)){
            $result = Db::name($this->config['auth_category'])
                ->where('status',1)
                ->where('tenant_id',$this->tenant_id)
                ->whereNull('delete_time')
                ->column('id');
        }else{
            $result = Db::name($this->config['auth_group_access'])
                ->alias('aga')
                ->join($this->config['auth_group_extend'].' b','aga.role_id=b.role_id')
                ->where("aga.uid='$uid' and b.type='$type' and !isnull(extend_id)")
                ->column('extend_id');
            $result = array_unique($result);
        }

        //登录验证则缓存扩展规则列表
        if (2 == $this->config['auth_type'])
        {
            Cache::set('_extend_list_' . $uid, $result);
        }
        return $result;
    }

    /**
     * 获取用户组授权的扩展信息数据
     * @param int     $gid  用户组id
     * @return array
     * @author Websky <web88@qq.com>
     */
    public function getExtendOfGroup($role_id,$type=null){
        if ( !is_numeric($type) ) {
            return false;
        }
        return Db::name($this->config['auth_group_extend'])->where('role_id',$role_id)->where('type',$type)->column('extend_id');
    }

    /**
     * 返回分类读写删审权限
     * @param string $type （read/add/edit/delete/examine）
     * @param int $category_id 大于0返回栏目是否有权限bool
     * @param int $uid
     * @return array|bool
     */
    public function getAuthCategory($type='read',$category_id=0,$uid=0){
        $uid = $uid ? $uid:$this->uid;

        $auth = Db::name($this->config['auth_group_extend'])
            ->alias('a')
            ->join($this->config['auth_group_access'].' b','a.role_id=b.role_id')
            ->where('a.'.$type,1)
            ->where('b.uid',$uid)
            ->column('a.extend_id');
        $auth = array_unique(is_array($auth)?$auth:[]);
        if ($category_id){
            if ($this->isSuperAdmin($uid) || in_array($category_id, $auth)){
                return true;
            }
        }else{
            return $auth;
        }

        return false;
    }

    /**
     * 返回分类下读取权限
     * @param $category_id
     * @param int $uid
     * @return array|bool
     */
    public function getAuthCategoryRead($category_id=0,$uid=0){
        return $this->getAuthCategory('read',$category_id,$uid);
    }
    /**
     * 返回分类下添加权限
     * @param $category_id
     * @param int $uid
     * @return array|bool
     */
    public function getAuthCategoryAdd($category_id=0,$uid=0){
        return $this->getAuthCategory('add',$category_id,$uid);
    }
    /**
     * 返回分类下修改权限
     * @param $category_id
     * @param int $uid
     * @return array|bool
     */
    public function getAuthCategoryEdit($category_id=0,$uid=0){
        return $this->getAuthCategory('edit',$category_id,$uid);
    }
    /**
     * 返回分类下删除权限
     * @param $category_id
     * @param int $uid
     * @return array|bool
     */
    public function getAuthCategoryDelete($category_id=0,$uid=0){
        return $this->getAuthCategory('delete',$category_id,$uid);
    }
    /**
     * 返回分类下审核权限
     * @param $category_id
     * @param int $uid
     * @return array|bool
     */
    public function getAuthCategoryExamine($category_id=0,$uid=0){
        return $this->getAuthCategory('examine',$category_id,$uid);
    }

}