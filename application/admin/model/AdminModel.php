<?php
// +----------------------------------------------------------------
// | LeisoonCMF V5.0
// +----------------------------------------------------------------
// | Copyright (c) 2016 http://www.leisoon.com All rights reserved.
// +----------------------------------------------------------------
// | Author: websky <web88@qq.com>
// +----------------------------------------------------------------

namespace app\admin\model;


/**
 * 设置模型
 */
class AdminModel extends BaseAdminModel {

    protected $readonly = ['name'];

	/**
	 * 更新一个或新增一个模型
	 * @return array
	 */
	public function change() {
		if(IS_POST){
			$data = request()->post();
			if($data){
				if (empty($data['id'])) {
					/*创建表*/
					$db = new \com\Datatable();

					if ($data['extend'] == 1) {
						//文档模型
						$sql = $db->start_table('document_'.$data['name'])->create_id('doc_id', 11 , '主键' , false)->create_key('doc_id');
					}else{
						$sqlstr="`create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间'";
						$sqlstr .=",`update_time` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间'";
						$sqlstr .=",`delete_time` int(10) NULL DEFAULT NULL COMMENT '删除时间'";//软删除字段，默认值Null
						$sqlstr .=",`status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态'";
						$sqlstr .=",`category_id` int(10) NOT NULL DEFAULT '0' COMMENT '所属分类'";
                        $sql = $db->start_table($data['name'])->create_id('id', 11 , '主键' , true)->create_uid()->create_field($sqlstr)->create_key('id');
					}
					//执行操作数据库，建立数据表
					$result = $sql->end_table($data['title'], $data['engine_type'])->create();
					if ($result) {
						$id = $this->save($data);
						if (false === $id) {
							return array('info'=>$this->getError(), 'status'=>0);
						}else{
							// 清除模型缓存数据
							cache('document_model_list', null);

                            //独立模型生成模型文件
                            if ($data['extend'] > 1){
                                $modelName=ucfirst($data['name']);
                                $modelPath=APP_PATH.'common/model';
                                $newName=$modelPath.'/'.$modelName.'.php';

                                if (!file_exists($newName)){
                                    $file= new \com\File();
                                    $modelContent=$file->read_file($modelPath.'/ModelTemplate.php');
                                    $modelContent=str_replace('ModelTemplate',$modelName,$modelContent);
                                    $filere=$file->write_file($newName,$modelContent);
                                }
                            }
								
							//记录行为
							action_log('update_model', 'model', $id, session('auth_user.uid'));
							return $id ? array('info'=>'创建模型成功！','status'=>1) : array('info'=>'创建模型失败！','status'=>1);
						}
					}else{
						return false;
					}
				} else {
					//修改
					$status = $this->save($data,array('id'=>$data['id']));
					if (false === $status) {
						return array('info'=>$this->getError(), 'status'=>0);
					}else{
						// 清除模型缓存数据
						cache('document_model_list', null);
						//记录行为
						action_log('update_model','model',$data['id'],session('auth_user.uid'));
						return array('info'=>'保存模型成功！','status'=>1);
					}
				}
			}else{
				return array('info'=>$this->getError(),'status'=>0);
			}
		}
	}

	public function del(){
		$id = input('id','','trim,intval');
		$model = $this->db()->where(array('id'=>$id))->find();

		if ($model['extend'] == 0) {
			$this->error = "基础模型不允许删除！";
			return false;
		}elseif ($model['extend'] == 1){
			$tablename = 'document_'.$model['name'];
		}elseif ($model['extend'] == 2){
			$tablename = $model['name'];
		}
		//删除数据表
		$db = new \com\Datatable();
		if ($db->CheckTable($tablename)) {
			//检测表是否存在
			$result = $db->del_table($tablename)->query();
			if (!$result) {
				return false;
				$this->error = "数据表删除失败！";
			}
		}
		$result = $this->db()->where(array('id'=>$id))->delete();
		if ($result) {
			return true;
		}else{
			$this->error = "模型删除失败！";
			return false;
		}
	}

	public function attribute(){
		return $this->hasMany('Attribute');
	}

	/**
	 * 解析字段
	 * @param  [array] $model      [字段]
	 * @return [array]             [解析后的字段]
	 */
	public function preFields($model){
		$fields = $model->attribute;
		$groups = parse_config_attr($model['field_group']);
		$field_sort = json_decode($model['field_sort'],true);;

		//获得数组的第一条数组
		$first_key = array_keys($groups);
		if (!empty($field_sort)) {
			foreach ($field_sort as $key => $value) {
				foreach ($value as $index) {
					if (isset($fields[$index])) {
						$groupfield[$key][] = $fields[$index];
						unset($fields[$index]);
					}
				}
			}
		}
		//未进行排序的放入第一组中
		$fields[] = array('name'=>'model_id','type'=>'hidden');    //加入模型ID值
		$fields[] = array('name'=>'id','type'=>'hidden');    //加入模型ID值
		foreach ($fields as $key => $value) {
			$groupfield[$first_key[0]][] = $value;
		}

		foreach ($groups as $key => $value) {
			if ($groupfield[$key]) {
				$data[$value] = $groupfield[$key];
			}
		}
		return $data;
		return array();
	}
}