<?php
namespace app\link\controller;

use app\link\model\Link;

/**
 * 友情链接
 * @package app\user\controller
 */
class Index extends BaseLinkController
{

    protected $noNeedLogin = ['index','test'];
    protected $noNeedRight = [];
    protected $whereFields = ['type_id'];
    protected $searchFields = ['id','title'];
    protected $validateAction = ['add','edit','del','save','editfield'];
    protected $statusField = 'status';
    protected $defaultSort = [];
    protected $with = ['type','oss'];

    public function __construct()
    {
        if (is_null($this->model)){
            $this->model = new Link();
        }
        parent::__construct();
        parent::initialize();
    }

    /**
     * 排序
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function sort(){
        if ($this->request->isPost()){
            $ids = $this->request->param('ids');
            $ids = explode(',', $ids);

            $count=0;
            foreach ($ids as $key=>$value){
                $postData['id']=$value;
                $postData['sort']=$key+1;
                if ($this->model->update($postData)){
                    $count++;
                }
            }

            if ($count){
                $this->reSuccess($count);
            }else{
                $this->reError(1030,'排序失败！');
            }
        }else{
            $pid = $this->request->param('pid',null);
            $map=[];
            if (isset($pid) && $pid != ''){
                $map[]=['type_id','=',$pid];
            }
            $list = $this->model->where($map)->order('sort asc')->fetchSql(false)->select();
            $this->reSuccess($list);
        }
    }

}
