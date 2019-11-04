<?php
namespace app\index\controller;


use app\admin\model\AdminCategory;
use app\cms\model\Document;
use app\cms\model\DocumentContent;
use lib\ReturnCode;
use org\Http;

class Collect extends IndexBase
{
    public function initialize() {
        parent::initialize();
        config('default_return_type','json');

    }

    public function index(){
        //p(config());
        p(config('cms.document_position'));
    }

    /**
     * 关联新增、编辑
     * @return array|void
     */
    public function addArticle(){
        if (!$this->request->isPost()) {
            $this->reError(ReturnCode::ERROR);
        }

        try{
            $model = new Document();
            $documentContent = new DocumentContent();
            $data = $this->param($model->getTableFields(),'post');
            $data_content = $this->param($documentContent->getTableFields(),'post');

            if (isset($data['id']) && $data['id']){
                $info = $model->find($data['id']);

                foreach ($data as $key => $value) {
                    $info->setAttr($key, $value, $data);
                }
                foreach ($data_content as $key => $value) {
                    $info->article->setAttr($key, $value, $data);
                }

                //$info->update_time = time();//主表无变化强制更新
                $return = $info->together('article')->save();
            }else{
                //数据对象赋值
                foreach ($data as $key => $value) {
                    $model->setAttr($key, $value, $data);
                }
                foreach ($data_content as $key => $value) {
                    $documentContent->setAttr($key, $value, $data);
                }

                $model->article=$documentContent;
                $return = $model->together('article')->save();
            }

            if ($return){
                $this->reSuccess(1);
            }else{
                $this->reError(isset($data['id']) ? ReturnCode::UPDATE_FAILED:ReturnCode::ADD_FAILED,$model->getError());
            }
        }catch (\think\exception\PDOException $e){
            $this->reError(ReturnCode::ADD_FAILED,$e->getMessage());
        }catch (\think\Exception $e){
            $this->reError(ReturnCode::ADD_FAILED,$e->getMessage());
        }
    }

    /**
     * 下载内容中图片（采集微信信息专用）优化1
     * Enter description here ...
     * @param $infos
     */
    function Down_info_Img($content){
        $info=$content;
        $save_path='./Uploads/weixindown/'.date("Ymd").'/';

        $reg = "/<img[^>]*src=\"(http:\/\/.*)\".*\/>/isU";
        $regurl = "/<img[^>]*src=\"(http:\/\/.*)\"/isU";
        preg_match_all($reg, $info, $img_array, PREG_PATTERN_ORDER);
        $ImgUrlArray = array_unique($img_array[1]);//过滤重复的图片
        $ImgArray = array_unique($img_array[0]);//过滤重复的图片

        foreach ($ImgArray as $k=>$v){
            $imgurl='<img src="'.$ImgUrlArray[$k].'" />';
            $info=str_replace($ImgArray[$k],$imgurl, $info);//替换img标签格式
        }

        $http=new Http();
        foreach ($ImgUrlArray as $j=>$img){
            mkdir($save_path);//创建目录
            $TempImg=$save_path.uniqid();
            $http->curlDownload($img, $TempImg);

            $imginfo=getimagesize($TempImg);
            if ($imginfo[0] < 200 || $imginfo[1] <200){
                unlink($TempImg);//删除宽高＜200的图片
                $info=str_replace($img,'', $info);//替换img地址为空
                $info=str_replace('<img src="" />','', $info);//删除空IMG标签
            }else {
                $sha1=sha1_file($TempImg);
                $img_type = getImg_TypeName($TempImg);
                $newname=$save_path.$sha1.'.'.$img_type;
                rename($TempImg,$newname);//重命名
                $url_path=str_replace('./', '/', $newname);
                $info = str_replace($img, $url_path, $info); //图片路径替换
            }
        }
        return $info;
    }


}
