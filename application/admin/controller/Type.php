<?php
// +----------------------------------------------------------------
// | LeisoonCMF V5.0
// +----------------------------------------------------------------
// | Copyright (c) 2016 http://www.leisoon.com All rights reserved.
// +----------------------------------------------------------------
// | Author: websky <web88@qq.com>
// +----------------------------------------------------------------

namespace app\admin\controller;

use app\admin\model\AdminType;
use lib\ReturnCode;
use org\Tree;
use think\facade\Config;

/**
 * 字典控制器
 */
class Type extends AdminBase
{
    protected $noNeedLogin = ['getStatus','read'];
    protected $noNeedRight = [];
    protected $searchFields = 'id,title';
    protected $statusField = 'status';
    protected $defaultSort = ['sort'=>'asc'];
    protected $with = '';

    /**
     * 引入adminExtend traits
     */
    use \app\common\traits\admin\AdminExtend;

    public function __construct()
    {
        if (is_null($this->model)){
            $this->model = new AdminType();
        }
        parent::__construct();
        parent::initialize();
    }

    /**
     * 显示资源列表
     * Author: websky
     * @return array
     */
    public function index()
    {
        $map=[];
        $query = $this->model->with($this->with)->where($map)->where($this->whereKey())->where($this->whereStatus());
        $list = $query->order('sort asc,id desc')->fetchSql(false)->select();
        $count =$query->count();
        $return_data = [
            'code' => 0,
            'msg' => '',
            'count' => $count,
            'data' => $list,
            'is' => true,
            'tip' => '操作成功！'
        ];
        return $return_data;
    }

    /**
     * 返回状态数组（无需登录）
     */
    public function getStatus(){
        $value = $this->request->param('id',null);
        $type = $this->request->param('type','normal');

        $data = $this->model->getStatus($type,$value);
        if ($data){
            $this->reSuccess($data);
        }else{
            $this->reError(999);
        }
    }

    /**
     * 返回字典数据，已开启缓存查询
     * Author: websky
     * @param int $pid
     * @param int $id
     */
    public function read($pid=0,$id=0)
    {
        if (!empty($id)){
            $title = $this->model->where('id',$id)->cache(true)->value('title');
            $this->reSuccess($title);
        }
        $info = $this->model->where('pid',$pid)->order('sort asc')->field('id,title,name,value,sort')->all(null,true);
        if ($info){
            $this->reSuccess($info);
        }else{
            $this->reError(1010);
        }
    }

    /**
     * 返回value=>title类型字典（未用）
     * Author: websky
     * @param int $pid
     * @param int $value
     * @return array
     */
    public function getValue($pid=0,$value=0)
    {
        if (!empty($value) && !empty($pid)){
            $title = $this->model->where(['pid'=>$pid,'value'=>$value])->value('title');
            $this->reSuccess($title);
        }
        $info = $this->model->where('pid',$pid)->column('title','value');
        if ($info){
            $this->reSuccess($info);
        }else{
            $this->reError(1010);
        }
    }

    /**
     * 返回字典数组、标题
     * @param int $pid
     * @param int $id
     * @param int $value
     */
    public function getType($pid=0,$id=0){
        $data = '';
        if ($id){
            $data = $this->model->getTitle($id);
        }elseif ($pid){
            $data = $this->model->getType($pid);
            $this->reSuccess($data);
        }
        $this->reSuccess($data);
    }

    /**
     * 重写删除控制器，可以删除子项目
     * @param string $id
     * @return array|void
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    /*public function del($id='')
    {
        if ($id){
            $list = $this->model->where('id','in',$id)->select();
            $count = 0;
            foreach ($list as $v){
                //删除子类
                if ($re = $this->model->where('pid',$v->id)->update(['delete_time'=>time()])){
                    $count += $re;
                }
                $count += $v->delete();
            }

            if ($count){
                $this->reSuccess($count);
            }else{
                $this->reError(ReturnCode::DELETE_FAILED);
            }
        }
    }*/


}