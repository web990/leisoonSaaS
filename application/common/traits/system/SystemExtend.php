<?php
/**
 * Created by Leisoon.
 * User: websky <web88@qq.com>
 * Date: 2018/12/18 11:00
 */

namespace app\common\traits\system;

use lib\ReturnCode;
use org\Tree;

/**
 * Admin扩展功能 trait
 */
trait AdminExtend
{

    /**
     * 排序
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
                $map[]=['pid','=',$pid];
            }
            $list = $this->model->where($map)->order('sort asc')->fetchSql(false)->select();
            $this->reSuccess($list);
        }
    }

    /**
     * 返回下拉树数据
     * Author: websky
     * @param int $roles_id
     * @return array
     */
    public function selectTree(){
        $name = $this->request->param('name','name');
        $pid = $this->request->param('pid',0);
        $map=[];
        $list = $this->model->where($map)->order('sort asc,id desc')->field('id,'.$name.',pid')->select();

        $data = Tree::toFormatTree($list->toArray(),$name,'id','pid',$pid);
        $this->reSuccess($data);
    }

}