<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link type="text/css" rel="stylesheet" href="/uweb/Public/css/bootstrap.min.css">
    <title></title>
    <style type="text/css">
        <!--
        #bdy{
            float: none;
            position: absolute;
            left: 10%;
        }
        .phk{
            height: 170px;
            width: 190px;
            float: left;
        }
        img{
            height: 150px;
            width: 190px;
            margin-top: 30px;
            margin-right: 15px;
        }
        -->
    </style>
</head>
<body>
<div id="bdy" class="col-xs-12 col-md-8">
    <?php if(is_array($phn)): foreach($phn as $key=>$vo): ?><div class="phk"><img src="/uweb/Uploads/<?php echo ($vo["name"]); ?>"><button class="btn btn-info btn-block" onclick="dels(<?php echo ($vo["id"]); ?>)">删除</button></div><?php endforeach; endif; ?>
</div>
</body>
<script src="/uweb/Public/js/jquery-1.12.3.min.js"></script>
<script type="text/javascript">
    function dels(c){
        if (confirm("点击确认后删除！！！")) {
            $.post("/uweb/index.php/Home/Photo/delph", {id: c}, function (msg) {
                if (msg == 1) {
                    alert("删除成功");
                } else {
                    alert("删除失败");
                }
                close();
            })
        }
    }
</script>
</html>