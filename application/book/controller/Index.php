<?php
namespace app\book\controller;

use app\book\model\Book;

/**
 * 留言板
 * @package app\user\controller
 */
class Index extends BaseBookController
{

    protected $noNeedLogin = ['index','test'];
    protected $noNeedRight = [];
    protected $whereFields = ['type_id'];
    protected $searchFields = ['id','title','name','mobile'];
    protected $validateAction = [];
    protected $statusField = 'status';
    protected $defaultSort = [];
    protected $with = ['type'];

    public function __construct()
    {
        if (is_null($this->model)){
            $this->model = new Book();
        }
        parent::__construct();
        parent::initialize();
    }

}
