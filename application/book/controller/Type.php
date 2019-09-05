<?php
namespace app\book\controller;

use app\book\model\BookType;

/**
 * 留言分类
 * @package app\user\controller
 */
class Type extends BaseBookController
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
            $this->model = new BookType();
        }
        parent::__construct();
        parent::initialize();
    }
}
