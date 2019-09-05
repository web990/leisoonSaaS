{__NOLAYOUT__}<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>跳转提示</title>
    <link rel="stylesheet" href="__LAYUI__/css/layui.css" />
    <style type="text/css">
        *{ padding: 0; margin: 0; }
        body{ background: #fff; font-family: "Microsoft Yahei","Helvetica Neue",Helvetica,Arial,sans-serif; color: #333; font-size: 16px; }
        .system-message{ padding: 24px 48px; }
        .system-message h1{ font-size: 100px; font-weight: normal; line-height: 120px; margin-bottom: 10px; color: #00a65a;}
        .system-message .jump{ padding-top: 50px; }
        .system-message .jump a{ color: #333; }
        .system-message .success,.system-message .error{ line-height: 1.8em; font-size: 36px; }
        .system-message .detail{ font-size: 12px; line-height: 20px; margin-top: 12px; display: none; }
    </style>
</head>
<body>
<div style="width: 100%; height: 100%; text-align: center">
    <div class="system-message" style="width:500px;height:350px;margin:auto;margin-top:120px;background:#FFFFFF; text-align:center;border:1px solid #efefef;box-shadow:0 2px 10px rgba(0,0,0,0.2);">
        <?php switch ($code) {?>
        <?php case 1:?>
        <h1><i class="layui-icon" style="font-size: 100px; color:#00a65a;">&#x1005;</i></h1>
        <p class="success"><?php echo(strip_tags($msg));?></p>
        <?php break;?>
        <?php case 0:?>
        <h1><i class="layui-icon" style="font-size: 100px; color:#f89406;">&#xe60b;</i></h1>
        <p class="error"><?php echo(strip_tags($msg));?></p>
        <?php break;?>
        <?php } ?>
        <p class="detail"></p>
        <p class="jump">
            页面自动 <a id="href" href="<?php echo($url);?>">跳转</a> 等待时间： <b id="wait"><?php echo($wait);?></b>
        </p>
    </div>
</div>

    <script type="text/javascript">
        (function(){
            var wait = document.getElementById('wait'),
                href = document.getElementById('href').href;
            var interval = setInterval(function(){
                var time = --wait.innerHTML;
                if(time <= 0) {
                    location.href = href;
                    clearInterval(interval);
                };
            }, 1000);
        })();
    </script>
</body>
</html>
