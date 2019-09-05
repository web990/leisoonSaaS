<?php
namespace app\tool\controller;


use com\doc\ClassMethod;

/**
 * 工具控制器
 * @package app\user\controller
 */
class Index extends BaseToolController
{

    protected $noNeedLogin = ['index','test'];
    protected $noNeedRight = [];
    protected $whereFields = [];
    protected $searchFields = ['id'];
    protected $validateAction = [];
    protected $statusField = '';
    protected $defaultSort = [];
    protected $with = [];

    public function __construct()
    {
        if (is_null($this->model)){
            //$this->model = new Zhiban();
        }
        parent::__construct();
        parent::initialize();
    }

    public function index($name='pinyin'){
        $classPath ='app\\tool\\controller\\'.ucfirst($name);
        $class = new ClassMethod($classPath);
        $action=$class->getAction();
        p($action);
    }


}
