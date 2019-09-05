<?php
// +----------------------------------------------------------------
// | LeisoonCMF V5.0
// +----------------------------------------------------------------
// | Copyright (c) 2016 http://www.leisoon.com All rights reserved.
// +----------------------------------------------------------------
// | Author: websky <web88@qq.com>
// +----------------------------------------------------------------

namespace app\common\model;

use think\facade\Request;
use think\Model;

class Base extends Model
{
    protected $readonly = ['id','tenant_id']; //定义只读字段

    protected $tenant_id = 0; //租户id
    protected $uid = 0;       //用户id

    protected $globalScope = ['TenantId']; // 定义全局的查询范围

    //定义自动类型转换字段
    protected $type = [
        'id' => 'integer'
    ];

    protected static function init()
    {
        /**
         * 新增后记录日志
         */
        self::afterInsert(function ($model){
            //获取执行的model名称

        });
    }

    public function __construct($data = [])
    {
        parent::__construct($data);

        if ($data && is_array($data)){
            $this->setConfig($data);
        }

        //临时解决关tenant_id问题（websky201905241715）
        if (!$this->tenant_id && session('?tenant_id')){
            $this->setTenantId(session('tenant_id'));
        }
    }

    /**
     * 设置模型参数
     * @param array|$data []
     * @return int|string
     */
    public function setConfig($data=[]){
        if ($data){
            if ($data && isset($data['tenant_id'])){
                $this->setTenantId($data['tenant_id']);
            }

            if ($data && isset($data['uid'])){
                $this->setUid($data['uid']);
            }
        }
    }

    /**
     * 设置租户id
     * @param $value
     * @return int|string
     */
    public function setTenantId($value){
        if ($value && is_numeric($value)){
            $this->tenant_id = $value;
            session('tenant_id',$value);
        }
    }

    /**
     * 返回租户id
     * @return int
     */
    public function getTenantId(){
        return $this->tenant_id;
    }

    /**
     * 设置用户id
     * @param $value
     * @return int|string
     */
    public function setUid($value){
        if ($value && is_numeric($value)){
            $this->uid = $value;
        }
    }

    /**
     * 条件表达式生成
     * Author: websky
     * @param $field 字段名
     * @param $condition 查询条件
     * @param null $op 查询表达式
     * @return array
     */
    protected function mapBuild($field,$condition,$op=null){
        $map=[];
        if (empty($field) || empty($condition)){
            return $map;
        }

        if (!empty($op)){
            if ($op == strtolower('like')){
                $condition='%'.$condition.'%';
            }
        }

        if (is_array($condition)){
            $map=[$field,$op ? $op:'in',$condition];
        }elseif (is_string($condition) && strpos($condition,',')==true){
            $map=[$field,$op ? $op:'in',explode(',',$condition)];
        }elseif (is_numeric($condition)){
            $map=[$field,$op ? $op:'=',$condition];
        }elseif (is_string($condition)){
            $map=[$field,$op ? $op:'=',$condition];
        }

        return $map;
    }

    //租户范围查询
    public function scopeTenantId($query)
    {
        $query->where('tenant_id',$this->tenant_id);
    }

}
