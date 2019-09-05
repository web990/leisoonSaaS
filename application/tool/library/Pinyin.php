<?php
/**
 * Created by Leisoon.
 * User: websky <web88@qq.com>
 * Date: 2018/12/12 11:11
 */
namespace app\tool\library;


use org\PinyinMini;
use org\PinyinMs;

/**
 * 拼音类封装
 */
class Pinyin
{
    /**
     * 返回全拼
     * @param $str
     * @return string
     */
    public static function getPinyin($str){
        return self::getPinyinClass($str);
    }

    /**
     * 返回简拼
     * @param $str
     * @return string
     */
    public static function getJianpin($str){
        return self::getPinyinClass($str,true);
    }

    /**
     * 返回拼音
     * @param $str
     * @return string
     */
    public static function pinyin($str,$isFirst=false){
        return self::getPinyinClass($str,$isFirst);
    }

    /**
     * 返回拼音 数组
     * @param $str
     * @return array
     */
    public static function getPinyinArray($str){
        $data = [
            'str'=>$str
            ,'pinyin'=>self::getPinyinClass($str)
            ,'jianpin'=>self::getPinyinClass($str,true)
        ];
        return $data;
    }

    /**
     * 返回拼音类
     * @param $s
     * @param bool $isFirst 首字母
     * @param string $type 拼音Class类（mini、ms、all）
     * @return string
     */
    public static function getPinyinClass($s,$isFirst=false,$type='all'){
        if (empty($s)){
            return false;
        }

        if ($type=='mini'){
            return PinyinMini::utf8_to($s,$isFirst);
        }elseif($type=='ms'){
            return PinyinMs::pinyin($s,$isFirst);
        }else{
            return \org\Pinyin::pinyin($s,$isFirst);
        }
    }


}