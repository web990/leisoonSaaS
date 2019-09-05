<?php
// +----------------------------------------------------------------
// | LeisoonCMF V5.0
// +----------------------------------------------------------------
// | Copyright (c) 2016 http://www.leisoon.com All rights reserved.
// +----------------------------------------------------------------
// | Author: websky <web88@qq.com>
// +----------------------------------------------------------------

namespace app\common\controller;

use app\common\model\File;
use app\common\model\Picture;

/**
 * Upload控制器
 */
class Upload
{
    /**
     * 上传控制器
     */
    public function upload() {
        $uploadType = input('get.filename', 'images', 'trim');
        $config      = $this->config($uploadType);
        $file = request()->file('file');
        $info = $file->move($config['rootPath'], true, false);

        $return['code'] = 1;
        $return['msg']   = $file->getError();

        if ($info) {
            $return['code'] = 0;
            $return['data']   = $this->save($config, $uploadType, $info);
        }

        return json($return);
    }

    /**
     * 配置信息
     * @param string $type
     * @return mixed
     */
    protected function config($type='images'){
        if ($type=='file'){
            return $this->attachment();
        }else{
            return $this->images();
        }
    }

    /**
     * 图片上传
     * @var view
     * @access public
     */
    protected function images() {
        return config('upload.picture');
    }

    /**
     * 文件上传
     * @var view
     * @access public
     */
    protected function attachment() {
        return config('upload.attachment');
    }

    /**
     * 百度编辑器使用
     * @var view
     * @access public
     */
    public function ueditor() {
        $config = json_decode(preg_replace("/\/\*[\s\S]+?\*\//", "", file_get_contents(APP_PATH."common/ueditorConfig.json")), true);//导入设置
        $action = input('action','htmlspecialchars');//获取
        switch($action){
            case 'config':
                $result = json_encode($config);
                break;

            case 'uploadimage':
                $config_config=config('editor_upload');//获取编辑器上传配置信息
                $fieldName = 'upfile';
                //$fieldName = $config['imageFieldName'];
                $result = $this->uploadImages($fieldName,$config_config);
                break;

            /*case 'uploadscrawl':
                $config = array(
                    "pathFormat" => $this->config['scrawlPathFormat'],
                    "maxSize" => $this->config['scrawlMaxSize'],
                    "allowFiles" => $this->config['scrawlAllowFiles'],
                    "oriName" => "scrawl.png"
                );
                $fieldName = $this->config['scrawlFieldName'];
                $result=$this->uploadBase64($config,$fieldName);
                break;

            case 'uploadvideo':
                $config = array(
                    "pathFormat" => $this->config['videoPathFormat'],
                    "maxSize" => $this->config['videoMaxSize'],
                    "allowFiles" => $this->config['videoAllowFiles']
                );
                $fieldName = $this->config['videoFieldName'];
                $result=$this->uploadFile($config, $fieldName);
                break;

            case 'uploadfile':
                // default:
                $config = array(
                    "pathFormat" => $this->config['filePathFormat'],
                    "maxSize" => $this->config['fileMaxSize'],
                    "allowFiles" => $this->config['fileAllowFiles']
                );
                $fieldName = $this->config['fileFieldName'];
                $result=$this->uploadFile($config, $fieldName);
                break;

            case 'listfile':
                $config=array(
                    'allowFiles' => $this->config['fileManagerAllowFiles'],
                    'listSize' => $this->config['fileManagerListSize'],
                    'path' => $this->config['fileManagerListPath'],
                );
                $result = $this->listFile($config);
                break;

            case 'listimage':
                $config=array(
                    'allowFiles' => $this->config['imageManagerAllowFiles'],
                    'listSize' => $this->config['imageManagerListSize'],
                    'path' => $this->config['imageManagerListPath'],
                );
                $result = $this->listFile($config);
                break;

            case 'catchimage':
                $config = array(
                    "pathFormat" => $this->config['catcherPathFormat'],
                    "maxSize" => $this->config['catcherMaxSize'],
                    "allowFiles" => $this->config['catcherAllowFiles'],
                    "oriName" => "remote.png"
                );
                $fieldName = $this->config['catcherFieldName'];
                $result = $this->saveRemote($config , $fieldName);
                break;*/

            default:
                $result = json_encode(array(
                    'state'=> 'wrong require'
                ));
                break;

        }

        if (isset($_GET["callback"])) {
            if (preg_match("/^[\w_]+$/", $_GET["callback"])) {
                $this->output = htmlspecialchars($_GET["callback"]) . '(' . $result . ')';
            } else {
                return json_encode(array(
                    'state'=> 'callback参数不合法'
                ));
            }
        } else {
            return $result;
        }
    }

    public function uploadImages($fieldName,$config){
        $info = $this->uploadFile($fieldName,$config);
        if($info['status']){
            $data = array(
                'state'    => "SUCCESS",
                'url'      => $info['path'],
                'title'    => $info['name'],
                'original' => $info['file']['name'],
                'type'     => '.' . $info['ext'],
                'size'     => $info['size'],
            );
        }else{
            $data = array(
                "state"=>$info['info'],
            );
        }
        return json_encode($data);
    }

    public function editor() {
        $file = request()->file('upfile');
        $info = $file->move(config('editor_upload.rootPath'), true, false);
        if ($info) {
            $data              = $this->parseFile($info);
            $data['success']   = true;
            $data['file_path'] = $data['url'];
        } else {
            $data['success'] = false;
            $data['msg']     = "error message";
        }
        return $data;
    }

    /**
     * umeditor编辑器图片上传
     * @return string
     */
    public function umeditor() {
        $data=$this->uploadImages('upfile',config('editor_upload'));
        return $data;
    }

    public function delete() {
        $data = array(
            'status' => 1,
        );
        echo json_encode($data);exit();
    }


    /**
     * 上传文件并保存信息到数据库
     * @param $fieldName 上传表达名称<input type="file" name="upfile" />
     * @param $config 配置信息
     * @return array
     */
    public function uploadFile($fieldName,$config){
        $data=['status'=>0,'info'=>''];
        $rootPath= $config['rootPath']? $config['rootPath']: './uploads/picture';
        $file = request()->file($fieldName);

        $dbname = (strpos($file->getMime(),'image')===false) ? 'file':'picture';
        $pathname=$file->getPathname();
        $datainfo = db($dbname)->where(array('md5' => md5_file($pathname),'sha1'=>sha1_file($pathname)))->find();
        if ($datainfo){
            //检查死链接,并删除数据库0
            /*if (file_exists('/'.config('base_url').$datainfo['path'])){
                $data=array_merge($this->parseFile($file),$datainfo);
                return $data;
            }*/
            $data=array_merge($this->parseFile($file),$datainfo);
            return $data;
        }

        if ($config['mimes']){
            /*$fileType='.'.strtolower($file->getExtension());//验证扩展名
            if (!in_array($fileType, $config['mimes'])) {
                $data['info']='文件格式不正确';
                return $data;
            }*/
        }
        $info = $file->move($rootPath, true, false);
        if ($info){
            $file           = $this->parseFile($info);
            $file['status'] = 1;
            $dbname = (strpos($file['mime'],'image')===false) ? 'file':'picture';
            $id     = db($dbname)->insertGetId($file);//插入数据库
            if ($id) {
                $data=$file;
            }
        }else{
            $data['info']=$file->getError();
        }
        return $data;
    }

    /**
     * 保存上传的信息到数据库
     * @var view
     * @access public
     */
    public function save($config, $type, $file) {
        $file           = $this->parseFile($file);
        if ($type == 'images'){
            $model = new Picture();
        }else{
            $model = new File();
        }
        $pk = $model->getPk();
        if (isset($file[$pk])){
            unset($file[$pk]);
        }
        $data = $model->allowField(true)->create($file);
        if ($data) {
            return array_merge($file,$data->toArray());
        } else {
            return false;
        }
    }

    /**
     * 下载本地文件
     * @param  array    $file     文件信息数组
     * @param  callable $callback 下载回调函数，一般用于增加下载次数
     * @param  string   $args     回调函数参数
     * @return boolean            下载失败返回false
     */
    public function downLocalFile($file, $callback = null, $args = null) {
        if (is_file($file['rootpath'] . $file['savepath'] . $file['savename'])) {
            /* 调用回调函数新增下载数 */
            is_callable($callback) && call_user_func($callback, $args);

            /* 执行下载 *///TODO: 大文件断点续传
            header("Content-Description: File Transfer");
            header('Content-type: ' . $file['type']);
            header('Content-Length:' . $file['size']);
            if (preg_match('/MSIE/', $_SERVER['HTTP_USER_AGENT'])) {
                //for IE
                header('Content-Disposition: attachment; filename="' . rawurlencode($file['name']) . '"');
            } else {
                header('Content-Disposition: attachment; filename="' . $file['name'] . '"');
            }
            readfile($file['rootpath'] . $file['savepath'] . $file['savename']);
            exit;
        } else {
            $this->error = '文件已被删除！';
            return false;
        }
    }

    protected function parseFile($info) {
        $data['create_time'] = $info->getATime(); //最后访问时间
        $data['savename']    = $info->getBasename(); //获取无路径的basename
        $data['c_time']      = $info->getCTime(); //获取inode修改时间
        $data['ext']         = $info->getExtension(); //文件扩展名
        $data['mime']         = $info->getMime(); //文件扩展名
        $data['name']        = $info->getFilename(); //获取文件名
        $data['m_time']      = $info->getMTime(); //获取最后修改时间
        $data['owner']       = $info->getOwner(); //文件拥有者
        $data['savepath']    = $info->getPath(); //不带文件名的文件路径
        $data['path']        =  str_replace("\\", '/', substr($info->getPathname(), 1)); //全路径
        $data['url']         = ''; //全路径
        $data['src']         = $data['path']; //图片路径
        $data['size']        = $info->getSize(); //文件大小，单位字节
        $data['is_file']     = $info->isFile(); //是否是文件
        $data['is_execut']   = $info->isExecutable(); //是否可执行
        $data['is_readable'] = $info->isReadable(); //是否可读
        $data['is_writable'] = $info->isWritable(); //是否可写
        //$data['file']        = $info->getInfo(); //获取上传信息
        $data['md5']         = md5_file($info->getPathname());
        $data['sha1']        = sha1_file($info->getPathname());
        $data['getPathname']= $info->getPathname();
        return $data;
    }

}