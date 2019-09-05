<?php
// +----------------------------------------------------------------
// | LeisoonCMF V5.0
// +----------------------------------------------------------------
// | Copyright (c) 2016 http://www.leisoon.com All rights reserved.
// +----------------------------------------------------------------
// | Author: websky <web88@qq.com>
// +----------------------------------------------------------------

namespace app\index\taglib;

use think\template\TagLib;

/**
 * 网站前台标签
 * @author websky
 *
 */
class Index extends taglib {
    /**
     * 定义标签列表
     * @var array
     */
    protected $tags   =  array(
        // 标签定义： attr 属性列表 close 是否闭合（0 或者1 默认1） alias 标签别名 level 嵌套层次
        'nav'      =>  array('attr' => 'id,field,pid,where', 'close' => 1), //获取导航
        'subnav'   =>  array('attr' => 'id,field,pid,where,tongji', 'close' => 1), //子导航
        'weizhi'   =>  array('attr' => 'id,cid', 'close' => 1), //当前位置
        'link'     => array('attr' => 'id,type,limit', 'close' => 1), //获取指定分类列表
        'position' => array('attr' => 'id,pos,cate,limit,filed', 'close' => 1,'level'=>3), //获取推荐位列表
    );

    /* 友情链接列表 */
    public function tagLink($tag, $content){
        $type_id  = empty($tag['type']) ? '0' : $tag['type'];
        $limit  = empty($tag['limit']) ? '0' : $tag['limit'];
        $parse  = $parse   = '<?php ';
        $parse .= '$__LINK__ = model(\'app\link\model\Link\')->getLink('.$type_id.','.$limit.');';
        $parse .= 'foreach($__LINK__ as $key=>$' . $tag['id'] . '): ';
        $parse .= ' ?>';
        $parse .= $content;
        $parse .= '<?php endforeach;?>';
        return $parse;
    }

    public function tagPosition($tag, $content){
        $pos    = $tag['pos'];
        $cate   = $tag['cate'];
        $limit  = empty($tag['limit']) ? 'null' : $tag['limit'];
        $field  = empty($tag['field']) ? 'true' : $tag['field'];
        $empty  = isset($tag['empty']) ? $tag['empty'] : '';
        $key    = !empty($tag['key']) ? $tag['key'] : 'i';
        $mod    = isset($tag['mod']) ? $tag['mod'] : '2';
        $name   = $tag['id'];
        $parse  = '<?php ';
        $parse .= '$category=model(\'app\admin\model\AdminCategory\')->getChildrenId('.$cate.');';
        $parse .= '$__POSLIST__ = model(\'app\cms\model\Document\')->position(';
        $parse .= $pos . ',';
        $parse .= '$category,';
        $parse .= $limit . ');';
        $parse .= 'if( count($__POSLIST__)==0 ) : echo "' . $empty . '" ;';
        $parse .= 'else: ';
        $parse .= 'foreach($__POSLIST__ as $key=>$' . $name . '): ';
        $parse .= '$mod = ($' . $key . ' % ' . $mod . ' );';
        $parse .= '++$' . $key . ';?>';
        $parse .= $content;
        $parse .= '<?php endforeach; endif; ?>';

        if (!empty($parse)) {
            return $parse;
        }
        return;
    }


    /* 导航列表 */
    public function tagNav($tag, $content){
        $field  = empty($tag['field']) ? 'true' : $tag['field'];
        $pid    = empty($tag['pid']) ? 0 : $tag['pid'];
        $where    = empty($tag['where']) ? 'false' : $tag['where'];
        $parse   = '<?php ';
        $parse .= '$__NAV__=model(\'app\admin\model\AdminCategory\')->getNavTree('.$where.','.$pid.','.$field.');';
        $parse .= 'foreach($__NAV__ as $key=>$' . $tag['id'] . '): ';
        $parse .= ' ?>';
        $parse .= $content;
        $parse .= '<?php endforeach;?>';
        return $parse;
    }

    /* 子导航列表，没有子分类则显示同级分类($tongji=true) */
    public function tagSubnav($tag, $content){
        $field  = empty($tag['field']) ? 'true' : $tag['field'];
        $pid    = empty($tag['pid']) ? 0 : $tag['pid'];
        $where    = empty($tag['where']) ? 'false' : $tag['where'];
        $tongji    = empty($tag['tongji']) ? 1 : $tag['tongji'];
        $parse   = '<?php ';
        $parse .= '$__SUBNAV__=model(\'app\admin\model\AdminCategory\')->getSubNav('.$pid.','.$tongji.','.$where.','.$field.');';
        $parse .= 'foreach($__SUBNAV__ as $key=>$' . $tag['id'] . '): ';
        $parse .= ' ?>';
        $parse .= $content;
        $parse .= '<?php endforeach;?>';
        return $parse;
    }

    /* 子导航列表，没有子分类则显示同级分类($tongji=true) */
    public function tagWeizhi($tag, $content){
        $cid    = empty($tag['cid']) ? 0 : $tag['cid'];
        $parse   = '<?php ';
        $parse .= '$__WEIZHI__=model(\'app\admin\model\AdminCategory\')->getBreadcrumb('.$cid.');';
        $parse .= 'foreach($__WEIZHI__ as $key=>$' . $tag['id'] . '): ';
        $parse .= ' ?>';
        $parse .= $content;
        $parse .= '<?php endforeach;?>';
        return $parse;
    }

}