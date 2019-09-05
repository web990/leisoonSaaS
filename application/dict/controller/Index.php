<?php
/**
 * 字典控制器
 */

namespace app\dict\controller;


use app\admin\model\AdminType;
use app\common\controller\Base;
use think\Controller;

/**
 * 字典输出控制器
 * @package app\dict\controller
 */
class Index extends Base
{
    protected $model;

    public function __construct()
    {
        if (is_null($this->model)){
            $this->model = new AdminType();
        }
        parent::__construct();
    }

    /**
     * 返回字典数组、标题
     * @param int $pid
     * @param int $id
     * @param int $value
     */
    public function index($pid=0,$id=0){
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
     * 返回字典Value 数组或标题
     * @param int $pid
     * @param null $value
     */
    public function getValue($pid=0,$value=null){
        $data = '';
        if ($pid && $value != null){
            $data = $this->model->getValueTitle($pid,$value);
        }elseif ($pid){
            $data = $this->model->where('pid',$pid)->column('title','value');
            $this->reSuccess($data);
        }
        $this->reSuccess($data);
    }

}