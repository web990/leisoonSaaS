<?php
// +----------------------------------------------------------------
// | LeisoonCMF V5.0
// +----------------------------------------------------------------
// | Copyright (c) 2016 http://www.leisoon.com All rights reserved.
// +----------------------------------------------------------------
// | Author: websky <web88@qq.com>
// +----------------------------------------------------------------

namespace app\admin\controller;


use app\admin\model\AdminCategory;
use app\admin\model\AdminDepartment;
use app\cms\model\Document;
use app\user\model\User;
use lib\ReturnCode;
use think\Db;

/**
 * 常用
 * @package app\admin\controller
 */
class Common extends AdminBase
{
    protected $noNeedLogin = ['cache','pinyin','pinyinfirst','dataCount','categoryCount'];
    protected $noNeedRight = ['getUserinfo','expiredCount','modelCount'];

    //常用公共方法Traits
    use \app\common\traits\Common;


    /**
     * JSON菜单
     * Author: websky
     */
    public function getMenu(){
        if($data = $this->auth->getMenu()){
            $this->reSuccess($data);
        }else{
            $this->reError(ReturnCode::ERROR,'获取menu失败！');
        }
    }

    /**
     * 分类统计（图表数据）
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function categoryCount(){
        $document = new Document(['tenant_id' => $this->tenant_id, 'uid' => $this->uid]);
        $category = new AdminCategory(['tenant_id' => $this->tenant_id, 'uid' => $this->uid]);
        $count = $document->where('status',1)
            ->where('model_id','in','2,5,13')
            ->field('category_id,count(id) as count')
            ->group('category_id')
            ->limit(20)->cache(3900)->select();

        $x = $y =[];
        $cate = $category->where('model_id','in','2,5,13')->cache(3800)->column('title','id');
        foreach ($count as $item) {
            $x[] = isset($cate[$item['category_id']]) ? $cate[$item['category_id']]:'';
            $y[] = $item['count'];
        }

        $data['title']=[
            'text'=>'栏目统计'
            ,'x'=>'center'
            ,'textStyle'=>['fontSize'=>14]
        ];
        $data['tooltip']=[
            'trigger'=>'axis'
            ,'formatter'=>"{b}<br>总量：{c}"
        ];
        $data['xAxis']=[[
            'type'=>'category'
            ,'data'=>$x
        ]];
        $data['yAxis']=[[
            'type'=>'value'
        ]];
        $data['series']=[[
            'type'=>'line'
            ,'data'=>$y
        ]];

        if($data){
            $this->reSuccess($data);
        }else{
            $this->reError(ReturnCode::ERROR,'获取menu失败！');
        }
    }

    /**
     * 数据统计
     */
    public function dataCount(){
        $setModel = ['tenant_id' => $this->tenant_id, 'uid' => $this->uid];
        $document = new Document($setModel);
        $category = new AdminCategory($setModel);
        $user = new User($setModel);
        $dept = new AdminDepartment($setModel);

        $data['user']=$user->where('status',1)->cache(3600)->count();
        $data['document']=$document->where('status',1)->cache(600)->count();
        $data['category']=$category->where('status',1)->cache(3000)->count();
        $data['dept']=$dept->cache(7200)->count();

        $this->reSuccess($data);
    }

    /**
     * 模型统计
     * Author: websky
     * @param string $model 模型名
     * @param string $where 目前仅支持字符串条件（严格按5.1字符串条件）
     */
    public function modelCount($model='',$where=''){
        if (!$model){
            $this->reSuccess(0);
        }
        $model = Db::name($model);
        $data = [
            'count'=>$model->where($where)->count()
        ];

        $this->reSuccess($data);
    }

}
