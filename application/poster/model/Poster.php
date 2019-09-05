<?php
// +----------------------------------------------------------------
// | LeisoonCMF V5.0
// +----------------------------------------------------------------
// | Copyright (c) 2016 http://www.leisoon.com All rights reserved.
// +----------------------------------------------------------------
// | Author: websky <web88@qq.com>
// +----------------------------------------------------------------

namespace app\poster\model;



/**
 * 广告
 */
class Poster extends BasePosterModel {
    protected $readonly = ['id'];
    protected $auto = [];
    protected $insert = ['status'=>0];

    public function setStartTimeAttr($value) {
        return is_numeric($value) ? $value:strtotime($value);
    }
    public function getStartTimeAttr($value) {
        return empty($value) ? '':date('Y-m-d H:i:s',$value);
    }

    public function setEndTimeAttr($value) {
        return is_numeric($value) ? $value:strtotime($value);
    }
    public function getEndTimeAttr($value) {
        return empty($value) ? '':date('Y-m-d H:i:s',$value);
    }

    /**
     * 一对一关联广告位
     * @return \think\model\relation\HasOne
     */
    public function Space()
    {
        return $this->hasOne('PosterSpace','id','space_id')->bind([
            'space_name'=>'name'
        ]);
    }

    /**
     * 一对一关联缩略图
     * @return \think\model\relation\HasOne
     */
    public function oss()
    {
        return $this->hasOne('\\app\\oss\\model\\Oss','id','img_id')->bind([
            'img_path'=>'url'
        ]);
    }

    /**
     * 返回有效广告信息
     * @param int $space_id
     * @return array|bool|null|\PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getPoster($space_id=0){
        $info = cache('poster_getposter_300_'.$space_id);
        if (!$info){
            $space = PosterSpace::where('status',1)->find($space_id);
            if (!$space){
                return false;
            }

            $info = $this->where('space_id',$space->id)->where('status',1)->with('oss')->find();
            if (!$info){
                return false;
            }

            //未到开始时间
            if ($info->getData('start_time') && $info->getData('start_time') > time()){
                return false;
            }

            //已到期
            if ($info->getData('end_time') && $info->getData('end_time') < time()){
                return false;
            }
            cache('poster_getposter_300_'.$space_id,$info,600);
        }
        return $info;
    }
}