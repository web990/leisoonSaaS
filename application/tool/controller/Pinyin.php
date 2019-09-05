<?php
namespace app\tool\controller;

use app\tool\library\Pinyin as Pinyins;

/**
 * 工具控制器
 * @package app\user\controller
 */
class Pinyin extends BaseToolController
{

    protected $noNeedLogin = ['index','first'];
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

    /**
     * 返回拼音
     * @param key 字符串
     * @param isFirst 是否简拼
     */
    public function index(){
        $key = $this->request->param('key');
        $isFirst = $this->request->param('jianpin',false);
        $data = Pinyins::pinyin($key,$isFirst);
        $this->reSuccess($data);
    }

    /**
     * 返回简拼
     */
    public function jianpin(){
        $key = $this->request->param('key');
        $data = Pinyins::getJianpin($key);
        $this->reSuccess($data);
    }


}
