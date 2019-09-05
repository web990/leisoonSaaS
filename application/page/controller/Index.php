<?php
namespace app\page\controller;

use app\page\model\Page;

/**
 * 单页面
 * @package app\user\controller
 */
class Index extends BasePageController
{

    protected $noNeedLogin = ['index'];
    protected $noNeedRight = [];
    protected $whereFields = ['type_id'];
    protected $searchFields = ['id','title','name'];
    protected $validateAction = [];
    protected $statusField = 'status';
    protected $defaultSort = [];
    protected $with = ['type'];

    public function __construct()
    {
        if (is_null($this->model)){
            $this->model = new Page();
        }
        parent::__construct();
        parent::initialize();
    }

}
