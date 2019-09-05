<?php
namespace app\poster\controller;

use app\poster\model\Poster;
use app\poster\model\PosterSpace;

/**
 * 广告位
 * @package app\user\controller
 */
class Index extends BasePosterController
{

    protected $noNeedLogin = ['index','test'];
    protected $noNeedRight = [];
    protected $whereFields = [];
    protected $searchFields = ['id','name'];
    protected $validateAction = ['add','edit','del','save','editfield'];
    protected $statusField = 'status';
    protected $defaultSort = [];
    protected $with = ['template'];

    public function __construct()
    {
        if (is_null($this->model)){
            $this->model = new PosterSpace();
        }
        parent::__construct();
        parent::initialize();
    }

}
