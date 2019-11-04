<?php
namespace app\oss\controller;

use app\oss\model\Oss;
use lib\ReturnCode;
use think\facade\Env;
use think\File;
use think\Image;

/**
 * 上传控制器
 * @package app\user\controller
 */
class Upload extends BaseOssController
{
    protected $noNeedLogin = ['index','ueditor'];
    protected $noNeedRight = [];

    //protected $tenant_id = 9;

    public function __construct()
    {
        if (is_null($this->model)){
            $this->model = new Oss();
        }
        parent::__construct();
        parent::initialize();
    }

    /**
     * 默认上传
     * Author: websky
     */
    public function index(){
        $uploadType = $this->request->param('upload_type','images');
        $fieldName = $this->request->param('field_name','upfile');

        $file = $this->uploadFile($uploadType,$fieldName);
        if ($file && is_array($file)){
            $this->reSuccess($file,0,'上传成功！');
        }else{
            $this->reError(ReturnCode::UPLOAD_FAILED,$file);
        }
    }

    /**
     * 上传文件
     * 成功返回数组信息，失败直接返回错误信息。
     * （注：判断数组方式判断是否上传成功）
     * @param string $uploadType （配置信息类型）
     * @param $fieldName
     * @return bool|mixed|string
     */
    public function uploadFile($uploadType='images',$fieldName){
        $config = $this->config($uploadType);
        if (!$config || !is_array($config)){
            return 'config error';
        }
        //p($config);

        $file = request()->file($fieldName ? $fieldName : $config['field_name']);
        if (!$file){
            return 'upload error';
        }

        $md5 = $file->md5();
        $oss = $this->model->where('md5',$md5)->find();
        if ($oss){
            $path = $oss->savepath .'/'. $oss->savename;
            if (is_file('.'.$path)){
                $data['savename'] = $oss->savename;
                $data['savepath'] = $oss->savepath;
                $data['ext'] = $oss->ext;
                $data['mime'] = $oss->mime;
                $data['size'] = $oss->size;
                $data['name'] = $oss->name;
                $data['title'] = $oss->savename;
                $data['create_time'] = $oss->create_time;
                $data['path'] = $path;
                $data['src'] = $path;
                $data['id'] = $oss->id;;
                return $data;
            }else{
                $oss->delete(true);
            }
        }

        $info = $file->rule($config['save_name'])
            ->validate(['size'=>$config['max_size'],'ext'=>$config['exts'],'type'=>$config['mimes']])
            ->move($config['root_path'], true, true);

        if ($info){
            //图片压缩或增加水印
            if ((isset($config['image_compress']) && $config['image_compress']) || (isset($config['image_water']) && $config['image_water'])){
                $pathname = '.'.str_replace("\\", '/', substr($info->getPathname(), 1));
                $image = Image::open($pathname);

                //图片压缩缩略图
                if (isset($config['image_compress']) && $config['image_compress']){
                    $image_compress_width = isset($config['image_compress_width']) && is_numeric($config['image_compress_width']) ? $config['image_compress_width']:0;
                    $image_compress_height = isset($config['image_compress_height']) && is_numeric($config['image_compress_height']) ? $config['image_compress_height']:0;
                    $image_compress_type = isset($config['image_compress_type']) && is_numeric($config['image_compress_type']) ? $config['image_compress_type']:1;
                    if ($image->width() > $image_compress_width || $image->height() >$image_compress_height){
                        $image->thumb($image_compress_width,$image_compress_height,$image_compress_type);
                    }
                }

                //图片增加水印
                if (isset($config['image_water']) && $config['image_water']){
                    $image_water_type = isset($config['image_water_type']) ? $config['image_water_type']:'font';
                    $image_water_path = isset($config['image_water_path']) ? $config['image_water_path']:'';
                    $image_water_locate = isset($config['image_water_locate']) ? $config['image_water_locate']:9;
                    $image_water_alpha = isset($config['image_water_alpha']) && is_numeric($config['image_water_alpha']) ? $config['image_water_alpha']:100;
                    $image_water_font = isset($config['image_water_font']) ? $config['image_water_font']:Env::get('root_path').'public/font/arial.ttf';
                    if ($image_water_type == 'image' && $image_water_path){
                        $image->water($image_water_path,$image_water_locate,$image_water_alpha);
                    }elseif($image_water_type == 'font' && is_file($image_water_font)){
                        $image_water_text = isset($config['image_water_text']) ? $config['image_water_text']:'LEISOON';
                        $size = isset($config['image_water_size']) && is_numeric($config['image_water_size']) ? $config['image_water_size']:16;
                        $color = isset($config['image_water_color']) ? $config['image_water_color']:'#000000';
                        $offset = isset($config['image_water_offset']) && is_numeric($config['image_water_offset']) ? $config['image_water_offset']:0;
                        $angle = isset($config['image_water_angle']) && is_numeric($config['image_water_angle']) ? $config['image_water_angle']:0;
                        $image->text($image_water_text,$image_water_font,$size,$color,$image_water_locate,$offset,$angle);
                    }
                }
                $image->save($pathname);
                @unlink($pathname);
            }

            $return = $this->saveOss($info,$uploadType);
            if ($return){
                return $return;
            }else{
                $error = 'save error';
            }
        }else{
            $error = $file->getError();
        }

        return $error;
    }

    /**
     * 百度编辑器使用
     * @var view
     * @access public
     */
    public function ueditor() {
        $config = json_decode(preg_replace("/\/\*[\s\S]+?\*\//", "", file_get_contents(Env::get('config_path')."json/ueditorConfig.json")), true);//导入设置
        $action = input('action','htmlspecialchars');//获取
        switch($action){
            case 'config':
                $result = $config;
                break;

            case 'uploadimage':
                $result = $this->uploadImages('editor','upfile');
                break;

            case 'uploadvideo':
                $result=$this->uploadVideo();
                break;
            case 'uploadfile':
                $result=$this->uploadAttachment();
                break;
            case 'uploadscrawl':
                $result=$this->uploadScrawl('editor');
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
                $result =  ['state'=> 'wrong require'];
                break;

        }

        if (isset($_GET["callback"])) {
            if (preg_match("/^[\w_]+$/", $_GET["callback"])) {
                return jsonp($result);
                //return htmlspecialchars($_GET["callback"]) . '(' . $result . ')';
            } else {
                return ['state'=> 'callback参数不合法'];
            }
        } else {
            return $result;
        }
    }

    /**
     * 上传图片
     * @param string $uploadType
     * @param string $fieldName
     * @return array
     */
    public function uploadImages($uploadType='images',$fieldName='upfile'){
        $info = $this->uploadFile($uploadType,$fieldName);
        return $this->parseUeditor($info);
    }

    /**
     * 上传视频
     * @param string $uploadType
     * @param string $fieldName
     * @return array
     */
    public function uploadVideo($uploadType='video',$fieldName='upfile'){
        $info = $this->uploadFile($uploadType,$fieldName);
        return $this->parseUeditor($info);
    }

    /**
     * 上传附件
     * @param string $uploadType
     * @param string $fieldName
     * @return array
     */
    public function uploadAttachment($uploadType='attachment',$fieldName='upfile'){
        $info = $this->uploadFile($uploadType,$fieldName);
        return $this->parseUeditor($info);
    }

    /**
     * 上传涂鸦
     * @param string $uploadType
     * @param string $fieldName
     * @return array
     */
    public function uploadScrawl($uploadType='editor',$fieldName='upfile'){

        return $this->upBase64($uploadType,$fieldName);
    }

    /**
     * 处理base64编码的图片上传
     * @return mixed
     */
    private function upBase64($uploadType,$fieldName)
    {
        $base64Data = $_POST[$fieldName];
        $img = base64_decode($base64Data);

        $config = $this->config($uploadType);

        $fileSize = strlen($img);
        $filePath = $config['root_path'];
        $fullName = uniqid().'.jpg';
        $dirname = dirname($filePath);

        $savePath = $filePath .'/'.$fullName;


        //创建目录失败
        if (!file_exists($dirname) && !mkdir($dirname, 0777, true)) {
            return '创建目录失败！';
        }

        //移动文件
        if (!(file_put_contents($savePath, $img) && file_exists($savePath))) { //移动失败
            return '移动文件失败！';
        }else{
            $info = [
                'path'      => str_replace("\\", '/', substr($savePath, 1)),
                'title'    => $fullName,
                'name'      => $fullName,
                'ext'     => 'jpg',
                'size'     => $fileSize,
            ];
            $info = $this->parseUeditor($info);
            return $info;
        }
    }

    /**
     * 配置信息
     * @param string $type
     * @return mixed
     */
    protected function config($type='images'){
        if (config('?upload.'.$type)){
            return config('upload.'.$type);
        }else{
            return false;
        }
    }

    /**
     * 保存上传数据
     * @param $info
     * @return bool|mixed
     */
    protected function saveOss($info,$uploadType=''){
        $data = $this->parseFile($info);
        $data['type']=$uploadType;
        if ($this->model->save($data)){
            $data['id'] = $this->model->id;
            return $data;
        }else{
            return false;
        }
    }

    /**
     * 解析上传信息
     * @param $info
     * @return mixed
     */
    protected function parseFile($info) {
        if ($info){
            $data['create_time'] = $info->getATime(); //最后访问时间
            $data['savename']    = $info->getBasename(); //获取无路径的basename
            $data['savepath']    = str_replace("\\", '/', substr($info->getPath(), 1)); //不带文件名的文件路径
            $data['ext']         = $info->getExtension(); //文件扩展名
            $data['mime']         = $info->getMime(); //文件MIME信息
            $data['size']        = $info->getSize(); //文件大小，单位字节
            $data['path']        =  str_replace("\\", '/', substr($info->getPathname(), 1)); //全路径
            $data['src']         = $data['path']; //图片路径
            $data['url']         = ''; //全路径
            $data['md5']         = $info->md5();
            $data['sha1']        = $info->sha1();

            $data['c_time']      = $info->getCTime(); //获取inode修改时间
            $data['m_time']      = $info->getMTime(); //获取最后修改时间
            $data['is_file']     = $info->isFile(); //是否是文件
            $data['is_execut']   = $info->isExecutable(); //是否可执行
            $data['is_readable'] = $info->isReadable(); //是否可读
            $data['is_writable'] = $info->isWritable(); //是否可写
            //$data['getPathname']= $info->getPathname();
            //$data['owner']       = $info->getOwner(); //文件拥有者

            //$data['file']        = $info->getInfo(); //获取上传信息
            $data['name']        = $info->getInfo('name'); //获取原始文件名
            $data['title']        = $info->getFilename(); //获取文件名
            return $data;
        }else{
            return false;
        }
    }


    /**
     * 解析返回Ueditor需要的格式
     * @param $info
     * @return array
     */
    protected function parseUeditor($info=''){
        if($info && is_array($info)){
            $data = array(
                'state'    => "SUCCESS",
                'url'      => $info['path'],
                'title'    => $info['title'],
                'original' => $info['name'],
                'type'     => '.' . $info['ext'],
                'size'     => $info['size'],
            );
        }else{
            $data = ["state"=>$info];
        }

        return $data;
    }

}
