<?php
/**
 * 构建各类有意义的随机数
 * @since   2018-08-07
 * @author  zhaoxiang <zhaoxiang051405@gmail.com>
 */

namespace org;


class StrRandom {

    /**
     * 生成UUID 单机使用
     * @access public
     * @return string
     */
    static public function uuid() {
        $charId = md5(uniqid(mt_rand(), true));
        $hyphen = chr(45);
        $uuid = chr(123)
            . substr($charId, 0, 8) . $hyphen
            . substr($charId, 8, 4) . $hyphen
            . substr($charId, 12, 4) . $hyphen
            . substr($charId, 16, 4) . $hyphen
            . substr($charId, 20, 12)
            . chr(125);

        return $uuid;
    }

    /**
     * 获取全球唯一标识
     * @return string
     */
    public static function uuid2()
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x', mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0x0fff) | 0x4000, mt_rand(0, 0x3fff) | 0x8000, mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

    /**
     * 生成Guid主键
     * @return Boolean
     */
    static public function keyGen() {
        return str_replace('-', '', substr(self::uuid(), 1, -1));
    }

    /**
     * 产生随机字串，可用来自动生成密码
     * 默认长度6位 字母和数字混合 支持中文
     * @param integer $len 长度
     * @param string $type 字串类型
     * 0 字母 1 数字 其它 混合
     * @param string $addChars 额外字符
     * @return string
     */
    static public function randString($len = 6, $type = '', $addChars = '') {
        $str = '';
        switch ($type) {
            case 0:
                $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz' . $addChars;
                break;
            case 1:
                $chars = str_repeat('0123456789', 3);
                break;
            case 2:
                $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ' . $addChars;
                break;
            case 3:
                $chars = 'abcdefghijklmnopqrstuvwxyz' . $addChars;
                break;
            case 4:
                $chars = "们以我到他会作时要动国产的一是工就年阶义发成部民可出能方进在了不和有大这主中人上为来分生对于学下级地个用同行面说种过命度革而多子后自社加小机也经力线本电高量长党得实家定深法表着水理化争现所二起政三好十战无农使性前等反体合斗路图把结第里正新开论之物从当两些还天资事队批点育重其思与间内去因件日利相由压员气业代全组数果期导平各基或月毛然如应形想制心样干都向变关问比展那它最及外没看治提五解系林者米群头意只明四道马认次文通但条较克又公孔领军流入接席位情运器并飞原油放立题质指建区验活众很教决特此常石强极土少已根共直团统式转别造切九你取西持总料连任志观调七么山程百报更见必真保热委手改管处己将修支识病象几先老光专什六型具示复安带每东增则完风回南广劳轮科北打积车计给节做务被整联步类集号列温装即毫知轴研单色坚据速防史拉世设达尔场织历花受求传口断况采精金界品判参层止边清至万确究书术状厂须离再目海交权且儿青才证低越际八试规斯近注办布门铁需走议县兵固除般引齿千胜细影济白格效置推空配刀叶率述今选养德话查差半敌始片施响收华觉备名红续均药标记难存测士身紧液派准斤角降维板许破述技消底床田势端感往神便贺村构照容非搞亚磨族火段算适讲按值美态黄易彪服早班麦削信排台声该击素张密害侯草何树肥继右属市严径螺检左页抗苏显苦英快称坏移约巴材省黑武培著河帝仅针怎植京助升王眼她抓含苗副杂普谈围食射源例致酸旧却充足短划剂宣环落首尺波承粉践府鱼随考刻靠够满夫失包住促枝局菌杆周护岩师举曲春元超负砂封换太模贫减阳扬江析亩木言球朝医校古呢稻宋听唯输滑站另卫字鼓刚写刘微略范供阿块某功套友限项余倒卷创律雨让骨远帮初皮播优占死毒圈伟季训控激找叫云互跟裂粮粒母练塞钢顶策双留误础吸阻故寸盾晚丝女散焊功株亲院冷彻弹错散商视艺灭版烈零室轻血倍缺厘泵察绝富城冲喷壤简否柱李望盘磁雄似困巩益洲脱投送奴侧润盖挥距触星松送获兴独官混纪依未突架宽冬章湿偏纹吃执阀矿寨责熟稳夺硬价努翻奇甲预职评读背协损棉侵灰虽矛厚罗泥辟告卵箱掌氧恩爱停曾溶营终纲孟钱待尽俄缩沙退陈讨奋械载胞幼哪剥迫旋征槽倒握担仍呀鲜吧卡粗介钻逐弱脚怕盐末阴丰雾冠丙街莱贝辐肠付吉渗瑞惊顿挤秒悬姆烂森糖圣凹陶词迟蚕亿矩康遵牧遭幅园腔订香肉弟屋敏恢忘编印蜂急拿扩伤飞露核缘游振操央伍域甚迅辉异序免纸夜乡久隶缸夹念兰映沟乙吗儒杀汽磷艰晶插埃燃欢铁补咱芽永瓦倾阵碳演威附牙芽永瓦斜灌欧献顺猪洋腐请透司危括脉宜笑若尾束壮暴企菜穗楚汉愈绿拖牛份染既秋遍锻玉夏疗尖殖井费州访吹荣铜沿替滚客召旱悟刺脑措贯藏敢令隙炉壳硫煤迎铸粘探临薄旬善福纵择礼愿伏残雷延烟句纯渐耕跑泽慢栽鲁赤繁境潮横掉锥希池败船假亮谓托伙哲怀割摆贡呈劲财仪沉炼麻罪祖息车穿货销齐鼠抽画饲龙库守筑房歌寒喜哥洗蚀废纳腹乎录镜妇恶脂庄擦险赞钟摇典柄辩竹谷卖乱虚桥奥伯赶垂途额壁网截野遗静谋弄挂课镇妄盛耐援扎虑键归符庆聚绕摩忙舞遇索顾胶羊湖钉仁音迹碎伸灯避泛亡答勇频皇柳哈揭甘诺概宪浓岛袭谁洪谢炮浇斑讯懂灵蛋闭孩释乳巨徒私银伊景坦累匀霉杜乐勒隔弯绩招绍胡呼痛峰零柴簧午跳居尚丁秦稍追梁折耗碱殊岗挖氏刃剧堆赫荷胸衡勤膜篇登驻案刊秧缓凸役剪川雪链渔啦脸户洛孢勃盟买杨宗焦赛旗滤硅炭股坐蒸凝竟陷枪黎救冒暗洞犯筒您宋弧爆谬涂味津臂障褐陆啊健尊豆拔莫抵桑坡缝警挑污冰柬嘴啥饭塑寄赵喊垫丹渡耳刨虎笔稀昆浪萨茶滴浅拥穴覆伦娘吨浸袖珠雌妈紫戏塔锤震岁貌洁剖牢锋疑霸闪埔猛诉刷狠忽灾闹乔唐漏闻沈熔氯荒茎男凡抢像浆旁玻亦忠唱蒙予纷捕锁尤乘乌智淡允叛畜俘摸锈扫毕璃宝芯爷鉴秘净蒋钙肩腾枯抛轨堂拌爸循诱祝励肯酒绳穷塘燥泡袋朗喂铝软渠颗惯贸粪综墙趋彼届墨碍启逆卸航衣孙龄岭骗休借" . $addChars;
                break;
            default :
                // 默认去掉了容易混淆的字符oOLl和数字01，要添加请使用addChars参数
                $chars = 'ABCDEFGHIJKMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789' . $addChars;
                break;
        }
        if ($len > 10) {//位数过长重复字符串一定次数
            $chars = $type == 1 ? str_repeat($chars, $len) : str_repeat($chars, 5);
        }
        if ($type != 4) {
            $chars = str_shuffle($chars);
            $str = substr($chars, 0, $len);
        } else {
            // 中文随机字
            for ($i = 0; $i < $len; $i++) {
                $str .= Strs::mSubStr($chars, floor(mt_rand(0, mb_strlen($chars, 'utf-8') - 1)), 1, 'utf-8', false);
            }
        }

        return $str;
    }

    /**
     * 生成一定数量的随机数，并且不重复（长度过短可能产生数量不足情况）
     * @param integer $number 数量
     * @param integer $length 长度
     * @param integer $mode 字串类型
     * 0 字母 1 数字 其它 混合
     * @return string
     */
    static public function buildCountRand($number, $length = 4, $mode = 1) {
        if ($mode == 1 && $length < strlen($number)) {
            //不足以生成一定数量的不重复数字
            return false;
        }
        $rand = array();
        for ($i = 0; $i < $number; $i++) {
            $rand[] = self::randString($length, $mode);
        }
        $unique = array_unique($rand);
        if (count($unique) == count($rand)) {
            return $rand;
        }
        $count = count($rand) - count($unique);
        for ($i = 0; $i < $count * 3; $i++) {
            $rand[] = self::randString($length, $mode);
        }
        $rand = array_slice(array_unique($rand), 0, $number);

        /*//长度数量极小时可能产生数量不足时重新生成
        if ($count=$number-count($rand) > 0){
            $rand = array_merge($rand,self::buildCountRand($number,$length,$mode));
            $rand = array_slice(array_unique($rand), 0, $number);
        }*/

        return $rand;
    }

    /**
     *  带格式生成随机字符 支持批量生成
     *  但可能存在重复
     * @param string $format 字符格式
     *     # 表示数字 * 表示字母和数字 $ 表示字母
     * @param integer $number 生成数量
     * @return string | array
     */
    static public function buildFormatRand($format, $number = 1) {
        $str = array();
        $length = strlen($format);
        for ($j = 0; $j < $number; $j++) {
            $strTemp = '';
            for ($i = 0; $i < $length; $i++) {
                $char = substr($format, $i, 1);
                switch ($char) {
                    case "*"://字母和数字混合
                        $strTemp .= self::randString(1);
                        break;
                    case "#"://数字
                        $strTemp .= self::randString(1, 1);
                        break;
                    case "$"://大写字母
                        $strTemp .= self::randString(1, 2);
                        break;
                    default://其他格式均不转换
                        $strTemp .= $char;
                        break;
                }
            }
            $str[] = $strTemp;
        }

        return $number == 1 ? $strTemp : $str;
    }

    /**
     * 获取一定范围内的随机数字 位数不足补零
     * @param integer $min 最小值
     * @param integer $max 最大值
     * @return string
     */
    static public function randNumber($min, $max) {
        return sprintf("%0" . strlen($max) . "d", mt_rand($min, $max));
    }

    /**
     * 自动转换字符集 支持数组转换
     * Author: websky
     * @param $string
     * @param string $from
     * @param string $to
     * @return array|mixed|string
     */
    static public function autoCharset($string, $from = 'gbk', $to = 'utf-8') {
        $from = strtoupper($from) == 'UTF8' ? 'utf-8' : $from;
        $to = strtoupper($to) == 'UTF8' ? 'utf-8' : $to;
        if (strtoupper($from) === strtoupper($to) || empty($string) || (is_scalar($string) && !is_string($string))) {
            //如果编码相同或者非字符串标量则不转换
            return $string;
        }
        if (is_string($string)) {
            if (function_exists('mb_convert_encoding')) {
                return mb_convert_encoding($string, $to, $from);
            } elseif (function_exists('iconv')) {
                return iconv($from, $to, $string);
            } else {
                return $string;
            }
        } elseif (is_array($string)) {
            foreach ($string as $key => $val) {
                $_key = self::autoCharset($key, $from, $to);
                $string[$_key] = self::autoCharset($val, $from, $to);
                if ($key != $_key)
                    unset($string[$key]);
            }

            return $string;
        } else {
            return $string;
        }
    }

    /**
     * 构建一个随机浮点数
     * @param int $min 整数部分的最小值，默认值为-999999999
     * @param int $max 整数部分的最大值，默认值为999999999
     * @param int $dmin 小数部分位数的最小值，默认值为 0
     * @param int $dmax 小数部分位数的最大值，默认值为 8
     * @return float
     * @author zhaoxiang <zhaoxiang051405@gmail.com>
     */
    public static function randomFloat($min = -999999999, $max = 999999999, $dmin = 0, $dmax = 8) {
        $rand = '';
        $intNum = mt_rand($min, $max);
        $floatLength = mt_rand($dmin, $dmax);
        if ($floatLength > 1) {
            $rand = Strs::randString($floatLength - 1, 1);
        }
        $floatEnd = mt_rand(1, 9);

        return floatval($intNum . '.' . $rand . $floatEnd);
    }

    /**
     * 获取随机的时间
     * @param string $format PHP的时间日期格式化字符
     * @return false|string
     * @author zhaoxiang <zhaoxiang051405@gmail.com>
     */
    public static function randomDate($format = 'Y-m-d H:i:s') {
        $timestamp = time() - mt_rand(0, 86400 * 3650);

        return date($format, $timestamp);
    }

    /**
     * 构建随机IP地址
     * @return string
     * @author zhaoxiang <zhaoxiang051405@gmail.com>
     */
    public static function randomIp() {
        $ipLong = [
            ['607649792', '608174079'], // 36.56.0.0-36.63.255.255
            ['1038614528', '1039007743'], // 61.232.0.0-61.237.255.255
            ['1783627776', '1784676351'], // 106.80.0.0-106.95.255.255
            ['2035023872', '2035154943'], // 121.76.0.0-121.77.255.255
            ['2078801920', '2079064063'], // 123.232.0.0-123.235.255.255
            ['-1950089216', '-1948778497'], // 139.196.0.0-139.215.255.255
            ['-1425539072', '-1425014785'], // 171.8.0.0-171.15.255.255
            ['-1236271104', '-1235419137'], // 182.80.0.0-182.92.255.255
            ['-770113536', '-768606209'], // 210.25.0.0-210.47.255.255
            ['-569376768', '-564133889'], // 222.16.0.0-222.95.255.255
        ];
        $randKey = mt_rand(0, 9);

        return $ip = long2ip(mt_rand($ipLong[$randKey][0], $ipLong[$randKey][1]));
    }

    /**
     * 随机生成一个 URL 协议
     * @return mixed
     * @author zhaoxiang <zhaoxiang051405@gmail','com>
     */
    public static function randomProtocol() {
        $proArr = [
            'http',
            'ftp',
            'gopher',
            'mailto',
            'mid',
            'cid',
            'news',
            'nntp',
            'prospero',
            'telnet',
            'rlogin',
            'tn3270',
            'wais'
        ];
        shuffle($proArr);

        return $proArr[0];
    }

    /**
     * 随机生成一个顶级域名
     * @author zhaoxiang <zhaoxiang051405@gmail','com>
     */
    public static function randomTld() {
        $tldArr = [
            'com', 'cn', 'xin', 'net', 'top', '在线',
            'xyz', 'wang', 'shop', 'site', 'club', 'cc',
            'fun', 'online', 'biz', 'red', 'link', 'ltd',
            'mobi', 'info', 'org', 'edu', 'com.cn', 'net.cn',
            'org.cn', 'gov.cn', 'name', 'vip', 'pro', 'work',
            'tv', 'co', 'kim', 'group', 'tech', 'store', 'ren',
            'ink', 'pub', 'live', 'wiki', 'design', '中文网',
            '我爱你', '中国', '网址', '网店', '公司', '网络', '集团', 'app'
        ];
        shuffle($tldArr);

        return $tldArr[0];
    }

    /**
     * 获取一个随机的域名
     * @return string
     * @author zhaoxiang <zhaoxiang051405@gmail.com>
     */
    public static function randomDomain() {
        $len = mt_rand(6, 16);

        return strtolower(Strs::randString($len)) . '.' . self::randomTld();
    }

    /**
     * 随机生成一个URL
     * @param string $protocol 协议名称，可以不用指定
     * @return string
     * @author zhaoxiang <zhaoxiang051405@gmail.com>
     */
    public static function randomUrl($protocol = '') {
        $protocol = $protocol ? $protocol : self::randomProtocol();

        return $protocol . '://' . self::randomDomain();
    }

    /**
     * 随机生成一个邮箱地址
     * @param string $domain 可以指定邮箱域名
     * @return string
     * @author zhaoxiang <zhaoxiang051405@gmail.com>
     */
    public static function randomEmail($domain = '') {
        $len = mt_rand(6, 16);
        $domain = $domain ? $domain : self::randomDomain();

        return Strs::randString($len) . '@' . $domain;

    }


    /**
     * 随机生成一个手机号
     * Author: websky
     * @return string
     */
    public static function randomPhone() {
        $prefixArr = [133, 153, 173, 177, 180, 181, 189, 199, 134, 135,
            136, 137, 138, 139, 150, 151, 152, 157, 158, 159, 172, 178,
            182, 183, 184, 187, 188, 198, 130, 131, 132, 155, 156, 166,
            175, 176, 185, 186, 145, 147, 149, 170, 171];
        shuffle($prefixArr);

        return $prefixArr[0] . Strs::randString(8, 1);
    }

    /**
     * 随机创建一个身份证号码
     * @return string
     * @author zhaoxiang <zhaoxiang051405@gmail.com>
     */
    public static function randomId() {
        $prefixArr = [
            11, 12, 13, 14, 15,
            21, 22, 23,
            31, 32, 33, 34, 35, 36, 37,
            41, 42, 43, 44, 45, 46,
            50, 51, 52, 53, 54,
            61, 62, 63, 64, 65,
            71, 81, 82
        ];
        shuffle($prefixArr);

        $suffixArr = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 'X'];
        shuffle($suffixArr);

        return $prefixArr[0] . '0000' . self::randomDate('Ymd') . self::randString(3, 1) . $suffixArr[0];
    }



    /**
     * 生成数字和字母
     *
     * @param int $len 长度
     * @return string
     */
    public static function alnum($len = 6)
    {
        return self::build('alnum', $len);
    }

    /**
     * 仅生成字符
     *
     * @param int $len 长度
     * @return string
     */
    public static function alpha($len = 6)
    {
        return self::build('alpha', $len);
    }

    /**
     * 生成指定长度的随机数字
     *
     * @param int $len 长度
     * @return string
     */
    public static function numeric($len = 4)
    {
        return self::build('numeric', $len);
    }

    /**
     * 数字和字母组合的随机字符串
     *
     * @param int $len 长度
     * @return string
     */
    public static function nozero($len = 4)
    {
        return self::build('nozero', $len);
    }

    /**
     * 能用的随机数生成
     * @param string $type 类型 alpha/alnum/numeric/nozero/unique/md5/encrypt/sha1
     * @param int $len 长度
     * @return string
     */
    public static function build($type = 'alnum', $len = 8)
    {
        switch ($type)
        {
            case 'alpha':
            case 'alnum':
            case 'numeric':
            case 'nozero':
                switch ($type)
                {
                    case 'alpha':
                        $pool = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                        break;
                    case 'alnum':
                        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                        break;
                    case 'numeric':
                        $pool = '0123456789';
                        break;
                    case 'nozero':
                        $pool = '123456789';
                        break;
                }
                return substr(str_shuffle(str_repeat($pool, ceil($len / strlen($pool)))), 0, $len);
            case 'unique':
            case 'md5':
                return md5(uniqid(mt_rand()));
            case 'encrypt':
            case 'sha1':
                return sha1(uniqid(mt_rand(), TRUE));
        }
    }

    /**
     * 根据数组元素的概率获得键名
     *
     * @param array $ps array('p1'=>20, 'p2'=>30, 'p3'=>50);
     * @param array $num 默认为1,即随机出来的数量
     * @param array $unique 默认为true,即当num>1时,随机出的数量是否唯一
     * @return mixed 当num为1时返回键名,反之返回一维数组
     */
    public static function lottery($ps, $num = 1, $unique = true)
    {
        if (!$ps)
        {
            return $num == 1 ? '' : [];
        }
        if ($num >= count($ps) && $unique)
        {
            $res = array_keys($ps);
            return $num == 1 ? $res[0] : $res;
        }
        $max_exp = 0;
        $res = [];
        foreach ($ps as $key => $value)
        {
            $value = substr($value, 0, stripos($value, ".") + 6);
            $exp = strlen(strchr($value, '.')) - 1;
            if ($exp > $max_exp)
            {
                $max_exp = $exp;
            }
        }
        $pow_exp = pow(10, $max_exp);
        if ($pow_exp > 1)
        {
            reset($ps);
            foreach ($ps as $key => $value)
            {
                $ps[$key] = $value * $pow_exp;
            }
        }
        $pro_sum = array_sum($ps);
        if ($pro_sum < 1)
        {
            return $num == 1 ? '' : [];
        }
        for ($i = 0; $i < $num; $i++)
        {
            $rand_num = mt_rand(1, $pro_sum);
            reset($ps);
            foreach ($ps as $key => $value)
            {
                if ($rand_num <= $value)
                {
                    break;
                }
                else
                {
                    $rand_num -= $value;
                }
            }
            if ($num == 1)
            {
                $res = $key;
                break;
            }
            else
            {
                $res[$i] = $key;
            }
            if ($unique)
            {
                $pro_sum -= $value;
                unset($ps[$key]);
            }
        }
        return $res;
    }

    /**
     * 生成条形码 默认13位（国家代码+2位年+3位一年中的天+6位随机数字）
     * Author: websky
     * @param int $number
     * @param string $format
     * @param string $dateFormat
     * @return bool|string
     */
    public static function barCode($number=0,$format='888'){
        if (!$number || strlen($number)>=5){
            return false;
        }
        $rand = self::buildCountRand($number,8,1);
        $format = date('y').sprintf('%03d',date('z'));
        foreach ($rand as &$v){
            $v=$format.$v;
        }
        return $rand;
    }

    /**
     * 防伪码生成（2位年+3位一年中天+9位随机数）
     * Author: websky
     * @param int $number
     * @param int $len
     * @return bool|string
     */
    public static function fangweiCode($number=0,$len=13){
        if (!$number || strlen($number)>=$len){
            return false;
        }
        $rand = self::buildCountRand($number,8,1);
        $format = date('y').sprintf('%03d',date('z'));
        foreach ($rand as &$v){
            $v=$format.$v;
        }
        return $rand;
    }

}
