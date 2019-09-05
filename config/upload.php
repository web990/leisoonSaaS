<?php

return [
    // +----------------------------------------------------------------------
    // | 上传设置
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
