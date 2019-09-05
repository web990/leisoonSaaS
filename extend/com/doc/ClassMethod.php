<?php
// +----------------------------------------------------------------------
// | LEISOON CMS
// +----------------------------------------------------------------------
// | DataTime 2018-12-6 10:21:19
// +----------------------------------------------------------------------
// | Author: websky <web88@qq.com>　
// +----------------------------------------------------------------------
namespace com\doc;

/**
 * 获取类中方法、属性、注释
 * @package com
 */
class ClassMethod{
    /**
     * 要获取类名（路径）
     * @var string
     */
    public $className;

    /**
     * 反射类
     * @var \ReflectionClass
     */
    public $reflection;

    /**
     * 方法过滤条件
     * @var $filter
     */
    public $filter=null;

    /**
     * 是否显示父类方法
     * @var bool
     */
    public $isParent=true;

    /**
     * 构造函数(注：用 class_exists() 函数判断类是否存在)
     * @param string $className 如：app\admin\controller\Roles
     */
    public function __construct($className='',$filter='') {
        $this->setClassName($className);
        $this->setFilter($filter);

        if (class_exists($this->className)){
            //反射类
            $this->reflection = new \ReflectionClass ($this->className);
        }
    }

    /**
     * 返回控制器外露方法（增删改查等）
     * Author: websky
     * @return array
     */
    public function getAction($isExtendClass=false){
        $this->isParent=false;
        //$this->setFilter('');
        $name = $this->getName();
        $name = substr(strrchr($name,'\\'),1);
        $doc = $this->getDoc();
        $method = $this->getMethods();//获取类方法（不包含父类）

        //手动增加（增删改查方法）
        if ($isExtendClass){
            $addArray=['add','del','edit','detailed','multi','editfield'];
            $method = array_merge($method,$addArray);
        }

        $data = [];
        if ($method && is_array($method)){
            foreach ($method as $k => $v){
                $data[$k]['name']=$v;
                $a = $this->reflection->getMethod($v);
                $data[$k]['doc']=DocParserFactory::getActionDoc($a->getDocComment());
                $data[$k]['route']=strtolower($name).'/'.$v;
            }
        }

        $reData=[
            'list'=>$data
            ,'name'=>$name
            ,'doc'=>$doc
            ,'route'=>strtolower($name).'/index'
        ];

        return $reData;
    }

    /**
     * 设置类名
     * Author: websky
     * @param string $className
     */
    public function setClassName($className=''){
        $this->className=$className;
    }

    /**
     * 是否显示父类方法
     * Author: websky
     * @param bool $parent
     */
    public function isParent($parent=true){
        $this->isParent=$parent;
    }

    /**
     * 设置返回方法过滤条件
     * Author: websky
     * @param array|string $filter [public,protected,private,abstract,final,static]
     */
    public function setFilter($filter=''){
        //$param = '1|256|512|1024|2|4';
        $param = 1+256+512+1024+2+4;
        if (is_array($filter)){
            $param = implode('|', $filter);
        }elseif($filter && is_string($filter)){
            $param = str_replace(',','|',$filter);
        }

        if ($filter){
            $param = str_replace(array('static','public','protected','private','abstract','final'),array(1,256,512,1024,2,4),$param);
        }
        $this->filter=$param;
    }

    /**
     * 返回所有方法名
     * Author: websky
     * @return \ReflectionMethod[]
     */
    public function getMethods(){
        //有父类并设置不显示父类方法
        if (!$this->isParent && $this->reflection->getParentClass()){
            $array1 = get_class_methods($this->className);
            if ($parent_class = get_parent_class($this->className)) {
                $array2 = get_class_methods($parent_class);
                $array3 = array_diff($array1, $array2);
            } else {
                $array3 = $array1;
            }
            return $array3;
        }else{
            return $this->reflection->getMethods($this->filter);
        }
    }

    /**
     * 返回类名
     * Author: websky
     * @return string
     */
    public function getName(){
        return $this->reflection->getName();
    }
    /**
     * 返回类注释
     * Author: websky
     * @return string
     */
    public function getDoc($format = true){
        if ($format){
            return DocParserFactory::getDoc($this->reflection->getDocComment());
        }
        return $this->reflection->getDocComment();
    }

    /**
     * 仅仅获取这个类的方法，不要父类的
     * Author: websky
     * @param $class int Y N 类名
     * @return array3 array 本类的所有方法构成的一个数组
     */
    public function get_this_class_methods($class='') {
        if (!$class){
            $class=$this->className;
        }
        $array1 = get_class_methods($class);
        if ($parent_class = get_parent_class($class)) {
            $array2 = get_class_methods($parent_class);
            $array3 = array_diff($array1, $array2);
        } else {
            $array3 = $array1;
        }
        return $array3;
    }

}
