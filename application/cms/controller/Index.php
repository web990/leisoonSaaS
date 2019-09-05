<?php
namespace app\cms\controller;

use app\admin\model\AdminCategory;
use app\cms\model\Document;
use app\cms\model\DocumentContent;
use lib\ReturnCode;

/**
 * Cms Index 控制器
 * @package app\user\controller
 */
class Index extends BaseCmsController
{
    protected $noNeedLogin = ['getPosition','index','test'];
    protected $noNeedRight = [];
    protected $searchFields = ['id','title'];
    protected $validateAction = ['add','edit','del','save','editfield'];
    protected $statusField = 'status';
    protected $defaultSort = [];
    protected $with = ['article','oss','user','category'];

    public function __construct()
    {
        if (is_null($this->model)){
            $this->model = new Document();
        }
        parent::__construct();
        parent::initialize();
    }

    /**
     * 显示数据集
     * Author: websky
     */
    public function index()
    {
        $this->request->filter(['strip_tags']);

        try{
            list($where, $order, $page, $limit) = $this->whereBuild();

            $category_id = $this->request->param('category_id');
            $category_child = $this->request->param('category_child');
            $model_id = $this->request->param('model_id');
            $pid = $this->request->param('pid');

            //权限内待审核信息
            if ($model_id == 6){
                $cate_auth  =   $this->auth->getAuthCategoryExamine();
                $where[]=['category_id','in',$cate_auth];
                $where[]=['status','in','2,3'];
            }else{
                //获取用户权限分类
                $cate_auth  =   $this->auth->getAuthCategoryRead();
                if ($category_child && is_array($category_child)){
                    $category_id = $category_child;
                }elseif ($category_id && is_numeric($category_id)){
                    $category_id = [$category_id];
                }else{
                    $category_id = $cate_auth;
                }
                $authCategory = array_intersect(is_array($cate_auth) ? $cate_auth:[],$category_id);//数组交集处理，计算出有权限的分类

                if ($authCategory){
                    $where[]=['category_id','in',$authCategory];
                }else{
                    $where[]=['category_id','=',0];
                }
            }

            $query = $this->model->where($where)->where($this->whereTime());
            $count = $query->count();
            $list = $query->with($this->with)->page($page,$limit)->order($order)->fetchSql(0)->select();

        }catch (\think\exception\PDOException $e){
            $this->reError(ReturnCode::SELECT_ERROR,$e->getMessage());
        }catch (\think\Exception $e){
            $this->reError(ReturnCode::SELECT_ERROR,$e->getMessage());
        }

        /*foreach ($list as &$item) {
            $item['position_text']=$item->position_text;
        }*/

        $this->reTable($list,$count);
    }

    /**
     * 返回状态
     * @param null $status
     */
    public function getStatus(){
        $status = $this->request->param('status',null);
        $data = $this->model->getStatusType($status);
        $this->reSuccess($data,0);
    }

    /**
     * 关联新增、编辑
     * @return array|void
     */
    public function save(){
        if (!$this->request->isPost()) {
            $this->reError(ReturnCode::ERROR);
        }

        try{
            $model = new Document();
            $documentContent = new DocumentContent();
            $data = $this->param($model->getTableFields(),'post');
            $data_content = $this->param($documentContent->getTableFields(),'post');

            if (isset($data['id']) && $data['id']){
                $info = $model->field('update_time',true)->find($data['id']);

                //判断修改权限
                if (!$info['category_id'] || !$this->auth->getAuthCategoryEdit($info['category_id'])){
                    $this->reError(ReturnCode::ADD_FAILED,'无此栏目修改权限！');
                }

                foreach ($data as $key => $value) {
                    $info->setAttr($key, $value, $data);
                }
                foreach ($data_content as $key => $value) {
                    $info->article->setAttr($key, $value, $data);
                }

                //退回信息修改后变回待审核
                if ($info->getData('status') == 3){
                    $info->status = 2;
                }

                $return = $info->together('article')->save();
            }else{

                //判断新增权限
                if (!$data['category_id'] || !$this->auth->getAuthCategoryAdd($data['category_id'])){
                    $this->reError(ReturnCode::ADD_FAILED,'无此栏目添加权限！');
                }

                //数据对象赋值
                foreach ($data as $key => $value) {
                    $model->setAttr($key, $value, $data);
                }
                foreach ($data_content as $key => $value) {
                    $documentContent->setAttr($key, $value, $data);
                }

                //判断栏目是否需要审核
                if (AdminCategory::where('id',$data['category_id'])->where('check',1)->count()){
                    $model->status = 2;
                }

                $model->article=$documentContent;
                $return = $model->together('article')->save();
            }

            if ($return){
                $this->reSuccess(1);
            }else{
                $this->reError(isset($data['id']) ? ReturnCode::UPDATE_FAILED:ReturnCode::ADD_FAILED,$model->getError());
            }
        }catch (\think\exception\PDOException $e){
            $this->reError(ReturnCode::ADD_FAILED,$e->getMessage());
        }catch (\think\Exception $e){
            $this->reError(ReturnCode::ADD_FAILED,$e->getMessage());
        }
    }

    /**
     * 关联更新
     * @param int $id
     * @return array|void
     */
    public function edit($id=0){
        $this->save();
    }

    /**
     * 关联删除
     * @param int $id
     * @return array|void
     */
    public function del($id=0){
        if ($id){
            $pk = $this->model->getPk();
            $msg = '';

            $list = $this->model->where($pk,'in',$id)->select();
            $count = 0;
            foreach ($list as $v){
                if (!$this->auth->getAuthCategoryDelete($v->category_id)){
                    $msg = '无删除权限';
                    continue;
                }else{
                    $count += $v->delete();
                }
            }

            if ($count){
                $this->reSuccess($count);
            }else{
                $this->reError(ReturnCode::DELETE_FAILED,$msg);
            }
        }
    }

    /**
     * 返回、解析推荐位
     * @param null $value
     * @return array|mixed|string
     */
    public function getPosition($value=null){
        $this->result($this->model->getPosition($value));
    }

    /**
     * 审核内容
     * @param int $id
     * @param null $status
     */
    public function shenhe($id=0,$status=null){
        $value = 0;
        $msg = '';

        if ($status && $status=='shenhe'){
            $value=1;
            $msg = '审核成功';
        }elseif($status && $status=='tuihui'){
            $value=3;
            $msg = '退回成功';
        }elseif($status && $status=='quxiaoshenhe'){
            $value=2;
            $msg = '取消成功';
        }else{
            $this->reError(ReturnCode::UPLOAD_FAILED,'请求错误！');
        }

        $info = $this->model->find($id);
        if ($info && $this->auth->getAuthCategoryExamine($info->category_id)){
            $info->status = $value;
            if($info->save()){
                $this->reSuccess(1,0,$msg);
            }else{
                $this->reError(ReturnCode::UPLOAD_FAILED,'失败！');
            }
        }else{
            $this->reError(ReturnCode::UPLOAD_FAILED,'无此信息或无审核权限');
        }
    }



    public function test(){
        p(6 &8);
    }

}
