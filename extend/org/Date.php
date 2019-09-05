<?php

namespace org;

use think\helper\Time;

/**
 * 日期时间处理类
 */
class Date extends Time
{
    const YEAR = 31536000;
    const MONTH = 2592000;
    const WEEK = 604800;
    const DAY = 86400;
    const HOUR = 3600;
    const MINUTE = 60;

    /**
     * 时间格式化（date 函数重写
     * @param unknown $time
     * @param string $format
     * @return string
     */
    public static function dateFormat($time,$format='Y-m-d H:i') {
        if (empty($time)){
            return '';
        }
        if (!strpos($time,'-') === false){
            return date($format,strtotime($time));
        }
        $time = $time === NULL ? time() : intval($time);
        return date($format, $time);
    }


    /**
     * 计算两个时区间相差的时长,单位为秒
     *
     * $seconds = self::offset('America/Chicago', 'GMT');
     *
     * [!!] A list of time zones that PHP supports can be found at
     * <http://php.net/timezones>.
     *
     * @param   string  $remote timezone that to find the offset of
     * @param   string  $local  timezone used as the baseline
     * @param   mixed   $now    UNIX timestamp or date string
     * @return  integer
     */
    public static function offset($remote, $local = NULL, $now = NULL)
    {
        if ($local === NULL)
        {
            // Use the default timezone
            $local = date_default_timezone_get();
        }
        if (is_int($now))
        {
            // Convert the timestamp into a string
            $now = date(DateTime::RFC2822, $now);
        }
        // Create timezone objects
        $zone_remote = new DateTimeZone($remote);
        $zone_local = new DateTimeZone($local);
        // Create date objects from timezones
        $time_remote = new DateTime($now, $zone_remote);
        $time_local = new DateTime($now, $zone_local);
        // Find the offset
        $offset = $zone_remote->getOffset($time_remote) - $zone_local->getOffset($time_local);
        return $offset;
    }

    /**
     * 计算两个时间戳之间相差的时间
     *
     * $span = self::span(60, 182, 'minutes,seconds'); // array('minutes' => 2, 'seconds' => 2)
     * $span = self::span(60, 182, 'minutes'); // 2
     *
     * @param   int $remote timestamp to find the span of
     * @param   int $local  timestamp to use as the baseline
     * @param   string  $output formatting string
     * @return  string   when only a single output is requested
     * @return  array    associative list of all outputs requested
     */
    public static function span($remote, $local = NULL, $output = 'years,months,weeks,days,hours,minutes,seconds')
    {
        // Normalize output
        $output = trim(strtolower((string) $output));
        if (!$output)
        {
            // Invalid output
            return FALSE;
        }
        // Array with the output formats
        $output = preg_split('/[^a-z]+/', $output);
        // Convert the list of outputs to an associative array
        $output = array_combine($output, array_fill(0, count($output), 0));
        // Make the output values into keys
        extract(array_flip($output), EXTR_SKIP);
        if ($local === NULL)
        {
            // Calculate the span from the current time
            $local = time();
        }
        // Calculate timespan (seconds)
        $timespan = abs($remote - $local);
        if (isset($output['years']))
        {
            $timespan -= self::YEAR * ($output['years'] = (int) floor($timespan / self::YEAR));
        }
        if (isset($output['months']))
        {
            $timespan -= self::MONTH * ($output['months'] = (int) floor($timespan / self::MONTH));
        }
        if (isset($output['weeks']))
        {
            $timespan -= self::WEEK * ($output['weeks'] = (int) floor($timespan / self::WEEK));
        }
        if (isset($output['days']))
        {
            $timespan -= self::DAY * ($output['days'] = (int) floor($timespan / self::DAY));
        }
        if (isset($output['hours']))
        {
            $timespan -= self::HOUR * ($output['hours'] = (int) floor($timespan / self::HOUR));
        }
        if (isset($output['minutes']))
        {
            $timespan -= self::MINUTE * ($output['minutes'] = (int) floor($timespan / self::MINUTE));
        }
        // Seconds ago, 1
        if (isset($output['seconds']))
        {
            $output['seconds'] = $timespan;
        }
        if (count($output) === 1)
        {
            // Only a single output was requested, return it
            return array_pop($output);
        }
        // Return array
        return $output;
    }

    /**
     * 格式化 UNIX 时间戳为人易读的字符串
     *
     * @param	int	Unix 时间戳
     * @param	mixed	$local 本地时间
     *
     * @return	string	格式化的日期字符串
     */
    public static function human($remote, $local = null)
    {
        $timediff = (is_null($local) || $local ? time() : $local) - $remote;
        $chunks = array(
            array(60 * 60 * 24 * 365, 'year'),
            array(60 * 60 * 24 * 30, 'month'),
            array(60 * 60 * 24 * 7, 'week'),
            array(60 * 60 * 24, 'day'),
            array(60 * 60, 'hour'),
            array(60, 'minute'),
            array(1, 'second')
        );

        for ($i = 0, $j = count($chunks); $i < $j; $i++)
        {
            $seconds = $chunks[$i][0];
            $name = $chunks[$i][1];
            if (($count = floor($timediff / $seconds)) != 0)
            {
                break;
            }
        }
        return __("%d {$name}%s ago", $count, ($count > 1 ? 's' : ''));
    }

    /**
     * 获取一个基于时间偏移的Unix时间戳
     *
     * @param string $type 时间类型，默认为day，可选minute,hour,day,week,month,quarter,year
     * @param int $offset 时间偏移量 默认为0，正数表示当前type之后，负数表示当前type之前
     * @param string $position 时间的开始或结束，默认为begin，可选前(begin,start,first,front)，end
     * @param int $year 基准年，默认为null，即以当前年为基准
     * @param int $month 基准月，默认为null，即以当前月为基准
     * @param int $day 基准天，默认为null，即以当前天为基准
     * @param int $hour 基准小时，默认为null，即以当前年小时基准
     * @param int $minute 基准分钟，默认为null，即以当前分钟为基准
     * @return int 处理后的Unix时间戳
     */
    public static function unixtime($type = 'day', $offset = 0, $position = 'begin', $year = null, $month = null, $day = null, $hour = null, $minute = null)
    {
        $year = is_null($year) ? date('Y') : $year;
        $month = is_null($month) ? date('m') : $month;
        $day = is_null($day) ? date('d') : $day;
        $hour = is_null($hour) ? date('H') : $hour;
        $minute = is_null($minute) ? date('i') : $minute;
        $position = in_array($position, array('begin', 'start', 'first', 'front'));

        switch ($type)
        {
            case 'minute':
                $time = $position ? mktime($hour, $minute + $offset, 0, $month, $day, $year) : mktime($hour, $minute + $offset, 59, $month, $day, $year);
                break;
            case 'hour':
                $time = $position ? mktime($hour + $offset, 0, 0, $month, $day, $year) : mktime($hour + $offset, 59, 59, $month, $day, $year);
                break;
            case 'day':
                $time = $position ? mktime(0, 0, 0, $month, $day + $offset, $year) : mktime(23, 59, 59, $month, $day + $offset, $year);
                break;
            case 'week':
                $time = $position ?
                        mktime(0, 0, 0, $month, $day - date("w", mktime(0, 0, 0, $month, $day, $year)) + 1 - 7 * (-$offset), $year) :
                        mktime(23, 59, 59, $month, $day - date("w", mktime(0, 0, 0, $month, $day, $year)) + 7 - 7 * (-$offset), $year);
                break;
            case 'month':
                $time = $position ? mktime(0, 0, 0, $month + $offset, 1, $year) : mktime(23, 59, 59, $month + $offset, get_month_days($month + $offset, $year), $year);
                break;
            case 'quarter':
                $time = $position ?
                        mktime(0, 0, 0, 1 + ((ceil(date('n', mktime(0, 0, 0, $month, $day, $year)) / 3) + $offset) - 1) * 3, 1, $year) :
                        mktime(23, 59, 59, (ceil(date('n', mktime(0, 0, 0, $month, $day, $year)) / 3) + $offset) * 3, get_month_days((ceil(date('n', mktime(0, 0, 0, $month, $day, $year)) / 3) + $offset) * 3, $year), $year);
                break;
            case 'year':
                $time = $position ? mktime(0, 0, 0, 1, 1, $year + $offset) : mktime(23, 59, 59, 12, 31, $year + $offset);
                break;
            default:
                $time = mktime($hour, $minute, 0, $month, $day, $year);
                break;
        }
        return $time;
    }

    /**
     * Excel 日期时间戳转换
     * Author: websky
     * @param $date
     * @param bool $time
     * @return array|int|string
     */
    public static function excelTime($date, $time = false) {
        if(function_exists('GregorianToJD')){
            if (is_numeric( $date )) {
                $jd = GregorianToJD( 1, 1, 1970 );
                $gregorian = JDToGregorian( $jd + intval ( $date ) - 25569 );
                $date = explode( '/', $gregorian );
                $date_str = str_pad( $date [2], 4, '0', STR_PAD_LEFT )
                    ."-". str_pad( $date [0], 2, '0', STR_PAD_LEFT )
                    ."-". str_pad( $date [1], 2, '0', STR_PAD_LEFT )
                    . ($time ? " 00:00:00" : '');
                return $date_str;
            }
        }else{
            $date=$date>25568?$date+1:25569;
            /*There was a bug if Converting date before 1-1-1970 (tstamp 0)*/
            $ofs=(70 * 365 + 17+2) * 86400;
            $date = date("Y-m-d",($date * 86400) - $ofs).($time ? " 00:00:00" : '');
        }
        return $date;
    }

    /**
     * 友好的时间显示
     *
     * @param int    $sTime 待显示的时间
     * @param string $type  类型. normal | mohu | full | ymd | other
     * @param string $alt   已失效
     * @return string
     */
    public static function friendlyDate($sTime,$type = 'normal',$alt = 'false') {
        if (!$sTime)
            return '';
        //sTime=源时间，cTime=当前时间，dTime=时间差
        $cTime      =   time();
        $dTime      =   $cTime - $sTime;
        $dDay       =   intval(date("z",$cTime)) - intval(date("z",$sTime));
        //$dDay     =   intval($dTime/3600/24);
        $dYear      =   intval(date("Y",$cTime)) - intval(date("Y",$sTime));
        //normal：n秒前，n分钟前，n小时前，日期
        if($type=='normal'){
            if( $dTime < 60 ){
                if($dTime < 10){
                    return '刚刚';    //by yangjs
                }else{
                    return intval(floor($dTime / 10) * 10)."秒前";
                }
            }elseif( $dTime < 3600 ){
                return intval($dTime/60)."分钟前";
                //今天的数据.年份相同.日期相同.
            }elseif( $dYear==0 && $dDay == 0  ){
                //return intval($dTime/3600)."小时前";
                return '今天'.date('H:i',$sTime);
            }elseif($dYear==0){
                return date("m月d日 H:i",$sTime);
            }else{
                return date("Y-m-d H:i",$sTime);
            }
        }elseif($type=='mohu'){
            if( $dTime < 60 ){
                return $dTime."秒前";
            }elseif( $dTime < 3600 ){
                return intval($dTime/60)."分钟前";
            }elseif( $dTime >= 3600 && $dDay == 0  ){
                return intval($dTime/3600)."小时前";
            }elseif( $dDay > 0 && $dDay<=7 ){
                return intval($dDay)."天前";
            }elseif( $dDay > 7 &&  $dDay <= 30 ){
                return intval($dDay/7) . '周前';
            }elseif( $dDay > 30 ){
                return intval($dDay/30) . '个月前';
            }elseif( $dDay > 360 ){
                return intval($dDay/360) . '年前';
            }
            //full: Y-m-d , H:i:s
        }elseif($type=='full'){
            return date("Y-m-d , H:i:s",$sTime);
        }elseif($type=='ymd'){
            return date("Y-m-d",$sTime);
        }else{
            if( $dTime < 60 ){
                return $dTime."秒前";
            }elseif( $dTime < 3600 ){
                return intval($dTime/60)."分钟前";
            }elseif( $dTime >= 3600 && $dDay == 0  ){
                return intval($dTime/3600)."小时前";
            }elseif($dYear==0){
                return date("Y-m-d H:i:s",$sTime);
            }else{
                return date("Y-m-d H:i:s",$sTime);
            }
        }
    }


    /**
     * 根据时间戳返回汉字几分钟前等信息
     * Enter description here ...
     * @param unknown_type $the_time
     */
    public static function timeTran($the_time,$format='m-d H:i'){
        $now_time = date("Y-m-d H:i",time());
        $now_time = strtotime($now_time);
        if (is_numeric($the_time)) {
            $show_time = $the_time;
        }else {
            $show_time = strtotime($the_time);
        }
        $dur = $now_time - $show_time;
        $rtime=date($format,$show_time);
        if($dur < 0){
            return $the_time;
        }else{
            if($dur < 60){
                return $dur.'秒前';
            }else{
                if($dur < 3600){
                    return floor($dur/60).'分钟前';
                }else{
                    if($dur < 86400){
                        return floor($dur/3600).'小时前';
                    }else{
                        if($dur < 259200){//3天内
                            return floor($dur/86400).'天前';
                        }else{
                            return $rtime;
                        }
                    }
                }
            }
        }
    }


    /**
     * 传入时间戳,计算距离现在的时间
     * @param  number $time 时间戳
     * @return string       返回多少以前
     */
    public static function wordTime($time) {
        $time = (int) substr($time, 0, 10);
        $int = time() - $time;
        $str = '';
        if ($int <= 2){
            $str = sprintf('刚刚', $int);
        }elseif ($int < 60){
            $str = sprintf('%d秒前', $int);
        }elseif ($int < 3600){
            $str = sprintf('%d分钟前', floor($int / 60));
        }elseif ($int < 86400){
            $str = sprintf('%d小时前', floor($int / 3600));
        }else{
            $str = date('Y-m-d H:i:s', $time);
        }
        return $str;
    }

    /**
     * 返回一年有多少周
     * @param $year
     * @return int
     */
    public static function getYearWeek($year)
    {
        $date = new DateTime;
        $date->setISODate($year, 53);
        return ($date->format("W") === "53" ? 53 : 52);
    }

    /**
     * 返回年中第几周开始日期和结束日期
     * @param string $year
     * @param int $week
     * @param string $format
     * @return array
     */
    public static function getWeekStratEnd($year = '',$week = 0,$format=true) {
        if (!$year){
            $year = date( "Y" );
        }
        if (!$week){
            $week=1;
        }
        if(strlen($week)==1){
            $week='0'.$week;
        }
        $timestamp['start'] = strtotime($year . 'W' . $week);
        $timestamp['end'] = strtotime('+1 week -1 day', $timestamp['start']);
        if ($format){
            return array(date("Y-m-d", $timestamp['start']),date("Y-m-d", $timestamp['end']));
        }else{
            return array($timestamp['start'],$timestamp['end']);
        }
    }

    /**
     * 返回当年第几周开始结束日期
     * @param $week
     * @param int $type
     * @return array|mixed
     */
    public static function getThatYearWeek($week,$type=1){
        $w=get_week_date(false,$week);
        if ($type==1){
            return $w[0];
        }elseif ($type==2){
            return $w[1];
        }else{
            return $w;
        }
    }



}
