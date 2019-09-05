<?php
namespace app\oss\controller;

use app\cms\model\Document;
use app\cms\model\DocumentContent;
use lib\ReturnCode;
use think\facade\Env;

/**
 * Oss Index 控制器
 * @package app\user\controller
 */
class Index extends BaseOssController
{
    protected $noNeedLogin = ['index'];
    protected $noNeedRight = [];
    protected $searchFields = ['id','title'];
    protected $validateAction = ['add','edit','del','save','editfield'];
    protected $statusField = 'status';
    protected $defaultSort = [];
    protected $with = ['content'];

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

        /*$path = './0000/';
        p($path);
        if (1) {
            $files = glob($path . '*.txt');
            p($files);

            try {
                if (count($files) > 1) {
                    //unlink($files[0]);
                }
            } catch (\Exception $e) {
            }
        }*/
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
                $info = $model->find($data['id']);

                foreach ($data as $key => $value) {
                    $info->setAttr($key, $value, $data);
                }
                foreach ($data_content as $key => $value) {
                    $info->content->setAttr($key, $value, $data);
                }
                $info->update_time = time();//主表无变化强制更新
                $return = $info->together('content')->save();
            }else{
                //数据对象赋值
                foreach ($data as $key => $value) {
                    $model->setAttr($key, $value, $data);
                }
                foreach ($data_content as $key => $value) {
                    $documentContent->setAttr($key, $value, $data);
                }
                $model->content=$documentContent;
                $return = $model->together('content')->save();
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

            $list = $this->model->where($pk,'in',$id)->select();
            $count = 0;
            foreach ($list as $v){
                $count += $v->together('content')->delete();
            }

            if ($count){
                $this->reSuccess($count);
            }else{
                $this->reError(ReturnCode::DELETE_FAILED);
            }
        }
    }

}
