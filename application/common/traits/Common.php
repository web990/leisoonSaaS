<?php
/**
 * Created by Leisoon.
 * User: websky <web88@qq.com>
 * Date: 2018/12/18 11:00
 */

namespace app\common\traits;

use com\File;
use lib\ReturnCode;
use org\Pinyin;
use org\Strs;
use think\Db;
use think\facade\Cache;
use think\facade\Env;
use think\facade\Log;
use think\facade\Request;

/**
 * 常用 trait
 */
trait Common
{
    /**
     * 返回汉子全拼音
     * Author: websky
     * @param string $str
     * @param bool $isfirst
     */
    public function pinyin($str='',$isfirst=false){
        if (!empty($str)){
            try{
                $pinyin = Pinyin::pinyin($str,$isfirst);
                $this->reSuccess($pinyin);
            }catch (\think\Exception $e){
                $this->reError(999,$e->getMessage());
            }
        }
        $this->reError(ReturnCode::EMPTY_PARAMS);
    }

    /**
     * 返回汉子首拼字母
     * Author: websky
     * @param string $str
     */
    public function pinyinfirst($str=''){
        return $this->pinyin($str,true);
    }


    /**
     * 返回服务器信息
     * Author: websky
     */
    public function getServerInfo()
    {
        $data = Cache::get('get_php_system_version_mysql_v');
        if ($data || config('app_debug')==true){
            $mysqlv=Db::query("select version() as v;");
            $data = [
                'os'=>php_uname('s').' '.php_uname('r')
                ,'cpu'=> isset($_SERVER['PROCESSOR_IDENTIFIER']) ? $_SERVER['PROCESSOR_IDENTIFIER']:''
                ,'ram'=> Strs::format_bytes(memory_get_usage())
                ,'date'=> date('Y-m-d　H:i:s')
                ,'server'=>Request::server('SERVER_SOFTWARE')
                ,'mysql'=>isset($mysqlv[0]['v']) ? $mysqlv[0]['v']:''
                ,'php'=>PHP_VERSION
                ,'php_sapi'=>php_sapi_name() //php运行环境
                ,'http'=>isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL']:''
                ,'upload_max'=>ini_get("file_uploads") ? ini_get("upload_max_filesize") : "Disabled"
            ];
            Cache::set('get_php_system_version_mysql_v',$data);
        }
        $this->reSuccess($data);
    }

    /**
     * 清除缓存
     * Author: websky
     */
    public function cache(){
        $type = $this->request->request("type");
        switch ($type) {
            case 'all':
                Cache::clear();
                $dirname=Env::get('runtime_path').'temp';
                File::del_dir($dirname);
                break;
            case 'cache':
                Cache::clear();
                break;
            case 'log':
                $dirname=Env::get('runtime_path').'log';
                File::del_dir($dirname);
                break;
            case 'temp':
                $dirname=Env::get('runtime_path').'temp';
                File::del_dir($dirname);
                break;
            default:
                Cache::clear();
                $this->reSuccess(1);
        }
        $this->reSuccess(1);
    }

}