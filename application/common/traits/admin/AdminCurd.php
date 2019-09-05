<?php
/**
 * Created by Leisoon.
 * User: websky <web88@qq.com>
 * Date: 2018/12/18 11:00
 */

namespace app\common\traits\admin;

use lib\ReturnCode;

/**
 * Admin模块增删改查 trait
 */
trait AdminCurd
{
    /**
     * 显示数据集
     * Author: websky
     */
    public function index()
    {
        $this->request->filter(['strip_tags']);
        try{
            list($where, $order, $page, $limit) = $this->whereBuild();

            $query = $this->model->where($where)->where($this->whereTime());
            $count = $query->count();
            $list = $query->with($this->with)->page($page,$limit)->order($order)->select();
        }catch (\think\exception\PDOException $e){
            $this->reError(ReturnCode::SELECT_ERROR,$e->getMessage());
        }catch (\think\Exception $e){
            $this->reError(ReturnCode::SELECT_ERROR,$e->getMessage());
        }

        $this->reTable($list,$count);
    }

    /**
     * 回收站
     * Author: websky
     */
    public function recyclebin()
    {
        $this->request->filter(['strip_tags']);
        try{
            list($where, $order, $page, $limit) = $this->whereBuild();

            $query = $this->model->where($where)
                ->onlyTrashed()
                ->where($this->whereTime());
            $count = $query->count();
            $list = $query->page($page,$limit)->order($order)->fetchSql(false)->select();
        }catch (\think\exception\PDOException $e){
            $this->reError(ReturnCode::SELECT_ERROR,$e->getMessage());
        }catch (\think\Exception $e){
            $this->reError(ReturnCode::SELECT_ERROR,$e->getMessage());
        }

        $this->reTable($list,$count);
    }

    /**
     * 详细信息
     * Author: websky
     * @param int $id
     * @return array
     */
    public function detailed($id=0)
    {
        //判断id是否为空，并返回错误
        $this->isParam('id');

        $info = $this->model->get($id);
        if ($info){
            $this->reSuccess($info);
        }else{
            $this->reError(1010);
        }
    }

    /**
     * 新增数据
     * Author: websky
     * @return array
     */
    public function add()
    {
        if (!$this->request->isPost()){
            $this->reError(ReturnCode::ERROR);
        }
        try{
            //获取数据
            $data = $this->param($this->model->getTableFields());

            //创建保存数据，返回数据集对象
            if ($reData=$this->model->allowField(true)->create($data)){
                $this->reSuccess($reData);
            }else{
                $this->reError(ReturnCode::ADD_FAILED,$this->model->getError());
            }
        }catch (\think\exception\PDOException $e){
            $this->reError(ReturnCode::ADD_FAILED,$e->getMessage());
        }catch (\think\Exception $e){
            $this->reError(ReturnCode::ADD_FAILED,$e->getMessage());
        }
    }


    /**
     * 更新数据
     * Author: websky
     * @param int $id
     * @return array
     */
    public function edit($id=0)
    {
        if (!$this->request->isPost()){
            $this->reError(ReturnCode::ERROR);
        }

        try{
            $pk = $this->model->getPk();
            $id = $this->isParam($pk);

            $info = $this->model->where($pk,'=',$id)->find();
            if ($info){
                $data = $this->param($this->model->getTableFields());
                if ($reData=$info->allowField(true)->save($data)){
                    $this->reSuccess($reData);
                }
            }
            $this->reError(ReturnCode::UPDATE_FAILED,$this->model->getError());
        }catch (\think\exception\PDOException $e){
            $this->reError(ReturnCode::UPDATE_FAILED,$e->getMessage());
        }catch (\think\Exception $e){
            $this->reError(ReturnCode::UPDATE_FAILED,$e->getMessage());
        }
    }

    /**
     * 删除数据
     * Author: websky
     * @param int $id
     * @return array
     */
    public function del($id='')
    {
        if ($id){
            $pk = $this->model->getPk();

            $list = $this->model->where($pk,'in',$id)->select();
            $count = 0;
            foreach ($list as $v){
                $count += $v->delete();
            }

            if ($count){
                $this->reSuccess($count);
            }else{
                $this->reError(ReturnCode::DELETE_FAILED);
            }
        }
    }


    /**
     * 真实删除
     * Author: websky
     * @param string $id
     */
    public function destroy($id='')
    {
        if ($id){
            $pk = $this->model->getPk();

            $list = $this->model->where($pk,'in',$id)->withTrashed()->select();
            $count = 0;
            foreach ($list as $v){
                $count += $v->delete(true);
            }

            if ($count){
                $this->reSuccess($count);
            }else{
                $this->reError(ReturnCode::DELETE_FAILED);
            }
        }
    }

    /**
     * 还原
     * Author: websky
     * @param string $id
     */
    public function restore($id='')
    {
        if ($id){
            $pk = $this->model->getPk();

            $list = $this->model->where($pk,'in',$id)->onlyTrashed()->select();
            $count = 0;
            foreach ($list as $v){
                $count += $v->restore();
            }

            if ($count){
                $this->reSuccess($count);
            }else{
                $this->reError(ReturnCode::DELETE_FAILED);
            }
        }
    }

    /**
     * 批量更新
     * Author: websky
     * @param string $ids
     */
    public function multi($ids='')
    {
        $ids = $ids ? $ids : $this->request->param("ids");
        if ($ids) {
            if ($this->request->has('params')) {
                parse_str($this->request->post("params"), $values);
                if (!$this->auth->isSuperAdmin()) {
                    $values = array_intersect_key($values, array_flip(is_array($this->multiFields) ? $this->multiFields : explode(',', $this->multiFields)));
                }
                if ($values) {
                    $count = 0;
                    $list = $this->model->where($this->model->getPk(), 'in', $ids)->select();
                    foreach ($list as $item) {
                        $count += $item->allowField(true)->isUpdate(true)->save($values);
                    }
                    if ($count) {
                        $this->reSuccess($count);
                    } else {
                        $this->reError(ReturnCode::UPDATE_FAILED);
                    }
                } else {
                    $this->reError(ReturnCode::EXCEPTION);
                }
            }
        }
    }

    /**
     * 字段修改
     * Author: websky
     */
    public function editfield()
    {
        $id = $this->isParam('id');
        $field=$this->request->param('field','');
        $value=$this->request->param('value','');

        try{
            $updateData=[];
            if ($this->request->has('params')) {
                parse_str($this->request->post("params"), $values);
                if (!$this->auth->isSuperAdmin()) {
                    $values = array_intersect_key($values, array_flip(is_array($this->multiFields) ? $this->multiFields : explode(',', $this->multiFields)));
                }
                if ($values) {
                    $updateData=$value;
                }
            }elseif ($field){
                $updateData=[$field=>$value];
            }

            if (!empty($updateData) && $this->model->allowField(true)->save($updateData,[$this->model->getPk() =>$id])) {
                $this->reSuccess($updateData);
            } else {
                $this->reError(ReturnCode::UPDATE_FAILED,$this->model->getError());
            }
        }catch (\think\exception\PDOException $e){
            $this->reError(ReturnCode::UPDATE_FAILED,$e->getMessage());
        }catch (\think\Exception $e){
            $this->reError(ReturnCode::UPDATE_FAILED,$e->getMessage());
        }
    }


    /**
     * 显示指定的资源
     * Author: websky
     * @param int $id
     * @return array
     */
    public function read($id=0)
    {
        return $this->detailed($id);
    }

    /**
     * 保存新建数据
     * Author: websky
     * @return array
     */
    public function save()
    {
        return $this->add();
    }

}