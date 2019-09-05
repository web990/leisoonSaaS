<?php
/**
 * Created by Leisoon.
 * User: websky
 * Date: 2017/11/13
 * Time: 9:37
 */

namespace org;

/**
 * Class IpHelper
 * @package org
 * 测试：
        $ip1 = "10.237.1.100";
        $ip2 = "10.237.3.100";
        $valid_list = array("10.237.1-2.*");
        $invalid_list = array("10.237.1.100");
        $rs1 = IpHelper::checkIP($ip1, $valid_list);
        $rs2 = IpHelper::checkIP($ip2, $valid_list);
        $rs3 = IpHelper::checkIP($ip1, $valid_list, $invalid_list);
        var_dump($rs1);
        var_dump($rs2);
        var_dump($rs3);
   输出结果：
        boolean true
        boolean false
        boolean false
 */
class IpHelper
{
    /**
     * IP地址转详细地址（格式：国家|区域|省份|城市|ISP）
     * @param $ip
     * @return string Ip2Region
     */
    public static function ip2region($ip){
        $re=self::ip_2_region($ip);
        $str='';
        if (is_array($re) && isset($re['region'])){
            $str=$re['region'];
        }
        return $str;
    }

    /**
     * IP地址转详细地址（格式：城市Id|国家|区域|省份|城市|ISP）
     * @param $ip
     * @return Ip2Region array()
     */
    public static function ip_2_region($ip){
        if (is_numeric($ip)){
            $ip=long2ip($ip);
        }
        $class = new \Ip2Region();
        return $class->btreeSearch($ip);
    }

    /**
     * IP验证
     *
     * 如果地址在黑名单中，返回false;
     * 如果地址不在黑名单但在白名单中，返回true;
     * 如果地址既不在黑名单也不在白名单，视是否是严格模式而定，
     * 如果是严格模式，则当IP不在黑白名单时返回false;反之，返回true
     *
     * @param string $ip 访问IP
     * @param array $valid_list 白名单
     * @param array $invalid_list 黑名单
     * @param boolean $is_strict 是否严格模式
     * @return boolean
     */
    public static function checkIP($ip, $valid_list, $invalid_list=array(), $is_strict=true)
    {
        $ip_segs = explode('.', $ip);
        // 先黑后白
        if (!empty($invalid_list))
        {
            return self::isInSection($ip_segs, $invalid_list) ? false : true;
        }
        if (!empty($valid_list))
        {
            return self::isInSection($ip_segs, $valid_list);
        }
        return $is_strict == true ? false : true;
    }
    /**
     * 判断某个IP是否在某个网段内
     *
     * @param array $ip_segs IP分段数组
     * @param array $section_list 指定IP或IP段列表
     * @return boolean
     */
    public static function isInSection($ip_segs, $ip_list)
    {
        foreach ($ip_list as $key => $val)
        {
            $ip_str = self::formatIp($val);
            if (!empty($ip_str))
            {
                $segments = explode('.', $ip_str);
                if (self::isValidSegment($ip_segs, $segments))
                {
                    return true;
                }
            }
        }
        return false;
    }
    /**
     * 格式化IP
     *
     * @param string $ip IP段或IP地址
     * @return mixed
     */
    public static function formatIp($ip)
    {
        $arr = explode('.', $ip);
        $repeat_count = 4 - count($arr);
        if ($repeat_count < 0)
        {
            return false;
        }
        $ip .= str_repeat('.*', $repeat_count);// 追加成完整格式
        return str_replace('*', '0-255', $ip);// 把星号转换成标准段
    }
    /**
     * 验证IP是否在合法范围中
     *
     * 依次比较每个IP进行判断，如果全都符合，返回true，有任何不符，返回false
     *
     * @param array $ip_segs IP分段数组
     * @param array $segments 指定IP或IP段分段数组
     * @return boolean
     */
    public static function isValidSegment($ip_segs, $segments)
    {
        foreach ($segments as $key => $val)
        {
            if (strstr($val, '-') !== false)
            {
                $range = explode('-', $val);
                if ($ip_segs[$key] < (int)$range[0] || $ip_segs[$key] > (int)$range[1])
                {
                    return false;
                }
            }
            else
            {
                if ((string)$ip_segs[$key] != trim($val))
                {
                    return false;
                }
            }
        }
        return true;
    }

}