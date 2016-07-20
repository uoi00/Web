<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link type="text/css" rel="stylesheet" href="/uweb/Public/css/bootstrap.min.css">
</head>
<body>
    <h3 align="center">相册修改</h3>
    <form action="/uweb/index.php/Home/Photo/updps" method="post" onsubmit="return addcx();">
        <input type="text" placeholder="相册名称" name="ps" id="ps" value="<?php echo ($name); ?>"><br>
        <textarea name="bew" placeholder="相册描述" cols="40" rows="4"><?php echo ($bew); ?></textarea><br>
        <button type="submit" name="sub" value="<?php echo ($id); ?>">发表</button>
    </form>
</body>
<script src="/uweb/Public/js/jquery-1.12.3.min.js"></script>
<script src="/uweb/Public/js/bootstrap.min.js"></script>
<script type="text/javascript">
    function addcx() {
        if ($("#ps").val() == '') {
            alert('相册名称不能为空');
            return false;
        } else {
            return true;
        }
    }
</script>
</html>