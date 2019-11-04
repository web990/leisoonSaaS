<?php
namespace app\index\controller;

use app\cms\model\Document;

class Index extends IndexBase
{
    public function __construct()
    {
        if (is_null($this->model)){
            $this->model = new Document();
        }
        parent::__construct();
        parent::initialize();
    }

    public function index(){
        echo 'hello word';
        //return $this->redirect('admin/index/index');
    }
}
