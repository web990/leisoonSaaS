<?php
// +----------------------------------------------------------------
// | LeisoonCMF V5.1
// +----------------------------------------------------------------
// | Copyright (c) 2018 http://www.leisoon.com All rights reserved.
// +----------------------------------------------------------------
// | Author: websky <web88@qq.com> 201808301514
// +----------------------------------------------------------------

namespace app\common\controller;

use think\Controller;

use org\Strs;
use think\facade\Response;
use think\exception\HttpResponseException;
use lib\ReturnCode;
use lib\Auth;

/**
 * Base基控制器
 * @author websky
 */
class Base extends Controller
{
    /**
     * 租户id
     * @var int
     */
    protected $tenant_id = 0;

    /**
     * 用户id
     * @var int
     */
    protected $uid = 0;

    /**
     * 无需登录的方法,同时也就不需要鉴权了
     * @var array
     */
    protected $noNeedLogin = [];

    /**
     * 无需鉴权的方法,但需要登录
     * @var array
     */
    protected $noNeedRight = [];

    /**
     * 权限控制类
     * @var Auth
     */
    protected $auth = null;

    /**
     * 模型对象
     * @var \think\Model
     */
    protected $model = null;

    /**
     * where条件字段
     */
    protected $whereFields = '';

    /**
     * 快速搜索时执行查找的字段
     */
    protected $searchFields = 'id';

    /**
     * 是否开启状态筛选，默认false
     * @var bool,string
     */
    protected $statusField = false;

    /**
     * 是否是关联查询
     */
    protected $relationSearch = false;

    /**
     * 是否开启数据限制
     * 支持auth/personal
     * 表示按权限判断/仅限个人
     * 默认为禁用,若启用请务必保证表中存在admin_id字段
     */
    protected $dataLimit = false;

    /**
     * 数据限制字段
     */
    protected $dataLimitField = 'admin_id';

    /**
     * 数据限制开启时自动填充限制字段值
     */
    protected $dataLimitFieldAutoFill = true;

    /**
     * 验证模型类
     */
    protected $validate = null;

    /**
     * 是否开启模型场景验证
     */
    protected $modelSceneValidate = true;

    /**
     * 需要模型验证的方法
     */
    protected $validateAction = ['add','edit','del','save','editfield'];

    /**
     * Multi方法可批量修改的字段
     */
    protected $multiFields = 'status';

    /**
     * Selectpage可显示的字段
     */
    protected $selectpageFields = '*';

    /**
     * 默认排序字段，请求参数中不包含“sort”字段时生效
     * 格式为TP5.1 order条件格式
     * @var null，array,string
     */
    protected $defaultSort = null;

    /**
     * 导入文件首行类型
     * 支持comment/name
     * 表示注释或字段名
     */
    protected $importHeadType = 'comment';

    /**
     * 关联预载入，支持数组或文本类型
     */
    protected $with = null;


    public function initialize() {
        parent::initialize();

        //读取数据库中的配置移动到模块控制器基类中加载
	}

	/* 空操作，用于输出404页面 */
	public function _empty(){
		//$this->redirect('/');
	}

    /**
     * 生成条件
     * where参数接收JSON字符串（'{"description":"websky","name":["test","LIKE"],"":["status",">","-1"]}'）
     * Author: websky
     * @param null $searchfields
     * @param null $relationSearch
     * @return array
     */
    protected function whereBuild($searchfields = null, $relationSearch = null){
        $searchfields = is_null($searchfields) ? $this->searchFields : $searchfields;
        $relationSearch = is_null($relationSearch) ? $this->relationSearch : $relationSearch;
        $whereFields = $this->whereFields;
        $key = $this->request->param('key',null);
        $where = $this->request->param('where',''); //where接收JSON字符串（'{"description":"websky","name":["test","LIKE"],"":["status",">","-1"]}'）
        $page = $this->request->param('page',1);
        $limit = $this->request->param('limit',10);
        $sort = $this->request->param("sort", "id");
        $order = $this->request->param("order", "DESC");
        $wheres=[];
        $arr = json_decode($where,true);
        if ($where && is_array($arr)){
            foreach ($arr as $k=>$v) {
                if (empty($v))
                    continue;
                if (is_array($v) && isset($v[0]) && isset($v[1])){
                    if (isset($v[2])){
                        $wheres[]=[$v[0],$v[1],$v[2]];
                    }else{
                        $wheres[]=[$k,$v[1],$v[0]];
                    }
                }elseif(is_string($v)){
                    $wheres[]=[$k,'=',$v];
                }
            }
        }

        //条件筛选字段条件附加(只增加了字段相等条件，后期增加判断数组条件)
        if ($whereFields){
            if (is_string($whereFields)){
                $whereFields = explode(',',$whereFields);
            }
            if (is_array($whereFields)){
                $params = $this->param($whereFields);
                foreach ($whereFields as $v){
                    if (isset($params[$v]) && $params[$v]){
                        $wheres[]=[$v,'=',$params[$v]];
                    }
                }
            }
        }

        //TODO where待完善

        $search = $this->whereKey($searchfields);
        if ($search && is_array($search)){
            $wheres=array_merge($wheres,$search);
        }

        //是否开启状态筛选条件
        if ($this->statusField){
            $wheres=array_merge($wheres,$this->whereStatus());
        }

        //默认排序条件，默认排序开启，并请求参数中不包含sort字段生效
        if ($this->defaultSort && empty($this->request->param('sort'))){
            $sortOrder = $this->defaultSort;
        }else{
            $sortOrder=[$sort=>$order];
        }

        return [$wheres,$sortOrder,$page,$limit];
    }

    /**
     * 生成搜索条件
     * Author: websky
     * @param null $field 只检索字段
     * @return array|bool
     */
    protected function whereKey($field=null){
        $key=$this->request->param('key',null);
        if (empty($key)) return false;

        $field = is_null($field) ? $this->searchFields : $field;
        if (!empty($field)){
            if (is_numeric($field)) {
                $map[]=[$field,'=',$key];
            }else{
                if(is_array($field)){
                    $field = implode('|',$field);
                }else{
                    $field = str_replace(',','|',$field);
                }
                $map[]=[$field,'like',(string)'%'.$key.'%'];
            }
            return $map;
        }
        $fields=$this->model->getFieldsType();//查询表字段类型

        $string_field=['varchar','char','text'];			 //文本字段
        $re_field=['create_time','update_time','delete_time','action_ip'];//排除字段
        $sfield=$intfield='';
        $map=[];
        foreach ($fields as $k=>$v){
            if (in_array($k, $re_field)) {
                continue;
            }
            $type=explode('(', $v);
            $type=$type[0];
            if (in_array($type, array('tinyint','bigint'))) {
                continue;
            }
            //如果是字符串则不增加int类型字典
            if (is_numeric($key)) {
                $intfield .= $intfield ? '|'.$k:$k;
            }else {
                if(in_array($type, $string_field)){
                    $sfield .= $sfield ? '|'.$k:$k;
                }
            }
        }

        if ($intfield) {
            $map[]=[$intfield,'=',$key];
        }elseif ($sfield){
            $map[]=[$sfield,'like',(string)'%'.$key.'%'];
        }
        return $map;
    }

    /**
     * 生成状态条件，默认“status”，可以通过私有变量“$this->statusField”来改变
     * @param string $field 为true则使用此字段
     * @return array|bool
     */
    protected function whereStatus($field=''){
        if ($this->request->param('isstatus')){
            return false;
        }
        $field = $field == true ? $field:($this->statusField && is_string($this->statusField)) ? $this->statusField : 'status';
        $status=$this->request->param($field);
        if (isset($status) && $status !== '') {
            $map[]=[$field,'=',$status];
        }else {
            $map[]=[$field,'gt', -1];
        }
        return $map;
    }

    /**
     * 生成时间查询条件（开始-结束时间）
     * @return multitype:multitype:string  multitype:string multitype:string unknown   multitype:string mixed
     */
    protected function whereTime(){
        $map=[];
        $start_field='create_time';
        $end_field='create_time';

        $start_time='';
        $end_time='';
        /*$start_time=input('time-start');
       $end_time=input('time-end'); */

        $input=$this->request->get();
        foreach ($input as $k=>$v){
            if ($start=strstr($k, '-start',true)) {
                $sfield = Strs::upperFormat($start);
                if (strpos($sfield, '_') !== false) {
                    $start_field=$sfield;
                }
                $start_time=$v;
            }
            if ($end=strstr($k, '-end',true)) {
                $efield= Strs::upperFormat($end);
                if (strpos($efield, '_') !== false) {
                    $end_field=$efield;
                }
                $end_time=$v;
            }
        }
        if (empty($start_time) && empty($end_time)){
            return false;
        }

        if ($start_time && $end_time && preg_match('/\d{4}\-\d{1,2}\-\d{1,2}/', $start_time) && preg_match('/\d{4}\-\d{1,2}\-\d{1,2}/', $end_time)) {
            $map[]=[$start_field,'between time',[$start_time,$end_time.' 23:59:59']];
        }elseif ($start_time && preg_match('/\d{4}\-\d{1,2}\-\d{1,2}/', $start_time)) {
            $map[]=[$start_field,'> time',$start_time];
        }elseif ($end_time && preg_match('/\d{4}\-\d{1,2}\-\d{1,2}/', $end_time)) {
            $map[]=[$start_field,'<= time',$end_time.' 23:59:59'];
        }
        return $map;
    }

    /**
     * 数据库字段 网页字段转换
     * Author: websky
     * @param array $array 要转化数组
     * @return array
     */
    protected function buildParam($array=[])
    {
        $data=[];
        if (is_array($array)&&!empty($array)){
            foreach( $array as $item=>$value ){
                $data[$item] = $this->request->param($value);
            }
        }
        return $data;
    }

    /**
     * 获取指定的参数
     * Author: websky
     * @param $name
     * @param string $type
     * @return mixed
     */
    protected function param($name='', $type = 'param')
    {
        if (empty($name)){
            $name = $this->model->getTableFields();
        }
        //获取数据
        $data = $this->request->only($name,$type);

        //数据限制开启后自动附加限制字段
        if ($this->dataLimit && $this->dataLimitFieldAutoFill) {
            $data[$this->dataLimitField] = $this->auth->uid;
        }
        $data['uid'] = $this->auth->getUid();
        $data['tenant_id'] = $this->tenant_id;
        return $data;
    }

    /**
     * 判断参数是否为空
     * Author: websky
     * @param string $param
     * @return array|int|string
     */
    protected function isParam($param='id'){
        if (empty($this->request->param($param))){
            $this->result([],ReturnCode::EXCEPTION,'参数'.$param.'错误！');
        }
        return $this->request->param($param);
    }

    /**
     * 返回封装后的Success
     * Author: websky
     * @param $data
     * @param int $code
     * @param string $msg
     * @param array $header
     */
    protected function reSuccess($data=1, $code = 0, $msg = '成功', array $header = []){
        return $this->result($data, $code, $msg, $type = '', $header);
    }

    /**
     * 返回封装后的Error
     * Author: websky
     * @param $data
     * @param int $code
     * @param string $msg
     * @param array $header
     */
    protected function reError($code = 999, $msg = '', array $header = []){
        if (empty($msg) && isset(ReturnCode::$returnCode[$code])) {
            $msg = ReturnCode::$returnCode[$code];
        }
        return $this->result([], $code, $msg, $type = '', $header);
    }

    /**
     * 返回Table json数据
     * Author: websky
     * @param array $data
     * @param int $count
     * @param int $code
     * @param string $msg
     */
    protected function reTable($data = [],$count=10,$code=0, $msg = '')
    {
        $result = [
            'code' => $code,
            'msg'  => $msg,
            'count' => $count,
            'time' => time(),
            'data' => $data,
        ];
        $response = Response::create($result, 'json');
        throw new HttpResponseException($response);
    }

    /**
     * 检测当前控制器和方法是否匹配传递的数组
     * Author: websky
     * @param array $arr 需要验证权限的数组
     * @return bool
     */
    protected function match($arr = [])
    {
        $arr = is_array($arr) ? $arr : explode(',', $arr);
        if (!$arr) {
            return false;
        }

        $arr = array_map('strtolower', $arr);
        if (in_array(strtolower($this->request->action()), $arr) || in_array('*', $arr)) {
            return true;
        }

        return false;
    }

    /**
     * 模型验证控制器（无参数根据验证模型类自动验证）
     * Author: websky
     * @param  array        $data     数据
     * @param  string|array $validate 验证器名或者验证规则数组
     * @param  array        $message  提示信息
     * @param  bool         $batch    是否批量验证
     * @param  mixed        $callback 回调方法（闭包）
     * @return array|string|true
     * @throws ValidateException
     */
    public function validateAuto($data=[], $validate='', $message = [], $batch = false, $callback = null)
    {
        $this->validate= $validate ? "app\\common\\validate\\" .$validate:$this->validate;

        if (empty($this->validate) && $this->model){
            $this->validate = "app\\common\\validate\\" .$this->model->getName();

            if (!class_exists($this->validate)){
                $controller = $this->request->controller();
                if (strpos($controller,'.') === false){
                    $this->validate = "app\\common\\validate\\" . ucfirst($controller);
                }else{
                    $group=strstr($controller,'.',true);
                    $name=substr(strstr($controller,'.'),1);
                    $this->validate = 'app\\common\\validate\\'.strtolower($group).'\\'.ucfirst($group).ucfirst($name);
                }
            }
        }

        //获取当前参数
        $params = $data ? $data:$this->request->param();

        //获取操作名,用于验证场景scene
        $scene    = $this->request->action();
        //仅当验证器存在时 进行校验
        if (class_exists($this->validate)) {
            if ($this->modelSceneValidate){
                $v = $this->app->validate($this->validate);
                if ($v->hasScene($scene)) {
                    //仅当存在验证场景才校验
                    $result = $this->validate($params, $this->validate . '.' . $scene,$message,$batch,$callback);
                    if (true !== $result) {
                        $this->reError(ReturnCode::VALIDATE_ERROR,$result);
                    }
                }
            }else{
                $result = $this->validate($params, $this->validate,$message,$batch,$callback);
                if (true !== $result) {
                    $this->reError(ReturnCode::VALIDATE_ERROR,$result);
                }
            }
        }
    }


}
