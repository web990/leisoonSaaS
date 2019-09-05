<?php
namespace app\poster\controller;

use app\poster\model\PosterTemplate;

/**
 * 广告模板
 * @package app\user\controller
 */
class Template extends BasePosterController
{

    protected $noNeedLogin = [];
    protected $noNeedRight = [];
    protected $whereFields = [];
    protected $searchFields = ['id','name','title'];
    protected $validateAction = ['add','edit','del','save','editfield'];
    protected $statusField = '';
    protected $defaultSort = ['sort'];
    protected $with = [];

    /**
     * 引入adminExtend traits
     */
    use \app\common\traits\admin\AdminExtend;

    public function __construct()
    {
        if (is_null($this->model)){
            $this->model = new PosterTemplate();
        }
        parent::__construct();
        parent::initialize();
    }

}
