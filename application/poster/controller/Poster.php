<?php
namespace app\poster\controller;


/**
 * 广告
 * @package app\user\controller
 */
class Poster extends BasePosterController
{

    protected $noNeedLogin = ['index','test'];
    protected $noNeedRight = [];
    protected $whereFields = ['space_id'];
    protected $searchFields = ['id','name'];
    protected $validateAction = ['add','edit','del','save','editfield'];
    protected $statusField = 'status';
    protected $defaultSort = [];
    protected $with = ['space','oss'];

    public function __construct()
    {
        if (is_null($this->model)){
            $this->model = new \app\poster\model\Poster();
        }
        parent::__construct();
        parent::initialize();
    }

}
