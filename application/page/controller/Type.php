<?php
namespace app\page\controller;

use app\page\model\PageType;

/**
 * 单页面分类
 * @package app\user\controller
 */
class Type extends BasePageController
{
    /**
     * 引入adminExtend traits
     */
    use \app\common\traits\admin\AdminExtend;

    protected $noNeedLogin = [];
    protected $noNeedRight = [];
    protected $searchFields = ['id','name'];
    protected $validateAction = [];
    protected $defaultSort = ['sort'=>'asc'];

    public function __construct()
    {
        if (is_null($this->model)){
            $this->model = new PageType();
        }
        parent::__construct();
        parent::initialize();
    }
}
