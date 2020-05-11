<?php
// +----------------------------------------------------------------
// | LeisoonCMF V5.0
// +----------------------------------------------------------------
// | Copyright (c) 2016 http://www.leisoon.com All rights reserved.
// +----------------------------------------------------------------
// | Author: websky <web88@qq.com>
// +----------------------------------------------------------------

namespace app\admin\model;

/**
 * 配置信息
 * @package app\common\model
 */
class AdminConfig extends BaseAdminModel {
    protected $auto = [];
    protected $insert = ['name','status'=>1];

    protected function setNameAttr($value){
        return strtolower($value);
    }

    protected function getTypeTextAttr($value, $data){
        $type = config('config_type_list');
        $type_text = explode(',', $type[$data['type']]);
        return $type_text[0];
    }

    /**
     * 获取配置信息
     * Author: websky
     * @param null $group
     * @return array
     */
    public function lists($group=null,$tenant_id=0){
        $map[] = $this->mapBuild('status',1);
        if ($group){
            /*if ($group == 'web'){
                $group = 1;
            }*/
            $map[] = $this->mapBuild('group',$group);
        }
        if ($tenant_id){
            $map[] = $this->mapBuild('tenant_id',$tenant_id);
            $data   = self::useGlobalScope(false)->where($map)->field('type,name,value')->select();
        }else{
            $data   = $this->where($map)->field('type,name,value')->select();
        }

        $config = array();
        if($data){
            foreach ($data as $value) {
                $config[$value['name']] = $this->parseFieldAttr($value['type'], $value['value']);
            }
        }
        return $config;
    }

    /**
     * 根据配置类型解析配置
     * @param  integer $type  配置类型
     * @param  string  $value 配置值
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public function parseFieldAttr($type, $value){
        $array = preg_split('/[,;\r\n]+/', trim($value, ",;\r\n"));
        switch ($type) {
            case 'array': //解析数组
                if(strpos($value,':')){
                    $value  = array();
                    foreach ($array as $val) {
                        $list = explode(':', $val);
                        if(isset($list[2])){
                            $value[$list[0]]   = $list[1].','.$list[2];
                        }else{
                            $value[$list[0]]   = $list[1];
                        }
                    }
                }else{
                    $value =    $array;
                }
                break;
            case 'select':
                if (strpos($value, ':')) {
                    $value = array();
                    foreach ($array as $val) {
                        list($k, $v) = explode(':', $val);
                        $value[$k]   = $v;
                    }
                } else {
                    $value = $array;
                }
                break;
        }
        return $value;
    }

    /**
     * 解析配置字段
     * @param null $name
     * @return array|array[]|false|string|string[]
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getFieldParse($name=null){
        $info = $this->where('name',$name)->find();
        if ($info){
            return $this->parseFieldAttr($info['type'],$info['value']);
        }

    }

}