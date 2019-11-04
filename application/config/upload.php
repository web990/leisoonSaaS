<?php

return [
    // +----------------------------------------------------------------------
    // | 上传设置
    /* 缩略图相关常量定义
    const THUMB_SCALING   = 1; //常量，标识缩略图等比例缩放类型
    const THUMB_FILLED    = 2; //常量，标识缩略图缩放后填充类型
    const THUMB_CENTER    = 3; //常量，标识缩略图居中裁剪类型
    const THUMB_NORTHWEST = 4; //常量，标识缩略图左上角裁剪类型
    const THUMB_SOUTHEAST = 5; //常量，标识缩略图右下角裁剪类型
    const THUMB_FIXED     = 6; //常量，标识缩略图固定尺寸缩放类型*/
    /* 水印相关常量定义
    const WATER_NORTHWEST = 1; //常量，标识左上角水印
    const WATER_NORTH     = 2; //常量，标识上居中水印
    const WATER_NORTHEAST = 3; //常量，标识右上角水印
    const WATER_WEST      = 4; //常量，标识左居中水印
    const WATER_CENTER    = 5; //常量，标识居中水印
    const WATER_EAST      = 6; //常量，标识右居中水印
    const WATER_SOUTHWEST = 7; //常量，标识左下角水印
    const WATER_SOUTH     = 8; //常量，标识下居中水印
    const WATER_SOUTHEAST = 9; //常量，标识右下角水印*/
    // +----------------------------------------------------------------------

    'editor'     => array(
        // 提交的图片表单名称
        'field_name'    => 'upfile',
        // 允许上传的文件MiMe类型
        'mimes'    => ['image/png','image/jpeg','image/gif','application/x-www-form-urlencoded'],
        // 上传的文件大小限制 (0-不做限制)
        'max_size'  => 9048000,
        // 允许上传的文件后缀
        'exts'     => "png,jpg,jpeg,gif,bmp",
        //保存根路径
        'root_path' => './uploads/editor',
        // 保存路径
        'save_path' => '',
        // date	根据日期和微秒数生成, md5 对文件使用md5_file散列生成, sha1 对文件使用sha1_file散列生成，（函数名）
        'save_name' => 'date',
        // 文件上传驱动e,
        'driver'   => 'local',

        //图片压缩
        'image_compress'   => true,
        'image_compress_type'   => 1,       //图片压缩类型1-6中压缩类型
        'image_compress_width'   => 800,    //图片宽度大于800压缩至800像素
        'image_compress_height'   => 1200,  //高度大于1200压缩至1200

        //图片水印
        'image_water'   => false,
        'image_water_type'   => 'image', //图片水印（image，font）
        'image_water_locate'   => 9,     //水印位置(0-9)
        'image_water_path'   => './index/images/logo.png',
        'image_water_alpha'   => 100,    //图片水印透明度

        'image_water_text'   => 'leisoon', //文字水印内容
        'image_water_size'   => 20,      //字号
        'image_water_offset'   => 0,    //文字相对当前位置的偏移量
        'image_water_angle'   => 0,     //文字倾斜角度
        'image_water_color'   => '#00000000',//文字颜色
        'image_water_font'   => Env::get('root_path').'public/font/arial.ttf', //字体路径
    ),

    'images'    => array(
        // 提交的图片表单名称
        'field_name'    => 'upfile',
        // 允许上传的文件MiMe类型
        'mimes'    => ['image/png','image/jpeg','image/gif','application/x-www-form-urlencoded'],
        // 上传的文件大小限制，位B (0-不做限制)
        'max_size'  => 20048000,
        // 允许上传的文件后缀
        'exts'     => "png,jpg,jpeg,gif,bmp",
        //保存根路径
        'root_path' => './uploads/picture',
        // 保存路径
        'save_path' => '',
        // date	根据日期和微秒数生成, md5 对文件使用md5_file散列生成, sha1 对文件使用sha1_file散列生成，（函数名）
        'save_name' => 'date',
        // 文件上传驱动,
        'driver'   => 'local',
    ),
    'video'    => array(
        // 提交的图片表单名称
        'field_name'    => 'upfile',
        // 允许上传的文件MiMe类型
        'mimes'    => ['video/mp4','video/flv'],
        // 上传的文件大小限制，位B (0-不做限制)
        'max_size'  => 999900000,
        // 允许上传的文件后缀
        'exts'     => "mp4,flv",
        //保存根路径
        'root_path' => './uploads/video',
        // 保存路径
        'save_path' => '',
        // date	根据日期和微秒数生成, md5 对文件使用md5_file散列生成, sha1 对文件使用sha1_file散列生成，（函数名）
        'save_name' => 'date',
        // 文件上传驱动,
        'driver'   => 'local',
    ),
    'attachment' => array(
        // 提交的图片表单名称
        'field_name'    => 'upfile',
        // 允许上传的文件MiMe类型
        'mimes'    => ['application/vnd.ms-excel','application/msword','application/x-zip-compressed'
            ,'image/png','image/jpeg','image/gif','application/x-www-form-urlencoded'
            ,'application/zip'
            ,'application/x-rar'
            ,'text/plain'
            ,'application/octet-stream'
            ,'application/vnd.openxmlformats-officedocument.presentationml.presentation'
            ,'application'],
        // 上传的文件大小限制 (0-不做限制)
        'max_size'  => 99000000,
        // 允许上传的文件后缀
        'exts'     => 'zip,rar,pdf,png,jpg,jpeg,gif,bmp,flv,swf,mkv,avi,rm,rmvb,mpeg,mpg,mp4,wmv,mp3,7z,doc,docx,xls,xlsx,ppt,pptx,txt,md',
        //保存根路径
        'root_path' => './uploads/attachment',
        // 保存路径
        'save_path' => '',
        // date	根据日期和微秒数生成, md5 对文件使用md5_file散列生成, sha1 对文件使用sha1_file散列生成，（函数名）
        'save_name' => 'date',
        // 文件上传驱动e,
        'driver'   => 'local',
    ),

];
