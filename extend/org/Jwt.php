<?php
/**
 * Created by Leisoon.
 * User: websky <web88@qq.com>
 * Date: 2018/9/11 9:34
 */

namespace org;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Parser;
/**
 * Jwt 封装
 */
class Jwt extends Builder
{
    protected $issuer='leisoon'; // iss (issuer) 请求实体，可以是发起请求的用户的信息，也可是jwt的签发者
    protected $subject='login'; // subject	设置主题，类似于发邮件时的主题
    protected $audience='vehicle'; // $audience	接收jwt的一方
    protected $expire=36000; // $expire token过期时间
    protected $time; //生成token的时间
    protected $not_before=0; //当前时间在not_before设定时间之前，该token无法使用
    protected $key='b{>=^B-nR`[@6rqd?H,iY+o>UgCF}7(9m1!|YL.P'; // 秘钥签名
    protected $jti; // jti (JWT ID)	对当前token设置唯一标示

    private $sha256;
    private $parser;

    static public $instance;

    /**
     * Jwt constructor.
     * @param array|string $option 字符串为秘钥，更多参数请使用数组['expire'=>过期时间,'key'=>秘钥,'audience'=>接收人,'issuer'=>签发者,'subject'=>主题,'time'=>生成token的时间,'not_before'=>秒内token无效]
     */
    public function __construct($option=null)
    {
        parent::__construct();
        $this->sha256 = new Sha256();
        $this->parser = new Parser();
        if (!isset($this->jti) && empty($this->jti)){
            $this->jti=microtime(true).rand(1111,9999);
        }
        if (empty($time)){
            $this->time=time();
        }
        if (!is_null($option)) {
            if (is_string($option)) {
                $this->key = $option;
            }
            if(isset($option['expire']))
                $this->expire=$option['expire'];
            if(isset($option['key']))
                $this->key=$option['key'];
            if(isset($option['issuer']))
                $this->issuer=$option['issuer'];
            if(isset($option['audience']))
                $this->audience=$option['audience'];
            if(isset($option['subject']))
                $this->subject=$option['subject'];
            if(isset($option['time']))
                $this->time=$option['time'];
            if(isset($option['not_before']))
                $this->not_before=$option['not_before'];
        }
    }

    public static function getInstance($option=null){
        if(!self::$instance){
        }
        self::$instance = new Jwt ($option);
        return self::$instance;
    }


    /**
     * 获取Token
     * Author: websky
     * @param int $id Token的唯一标识
     * @param int $expire 数字为过期时间
     * @param array $data 附加数组
     * @return string
     */
    public function get_token($id=0,$expire=0,$data=[]){
        if ($id){
            $this->jti=$id;
        }
        if ($expire){
            $this->expire=$expire;
        }

        //$this->setIssuer($this->issuer);// 设置发行人
        //$this->setAudience($this->audience);// 设置接收人
        //$this->setSubject($this->subject);// 主题
        $this->setId($this->jti);// 设置id
        $this->setIssuedAt(time());// 设置生成token的时间
        $this->setNotBefore(time()+$this->not_before);// 设置在60秒内该token无法使用
        $this->setExpiration(time()+$this->expire);// 设置过期时间

        // 给token设置值
        if (is_array($data) && !empty($data)){
            foreach( $data as $item=>$value ){
                $this->set($item, $value);
            }
        }
        $this->sign($this->sha256, $this->key);
        $token = $this->getToken();
        return (string)$token;
    }


    /**
     * 验证Token
     * Author: websky
     * @param string $token
     * @param string $key
     * @param bool $isArray
     * @return array|bool|mixed
     */
    public function checkToken($token='',$key='',$isArray=false){
        if (empty($token)){
            return false;
        }
        if (!empty($key)){
            $this->key=$key;
        }
        try{
            $parse = $this->parser->parse($token);
            if (!$parse->verify($this->sha256,$this->key)){
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
     * get_token
     * Author: websky
     * @param int $id token ID
     * @param int $exp 过期时间默认3600秒
     * @param array $data token附加数组
     * @return string
     */
    public static function gToken($id=0,$exp=0,$data=[]){
        return (new Jwt())->get_token($id,$exp,$data);
    }

    /**
     * 验证Token
     * Author: websky
     * @param string $token
     * @param bool $isArray
     * @return array|bool|mixed
     */
    public static function cToken($token='',$isArray=false){
        return (new Jwt())->checkToken($token,$isArray);
    }

}