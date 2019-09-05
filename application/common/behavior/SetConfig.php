<?php
/**
 * Created by Leisoon.
 * User: websky <web88@qq.com>
 * Date: 2018/12/12 9:01
 */

namespace app\common\behavior;

use think\facade\Cache;

/**
 * 设置SetConfig信息
 */
class SetConfig
{
    public function run($group)
    {
        //读取数据库中的配置
        $config = Cache::get('admin_config_data');
        if (!$config) {
            $config = \app\common\model\facade\Config::lists($group);
            Cache::set('admin_config_data', $config);
        }

        //绑定到admin数组，如：config('admin.site_title')
        Config($config, empty($group) ? 'admin' : $group);
    }
}