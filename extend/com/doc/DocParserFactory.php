<?php
// +----------------------------------------------------------------------
// | LEISOON CMS
// +----------------------------------------------------------------------
// | DataTime 2018-12-6 10:21:19
// +----------------------------------------------------------------------
// | Author: websky <web88@qq.com>　
// +----------------------------------------------------------------------
namespace com\doc;

/**
 * Class DocParserFactory 解析doc
 * 下面的DocParserFactory是对其的进一步封装，每次解析时，可以减少初始化DocParser的次数
 *
 * @example
 *      DocParserFactory::getInstance()->parse($doc);
 */
class DocParserFactory{

    private static $p;
    private function DocParserFactory(){
    }

    public static function getInstance(){
        if(self::$p == null){
            self::$p = new DocParser ();
        }
        return self::$p;
    }

    /**
     * 返回注释文本内容
     * Author: websky
     * @param string $description
     * @return array
     */
    public static function getDoc($description=''){
        if (strpos($description,'@')===false){
            $a = self::getInstance()->parse($description);
            if ($a && isset($a['long_description'])){
                return $a['long_description'];
            }
        }else{
            $a = self::getInstance()->getActionDoc($description);
            if ($a && isset($a[0]) && $a[0]){
                return trim($a[0]);
            }
        }

        return '';
    }

    /**
     * 控制器方法注释解析
     * Author: websky
     * @param string $description
     * @return string
     */
    public static function getActionDoc($description=''){
        $a = self::getInstance()->getActionDoc($description);
        if ($a && isset($a[0]) && $a[0]){
            return trim($a[0]);
        }
        return '';
    }

}