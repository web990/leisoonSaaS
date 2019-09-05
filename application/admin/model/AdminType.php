<?php
// +----------------------------------------------------------------
// | LeisoonCMF V5.0
// +----------------------------------------------------------------
// | Copyright (c) 2016 http://www.leisoon.com All rights reserved.
// +----------------------------------------------------------------
// | Author: websky <web88@qq.com>
// +----------------------------------------------------------------

namespace app\admin\model;

use think\facade\Cache;
use think\facade\Config;

/**
 * Type模型
 */
class AdminType extends BaseAdminModel {

    protected $autoWriteTimestamp = true;

    protected $auto = array('update_time');
    protected $insert = ['create_time','icon'=>'', 'status'=>1];

    /**
     * getType 返回id->title数组
     * Author: websky
     * @param int $pid
     * @return array
     */
    public function getType($pid=0){
        return $this->where('pid',$pid)->column('title','id');
    }

    /**
     * getTitle 返回title
     * Author: websky
     * @param int $id
     * @return mixed
     */
    public function getTitle($id=0){
        $data = Cache::get('model_type_all');
        if (empty($data)){
            $data = $this->column('title','id');
            Cache::set('model_type_all',$data,300);
        }
        return $id ? $data[$id]:'';
    }

    /**
     * getValueTitle  根据Value返回title
     * Author: websky
     * @param int $pid
     * @param int $value
     * @return mixed
     */
    public function getValueTitle($pid=0,$value=0){
        $data = Cache::get('model_type_all_pid'.$pid);
        if (empty($data)){
            $data = $this->where('pid',$pid)->column('title','value');
            Cache::set('model_type_all_pid'.$pid,$data,300);
        }
        return $value ? isset($data[$value]) ? $data[$value]:'':'';
    }

    /**
     * 返回状态信息array
     * @param null $type
     * @param null $value 键、值信息（value为文本信息则返回数组对应主键）
     * @return mixed
     */
    public function getStatus($type=null,$value=null){
        if ($type == 'normal'){
            $data = Config::get('config.status_type_normal');
        }else{
            $data = Config::get('config.status_type');
        }

        if (isset($value) && is_numeric($value)){
            return isset($data[$value]) ? $data[$value]:'';
        }elseif (isset($value) && is_string($value) && $value != ''){
            $data = array_flip($data);
            return isset($data[$value]) ? $data[$value]:'';
        }else{
            return $data;
        }
    }

}