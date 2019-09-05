<?php

// 应用行为扩展定义文件
return [
    // 应用结束标签位
    'response_send'      => [
        //记录请求日志，传入当前响应对象
        'app\\common\\behavior\\ActionLog'
    ],
];
