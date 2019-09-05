<?php
// +----------------------------------------------------------------
// | LeisoonCMF V5.0
// +----------------------------------------------------------------
// | Copyright (c) 2016 http://www.leisoon.com All rights reserved.
// +----------------------------------------------------------------
// | Author: websky <web88@qq.com>
// +----------------------------------------------------------------

namespace app\cms\model;

/**
 * 文档表
 */
class Document extends BaseCmsModel {
    protected $readonly = ['id'];
    protected $auto = ['update_time'];
    protected $insert = ['status'];

    protected $type = [
        'id'    =>  'integer',
        'cover_id'    =>  'integer',
        'deadline'    =>  'integer',
        'view'    =>  'integer',
        'bookmark'    =>  'integer',
    ];

    /**
     * 更新时间修改器
     * @param $value
     * @return false|int
     */
    public function setUpdateTimeAttr($value){
        if ($value && is_string($value)){
            return strtotime($value);
        }elseif($value && is_numeric($value)){
            return $value;
        }else{
            return time();
        }
    }

    /**
     * 是否置顶
     * @param $value
     * @return int
     */
    public function setIstopAttr($value) {
        if ($value == 'on'){
            return 1;
        }else{
            return 0;
        }
    }

    /**
     * 用户状态获取器
     * @param $value
     * @return mixed
     */
    public function getStatusAttr($value){
        return $this->getStatusType($value);
    }
    public function setStatusAttr($value){
        return is_numeric($value) ? $value:$this->getStatusType($value);
    }

    /**
     * 设置推荐位
     * @param $value
     * @return int
     */
    public function setPositionAttr($value) {
        $pos = 0;
        if($value && is_array($value)){
            foreach ($value as $key=>$v){
                $pos += $v;
            }
        }
        return $pos;
    }
    public function getPositionAttr($value) {
        return $this->getPosition($value,true);
    }

    /**
     * 一对一关联栏目分类详情
     * @return \think\model\relation\HasOne
     */
    public function categoryinfo()
    {
        return $this->hasOne('\\app\\admin\\model\\AdminCategory','id','category_id');
    }

    /**
     * 一对一关联栏目分类
     * @return \think\model\relation\HasOne
     */
    public function category()
    {
        return $this->hasOne('\\app\\admin\\model\\AdminCategory','id','category_id')->bind([
            'category_name'=>'title'
        ]);
    }

    /**
     * 一对一关联文章内容
     * @return \think\model\relation\HasOne
     */
    public function article()
    {
        return $this->hasOne('DocumentContent','document_id','id')->bind([
            'content'=>'content'
            ,'template'=>'template'
        ]);
    }

    /**
     * 一对一关联缩略图
     * @return \think\model\relation\HasOne
     */
    public function oss()
    {
        return $this->hasOne('\\app\\oss\\model\\Oss','id','cover_id')->bind([
            'cover_path'=>'url'
        ]);
    }

    /**
     * 一对一关联用户模型（绑定username字段到主对象）
     * @return \think\model\relation\HasOne
     */
    public function user()
    {
        return $this->hasOne('\\app\\user\\model\\User','id','uid')->bind(['username'=>'username']);
    }

    /**
     * 返回内容状态数组/字符串/值
     * @param null $status
     * @return array|mixed|string|null
     */
    public function getStatusType($status=null){
        $type = config('?config.status_type') ? config('config.status_type'):[-1=>'删除',0=>'禁用',1=>'正常',2=>'待审核'];

        if (is_numeric($status)){
            return isset($type[$status]) ? $type[$status]:'';
        }elseif (is_string($status)){
            $type = array_flip($type); // 交换数组中的键和值
            return isset($type[$status]) ? $type[$status]:'';
        }

        return $type;
    }

    /**
     * 返回推荐位（数组、值、推荐位名称）
     * @param null $value
     * @param bool $formatPosition
     * @param bool $reArray
     * @return array|mixed|string
     */
    public function getPosition($value=null,$formatPosition=false,$reArray=false){
        $data = config('config.document_position');
        //返回推荐位解析数组
        if ($formatPosition){
            $pos = [];
            foreach ($data as $k=>$v){
                $res = $value & $k;
                if($res !== 0){
                    $pos[$k]=$v;
                }
            }
            return $pos;
        }

        if ($value && is_numeric($value)){
            return isset($data[$value]) ? $data[$value]:'';
        }elseif ($value && is_array($value)){
            $arr = [];
            foreach ($value as $v){
                $arr[] =isset($data[$v]) ? $data[$v]:'';
            }
            return $reArray ? $arr:implode(',',$arr);
        }elseif (!is_array($value) && $value == null){
            return $data;
        }else{
            return '';
        }
    }

    /**
     * 获取推荐位数据列表
     * @param  number  $pos      推荐位 1-列表推荐，2-频道页推荐，4-首页推荐
     * @param  number  $category 分类ID
     * @param  number  $limit    列表行数
     * @param  boolean $filed    查询字段
     * @return array             数据列表
     */
    public function position($pos, $category = null, $limit = 5,$order='istop desc,update_time desc', $field = true){
        $map[] = ['status','=',1];
        $where ='';

        if(!is_null($category)){
            if(is_numeric($category)){
                $map[] = ['category_id','=',$category];
            } else {
                $map[] = ['category_id','in',str2arr($category)];
            }
        }

        /* 设置推荐位 */
        if($pos && is_numeric($pos)){
            $where = "position & {$pos} = {$pos}";
        }

        return $this->with('oss')->field($field)->where($map)->where($where)->order($order)->limit($limit)->cache(false)->select();
    }

}