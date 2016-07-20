<?php if (!defined('THINK_PATH')) exit();?><html lang="zh-cn">
<head>
    <title></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link type="text/css" rel="stylesheet" href="/uweb/Public/css/bootstrap.min.css">
    <style type="text/css">
        <!--
        #bdy{
            float: none;
            margin-right: auto;
            margin-left: auto;
        }
        #saytext{
            width: 100%;
            margin-right: auto;
            margin-left: auto;
        }
        .bqz{
            margin-left: 5%;
            margin-right: 8%;
        }
        -->
    </style>
</head>
<body>
<div id="bdy"  class="col-xs-12 col-md-8">
    <div id="say">
        <form action="/uweb/index.php/Home/Frdact/subsay" method="post" enctype="multipart/form-data">
            <textarea id="saytext" rows="4" name="saytext"></textarea>
            <input class="bqz" value="表情" type="button">
            <input class="bqz" type="file" multiple="multiple" name="pic[]">
            <input type="submit" style="float: right;margin-right: 4%" value="发表" name="sub">
        </form>
    </div>
    <div id="main">

    </div>
</div>
</body>
<script src="/uweb/Public/js/jquery-1.12.3.min.js"></script>
<script src="/uweb/Public/js/bootstrap.min.js"></script>
<script src="/uweb/Public/js/getsay.js"></script>
<script type="text/javascript">
    var url="/uweb/index.php";
</script>
</html>