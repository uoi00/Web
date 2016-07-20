<?php if (!defined('THINK_PATH')) exit();?><html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <title>登录界面</title>
    <link href="/uweb/Public/css/bootstrap.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <script src="/uweb/Public/js/jquery-1.12.3.min.js"></script>
    <script type="text/javascript">
        var url="/uweb/index.php";
    </script>
    <script type="text/javascript" src="/uweb/Public/js/dl.js"></script>
    <style>
        .col-center-block {
            float: none;
            display: block;
            margin-top: 10%;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>
<body>
<div class="col-xs-12 col-md-4 col-center-block">
    <form id="frm" action="/uweb/index.php/Home/Index/land" method="post" onsubmit="return dl()">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3>登录：</h3>
            </div>
            <div class="panel-body">
                <div id="inf" class="text-danger"></div>
                <input type="text" name="user" id="user" class="form-control" placeholder="帐号">
                <br>
                <input type="password" name="pwd" id="pwd" class="form-control" placeholder="密码">
                <br>
                <div id="dym">
                    <div class="input-group">
                        <input type="text" id="ym" name="ym" class="form-control" placeholder="验证码">
                        <span class="input-group-addon"><img  title="点击刷新" src="/uweb/index.php/Home/Index/yzm" align="absbottom" onclick="this.src='/uweb/index.php/Home/Index/yzm?'+Math.random();"/></span>
                    </div>
                </div>
                <br>
                <input class="btn btn-block btn-success" id="sub" type="submit" value="登录">
            </div>
        </div>
        <div class="panel-footer panel-info" align="center">
            <a href="/uweb/index.php/Home/Index/register" >注册帐号</a>&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="/uweb/index.php/Home/Index/found" >忘记密码</a>
        </div>
    </form>
</div>
</body>
</html>