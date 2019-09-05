<?php
namespace app\link\controller;

use app\link\model\LinkType;

/**
 * 友情链接分类
 * @package app\user\controller
 */
class Type extends BaseLinkController
{
    /**
     * 引入adminExtend traits
     */
    use \app\common\traits\admin\AdminExtend;

    protected $noNeedLogin = [];
    protected $noNeedRight = [];
    protected $searchFields = ['id','name'];
    protected $validateAction = ['add','edit','del','save','editfield'];
    protected $defaultSort = ['sort'=>'asc'];

    public function __construct()
    {
        if (is_null($this->model)){
            $this->model = new LinkType();
        }
        parent::__construct();
        parent::initialize();
    }
}
